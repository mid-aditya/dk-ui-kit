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
	import DatePicker from "$lib/components/ui/date-picker.svelte";
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Plus, Search, RefreshCw, ChevronRight, CalendarDays, Info, CalendarClock } from 'lucide-svelte';
	import { CalendarDate, type DateValue } from '@internationalized/date';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'Agent Schedule',
			title: 'Daftar Jadwal Agent',
			descPre: 'Cari nama / username / email',
			entry: 'entri',
			add: 'Tambah Jadwal',
			search: 'Pencarian', searchPh: 'Cari nama / username / email',
			status: 'Status', stAll: 'Semua', stScheduled: 'Terjadwal', stLimited: 'Terbatas', stOff: 'Libur',
			find: 'Cari', finding: 'Mencari', reset: 'Reset',
			viewLabel: 'Tampilan', list: 'Daftar', calendar: 'Kalender',
			showingPre: 'Showing', showingMid: 'of', showingPost: 'entries',
			calTitle: 'Kalender jadwal', calDesc: 'Pilih tanggal untuk melihat detail.',
			pickDate: 'Pilih tanggal jadwal', pickPh: 'Pilih tanggal',
			picked: 'Tanggal terpilih:',
			perDateTitle: 'Jadwal per tanggal', perDateDesc: 'Kolom: No, Tanggal, Jumlah Agent, Channel, Aksi.',
			emptyTitle: 'Tidak ada jadwal', emptyDesc: 'Tambah jadwal baru untuk tanggal ini.',
			thNo: 'No', thDate: 'Tanggal', thCount: 'Jumlah Agent', thChannel: 'Channel', thCap: 'Kapasitas', thAct: 'Aksi',
			agentSuffix: 'agent',
			detail: 'Detail', schedTipPre: 'Jadwal',
			alert: 'Jadwal tersimpan otomatis ke workforce.',
			channelInfo: 'Channel: Omnichannel, Inbound Call, Email',
			dlgTitle: 'Tambah Jadwal', dlgDesc: 'Buat jadwal agent baru per tanggal dan channel.',
			dateLabel: 'Tanggal', newDateLabel: 'Tanggal jadwal baru',
			cancel: 'Batal', save: 'Simpan'
		},
		en: {
			docTitle: 'Agent Schedule',
			title: 'Agent Schedule List',
			descPre: 'Search name / username / email',
			entry: 'entries',
			add: 'Add Schedule',
			search: 'Search', searchPh: 'Search name / username / email',
			status: 'Status', stAll: 'All', stScheduled: 'Scheduled', stLimited: 'Limited', stOff: 'Off',
			find: 'Search', finding: 'Searching', reset: 'Reset',
			viewLabel: 'View', list: 'List', calendar: 'Calendar',
			showingPre: 'Showing', showingMid: 'of', showingPost: 'entries',
			calTitle: 'Schedule calendar', calDesc: 'Pick a date to see details.',
			pickDate: 'Pick a schedule date', pickPh: 'Pick a date',
			picked: 'Selected date:',
			perDateTitle: 'Schedule by date', perDateDesc: 'Columns: No, Date, Agent Count, Channel, Actions.',
			emptyTitle: 'No schedules', emptyDesc: 'Add a new schedule for this date.',
			thNo: 'No', thDate: 'Date', thCount: 'Agent Count', thChannel: 'Channel', thCap: 'Capacity', thAct: 'Actions',
			agentSuffix: 'agents',
			detail: 'Details', schedTipPre: 'Schedule',
			alert: 'Schedules are auto-saved to workforce.',
			channelInfo: 'Channels: Omnichannel, Inbound Call, Email',
			dlgTitle: 'Add Schedule', dlgDesc: 'Create a new agent schedule per date and channel.',
			dateLabel: 'Date', newDateLabel: 'New schedule date',
			cancel: 'Cancel', save: 'Save'
		},
		th: {
			docTitle: 'ตารางงานเอเจนต์',
			title: 'รายการตารางงานเอเจนต์',
			descPre: 'ค้นหาชื่อ / ยูสเซอร์เนม / อีเมล',
			entry: 'รายการ',
			add: 'เพิ่มตารางงาน',
			search: 'ค้นหา', searchPh: 'ค้นหาชื่อ / ยูสเซอร์เนม / อีเมล',
			status: 'สถานะ', stAll: 'ทั้งหมด', stScheduled: 'กำหนดแล้ว', stLimited: 'จำกัด', stOff: 'หยุด',
			find: 'ค้นหา', finding: 'กำลังค้นหา', reset: 'รีเซ็ต',
			viewLabel: 'มุมมอง', list: 'รายการ', calendar: 'ปฏิทิน',
			showingPre: 'แสดง', showingMid: 'จาก', showingPost: 'รายการ',
			calTitle: 'ปฏิทินตารางงาน', calDesc: 'เลือกวันที่เพื่อดูรายละเอียด',
			pickDate: 'เลือกวันที่ตารางงาน', pickPh: 'เลือกวันที่',
			picked: 'วันที่เลือก:',
			perDateTitle: 'ตารางงานตามวันที่', perDateDesc: 'คอลัมน์: ลำดับ, วันที่, จำนวนเอเจนต์, ช่องทาง, การดำเนินการ',
			emptyTitle: 'ไม่มีตารางงาน', emptyDesc: 'เพิ่มตารางงานใหม่สำหรับวันที่นี้',
			thNo: 'ลำดับ', thDate: 'วันที่', thCount: 'จำนวนเอเจนต์', thChannel: 'ช่องทาง', thCap: 'ความจุ', thAct: 'การดำเนินการ',
			agentSuffix: 'เอเจนต์',
			detail: 'รายละเอียด', schedTipPre: 'ตารางงาน',
			alert: 'ตารางงานถูกบันทึกอัตโนมัติไปยัง workforce',
			channelInfo: 'ช่องทาง: Omnichannel, Inbound Call, Email',
			dlgTitle: 'เพิ่มตารางงาน', dlgDesc: 'สร้างตารางงานเอเจนต์ใหม่ตามวันที่และช่องทาง',
			dateLabel: 'วันที่', newDateLabel: 'วันที่ตารางงานใหม่',
			cancel: 'ยกเลิก', save: 'บันทึก'
		},
		tl: {
			docTitle: 'Agent Schedule',
			title: 'Listahan ng Iskedyul ng Agent',
			descPre: 'Maghanap ng pangalan / username / email',
			entry: 'mga entry',
			add: 'Magdagdag ng Iskedyul',
			search: 'Paghahanap', searchPh: 'Maghanap ng pangalan / username / email',
			status: 'Katayuan', stAll: 'Lahat', stScheduled: 'Naka-iskedyul', stLimited: 'Limitado', stOff: 'Pahinga',
			find: 'Hanapin', finding: 'Naghahanap', reset: 'Reset',
			viewLabel: 'View', list: 'Listahan', calendar: 'Kalendaryo',
			showingPre: 'Ipinapakita', showingMid: 'ng', showingPost: 'mga entry',
			calTitle: 'Kalendaryo ng iskedyul', calDesc: 'Pumili ng petsa upang makita ang detalye.',
			pickDate: 'Piliin ang petsa ng iskedyul', pickPh: 'Pumili ng petsa',
			picked: 'Napiling petsa:',
			perDateTitle: 'Iskedyul bawat petsa', perDateDesc: 'Mga column: No, Petsa, Bilang ng Agent, Channel, Aksyon.',
			emptyTitle: 'Walang iskedyul', emptyDesc: 'Magdagdag ng bagong iskedyul para sa petsang ito.',
			thNo: 'No', thDate: 'Petsa', thCount: 'Bilang ng Agent', thChannel: 'Channel', thCap: 'Kapasidad', thAct: 'Aksyon',
			agentSuffix: 'agent',
			detail: 'Detalye', schedTipPre: 'Iskedyul',
			alert: 'Auto-save ang iskedyul sa workforce.',
			channelInfo: 'Channel: Omnichannel, Inbound Call, Email',
			dlgTitle: 'Magdagdag ng Iskedyul', dlgDesc: 'Gumawa ng bagong iskedyul ng agent bawat petsa at channel.',
			dateLabel: 'Petsa', newDateLabel: 'Bagong petsa ng iskedyul',
			cancel: 'Kanselahin', save: 'I-save'
		}
	} as const;
	let s = $derived(STR[$locale]);

	let q = $state(''); let status = $state('semua'); let tab = $state('daftar'); let loading = $state(false); let open = $state(false);
	let date = $state<DateValue | undefined>(new CalendarDate(2026, 9, 30));
	let newDate = $state<DateValue | undefined>(new CalendarDate(2026, 9, 30));
	const schedules = [
		{ date: '30 Sep 2026', agents: 12, channels: ['Omnichannel', 'Inbound Call'], statusKey: 'scheduled', cap: 92 },
		{ date: '01 Okt 2026', agents: 14, channels: ['Omnichannel', 'Email', 'Inbound Call'], statusKey: 'scheduled', cap: 96 },
		{ date: '02 Okt 2026', agents: 13, channels: ['Omnichannel', 'Email'], statusKey: 'scheduled', cap: 88 },
		{ date: '03 Okt 2026', agents: 8, channels: ['Omnichannel'], statusKey: 'limited', cap: 55 },
		{ date: '04 Okt 2026', agents: 0, channels: [] as string[], statusKey: 'off', cap: 0 }
	];
	function statusLabel(key: string): string {
		if (key === 'scheduled') return s.stScheduled;
		if (key === 'limited') return s.stLimited;
		return s.stOff;
	}
	function statusValue(key: string): string {
		if (key === 'scheduled') return 'scheduled';
		if (key === 'limited') return 'limited';
		return 'off';
	}
	let filtered = $derived(schedules.filter((x) => x.date.toLowerCase().includes(q.toLowerCase()) && (status === 'semua' || statusValue(x.statusKey) === status)));
	function search() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : Search);

