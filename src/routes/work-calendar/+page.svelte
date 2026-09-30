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
	import { RangeCalendar } from '$lib/components/ui/range-calendar';
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Plus, Upload, Search, Pencil, Trash2, CalendarDays, Info, Palmtree } from 'lucide-svelte';
	import { CalendarDate } from '@internationalized/date';
	import type { DateRange } from 'bits-ui';

	let year = $state('2026'); let category = $state('all'); let q = $state(''); let tab = $state('daftar');
	let loading = $state(false); let open = $state(false); let bulk = $state(false);
	let period = $state<DateRange | undefined>({ start: new CalendarDate(2026, 1, 1), end: new CalendarDate(2026, 12, 31) });
	let holidays = $state([
		{ date: '01 Jan 2026', name: 'Tahun Baru 2026', category: 'Libur Nasional', status: 'Aktif', tmpl: 'Ya' },
		{ date: '16 Jan 2026', name: 'Isra Mikraj Nabi Muhammad SAW', category: 'Libur Nasional', status: 'Aktif', tmpl: 'Ya' },
		{ date: '17 Agu 2026', name: 'Hari Kemerdekaan RI', category: 'Libur Nasional', status: 'Aktif', tmpl: 'Tidak' },
		{ date: '25 Des 2026', name: 'Hari Raya Natal', category: 'Libur Nasional', status: 'Aktif', tmpl: 'Ya' },
		{ date: '12 Mar 2026', name: 'Cuti Bersama Internal', category: 'Custom', status: 'Nonaktif', tmpl: 'Tidak' }
	]);
	let filtered = $derived(holidays.filter((h) => (category === 'all' || h.category === category) && `${h.date} ${h.name}`.toLowerCase().includes(q.toLowerCase())));
	function load() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : CalendarDays);
	function save() { holidays = [...holidays, { date: '31 Des 2026', name: 'Hari Libur Custom', category: 'Custom', status: 'Aktif', tmpl: 'Tidak' }]; open = false; }
	const chartConfig = { n: { label: 'Hari libur', color: 'var(--primary)' } };
	const perCat = $derived([
		{ label: 'Nasional', value: holidays.filter((h) => h.category === 'Libur Nasional').length * 20 },
		{ label: 'Pemerintahan', value: 10 }, { label: 'Custom', value: holidays.filter((h) => h.category === 'Custom').length * 20 }
	]);
</script>

