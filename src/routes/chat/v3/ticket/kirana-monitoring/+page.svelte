<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Sheet from '$lib/components/ui/sheet';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Table from '$lib/components/ui/table';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import { toast } from 'svelte-sonner';
	import { Search, RotateCcw, MoreVertical } from 'lucide-svelte';

	const summary = [
		{ label: 'Current Success', value: '1.284', tone: 'text-emerald-500' },
		{ label: 'Current Failed', value: '37', tone: 'text-red-500' },
		{ label: 'Current Pending', value: '12', tone: 'text-amber-500' },
		{ label: 'Waiting Webhook', value: '5', tone: 'text-cyan-500' }
	];
	const rows = [
		{ group: 'REQ-88A1', ticket: 'TCK-101', source: 'manual', type: 'result', status: 'success', file: 'hasil_01.pdf', time: '10:02' },
		{ group: 'REQ-88A2', ticket: 'TCK-102', source: 'batch', type: 'outbound', status: 'failed', file: 'batch_44.csv', time: '10:20' },
		{ group: 'REQ-88A3', ticket: 'TCK-103', source: 'manual', type: 'result', status: 'processing', file: 'hasil_02.pdf', time: '10:31' }
	];
	let q = $state('');
	let loading = $state(false);
	let filtered = $derived(rows.filter((r) => !q || (r.ticket + r.group + r.file).toLowerCase().includes(q.toLowerCase())));
</script>

<svelte:head><title>Kirana Monitoring — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-3">
	<div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
		{#each summary as s}<Card.Root><Card.Header class="flex flex-row items-center justify-between gap-2"><span class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">{s.label}</span><Badge variant="outline">{s.value}</Badge></Card.Header><Card.Content><p class={`text-3xl font-bold ${s.tone}`}>{s.value}</p></Card.Content></Card.Root>{/each}
	</div>

	<Card.Root>
		<Card.Header class="flex flex-row flex-wrap items-center gap-2">
			<InputGroup.Root class="max-w-sm"><InputGroup.Addon><Search class="size-4" /></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder="Search ticket / request / filename" /></InputGroup.Root>
			<Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">Semua</Tabs.Trigger><Tabs.Trigger value="success">Success</Tabs.Trigger><Tabs.Trigger value="failed">Failed</Tabs.Trigger></Tabs.List></Tabs.Root>
			<DropdownMenu.Root>
				<DropdownMenu.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><MoreVertical class="size-4" /> Source</Button>{/snippet}</DropdownMenu.Trigger>
				<DropdownMenu.Content><DropdownMenu.Group><DropdownMenu.GroupHeading>Source</DropdownMenu.GroupHeading><DropdownMenu.Item>Manual</DropdownMenu.Item><DropdownMenu.Item>Batch</DropdownMenu.Item></DropdownMenu.Group></DropdownMenu.Content>
			</DropdownMenu.Root>
			<Tooltip.Provider><Tooltip.Root><Tooltip.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" onclick={() => { q = ''; toast.success('Filter direset'); }} {...props}><RotateCcw class="size-4" /> Reset</Button>{/snippet}</Tooltip.Trigger><Tooltip.Content>Kembalikan filter awal</Tooltip.Content></Tooltip.Root></Tooltip.Provider>
			<Sheet.Root>
				<Sheet.Trigger>{#snippet child({ props })}<Button size="sm" {...props}>Log Detail</Button>{/snippet}</Sheet.Trigger>
				<Sheet.Content><Sheet.Header><Sheet.Title>Step-by-step Log</Sheet.Title></Sheet.Header><div class="flex flex-col gap-2 p-4 text-sm"><p>Analyze dikirim → webhook diterima → final status success.</p><Separator /><p class="text-muted-foreground">Meniru log manual maupun batch pada blade.</p></div></Sheet.Content>
			</Sheet.Root>
		</Card.Header>
		<Separator />
		<ScrollArea.Root class="h-[50vh]">
			{#if loading}<div class="flex flex-col gap-2 p-4"><Skeleton class="h-10 w-full" /><Skeleton class="h-10 w-full" /></div>
			{:else if filtered.length === 0}<Empty.Root><Empty.Header><Empty.Title>Tidak ada attempt</Empty.Title><Empty.Description>Ubah kata kunci pencarian.</Empty.Description></Empty.Header></Empty.Root>
			{:else}
				<Table.Root>
					<Table.Header><Table.Row><Table.Head>Request Group</Table.Head><Table.Head>Ticket</Table.Head><Table.Head>Source</Table.Head><Table.Head>File</Table.Head><Table.Head>Status</Table.Head><Table.Head>Aksi</Table.Head></Table.Row></Table.Header>
					<Table.Body>
						{#each filtered as r (r.group)}
							<Table.Row>
								<Table.Cell>{r.group}</Table.Cell><Table.Cell>{r.ticket}</Table.Cell><Table.Cell><Badge variant="outline">{r.source}</Badge></Table.Cell><Table.Cell class="max-w-40 truncate">{r.file}</Table.Cell>
								<Table.Cell><Badge variant={r.status === 'success' ? 'default' : r.status === 'failed' ? 'destructive' : 'secondary'}>{r.status}</Badge></Table.Cell>
								<Table.Cell>
									<Dialog.Root>
										<Dialog.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}>Retry</Button>{/snippet}</Dialog.Trigger>
										<Dialog.Content><Dialog.Header><Dialog.Title>Retry {r.group}?</Dialog.Title></Dialog.Header><Dialog.Footer><Button onclick={() => toast.success(`Retry ${r.group} dijadwalkan`)}>Retry</Button></Dialog.Footer></Dialog.Content>
									</Dialog.Root>
								</Table.Cell>
							</Table.Row>
						{/each}
					</Table.Body>
				</Table.Root>
			{/if}
		</ScrollArea.Root>
	</Card.Root>
</div>
