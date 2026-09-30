<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as Select from '$lib/components/ui/select';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as Alert from '$lib/components/ui/alert';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Chart from '$lib/components/ui/chart';
	import * as ToggleGroup from '$lib/components/ui/toggle-group';
	import * as Dialog from '$lib/components/ui/dialog';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import { Input } from '$lib/components/ui/input';
	import * as Empty from '$lib/components/ui/empty';
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Users, Eye, Search, Star, Info, UserRound } from 'lucide-svelte';

	const agents = [
		{ name: 'Rina Amelia', user: 'rina.a', status: 'Ready', handle: 3, closed: 24, total: 128, avg: '1m 12s', rate: 94, rating: 4.9 },
		{ name: 'Budi Santoso', user: 'budi.s', status: 'Ready', handle: 2, closed: 19, total: 112, avg: '1m 48s', rate: 91, rating: 4.7 },
		{ name: 'Sari Dewi', user: 'sari.d', status: 'Offline', handle: 0, closed: 15, total: 96, avg: '2m 05s', rate: 88, rating: 4.6 },
		{ name: 'Andi Pratama', user: 'andi.p', status: 'Offline', handle: 0, closed: 11, total: 74, avg: '2m 40s', rate: 82, rating: 4.3 }
	];
	let q = $state(''); let range = $state('today'); let view = $state('semua'); let open = $state(false);
	let detail = $state(agents[0]); let loading = $state(false);
	let filtered = $derived(agents.filter((a) => `${a.name} ${a.user}`.toLowerCase().includes(q.toLowerCase()) && (view === 'semua' || (view === 'ready' ? a.status === 'Ready' : a.status === 'Offline'))));
	function reload() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : Users);
	const chartConfig = { total: { label: 'Handled', color: 'var(--primary)' } };
</script>

<svelte:head><title>Agent Performance</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header><Card.Title>Agent Performance</Card.Title><Card.Description>Monitor and track agent activities in real-time.</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_200px_auto]">
				<Field.Field><Field.Label for="q">Search agents</Field.Label><div class="relative"><Search data-icon="input" /><Input id="q" bind:value={q} placeholder="Search agents…" class="pl-9" /></div></Field.Field>
				<Field.Field>
					<Field.Label for="range">Time range</Field.Label>
					<Select.Root type="single" bind:value={range}><Select.Trigger id="range" class="w-full">{range}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Range</Select.GroupHeading><Select.Item value="today">Today</Select.Item><Select.Item value="week">This Week</Select.Item><Select.Item value="month">This Month</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button onclick={reload} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? 'Memuat' : 'Refresh'}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={view} aria-label="Status"><ToggleGroup.Item value="semua">Semua</ToggleGroup.Item><ToggleGroup.Item value="ready">Ready</ToggleGroup.Item><ToggleGroup.Item value="offline">Offline</ToggleGroup.Item></ToggleGroup.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">Last updated: Just now</Card.Footer>
	</Card.Root>

	<Card.Root>
		<Card.Header><Card.Title>Current Agent Status</Card.Title><Card.Description>Real-time overview of agent activities.</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Tabs.Root value="status"><Tabs.List><Tabs.Trigger value="status">Status</Tabs.Trigger><Tabs.Trigger value="history">Performance History</Tabs.Trigger></Tabs.List></Tabs.Root>
			{#if loading}
				<div class="flex flex-col gap-2">{#each [1, 2, 3] as _}<Skeleton class="h-12 w-full" />{/each}</div>
			{:else if filtered.length === 0}
				<Empty.Root><Empty.Header><Empty.Media><UserRound data-icon="empty" /></Empty.Media><Empty.Title>Tidak ada agent</Empty.Title><Empty.Description>Ubah kata kunci pencarian.</Empty.Description></Empty.Header></Empty.Root>
			{:else}
				<Table.Root><Table.Header><Table.Row><Table.Head>Agent</Table.Head><Table.Head>Status</Table.Head><Table.Head>Current Handle</Table.Head><Table.Head>Closed Today</Table.Head><Table.Head class="text-right">Actions</Table.Head></Table.Row></Table.Header>
				<Table.Body>{#each filtered as a}<Table.Row>
					<Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-8"><Avatar.Fallback>{a.name.slice(0, 1)}</Avatar.Fallback></Avatar.Root><div><div class="font-medium">{a.name}</div><div class="text-muted-foreground text-xs">{a.user}</div></div></div></Table.Cell>
					<Table.Cell><Badge variant={a.status === 'Ready' ? 'success' : 'secondary'} class={cn(a.status === 'Ready' && 'border-green-500/30')}>{a.status}</Badge></Table.Cell>
					<Table.Cell>{a.handle}</Table.Cell><Table.Cell>{a.closed}</Table.Cell>
					<Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="sm" onclick={() => { detail = a; open = true; }}><Eye data-icon="inline-start" />View Details</Button></Tooltip.Trigger><Tooltip.Content>Lihat detail {a.name}</Tooltip.Content></Tooltip.Root></Table.Cell>
				</Table.Row>{/each}</Table.Body></Table.Root>
			{/if}
		</Card.Content>
		<Card.Footer><Separator class="my-1" /><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> Kolom: Agent, Status, Current Handle, Closed Today, Actions</p></Card.Footer>
	</Card.Root>

	<Card.Root>
		<Card.Header><Card.Title>Performance History</Card.Title><Card.Description>Detailed agent performance metrics: Total Handled, Avg Response, Success Rate, Rating.</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Chart.Container config={chartConfig} class="min-h-36"><div class="flex h-32 w-full items-end gap-2">{#each filtered as a}<div class="flex flex-1 flex-col items-center gap-1"><div class="w-full rounded bg-primary/80" style="height:{Math.round((a.total / 128) * 100)}%"></div><span class="text-[10px]">{a.name.split(' ')[0]}</span></div>{/each}</div></Chart.Container>
			<Table.Root><Table.Header><Table.Row><Table.Head>Agent</Table.Head><Table.Head>Total Handled</Table.Head><Table.Head>Avg Response</Table.Head><Table.Head>Success Rate</Table.Head><Table.Head>Rating</Table.Head></Table.Row></Table.Header>
			<Table.Body>{#each filtered as a}<Table.Row><Table.Cell class="font-medium">{a.name}</Table.Cell><Table.Cell>{a.total}</Table.Cell><Table.Cell>{a.avg}</Table.Cell><Table.Cell><div class="flex items-center gap-2"><Progress value={a.rate} class="w-20" /><span class="text-xs">{a.rate}%</span></div></Table.Cell><Table.Cell><span class="flex items-center gap-1 font-medium"><Star data-icon="inline" />{a.rating}</span></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
		</Card.Content>
		<Card.Footer><Alert.Root variant="success"><Info data-icon="alert" /><Alert.Description>Success rate dihitung dari tiket selesai vs target.</Alert.Description></Alert.Root></Card.Footer>
	</Card.Root>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>Detail — {detail.name}</Dialog.Title><Dialog.Description>{detail.user} · {detail.status} · {detail.total} handled</Dialog.Description></Dialog.Header><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>Tutup</Button></Dialog.Footer></Dialog.Content></Dialog.Root>

