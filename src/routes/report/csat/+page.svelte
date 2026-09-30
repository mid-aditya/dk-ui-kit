<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Select from '$lib/components/ui/select';
	import * as Field from '$lib/components/ui/field';
	import * as Pagination from '$lib/components/ui/pagination';
	import * as Empty from '$lib/components/ui/empty';
	import * as Alert from '$lib/components/ui/alert';
	import * as Popover from '$lib/components/ui/popover';
	import * as Chart from '$lib/components/ui/chart';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { RangeCalendar } from '$lib/components/ui/range-calendar';
	import { CalendarDate, DateFormatter, getLocalTimeZone } from '@internationalized/date';
	import type { DateRange } from 'bits-ui';
	import { Chart as LCChart, Svg, Axis, Grid, Bars, Area } from 'layerchart';
	import { Download, Filter, RotateCcw, Search, Smile, Meh, Frown, CalendarIcon, Info, Phone, CircleCheck, ChartLine, CircleX } from 'lucide-svelte';

	const df = new DateFormatter('id-ID', { dateStyle: 'medium' });
	let period = $state<DateRange | undefined>({ start: new CalendarDate(2026, 1, 1), end: new CalendarDate(2026, 9, 30) });
	let kanal = $state('all');
	let agent = $state('all');
	let status = $state('all');
	let search = $state('');
	let page = $state(1);
	const perPage = 5;

	type Row = { customer: string; kanal: string; ticket: string; created: string; time: string; score: '1' | '2' | '3' | null; agent: string };
	const rows: Row[] = [
		{ customer: 'NINA', kanal: 'Inbound', ticket: 'T-2026-0101', created: '12 Sep 2026', time: '10:34:12', score: '1', agent: 'Ayu Lestari' },
		{ customer: 'EVA SITI RAHMATILLAH', kanal: 'Inbound', ticket: 'T-2026-0102', created: '12 Sep 2026', time: '11:10:44', score: '2', agent: 'Rizky Pratama' },
		{ customer: 'BUDI SANTOSO', kanal: 'WA Call', ticket: 'T-2026-0103', created: '13 Sep 2026', time: '09:22:05', score: '3', agent: 'Dewi Anggraini' },
		{ customer: 'SITI AMINAH', kanal: 'Inbound', ticket: 'T-2026-0104', created: '13 Sep 2026', time: '13:45:30', score: null, agent: 'Fajar Nugraha' },
		{ customer: 'ANDI WIJAYA', kanal: 'WA Call', ticket: 'T-2026-0105', created: '14 Sep 2026', time: '08:15:00', score: '1', agent: 'Ayu Lestari' },
		{ customer: 'DEWI PUSPITA', kanal: 'Inbound', ticket: 'T-2026-0106', created: '14 Sep 2026', time: '15:02:11', score: '1', agent: 'Rizky Pratama' },
		{ customer: 'HENDRA GUNAWAN', kanal: 'WA Call', ticket: 'T-2026-0107', created: '15 Sep 2026', time: '10:00:00', score: null, agent: 'Dewi Anggraini' },
		{ customer: 'RINA MARLINA', kanal: 'Inbound', ticket: 'T-2026-0108', created: '15 Sep 2026', time: '16:40:09', score: '2', agent: 'Fajar Nugraha' }
	];

	const scoreLabel: Record<string, string> = { '1': 'Puas', '2': 'Cukup Puas', '3': 'Kurang Puas' };
	function scoreVariant(s: Row['score']) { return s === '1' ? 'success' as const : s === '2' ? 'warning' as const : s === '3' ? 'destructive' as const : 'secondary' as const; }

	const filtered = $derived(rows.filter((r) => {
		if (kanal !== 'all' && r.kanal !== kanal) return false;
		if (agent !== 'all' && r.agent !== agent) return false;
		if (status === 'filled' && r.score === null) return false;
		if (status === 'empty' && r.score !== null) return false;
		const q = search.trim().toLowerCase();
		if (q && !`${r.customer} ${r.ticket} ${r.agent}`.toLowerCase().includes(q)) return false;
		return true;
	}));
	const total = rows.length;
	const filled = $derived(rows.filter((r) => r.score !== null).length);
	const empty = $derived(total - filled);
	const rate = $derived(Math.round((filled / Math.max(1, total)) * 100));
	const pageCount = $derived(Math.max(1, Math.ceil(filtered.length / perPage)));
	const safePage = $derived(Math.min(page, pageCount));
	const pageRows = $derived(filtered.slice((safePage - 1) * perPage, safePage * perPage));

	const dist = [
		{ label: 'Puas (1)', value: 3, color: 'var(--color-success, #16a34a)' },
		{ label: 'Cukup (2)', value: 2, color: 'var(--color-warning, #d97706)' },
		{ label: 'Kurang (3)', value: 1, color: 'var(--color-destructive, #dc2626)' },
		{ label: 'Belum isi', value: 2, color: 'var(--color-muted-foreground, #9ca3af)' }
	];
	const trend = [
		{ day: '12 Sep', total: 2, filled: 2 }, { day: '13 Sep', total: 2, filled: 1 },
		{ day: '14 Sep', total: 2, filled: 2 }, { day: '15 Sep', total: 2, filled: 1 }
	];
	const chartConfig = { value: { label: 'Responden' }, total: { label: 'Total' }, filled: { label: 'Terisi' } } satisfies import('$lib/components/ui/chart').ChartConfig;

	function reset() { kanal = 'all'; agent = 'all'; status = 'all'; search = ''; page = 1; period = { start: new CalendarDate(2026, 1, 1), end: new CalendarDate(2026, 9, 30) }; }
	const agents = ['Ayu Lestari', 'Rizky Pratama', 'Dewi Anggraini', 'Fajar Nugraha'];