<svelte:head><title>Work Calendar</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header class="flex-row flex-wrap items-center justify-between gap-3">
			<div><Card.Title>Work Calendar</Card.Title><Card.Description>Kelola hari libur nasional dan pemerintahan untuk perhitungan SLA.</Card.Description></div>
			<div class="flex flex-wrap gap-2"><Button onclick={() => (open = true)}><Plus data-icon="inline-start" />Tambah Hari Libur</Button><Button variant="outline" onclick={() => (bulk = true)}><Upload data-icon="inline-start" />Import Bulk</Button></div>
		</Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[140px_200px_1fr_auto]">
				<Field.Field>
					<Field.Label for="yr">Tahun</Field.Label>
					<Select.Root type="single" bind:value={year}><Select.Trigger id="yr" class="w-full">{year}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Tahun</Select.GroupHeading><Select.Item value="2025">2025</Select.Item><Select.Item value="2026">2026</Select.Item><Select.Item value="2027">2027</Select.Item><Select.Item value="2028">2028</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="cat">Kategori</Field.Label>
					<Select.Root type="single" bind:value={category}><Select.Trigger id="cat" class="w-full">{category === 'all' ? 'Semua Kategori' : category}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Kategori</Select.GroupHeading><Select.Item value="all">Semua Kategori</Select.Item><Select.Item value="Libur Nasional">Libur Nasional</Select.Item><Select.Item value="Libur Pemerintahan">Libur Pemerintahan</Select.Item><Select.Item value="Custom">Custom</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label for="qq">Pencarian</Field.Label><div class="relative"><Search data-icon="input" /><Input id="qq" bind:value={q} placeholder="Cari nama hari libur…" class="pl-9" /></div></Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button variant="secondary" onclick={load} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? 'Loading' : 'Muat'}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={category} aria-label="Kategori"><ToggleGroup.Item value="all">Semua</ToggleGroup.Item><ToggleGroup.Item value="Libur Nasional">Nasional</ToggleGroup.Item><ToggleGroup.Item value="Libur Pemerintahan">Pemerintahan</ToggleGroup.Item><ToggleGroup.Item value="Custom">Custom</ToggleGroup.Item></ToggleGroup.Root>
			<Tabs.Root bind:value={tab}><Tabs.List><Tabs.Trigger value="daftar">Daftar</Tabs.Trigger><Tabs.Trigger value="periode">Periode</Tabs.Trigger></Tabs.List></Tabs.Root>
			{#if tab === 'periode'}<RangeCalendar bind:value={period} numberOfMonths={1} locale="id-ID" />{/if}
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">{filtered.length} hari libur pada kalender {year}.</Card.Footer>
	</Card.Root>

	<div class="grid gap-4 lg:grid-cols-[1fr_1.4fr]">
		<Card.Root>
			<Card.Header><Card.Title>Komposisi libur</Card.Title><Card.Description>Per kategori tahun {year}.</Card.Description></Card.Header>
			<Card.Content class="flex flex-col gap-3">
				<Chart.Container config={chartConfig} class="min-h-28"><div class="flex h-24 w-full items-end gap-2">{#each perCat as p}<div class="flex flex-1 flex-col items-center gap-1"><div class="w-full rounded bg-primary/80" style="height:{Math.max(8, p.value)}%"></div><span class="text-[10px]">{p.label}</span></div>{/each}</div></Chart.Container>
				{#each perCat as p}<div class="flex flex-col gap-1.5"><div class="flex justify-between text-sm"><span>{p.label}</span><span class="text-muted-foreground">{p.value}%</span></div><Progress value={p.value} /></div>{/each}
			</Card.Content>
			<Card.Footer><p class="text-muted-foreground text-xs">Dipakai untuk perhitungan SLA tiket.</p></Card.Footer>
		</Card.Root>
		<Card.Root>
			<Card.Header><Card.Title>Daftar hari libur</Card.Title><Card.Description>Kolom: No, Tanggal, Nama, Kategori, Status, Template, Actions.</Card.Description></Card.Header>
			<Card.Content>
				{#if loading}
					<div class="flex flex-col gap-2">{#each [1, 2, 3] as _}<Skeleton class="h-12 w-full" />{/each}</div>
				{:else if filtered.length === 0}
					<Empty.Root><Empty.Header><Empty.Media><Palmtree data-icon="empty" /></Empty.Media><Empty.Title>Tidak ada hari libur</Empty.Title><Empty.Description>Tambah hari libur baru atau ubah filter.</Empty.Description></Empty.Header></Empty.Root>
				{:else}
					<Table.Root><Table.Header><Table.Row><Table.Head>No</Table.Head><Table.Head>Tanggal</Table.Head><Table.Head>Nama</Table.Head><Table.Head>Kategori</Table.Head><Table.Head>Status</Table.Head><Table.Head class="text-right">Actions</Table.Head></Table.Row></Table.Header>
					<Table.Body>{#each filtered as h, i}<Table.Row><Table.Cell class="text-muted-foreground">{i + 1}</Table.Cell><Table.Cell class="whitespace-nowrap font-medium">{h.date}</Table.Cell><Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-6"><Avatar.Fallback>{h.name.slice(0, 1)}</Avatar.Fallback></Avatar.Root>{h.name}</div></Table.Cell><Table.Cell><Badge variant={h.category === 'Custom' ? 'secondary' : 'outline'} class={cn(h.category === 'Custom' && 'border-dashed')}>{h.category}</Badge></Table.Cell><Table.Cell><Badge variant={h.status === 'Aktif' ? 'success' : 'secondary'}>{h.status}</Badge></Table.Cell><Table.Cell class="text-right"><div class="flex justify-end gap-1"><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="icon" aria-label="Edit {h.name}"><Pencil data-icon="icon" /></Button></Tooltip.Trigger><Tooltip.Content>Edit</Tooltip.Content></Tooltip.Root><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="icon" aria-label="Hapus {h.name}"><Trash2 data-icon="icon" /></Button></Tooltip.Trigger><Tooltip.Content>Hapus</Tooltip.Content></Tooltip.Root></div></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
				{/if}
			</Card.Content>
			<Card.Footer><Separator class="my-1" /><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> Template “Ya” berarti dipakai balasan otomatis.</p></Card.Footer>
		</Card.Root>
	</div>
	<Alert.Root variant="success"><CalendarDays data-icon="alert" /><Alert.Description>Kalender {year} tersinkron dengan perhitungan SLA.</Alert.Description></Alert.Root>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>Tambah Hari Libur</Dialog.Title><Dialog.Description>Tambahkan hari libur custom ke kalender kerja.</Dialog.Description></Dialog.Header><Field.FieldGroup class="flex flex-col gap-4 py-2"><Field.Field><Field.Label for="hd">Tanggal</Field.Label><Input id="hd" type="date" /></Field.Field><Field.Field><Field.Label for="hn">Nama Hari Libur</Field.Label><Input id="hn" placeholder="Contoh: Hari Kemerdekaan" /></Field.Field></Field.FieldGroup><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>Batal</Button><Button onclick={save}>Simpan</Button></Dialog.Footer></Dialog.Content></Dialog.Root>
<Dialog.Root bind:open={bulk}><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>Import Bulk</Dialog.Title><Dialog.Description>Unggah CSV berisi tanggal, nama, dan kategori.</Dialog.Description></Dialog.Header><Dialog.Footer><Button variant="outline" onclick={() => (bulk = false)}>Batal</Button><Button onclick={() => (bulk = false)}>Upload</Button></Dialog.Footer></Dialog.Content></Dialog.Root>