</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header class="flex-row items-center justify-between gap-3"><div><Card.Title>{s.title}</Card.Title><Card.Description>{s.descPre} · {filtered.length} {s.entry}</Card.Description></div><Button onclick={() => (open = true)}><Plus data-icon="inline-start" />{s.add}</Button></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_200px_auto]">
				<Field.Field><Field.Label for="q">{s.search}</Field.Label><div class="relative"><Search data-icon="input" /><Input id="q" bind:value={q} placeholder={s.searchPh} class="pl-9" /></div></Field.Field>
				<Field.Field>
					<Field.Label for="st">{s.status}</Field.Label>
					<Select.Root type="single" bind:value={status}><Select.Trigger id="st" class="w-full">{status === 'semua' ? s.stAll : statusLabel(status)}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.status}</Select.GroupHeading><Select.Item value="semua">{s.stAll}</Select.Item><Select.Item value="scheduled">{s.stScheduled}</Select.Item><Select.Item value="limited">{s.stLimited}</Select.Item><Select.Item value="off">{s.stOff}</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><div class="flex gap-2"><Button onclick={search} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? s.finding : s.find}</span></Button><Button variant="outline" onclick={() => (q = '')}><RefreshCw data-icon="inline-start" />{s.reset}</Button></div></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={tab} aria-label={s.viewLabel}><ToggleGroup.Item value="daftar">{s.list}</ToggleGroup.Item><ToggleGroup.Item value="kalender">{s.calendar}</ToggleGroup.Item></ToggleGroup.Root>
			<Tabs.Root bind:value={tab}><Tabs.List><Tabs.Trigger value="daftar">{s.list}</Tabs.Trigger><Tabs.Trigger value="kalender">{s.calendar}</Tabs.Trigger></Tabs.List></Tabs.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">{s.showingPre} {filtered.length} {s.showingMid} {schedules.length} {s.showingPost}</Card.Footer>
	</Card.Root>

	{#if tab === 'kalender'}
		<Card.Root><Card.Header><Card.Title>{s.calTitle}</Card.Title><Card.Description>{s.calDesc}</Card.Description></Card.Header><Card.Content><DatePicker bind:value={date} label={s.pickDate} placeholder={s.pickPh} /></Card.Content><Card.Footer><p class="text-muted-foreground text-xs">{s.picked} {date?.toString() ?? '-'}</p></Card.Footer></Card.Root>
	{:else}
		<Card.Root>
			<Card.Header><Card.Title>{s.perDateTitle}</Card.Title><Card.Description>{s.perDateDesc}</Card.Description></Card.Header>
			<Card.Content class="flex flex-col gap-4">
				<div class="flex flex-col gap-2">{#each filtered as x}<div class="flex items-center gap-3"><Badge variant="outline" class="min-w-24 justify-center">{x.date}</Badge><Progress value={x.cap} class="flex-1" /><span class="text-xs font-medium">{x.cap}%</span></div>{/each}</div>
				{#if loading}
					<div class="flex flex-col gap-2">{#each [1, 2, 3] as _}<Skeleton class="h-12 w-full" />{/each}</div>
				{:else if filtered.length === 0}
					<Empty.Root><Empty.Header><Empty.Media><CalendarClock data-icon="empty" /></Empty.Media><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header><Empty.Content><Button size="sm" onclick={() => (open = true)}><Plus data-icon="inline-start" />{s.add}</Button></Empty.Content></Empty.Root>
				{:else}
					<Table.Root><Table.Header><Table.Row><Table.Head>{s.thNo}</Table.Head><Table.Head>{s.thDate}</Table.Head><Table.Head>{s.thCount}</Table.Head><Table.Head>{s.thChannel}</Table.Head><Table.Head>{s.thCap}</Table.Head><Table.Head class="text-right">{s.thAct}</Table.Head></Table.Row></Table.Header>
					<Table.Body>{#each filtered as x, i}<Table.Row><Table.Cell class="text-muted-foreground">{i + 1}</Table.Cell><Table.Cell class="font-medium">{x.date}</Table.Cell><Table.Cell><span class="flex items-center gap-2"><Avatar.Root class="size-6"><Avatar.Fallback>{String(x.agents)}</Avatar.Fallback></Avatar.Root>{x.agents} {s.agentSuffix}</span></Table.Cell><Table.Cell><div class="flex min-w-48 flex-wrap gap-1.5">{#each x.channels as c}<Badge variant="secondary">{c}</Badge>{:else}<span class="text-muted-foreground text-sm">-</span>{/each}</div></Table.Cell><Table.Cell><div class="flex items-center gap-2"><Progress value={x.cap} class={cn('w-20', x.cap < 60 && 'opacity-70')} /><span class="text-xs">{x.cap}%</span></div></Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="sm">{s.detail}<ChevronRight data-icon="inline-end" /></Button></Tooltip.Trigger><Tooltip.Content>{s.schedTipPre} {x.date}</Tooltip.Content></Tooltip.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
				{/if}
			</Card.Content>
			<Card.Footer><Separator class="my-1" /><Alert.Root variant="success"><CalendarDays data-icon="alert" /><Alert.Description>{s.alert}</Alert.Description></Alert.Root></Card.Footer>
		</Card.Root>
	{/if}
	<p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> {s.channelInfo}</p>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>{s.dlgTitle}</Dialog.Title><Dialog.Description>{s.dlgDesc}</Dialog.Description></Dialog.Header><Field.FieldGroup class="flex flex-col gap-4 py-2"><Field.Field><Field.Label>{s.dateLabel}</Field.Label><DatePicker bind:value={newDate} label={s.newDateLabel} /></Field.Field></Field.FieldGroup><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>{s.cancel}</Button><Button onclick={() => (open = false)}>{s.save}</Button></Dialog.Footer></Dialog.Content></Dialog.Root>
