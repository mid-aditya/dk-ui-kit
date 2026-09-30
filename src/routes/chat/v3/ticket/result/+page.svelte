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
	import EmailItem from '$lib/components/ui/email-item.svelte';
	import { toast } from 'svelte-sonner';
	import { Search, Mail, MoreVertical } from 'lucide-svelte';

	const stages = ['Diterima', 'Diproses', 'Analisa Kirana', 'Follow-up', 'Selesai'];
	const tickets = [
		{ id: 'RS-001', customer: 'Budi Santoso', result: 'Lolos verifikasi', status: 'success', time: '10:40' },
		{ id: 'RS-002', customer: 'Siti Aminah', result: 'Perlu dokumen tambahan', status: 'pending', time: '11:05' }
	];
	let sel = $state(tickets[0]);
	let q = $state('');
	let loading = $state(false);
	const initials = (n: string) => n.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
</script>

<svelte:head><title>Result Ticket — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-3">
	<Card.Root>
		<Card.Content class="flex items-center gap-3 overflow-x-auto p-4">
			{#each stages as s, i}<div class="flex items-center gap-2"><span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-sm font-bold text-primary">{i + 1}</span><span class="whitespace-nowrap text-xs font-medium">{s}</span>{#if i < stages.length - 1}<span class="h-0.5 w-8 bg-border"></span>{/if}</div>{/each}
		</Card.Content>
	</Card.Root>

	<div class="flex flex-wrap items-center gap-2">
		<InputGroup.Root class="max-w-sm"><InputGroup.Addon><Search class="size-4" /></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder="Cari result ticket…" /></InputGroup.Root>
		<Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">Semua</Tabs.Trigger><Tabs.Trigger value="success">Success</Tabs.Trigger><Tabs.Trigger value="pending">Pending</Tabs.Trigger></Tabs.List></Tabs.Root>
		<DropdownMenu.Root>
			<DropdownMenu.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><MoreVertical class="size-4" /> Aksi</Button>{/snippet}</DropdownMenu.Trigger>
			<DropdownMenu.Content><DropdownMenu.Group><DropdownMenu.GroupHeading>Hasil</DropdownMenu.GroupHeading><DropdownMenu.Item>Export</DropdownMenu.Item><DropdownMenu.Item>Kirim Email</DropdownMenu.Item></DropdownMenu.Group></DropdownMenu.Content>
		</DropdownMenu.Root>
		<Tooltip.Provider><Tooltip.Root><Tooltip.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><Mail class="size-4" /> Email Hasil</Button>{/snippet}</Tooltip.Trigger><Tooltip.Content>Kirim hasil via email</Tooltip.Content></Tooltip.Root></Tooltip.Provider>
	</div>

	<div class="grid grid-cols-1 gap-3 xl:grid-cols-2">
		<Card.Root>
			<Card.Header><strong class="text-sm">Daftar Result Ticket</strong></Card.Header><Separator />
			<ScrollArea.Root class="h-[50vh]">
				{#if loading}<div class="flex flex-col gap-2 p-4"><Skeleton class="h-14 w-full" /><Skeleton class="h-14 w-full" /></div>
				{:else if tickets.length === 0}<Empty.Root><Empty.Header><Empty.Title>Belum ada hasil</Empty.Title><Empty.Description>Hasil tiket akan muncul di sini.</Empty.Description></Empty.Header></Empty.Root>
				{:else}
					<div class="flex flex-col gap-2 p-3">
						{#each tickets as t (t.id)}
							<button onclick={() => (sel = t)} class="flex items-center gap-3 rounded-lg border p-3 text-left hover:bg-muted/50">
								<Avatar.Root><Avatar.Fallback>{initials(t.customer)}</Avatar.Fallback></Avatar.Root>
								<span class="flex-1"><strong class="text-sm">{t.id} — {t.customer}</strong><span class="block text-xs text-muted-foreground">{t.result}</span></span>
								<Badge variant={t.status === 'success' ? 'default' : 'secondary'}>{t.status}</Badge>
							</button>
						{/each}
					</div>
				{/if}
			</ScrollArea.Root>
		</Card.Root>
		<Card.Root>
			<Card.Header class="flex flex-row items-center gap-2"><strong class="flex-1 text-sm">Detail {sel.id}</strong><Badge variant="outline">{sel.status}</Badge>
				<Dialog.Root>
					<Dialog.Trigger>{#snippet child({ props })}<Button size="sm" {...props}>Preview Email</Button>{/snippet}</Dialog.Trigger>
					<Dialog.Content><Dialog.Header><Dialog.Title>Preview Email Hasil — {sel.id}</Dialog.Title></Dialog.Header><EmailItem from="noreply@ahu.go.id" subject={`Hasil ${sel.id}`} preview={sel.result} time={sel.time} /><Dialog.Footer><Button onclick={() => toast.success('Email hasil dikirim')}>Kirim</Button></Dialog.Footer></Dialog.Content>
				</Dialog.Root>
			</Card.Header><Separator />
			<Card.Content class="flex flex-col gap-2 p-4">
				<Message.Group>
					<Message.Root><Message.Avatar><Avatar.Root><Avatar.Fallback>SY</Avatar.Fallback></Avatar.Root></Message.Avatar><div class="flex flex-col gap-1"><Message.Header>Sistem</Message.Header><Bubble.Root variant="received"><Bubble.Content>Hasil untuk {sel.customer}: {sel.result}.</Bubble.Content></Bubble.Root><Message.Footer>{sel.time}</Message.Footer></div></Message.Root>
				</Message.Group>
				<Separator />
				<p class="text-xs text-muted-foreground">Meniru dashboard result-ticket blade: timeline horizontal + detail + modal email body.</p>
			</Card.Content>
		</Card.Root>
	</div>
</div>