</script>

<svelte:head><title>Dashboard CSAT — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
	<div>
		<h1 class="flex items-center gap-2 text-xl font-bold"><Smile size={20} class="text-primary" />Dashboard CSAT</h1>
		<p class="mt-1 flex items-center gap-1 text-xs text-muted-foreground"><ChartLine size={13} />Kepuasan pelanggan dari IVR PBX (PABXCC) — 1=Puas, 2=Cukup Puas, 3=Kurang Puas</p>
	</div>

	<Alert.Root variant="warning"><Info /><Alert.Title>Filter aktif</Alert.Title><Alert.Description>Menampilkan {filtered.length} dari {total} record IVR CSAT pada rentang terpilih.</Alert.Description></Alert.Root>

	<div class="grid grid-cols-1 gap-4 md:grid-cols-4">
		{#each [
			{ icon: Phone, label: 'Total Record CSAT (IVR)', value: String(total) },
			{ icon: CircleCheck, label: 'CSAT Terisi', value: String(filled) },
			{ icon: ChartLine, label: 'Tingkat Pengisian', value: `${rate}%` },
			{ icon: CircleX, label: 'CSAT Belum Diisi', value: String(empty) }
		] as s}
			<Card.Root><Card.Content class="flex items-center gap-3 p-4"><div class="flex size-10 items-center justify-center rounded-xl bg-primary/10 text-primary"><s.icon size={19} /></div><div><p class="text-xl font-bold">{s.value}</p><p class="text-xs text-muted-foreground">{s.label}</p>{#if s.label.includes('Pengisian')}<Progress value={rate} class="mt-2 w-28" />{/if}</div></Card.Content></Card.Root>
		{/each}
	</div>

	<Card.Root>
		<Card.Header><Card.Title>Filter laporan</Card.Title><p class="text-sm text-muted-foreground">Saring berdasarkan periode, kanal, agent, dan status pengisian.</p></Card.Header>
		<Card.Content>
			<Field.FieldGroup class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
				<Field.Field>
					<Field.Label>Periode</Field.Label>
					<Popover.Root>
						<Popover.Trigger id="csat-period">
							{#snippet child({ props })}
								<Button {...props} variant="outline" class="w-full justify-start px-2.5 font-normal"><CalendarIcon data-icon="inline-start" />{#if period?.start}{#if period.end}{df.format(period.start.toDate(getLocalTimeZone()))} - {df.format(period.end.toDate(getLocalTimeZone()))}{:else}{df.format(period.start.toDate(getLocalTimeZone()))}{/if}{:else}<span>Pilih periode</span>{/if}</Button>
							{/snippet}
						</Popover.Trigger>
						<Popover.Content class="w-auto p-0" align="start"><RangeCalendar bind:value={period} numberOfMonths={1} locale="id-ID" /></Popover.Content>
					</Popover.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-kanal">Kanal</Field.Label>
					<Select.Root type="single" bind:value={kanal}><Select.Trigger id="csat-kanal"><Select.Value placeholder="Semua" /></Select.Trigger><Select.Content><Select.Item value="all">Semua</Select.Item><Select.Item value="Inbound">Inbound</Select.Item><Select.Item value="WA Call">WA Call</Select.Item></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-agent">Agent</Field.Label>
					<Select.Root type="single" bind:value={agent}><Select.Trigger id="csat-agent"><Select.Value placeholder="Semua agent" /></Select.Trigger><Select.Content><Select.Item value="all">Semua agent</Select.Item>{#each agents as a}<Select.Item value={a}>{a}</Select.Item>{/each}</Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-status">Status CSAT</Field.Label>
					<Select.Root type="single" bind:value={status}><Select.Trigger id="csat-status"><Select.Value placeholder="Semua" /></Select.Trigger><Select.Content><Select.Item value="all">Semua</Select.Item><Select.Item value="filled">Terisi</Select.Item><Select.Item value="empty">Belum diisi</Select.Item></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-q">Pencarian</Field.Label>
					<div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="csat-q" bind:value={search} placeholder="Pelapor / tiket / agent" class="pl-8" /></div>
				</Field.Field>
			</Field.FieldGroup>
			<div class="mt-4 flex flex-wrap items-center justify-between gap-2">
				<div class="flex gap-2"><Button size="sm"><Filter data-icon="inline-start" />Terapkan filter</Button><Button size="sm" variant="outline" onclick={reset}><RotateCcw data-icon="inline-start" />Reset</Button></div>
				<Button size="sm" variant="secondary"><Download data-icon="inline-start" />Export Excel</Button>
			</div>
		</Card.Content>
	</Card.Root>

	<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
		<Card.Root>
			<Card.Header><Card.Title>Distribusi skor CSAT</Card.Title><p class="text-sm text-muted-foreground">Puas / cukup / kurang / belum mengisi.</p></Card.Header>
			<Card.Content>
				<Chart.Container config={chartConfig} class="aspect-auto h-64">
					<LCChart data={dist} x="label" y="value" padding={{ left: 8, right: 8 }}>
						<Svg><Grid vertical={false} /><Axis placement="bottom" /><Axis placement="left" grid rule /><Bars radius={6} /></Svg>
					</LCChart>
				</Chart.Container>
				<div class="mt-3 flex flex-col gap-2">{#each dist as d}<div class="flex items-center justify-between text-xs"><span class="text-muted-foreground">{d.label}</span><span class="font-semibold">{d.value}</span></div><Progress value={(d.value / Math.max(1, total)) * 100} />{/each}</div>
			</Card.Content>
		</Card.Root>
		<Card.Root>
			<Card.Header><Card.Title>Tren CSAT per hari</Card.Title><p class="text-sm text-muted-foreground">Total vs terisi.</p></Card.Header>
			<Card.Content>
				<Chart.Container config={chartConfig} class="aspect-auto h-64">
					<LCChart data={trend} x="day" y="total" yNice padding={{ left: 8, right: 8 }}>
						<Svg><Grid vertical={false} /><Axis placement="bottom" /><Axis placement="left" grid rule /><Area y1="total" fill="var(--color-primary)" fillOpacity={0.15} stroke="var(--color-primary)" /><Area y1="filled" fill="var(--color-success, #16a34a)" fillOpacity={0.2} stroke="var(--color-success, #16a34a)" /></Svg>
					</LCChart>
				</Chart.Container>
				<Separator class="my-3" />
				<div class="flex flex-wrap gap-2 text-xs"><Badge variant="secondary">Total CSAT</Badge><Badge variant="secondary">CSAT Terisi</Badge><Badge variant="outline"><Smile size={12} />1 = Puas</Badge><Badge variant="outline"><Meh size={12} />2 = Cukup</Badge><Badge variant="outline"><Frown size={12} />3 = Kurang</Badge></div>
			</Card.Content>
		</Card.Root>
	</div>

	<Card.Root>
		<Card.Header class="flex-row items-center justify-between space-y-0">
			<div><Card.Title>Detail laporan CSAT</Card.Title><p class="mt-1 text-sm text-muted-foreground">Total {total} · menampilkan {pageRows.length} tiket per halaman.</p></div>
			<Badge variant="secondary">{filtered.length} data</Badge>
		</Card.Header>
		<Card.Content>
			{#if filtered.length > 0}
				<div class="overflow-x-auto rounded-xl border">
					<Table.Root>
						<Table.Header><Table.Row><Table.Head>No</Table.Head><Table.Head>Pelapor</Table.Head><Table.Head>Kanal</Table.Head><Table.Head>No. Tiket</Table.Head><Table.Head>Tgl Tiket</Table.Head><Table.Head>Waktu CSAT</Table.Head><Table.Head>Skor</Table.Head><Table.Head>Keterangan</Table.Head><Table.Head>Agent</Table.Head></Table.Row></Table.Header>
						<Table.Body>
							{#each pageRows as r, i}
								<Table.Row><Table.Cell>{(safePage - 1) * perPage + i + 1}</Table.Cell><Table.Cell class="font-medium">{r.customer}</Table.Cell><Table.Cell>{r.kanal}</Table.Cell><Table.Cell class="font-mono text-xs">{r.ticket}</Table.Cell><Table.Cell>{r.created}</Table.Cell><Table.Cell>{r.time}</Table.Cell><Table.Cell><Badge variant={scoreVariant(r.score)}>{r.score ?? 'Belum diisi'}</Badge></Table.Cell><Table.Cell>{r.score ? scoreLabel[r.score] : 'Belum diisi'}</Table.Cell><Table.Cell>{r.agent}</Table.Cell></Table.Row>
							{/each}
						</Table.Body>
					</Table.Root>
				</div>
				<div class="mt-4 flex justify-center">
					<Pagination.Root bind:page count={filtered.length} perPage={perPage} siblingCount={1}>
						{#snippet children({ pages, range })}
							<Pagination.Content>
								<Pagination.Item><Pagination.Previous /></Pagination.Item>
								{#each pages as p (p.key)}
									{#if p.type === 'ellipsis'}<Pagination.Item><Pagination.Ellipsis /></Pagination.Item>
									{:else}<Pagination.Item><Pagination.Link page={p.value} isActive={safePage === p.value}>{p.value}</Pagination.Link></Pagination.Item>{/if}
								{/each}
								<Pagination.Item><Pagination.Next /></Pagination.Item>
							</Pagination.Content>
							<span class="sr-only">{range.start}-{range.end}</span>
						{/snippet}
					</Pagination.Root>
				</div>
			{:else}
				<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><Search size={20} /></Empty.Media><Empty.Title>Tidak ada data</Empty.Title><Empty.Description>Tidak ada record CSAT yang cocok dengan filter saat ini.</Empty.Description></Empty.Header><Empty.Content><Button size="sm" variant="outline" onclick={reset}>Reset filter</Button></Empty.Content></Empty.Root>
			{/if}
		</Card.Content>
	</Card.Root>
</div>
