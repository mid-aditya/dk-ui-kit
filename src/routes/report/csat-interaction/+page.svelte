<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Select from '$lib/components/ui/select';
	import * as Field from '$lib/components/ui/field';
	import * as ToggleGroup from '$lib/components/ui/toggle-group';
	import * as Pagination from '$lib/components/ui/pagination';
	import * as Empty from '$lib/components/ui/empty';
	import * as Alert from '$lib/components/ui/alert';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as Chart from '$lib/components/ui/chart';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Slider } from '$lib/components/ui/slider';
	import { Switch } from '$lib/components/ui/switch';
	import { Chart as LCChart, Svg, Axis, Grid, Bars } from 'layerchart';
	import { Search, Star, Download, RotateCcw, TriangleAlert, MessagesSquare, SlidersHorizontal } from 'lucide-svelte';

	let channel = $state('all');
	let agent = $state('all');
	let view: string | undefined = $state('table');
	let minScore = $state(1);
	let onlyComment = $state(false);
	let search = $state('');
	let page = $state(1);
	const perPage = 5;
	let detailOpen = $state(false);
	let detailName = $state('');

	type Row = { agent: string; channel: string; interactions: number; avg: number; s5: number; s4: number; s3: number; s2: number; s1: number; comment: boolean };
	const rows: Row[] = [
		{ agent: 'Ayu Lestari', channel: 'WhatsApp', interactions: 86, avg: 4.7, s5: 64, s4: 14, s3: 5, s2: 2, s1: 1, comment: true },
		{ agent: 'Rizky Pratama', channel: 'Voice', interactions: 74, avg: 4.4, s5: 48, s4: 16, s3: 6, s2: 3, s1: 1, comment: true },
		{ agent: 'Dewi Anggraini', channel: 'Live Chat', interactions: 69, avg: 4.2, s5: 40, s4: 17, s3: 8, s2: 2, s1: 2, comment: false },
		{ agent: 'Fajar Nugraha', channel: 'Email', interactions: 52, avg: 4.0, s5: 28, s4: 12, s3: 7, s2: 3, s1: 2, comment: true },
		{ agent: 'Sari Wulandari', channel: 'WhatsApp', interactions: 47, avg: 3.8, s5: 22, s4: 12, s3: 8, s2: 3, s1: 2, comment: false },
		{ agent: 'Budi Hartono', channel: 'Voice', interactions: 41, avg: 3.6, s5: 16, s4: 11, s3: 8, s2: 4, s1: 2, comment: false }
	];

	const filtered = $derived(rows.filter((r) => {
		if (channel !== 'all' && r.channel !== channel) return false;
		if (agent !== 'all' && r.agent !== agent) return false;
		if (r.avg < minScore) return false;
		if (onlyComment && !r.comment) return false;
		const q = search.trim().toLowerCase();
		if (q && !`${r.agent} ${r.channel}`.toLowerCase().includes(q)) return false;
		return true;
	}));
	const totalInteractions = $derived(filtered.reduce((n, r) => n + r.interactions, 0));
	const avgAll = $derived(filtered.length ? filtered.reduce((n, r) => n + r.avg * r.interactions, 0) / Math.max(1, totalInteractions) : 0);
	const pageCount = $derived(Math.max(1, Math.ceil(filtered.length / perPage)));
	const safePage = $derived(Math.min(page, pageCount));
	const pageRows = $derived(filtered.slice((safePage - 1) * perPage, safePage * perPage));
	const barData = $derived(filtered.map((r) => ({ label: r.agent.split(' ')[0], value: Number(r.avg.toFixed(1)) })));
	const chartConfig = { value: { label: 'Rata-rata skor' } } satisfies import('$lib/components/ui/chart').ChartConfig;

	function openDetail(name: string) { detailName = name; detailOpen = true; }
	function reset() { channel = 'all'; agent = 'all'; minScore = 1; onlyComment = false; search = ''; page = 1; }
	function stars(v: number) { return Array.from({ length: 5 }, (_, i) => i < Math.round(v)); }
</script>

