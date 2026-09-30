<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as Select from '$lib/components/ui/select';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as Alert from '$lib/components/ui/alert';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as ToggleGroup from '$lib/components/ui/toggle-group';
	import * as Dialog from '$lib/components/ui/dialog';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import { Input } from '$lib/components/ui/input';
	import * as Empty from '$lib/components/ui/empty';
	import * as Popover from '$lib/components/ui/popover';
	import { Calendar } from '$lib/components/ui/calendar';
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Plus, Search, RefreshCw, ChevronRight, CalendarDays, Info, CalendarClock, CalendarIcon } from 'lucide-svelte';
	import { CalendarDate, DateFormatter, getLocalTimeZone, type DateValue } from '@internationalized/date';

	const df = new DateFormatter('id-ID', { dateStyle: 'medium' });

	let q = $state(''); let status = $state('semua'); let tab = $state('daftar'); let loading = $state(false); let open = $state(false);
	let date = $state<DateValue | undefined>(new CalendarDate(2026, 9, 30));
	const schedules = [
		{ date: '30 Sep 2026', agents: 12, channels: ['Omnichannel', 'Inbound Call'], status: 'Terjadwal', cap: 92 },
		{ date: '01 Okt 2026', agents: 14, channels: ['Omnichannel', 'Email', 'Inbound Call'], status: 'Terjadwal', cap: 96 },
		{ date: '02 Okt 2026', agents: 13, channels: ['Omnichannel', 'Email'], status: 'Terjadwal', cap: 88 },
		{ date: '03 Okt 2026', agents: 8, channels: ['Omnichannel'], status: 'Terbatas', cap: 55 },
		{ date: '04 Okt 2026', agents: 0, channels: [], status: 'Libur', cap: 0 }
	];
	let filtered = $derived(schedules.filter((s) => s.date.toLowerCase().includes(q.toLowerCase()) && (status === 'semua' || s.status === status)));
	function search() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : Search);

</script>

