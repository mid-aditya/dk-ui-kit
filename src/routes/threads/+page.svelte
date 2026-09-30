<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Message from '$lib/components/ui/message';
	import * as Bubble from '$lib/components/ui/bubble';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import { toast } from 'svelte-sonner';
	import { Search, Filter } from 'lucide-svelte';

	const rows = [
		{ id: 1, user: 'Budi Santoso', agent: 'Agent Rina', channel: 'Chat', preview: 'Paket belum sampai…', date: '2026-09-28', count: 12 },
		{ id: 2, user: 'Siti Aminah', agent: 'Agent Dodi', channel: 'Email', preview: 'Pengajuan KTP…', date: '2026-09-29', count: 5 },
		{ id: 3, user: 'Andi Wijaya', agent: 'Agent Rina', channel: 'Inbound', preview: 'Refund dana…', date: '2026-09-30', count: 8 }
	];
	let q = $state('');
	let loading = $state(false);
	let filtered = $derived(rows.filter((r) => !q || r.user.toLowerCase().includes(q.toLowerCase())));
	const initials = (n: string) => n.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
	function search() { loading = true; setTimeout(() => { loading = false; toast.success(`Ditemukan ${filtered.length} thread`); }, 600); }
</script>

<svelte:head><title>Threads — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-3">
	<Card.Root>
		<Card.Header class="flex flex-row items-center gap-2">
			<strong class="text-sm">Filters</strong>
			<div class="flex flex-1 flex-col gap-2 md:flex-row">
				<InputGroup.Root class="max-w-md"><InputGroup.Addon><Search class="size-4" /></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder="Search Phone, User or Agent…" /></InputGroup.Root>
				<InputGroup.Root class="max-w-xs"><InputGroup.Input type="date" /><InputGroup.Text>to</InputGroup.Text><InputGroup.Input type="date" /></InputGroup.Root>
			</div>
			<Button variant="outline" size="sm" onclick={() => (q = '')}>Clear</Button>
			<Button size="sm" onclick={search}>Search</Button>
			<DropdownMenu.Root>
				<DropdownMenu.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><Filter class="size-4" /> Filter</Button>{/snippet}</DropdownMenu.Trigger>
				<DropdownMenu.Content><DropdownMenu.Group><DropdownMenu.GroupHeading>Kanal</DropdownMenu.GroupHeading><DropdownMenu.Item>Semua</DropdownMenu.Item><DropdownMenu.Item>Chat</DropdownMenu.Item><DropdownMenu.Item>Email</DropdownMenu.Item><DropdownMenu.Item>Inbound</DropdownMenu.Item></DropdownMenu.Group></DropdownMenu.Content>
			</DropdownMenu.Root>
		</Card.Header>
	</Card.Root>

	<Tabs.Root value="list">
		<Tabs.List><Tabs.Trigger value="list">Thread List</Tabs.Trigger><Tabs.Trigger value="timeline">Timeline</Tabs.Trigger></Tabs.List>
		<Tabs.Content value="list">
			<Card.Root>
				<ScrollArea.Root class="h-[55vh]">
					{#if loading}<div class="flex flex-col gap-2 p-4"><Skeleton class="h-14 w-full" /><Skeleton class="h-14 w-full" /></div>
					{:else if filtered.length === 0}<Empty.Root><Empty.Header><Empty.Title>Tidak ada thread</Empty.Title><Empty.Description>Coba ubah filter pencarian.</Empty.Description></Empty.Header></Empty.Root>
					{:else}
						<div class="flex flex-col gap-2 p-3">
							{#each filtered as r (r.id)}
								<div class="flex items-center gap-3 rounded-lg border p-3">
									<Avatar.Root><Avatar.Fallback>{initials(r.user)}</Avatar.Fallback></Avatar.Root>
									<span class="min-w-0 flex-1"><span class="flex items-center gap-2"><strong class="truncate text-sm">{r.user}</strong><Badge variant="outline" class="text-[10px]">{r.channel}</Badge><Badge variant="secondary">{r.count} pesan</Badge></span>
									<span class="block truncate text-xs text-muted-foreground">{r.preview} • {r.agent} • {r.date}</span></span>
									<Tooltip.Provider><Tooltip.Root><Tooltip.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}>Buka</Button>{/snippet}</Tooltip.Trigger><Tooltip.Content>Lihat timeline thread</Tooltip.Content></Tooltip.Root></Tooltip.Provider>
									<Dialog.Root>
										<Dialog.Trigger>{#snippet child({ props })}<Button size="sm" {...props}>Detail</Button>{/snippet}</Dialog.Trigger>
										<Dialog.Content><Dialog.Header><Dialog.Title>Thread #{r.id} — {r.user}</Dialog.Title></Dialog.Header>
											<Message.Group>
												<Message.Root><div class="flex flex-col gap-1"><Message.Header>{r.user}</Message.Header><Bubble.Root variant="received"><Bubble.Content>{r.preview}</Bubble.Content></Bubble.Root><Message.Footer>{r.date}</Message.Footer></div></Message.Root>
											</Message.Group>
											<Separator class="my-2" />
											<p class="text-xs text-muted-foreground">Timeline vertikal meniru blade threads.</p>
										</Dialog.Content>
									</Dialog.Root>
								</div>
							{/each}
						</div>
					{/if}
				</ScrollArea.Root>
			</Card.Root>
		</Tabs.Content>
		<Tabs.Content value="timeline">
			<Card.Root><Card.Content class="flex flex-col gap-2 p-4">
				{#each filtered as r (r.id)}<div class="flex items-center gap-3"><span class="h-8 w-1 rounded bg-primary"></span><Avatar.Root><Avatar.Fallback>{initials(r.user)}</Avatar.Fallback></Avatar.Root><span class="text-sm">{r.user} — {r.preview}</span><Badge variant="outline">{r.date}</Badge></div><Separator />{/each}
			</Card.Content></Card.Root>
		</Tabs.Content>
	</Tabs.Root>
</div>