<svelte:head><title>CSAT Interaction — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
	<div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-end">
		<div><h1 class="flex items-center gap-2 text-xl font-bold"><MessagesSquare size={20} class="text-primary" />CSAT Interaction</h1><p class="mt-1 text-sm text-muted-foreground">Rating per interaksi & agent: distribusi bintang 1–5, rata-rata skor, dan komentar.</p></div>
		<div class="flex gap-2"><Button size="sm" variant="outline" onclick={reset}><RotateCcw data-icon="inline-start" />Reset</Button><Button size="sm"><Download data-icon="inline-start" />Ekspor</Button></div>
	</div>

	<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
		<Card.Root><Card.Content class="p-4"><p class="text-xs text-muted-foreground">Total interaksi ternilai</p><p class="mt-1 text-2xl font-bold">{totalInteractions}</p><Progress value={Math.min(100, totalInteractions / 4)} class="mt-3" /></Card.Content></Card.Root>
		<Card.Root><Card.Content class="p-4"><p class="text-xs text-muted-foreground">Rata-rata skor</p><p class="mt-1 flex items-center gap-1 text-2xl font-bold"><Star size={20} class="fill-amber-400 text-amber-400" />{avgAll.toFixed(1)}</p><div class="mt-2 flex gap-0.5">{#each stars(avgAll) as on}<Star size={14} class={on ? 'fill-amber-400 text-amber-400' : 'text-muted-foreground'} />{/each}</div></Card.Content></Card.Root>
		<Card.Root><Card.Content class="p-4"><p class="text-xs text-muted-foreground">Agent di atas target (≥ 4.0)</p><p class="mt-1 text-2xl font-bold">{filtered.filter((r) => r.avg >= 4).length}/{filtered.length}</p><p class="mt-2 text-xs text-muted-foreground">Target CSAT interaksi: 4.0/5.0</p></Card.Content></Card.Root>
	</div>

	{#if filtered.some((r) => r.avg < 3.8)}
		<Alert.Root variant="destructive"><TriangleAlert /><Alert.Title>Perlu coaching</Alert.Title><Alert.Description>{filtered.filter((r) => r.avg < 3.8).length} agent di bawah 3.8 — jadwalkan review interaksi minggu ini.</Alert.Description></Alert.Root>
	{/if}

	<Card.Root>
		<Card.Header><Card.Title class="flex items-center gap-2"><SlidersHorizontal size={16} />Filter interaksi</Card.Title></Card.Header>
		<Card.Content>
			<Field.FieldGroup class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
				<Field.Field><Field.Label for="ci-channel">Channel</Field.Label>
					<Select.Root type="single" bind:value={channel}><Select.Trigger id="ci-channel"><Select.Value placeholder="Semua channel" /></Select.Trigger><Select.Content><Select.Item value="all">Semua channel</Select.Item><Select.Item value="WhatsApp">WhatsApp</Select.Item><Select.Item value="Voice">Voice</Select.Item><Select.Item value="Live Chat">Live Chat</Select.Item><Select.Item value="Email">Email</Select.Item></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label for="ci-agent">Agent</Field.Label>
					<Select.Root type="single" bind:value={agent}><Select.Trigger id="ci-agent"><Select.Value placeholder="Semua agent" /></Select.Trigger><Select.Content><Select.Item value="all">Semua agent</Select.Item>{#each rows as r}<Select.Item value={r.agent}>{r.agent}</Select.Item>{/each}</Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label for="ci-min">Skor minimum: {minScore.toFixed(1)}</Field.Label><Slider id="ci-min" type="single" bind:value={minScore} min={1} max={5} step={0.5} /></Field.Field>
				<Field.Field><Field.Label for="ci-q">Pencarian</Field.Label><div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="ci-q" bind:value={search} placeholder="Cari agent / channel" class="pl-8" /></div></Field.Field>
			</Field.FieldGroup>
			<div class="mt-4 flex flex-wrap items-center justify-between gap-3">
				<label class="flex items-center gap-2 text-sm"><Switch bind:checked={onlyComment} />Hanya yang ada komentar</label>
				<ToggleGroup.Root type="single" bind:value={view} class="justify-start"><ToggleGroup.Item value="table">Tabel</ToggleGroup.Item><ToggleGroup.Item value="chart">Grafik</ToggleGroup.Item></ToggleGroup.Root>
			</div>
		</Card.Content>
	</Card.Root>

	{#if view === 'chart'}
		<Card.Root>
			<Card.Header><Card.Title>Rata-rata skor per agent</Card.Title><p class="text-sm text-muted-foreground">Visualisasi {filtered.length} agent yang lolos filter.</p></Card.Header>
			<Card.Content>
				<Chart.Container config={chartConfig} class="aspect-auto h-72">
					<LCChart data={barData} x="label" y="value" padding={{ left: 8, right: 8 }}>
						<Svg><Grid vertical={false} /><Axis placement="bottom" /><Axis placement="left" grid rule domain={[0, 5]} /><Bars radius={6} /></Svg>
					</LCChart>
				</Chart.Container>
			</Card.Content>
		</Card.Root>
	{/if}

	<Card.Root>
		<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>Rating per agent</Card.Title><p class="mt-1 text-sm text-muted-foreground">{filtered.length} agent · {totalInteractions} interaksi.</p></div><Badge variant="secondary">Target ≥ 4.0</Badge></Card.Header>
		<Card.Content>
			{#if filtered.length > 0}
				<div class="overflow-x-auto rounded-xl border">
					<Table.Root>
						<Table.Header><Table.Row><Table.Head>Agent</Table.Head><Table.Head>Channel</Table.Head><Table.Head class="text-right">Interaksi</Table.Head><Table.Head>Rata-rata</Table.Head><Table.Head>Distribusi 5→1</Table.Head><Table.Head>Komentar</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header>
						<Table.Body>
							{#each pageRows as r}
								<Table.Row>
									<Table.Cell class="font-medium">{r.agent}</Table.Cell>
									<Table.Cell><Badge variant="outline">{r.channel}</Badge></Table.Cell>
									<Table.Cell class="text-right">{r.interactions}</Table.Cell>
									<Table.Cell><span class="flex items-center gap-1 font-semibold"><Star size={13} class="fill-amber-400 text-amber-400" />{r.avg.toFixed(1)}</span><Progress value={(r.avg / 5) * 100} class="mt-1 w-24" /></Table.Cell>
									<Table.Cell class="text-xs text-muted-foreground">{r.s5} · {r.s4} · {r.s3} · {r.s2} · {r.s1}</Table.Cell>
									<Table.Cell>{#if r.comment}<Badge variant="success">Ada</Badge>{:else}<Badge variant="secondary">Tidak</Badge>{/if}</Table.Cell>
									<Table.Cell class="text-right"><Button size="sm" variant="outline" onclick={() => openDetail(r.agent)}>Detail</Button></Table.Cell>
								</Table.Row>
							{/each}
						</Table.Body>
					</Table.Root>
				</div>
				<Separator class="my-4" />
				<div class="flex justify-center">
					<Pagination.Root bind:page count={filtered.length} perPage={perPage} siblingCount={1}>
						{#snippet children({ pages })}
							<Pagination.Content>
								<Pagination.Item><Pagination.Previous /></Pagination.Item>
								{#each pages as p (p.key)}{#if p.type === 'ellipsis'}<Pagination.Item><Pagination.Ellipsis /></Pagination.Item>{:else}<Pagination.Item><Pagination.Link page={p.value} isActive={safePage === p.value}>{p.value}</Pagination.Link></Pagination.Item>{/if}{/each}
								<Pagination.Item><Pagination.Next /></Pagination.Item>
							</Pagination.Content>
						{/snippet}
					</Pagination.Root>
				</div>
			{:else}
				<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><Search size={20} /></Empty.Media><Empty.Title>Tidak ada interaksi</Empty.Title><Empty.Description>Tidak ada agent yang cocok — longgarkan skor minimum atau matikan filter komentar.</Empty.Description></Empty.Header><Empty.Content><Button size="sm" variant="outline" onclick={reset}>Reset filter</Button></Empty.Content></Empty.Root>
			{/if}
		</Card.Content>
	</Card.Root>

	<Dialog.Root bind:open={detailOpen}>
		<Dialog.Content>
			<Dialog.Header><Dialog.Title>Detail interaksi — {detailName}</Dialog.Title><Dialog.Description>Ringkasan rating, tren mingguan, dan contoh komentar pelanggan.</Dialog.Description></Dialog.Header>
			<div class="flex flex-col gap-3 text-sm">
				<div class="flex items-center justify-between rounded-lg bg-muted/50 p-3"><span class="text-muted-foreground">Rata-rata 4 minggu</span><span class="font-semibold">4.3 / 5.0</span></div>
				<Progress value={86} />
				<p class="text-muted-foreground">“Agent sigap dan solutif.” — contoh komentar CSAT 5 bintang.</p>
			</div>
			<Dialog.Footer><Button size="sm" variant="outline" onclick={() => (detailOpen = false)}>Tutup</Button></Dialog.Footer>
		</Dialog.Content>
	</Dialog.Root>
</div>