<svelte:head><title>Agent Schedule</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header class="flex-row items-center justify-between gap-3"><div><Card.Title>Daftar Jadwal Agent</Card.Title><Card.Description>Cari nama / username / email · {filtered.length} entri</Card.Description></div><Button onclick={() => (open = true)}><Plus data-icon="inline-start" />Tambah Jadwal</Button></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_200px_auto]">
				<Field.Field><Field.Label for="q">Pencarian</Field.Label><div class="relative"><Search data-icon="input" /><Input id="q" bind:value={q} placeholder="Cari nama / username / email" class="pl-9" /></div></Field.Field>
				<Field.Field>
					<Field.Label for="st">Status</Field.Label>
					<Select.Root type="single" bind:value={status}><Select.Trigger id="st" class="w-full">{status}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Status</Select.GroupHeading><Select.Item value="semua">Semua</Select.Item><Select.Item value="Terjadwal">Terjadwal</Select.Item><Select.Item value="Terbatas">Terbatas</Select.Item><Select.Item value="Libur">Libur</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><div class="flex gap-2"><Button onclick={search} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? 'Mencari' : 'Cari'}</span></Button><Button variant="outline" onclick={() => (q = '')}><RefreshCw data-icon="inline-start" />Reset</Button></div></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={tab} aria-label="Tampilan"><ToggleGroup.Item value="daftar">Daftar</ToggleGroup.Item><ToggleGroup.Item value="kalender">Kalender</ToggleGroup.Item></ToggleGroup.Root>
			<Tabs.Root bind:value={tab}><Tabs.List><Tabs.Trigger value="daftar">Daftar</Tabs.Trigger><Tabs.Trigger value="kalender">Kalender</Tabs.Trigger></Tabs.List></Tabs.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">Showing {filtered.length} of {schedules.length} entries</Card.Footer>
	</Card.Root>

	{#if tab === 'kalender'}
		<Card.Root><Card.Header><Card.Title>Kalender jadwal</Card.Title><Card.Description>Pilih tanggal untuk melihat detail.</Card.Description></Card.Header><Card.Content><Popover.Root><Popover.Trigger aria-label="Pilih tanggal jadwal">{#snippet child({ props })}<Button {...props} variant="outline" class="justify-start px-2.5 font-normal"><CalendarIcon data-icon="inline-start" />{#if date}{df.format(date.toDate(getLocalTimeZone()))}{:else}<span>Pilih tanggal</span>{/if}</Button>{/snippet}</Popover.Trigger><Popover.Content class="w-auto p-0" align="start"><Popover.Title class="sr-only">Pilih tanggal jadwal</Popover.Title><Popover.Description class="sr-only">Kalender jadwal</Popover.Description><Calendar type="single" bind:value={date} /></Popover.Content></Popover.Root></Card.Content><Card.Footer><p class="text-muted-foreground text-xs">Tanggal terpilih: {date?.toString() ?? '-'}</p></Card.Footer></Card.Root>
	{:else}
		<Card.Root>
			<Card.Header><Card.Title>Jadwal per tanggal</Card.Title><Card.Description>Kolom: No, Tanggal, Jumlah Agent, Channel, Aksi.</Card.Description></Card.Header>
			<Card.Content class="flex flex-col gap-4">
				<div class="flex flex-col gap-2">{#each filtered as s}<div class="flex items-center gap-3"><Badge variant="outline" class="min-w-24 justify-center">{s.date}</Badge><Progress value={s.cap} class="flex-1" /><span class="text-xs font-medium">{s.cap}%</span></div>{/each}</div>
				{#if loading}
					<div class="flex flex-col gap-2">{#each [1, 2, 3] as _}<Skeleton class="h-12 w-full" />{/each}</div>
				{:else if filtered.length === 0}
					<Empty.Root><Empty.Header><Empty.Media><CalendarClock data-icon="empty" /></Empty.Media><Empty.Title>Tidak ada jadwal</Empty.Title><Empty.Description>Tambah jadwal baru untuk tanggal ini.</Empty.Description></Empty.Header><Empty.Content><Button size="sm" onclick={() => (open = true)}><Plus data-icon="inline-start" />Tambah Jadwal</Button></Empty.Content></Empty.Root>
				{:else}
					<Table.Root><Table.Header><Table.Row><Table.Head>No</Table.Head><Table.Head>Tanggal</Table.Head><Table.Head>Jumlah Agent</Table.Head><Table.Head>Channel</Table.Head><Table.Head>Kapasitas</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header>
					<Table.Body>{#each filtered as s, i}<Table.Row><Table.Cell class="text-muted-foreground">{i + 1}</Table.Cell><Table.Cell class="font-medium">{s.date}</Table.Cell><Table.Cell><span class="flex items-center gap-2"><Avatar.Root class="size-6"><Avatar.Fallback>{String(s.agents)}</Avatar.Fallback></Avatar.Root>{s.agents} agent</span></Table.Cell><Table.Cell><div class="flex min-w-48 flex-wrap gap-1.5">{#each s.channels as c}<Badge variant="secondary">{c}</Badge>{:else}<span class="text-muted-foreground text-sm">-</span>{/each}</div></Table.Cell><Table.Cell><div class="flex items-center gap-2"><Progress value={s.cap} class={cn('w-20', s.cap < 60 && 'opacity-70')} /><span class="text-xs">{s.cap}%</span></div></Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="sm">Detail<ChevronRight data-icon="inline-end" /></Button></Tooltip.Trigger><Tooltip.Content>Jadwal {s.date}</Tooltip.Content></Tooltip.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
				{/if}
			</Card.Content>
			<Card.Footer><Separator class="my-1" /><Alert.Root variant="success"><CalendarDays data-icon="alert" /><Alert.Description>Jadwal tersimpan otomatis ke workforce.</Alert.Description></Alert.Root></Card.Footer>
		</Card.Root>
	{/if}
	<p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> Channel: Omnichannel, Inbound Call, Email</p>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>Tambah Jadwal</Dialog.Title><Dialog.Description>Buat jadwal agent baru per tanggal dan channel.</Dialog.Description></Dialog.Header><Field.FieldGroup class="flex flex-col gap-4 py-2"><Field.Field><Field.Label for="d">Tanggal</Field.Label><Input id="d" type="date" /></Field.Field></Field.FieldGroup><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>Batal</Button><Button onclick={() => (open = false)}>Simpan</Button></Dialog.Footer></Dialog.Content></Dialog.Root>

