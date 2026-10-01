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
	import DateRangePicker from "$lib/components/ui/date-range-picker.svelte";
	import DatePicker from "$lib/components/ui/date-picker.svelte";
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Plus, Upload, Search, Pencil, Trash2, CalendarDays, Info, Palmtree } from 'lucide-svelte';
	import { CalendarDate, type DateValue } from '@internationalized/date';
	import { locale } from '$lib/i18n';
	import { get } from 'svelte/store';

	import type { DateRange } from 'bits-ui';

	const STR = {
		id: {
			docTitle: 'Work Calendar',
			title: 'Work Calendar',
			desc: 'Kelola hari libur nasional dan pemerintahan untuk perhitungan SLA.',
			add: 'Tambah Hari Libur', import: 'Import Bulk',
			year: 'Tahun', category: 'Kategori',
			catAll: 'Semua Kategori', catNat: 'Libur Nasional', catGov: 'Libur Pemerintahan', catCustom: 'Custom',
			togAll: 'Semua', togNat: 'Nasional', togGov: 'Pemerintahan', togCustom: 'Custom',
			search: 'Pencarian', searchPh: 'Cari nama hari libur…',
			load: 'Muat', loading: 'Loading',
			tabList: 'Daftar', tabPeriod: 'Periode',
			pickPeriod: 'Pilih periode kalender',
			footCountPre: '', footCountPost: 'hari libur pada kalender',
			compTitle: 'Komposisi libur', compDescPre: 'Per kategori tahun',
			compFoot: 'Dipakai untuk perhitungan SLA tiket.',
			listTitle: 'Daftar hari libur', listDesc: 'Kolom: No, Tanggal, Nama, Kategori, Status, Template, Actions.',
			emptyTitle: 'Tidak ada hari libur', emptyDesc: 'Tambah hari libur baru atau ubah filter.',
			thNo: 'No', thDate: 'Tanggal', thName: 'Nama', thCat: 'Kategori', thStatus: 'Status', thAct: 'Actions',
			stActive: 'Aktif', stInactive: 'Nonaktif',
			edit: 'Edit', del: 'Hapus',
			tmplInfo: 'Template “Ya” berarti dipakai balasan otomatis.',
			syncPre: 'Kalender', syncPost: 'tersinkron dengan perhitungan SLA.',
			dlgTitle: 'Tambah Hari Libur', dlgDesc: 'Tambahkan hari libur custom ke kalender kerja.',
			dateLabel: 'Tanggal', pickHoliday: 'Tanggal hari libur',
			nameLabel: 'Nama Hari Libur', namePh: 'Contoh: Hari Kemerdekaan',
			cancel: 'Batal', save: 'Simpan',
			bulkTitle: 'Import Bulk', bulkDesc: 'Unggah CSV berisi tanggal, nama, dan kategori.',
			upload: 'Upload',
			newDate: '31 Des 2026', newName: 'Hari Libur Custom',
			perNat: 'Nasional', perGov: 'Pemerintahan', perCustom: 'Custom'
		},
		en: {
			docTitle: 'Work Calendar',
			title: 'Work Calendar',
			desc: 'Manage national and government holidays for SLA calculation.',
			add: 'Add Holiday', import: 'Bulk Import',
			year: 'Year', category: 'Category',
			catAll: 'All Categories', catNat: 'National Holiday', catGov: 'Government Holiday', catCustom: 'Custom',
			togAll: 'All', togNat: 'National', togGov: 'Government', togCustom: 'Custom',
			search: 'Search', searchPh: 'Search holiday names…',
			load: 'Load', loading: 'Loading',
			tabList: 'List', tabPeriod: 'Period',
			pickPeriod: 'Pick calendar period',
			footCountPre: '', footCountPost: 'holidays in calendar',
			compTitle: 'Holiday composition', compDescPre: 'Per category in',
			compFoot: 'Used for ticket SLA calculation.',
			listTitle: 'Holiday list', listDesc: 'Columns: No, Date, Name, Category, Status, Template, Actions.',
			emptyTitle: 'No holidays', emptyDesc: 'Add a new holiday or change the filter.',
			thNo: 'No', thDate: 'Date', thName: 'Name', thCat: 'Category', thStatus: 'Status', thAct: 'Actions',
			stActive: 'Active', stInactive: 'Inactive',
			edit: 'Edit', del: 'Delete',
			tmplInfo: 'Template “Yes” means used for auto-replies.',
			syncPre: 'Calendar', syncPost: 'synced with SLA calculation.',
			dlgTitle: 'Add Holiday', dlgDesc: 'Add a custom holiday to the work calendar.',
			dateLabel: 'Date', pickHoliday: 'Holiday date',
			nameLabel: 'Holiday Name', namePh: 'E.g. Independence Day',
			cancel: 'Cancel', save: 'Save',
			bulkTitle: 'Bulk Import', bulkDesc: 'Upload a CSV with date, name, and category.',
			upload: 'Upload',
			newDate: '31 Dec 2026', newName: 'Custom Holiday',
			perNat: 'National', perGov: 'Government', perCustom: 'Custom'
		},
		th: {
			docTitle: 'ปฏิทินงาน',
			title: 'ปฏิทินงาน',
			desc: 'จัดการวันหยุดนักขัตฤกษ์และวันหยุดราชการเพื่อคำนวณ SLA',
			add: 'เพิ่มวันหยุด', import: 'นำเข้าจำนวนมาก',
			year: 'ปี', category: 'หมวดหมู่',
			catAll: 'ทุกหมวดหมู่', catNat: 'วันหยุดนักขัตฤกษ์', catGov: 'วันหยุดราชการ', catCustom: 'กำหนดเอง',
			togAll: 'ทั้งหมด', togNat: 'นักขัตฤกษ์', togGov: 'ราชการ', togCustom: 'กำหนดเอง',
			search: 'ค้นหา', searchPh: 'ค้นหาชื่อวันหยุด…',
			load: 'โหลด', loading: 'กำลังโหลด',
			tabList: 'รายการ', tabPeriod: 'ช่วงเวลา',
			pickPeriod: 'เลือกช่วงปฏิทิน',
			footCountPre: '', footCountPost: 'วันหยุดในปฏิทิน',
			compTitle: 'สัดส่วนวันหยุด', compDescPre: 'ตามหมวดหมู่ปี',
			compFoot: 'ใช้คำนวณ SLA ตั๋ว',
			listTitle: 'รายการวันหยุด', listDesc: 'คอลัมน์: ลำดับ, วันที่, ชื่อ, หมวดหมู่, สถานะ, เทมเพลต, การดำเนินการ',
			emptyTitle: 'ไม่มีวันหยุด', emptyDesc: 'เพิ่มวันหยุดใหม่หรือเปลี่ยนตัวกรอง',
			thNo: 'ลำดับ', thDate: 'วันที่', thName: 'ชื่อ', thCat: 'หมวดหมู่', thStatus: 'สถานะ', thAct: 'การดำเนินการ',
			stActive: 'ใช้งาน', stInactive: 'ไม่ใช้งาน',
			edit: 'แก้ไข', del: 'ลบ',
			tmplInfo: 'เทมเพลต “ใช่” หมายถึงใช้ตอบกลับอัตโนมัติ',
			syncPre: 'ปฏิทิน', syncPost: 'ซิงก์กับการคำนวณ SLA แล้ว',
			dlgTitle: 'เพิ่มวันหยุด', dlgDesc: 'เพิ่มวันหยุดกำหนดเองลงในปฏิทินงาน',
			dateLabel: 'วันที่', pickHoliday: 'วันที่วันหยุด',
			nameLabel: 'ชื่อวันหยุด', namePh: 'เช่น วันชาติ',
			cancel: 'ยกเลิก', save: 'บันทึก',
			bulkTitle: 'นำเข้าจำนวนมาก', bulkDesc: 'อัปโหลด CSV ที่มีวันที่ ชื่อ และหมวดหมู่',
			upload: 'อัปโหลด',
			newDate: '31 ธ.ค. 2026', newName: 'วันหยุดกำหนดเอง',
			perNat: 'นักขัตฤกษ์', perGov: 'ราชการ', perCustom: 'กำหนดเอง'
		},
		tl: {
			docTitle: 'Work Calendar',
			title: 'Work Calendar',
			desc: 'Pamahalaan ang pambansa at government holiday para sa pagkalkula ng SLA.',
			add: 'Magdagdag ng Holiday', import: 'Bulk Import',
			year: 'Taon', category: 'Kategorya',
			catAll: 'Lahat ng Kategorya', catNat: 'Pambansang Holiday', catGov: 'Holiday ng Gobyerno', catCustom: 'Custom',
			togAll: 'Lahat', togNat: 'Pambansa', togGov: 'Gobyerno', togCustom: 'Custom',
			search: 'Paghahanap', searchPh: 'Maghanap ng pangalan ng holiday…',
			load: 'I-load', loading: 'Naglo-load',
			tabList: 'Listahan', tabPeriod: 'Panahon',
			pickPeriod: 'Piliin ang panahon ng kalendaryo',
			footCountPre: '', footCountPost: 'holiday sa kalendaryo',
			compTitle: 'Komposisyon ng holiday', compDescPre: 'Bawat kategorya sa taong',
			compFoot: 'Ginagamit para sa pagkalkula ng SLA ng ticket.',
			listTitle: 'Listahan ng holiday', listDesc: 'Mga column: No, Petsa, Pangalan, Kategorya, Katayuan, Template, Aksyon.',
			emptyTitle: 'Walang holiday', emptyDesc: 'Magdagdag ng bagong holiday o baguhin ang filter.',
			thNo: 'No', thDate: 'Petsa', thName: 'Pangalan', thCat: 'Kategorya', thStatus: 'Katayuan', thAct: 'Mga Aksyon',
			stActive: 'Aktibo', stInactive: 'Di-aktibo',
			edit: 'I-edit', del: 'Tanggalin',
			tmplInfo: 'Ang Template na “Oo” ay nangangahulugang ginagamit sa auto-reply.',
			syncPre: 'Kalendaryo', syncPost: 'naka-sync sa pagkalkula ng SLA.',
			dlgTitle: 'Magdagdag ng Holiday', dlgDesc: 'Magdagdag ng custom holiday sa work calendar.',
			dateLabel: 'Petsa', pickHoliday: 'Petsa ng holiday',
			nameLabel: 'Pangalan ng Holiday', namePh: 'Hal. Araw ng Kalayaan',
			cancel: 'Kanselahin', save: 'I-save',
			bulkTitle: 'Bulk Import', bulkDesc: 'Mag-upload ng CSV na may petsa, pangalan, at kategorya.',
			upload: 'I-upload',
			newDate: '31 Dis 2026', newName: 'Custom Holiday',
			perNat: 'Pambansa', perGov: 'Gobyerno', perCustom: 'Custom'
		}
	} as const;
	let s = $derived(STR[$locale]);

	let year = $state('2026'); let category = $state('all'); let q = $state(''); let tab = $state('daftar');
	let loading = $state(false); let open = $state(false); let bulk = $state(false);
	let period = $state<DateRange | undefined>({ start: new CalendarDate(2026, 1, 1), end: new CalendarDate(2026, 12, 31) });
	let holidayDate = $state<DateValue | undefined>(new CalendarDate(2026, 12, 31));
	let holidays = $state([
		{ date: '01 Jan 2026', name: 'Tahun Baru 2026', categoryKey: 'nasional', active: true, tmpl: 'Ya' },
		{ date: '16 Jan 2026', name: 'Isra Mikraj Nabi Muhammad SAW', categoryKey: 'nasional', active: true, tmpl: 'Ya' },
		{ date: '17 Agu 2026', name: 'Hari Kemerdekaan RI', categoryKey: 'nasional', active: true, tmpl: 'Tidak' },
		{ date: '25 Des 2026', name: 'Hari Raya Natal', categoryKey: 'nasional', active: true, tmpl: 'Ya' },
		{ date: '12 Mar 2026', name: 'Cuti Bersama Internal', categoryKey: 'custom', active: false, tmpl: 'Tidak' }
	]);
	function catLabel(key: string): string {
		if (key === 'nasional') return s.catNat;
		if (key === 'pemerintahan') return s.catGov;
		return s.catCustom;
	}
	let filtered = $derived(holidays.filter((h) => (category === 'all' || (category === 'Libur Nasional' ? h.categoryKey === 'nasional' : category === 'Libur Pemerintahan' ? h.categoryKey === 'pemerintahan' : category === 'Custom' ? h.categoryKey === 'custom' : h.categoryKey === category)) && `${h.date} ${h.name}`.toLowerCase().includes(q.toLowerCase())));
	function load() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : CalendarDays);
	function save() { const t = STR[get(locale)]; holidays = [...holidays, { date: t.newDate, name: t.newName, categoryKey: 'custom', active: true, tmpl: 'Tidak' }]; open = false; }
	const perCat = $derived([
		{ label: s.perNat, value: holidays.filter((h) => h.categoryKey === 'nasional').length * 20 },
		{ label: s.perGov, value: 10 }, { label: s.perCustom, value: holidays.filter((h) => h.categoryKey === 'custom').length * 20 }
	]);
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header class="flex-row flex-wrap items-center justify-between gap-3">
			<div><Card.Title>{s.title}</Card.Title><Card.Description>{s.desc}</Card.Description></div>
			<div class="flex flex-wrap gap-2"><Button onclick={() => (open = true)}><Plus data-icon="inline-start" />{s.add}</Button><Button variant="outline" onclick={() => (bulk = true)}><Upload data-icon="inline-start" />{s.import}</Button></div>
		</Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[140px_200px_1fr_auto]">
				<Field.Field>
					<Field.Label for="yr">{s.year}</Field.Label>
					<Select.Root type="single" bind:value={year}><Select.Trigger id="yr" class="w-full">{year}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.year}</Select.GroupHeading><Select.Item value="2025">2025</Select.Item><Select.Item value="2026">2026</Select.Item><Select.Item value="2027">2027</Select.Item><Select.Item value="2028">2028</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="cat">{s.category}</Field.Label>
					<Select.Root type="single" bind:value={category}><Select.Trigger id="cat" class="w-full">{category === 'all' ? s.catAll : category === 'nasional' ? s.catNat : category === 'pemerintahan' ? s.catGov : category === 'custom' ? s.catCustom : category}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.category}</Select.GroupHeading><Select.Item value="all">{s.catAll}</Select.Item><Select.Item value="nasional">{s.catNat}</Select.Item><Select.Item value="pemerintahan">{s.catGov}</Select.Item><Select.Item value="custom">{s.catCustom}</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label for="qq">{s.search}</Field.Label><div class="relative"><Search data-icon="input" /><Input id="qq" bind:value={q} placeholder={s.searchPh} class="pl-9" /></div></Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button variant="secondary" onclick={load} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? s.loading : s.load}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={category} aria-label={s.category}><ToggleGroup.Item value="all">{s.togAll}</ToggleGroup.Item><ToggleGroup.Item value="nasional">{s.togNat}</ToggleGroup.Item><ToggleGroup.Item value="pemerintahan">{s.togGov}</ToggleGroup.Item><ToggleGroup.Item value="custom">{s.togCustom}</ToggleGroup.Item></ToggleGroup.Root>
			<Tabs.Root bind:value={tab}><Tabs.List><Tabs.Trigger value="daftar">{s.tabList}</Tabs.Trigger><Tabs.Trigger value="periode">{s.tabPeriod}</Tabs.Trigger></Tabs.List></Tabs.Root>
			{#if tab === 'periode'}<DateRangePicker bind:value={period} label={s.pickPeriod} />{/if}
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">{filtered.length} {s.footCountPost} {year}.</Card.Footer>
	</Card.Root>

	<div class="grid gap-4 lg:grid-cols-[1fr_1.4fr]">
		<Card.Root>
			<Card.Header><Card.Title>{s.compTitle}</Card.Title><Card.Description>{s.compDescPre} {year}.</Card.Description></Card.Header>
			<Card.Content class="flex flex-col gap-3">
				{#each perCat as p}<div class="flex flex-col gap-1.5"><div class="flex justify-between text-sm"><span>{p.label}</span><span class="text-muted-foreground">{p.value}%</span></div><Progress value={p.value} /></div>{/each}
			</Card.Content>
			<Card.Footer><p class="text-muted-foreground text-xs">{s.compFoot}</p></Card.Footer>
		</Card.Root>
		<Card.Root>
			<Card.Header><Card.Title>{s.listTitle}</Card.Title><Card.Description>{s.listDesc}</Card.Description></Card.Header>
			<Card.Content>
				{#if loading}
					<div class="flex flex-col gap-2">{#each [1, 2, 3] as _}<Skeleton class="h-12 w-full" />{/each}</div>
				{:else if filtered.length === 0}
					<Empty.Root><Empty.Header><Empty.Media><Palmtree data-icon="empty" /></Empty.Media><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>
				{:else}
					<Table.Root><Table.Header><Table.Row><Table.Head>{s.thNo}</Table.Head><Table.Head>{s.thDate}</Table.Head><Table.Head>{s.thName}</Table.Head><Table.Head>{s.thCat}</Table.Head><Table.Head>{s.thStatus}</Table.Head><Table.Head class="text-right">{s.thAct}</Table.Head></Table.Row></Table.Header>
					<Table.Body>{#each filtered as h, i}<Table.Row><Table.Cell class="text-muted-foreground">{i + 1}</Table.Cell><Table.Cell class="whitespace-nowrap font-medium">{h.date}</Table.Cell><Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-6"><Avatar.Fallback>{h.name.slice(0, 1)}</Avatar.Fallback></Avatar.Root>{h.name}</div></Table.Cell><Table.Cell><Badge variant={h.categoryKey === 'custom' ? 'secondary' : 'outline'} class={cn(h.categoryKey === 'custom' && 'border-dashed')}>{catLabel(h.categoryKey)}</Badge></Table.Cell><Table.Cell><Badge variant={h.active ? 'success' : 'secondary'}>{h.active ? s.stActive : s.stInactive}</Badge></Table.Cell><Table.Cell class="text-right"><div class="flex justify-end gap-1"><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="icon" aria-label="{s.edit} {h.name}"><Pencil data-icon="icon" /></Button></Tooltip.Trigger><Tooltip.Content>{s.edit}</Tooltip.Content></Tooltip.Root><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="icon" aria-label="{s.del} {h.name}"><Trash2 data-icon="icon" /></Button></Tooltip.Trigger><Tooltip.Content>{s.del}</Tooltip.Content></Tooltip.Root></div></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
				{/if}
			</Card.Content>
			<Card.Footer><Separator class="my-1" /><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> {s.tmplInfo}</p></Card.Footer>
		</Card.Root>
	</div>
	<Alert.Root variant="success"><CalendarDays data-icon="alert" /><Alert.Description>{s.syncPre} {year} {s.syncPost}</Alert.Description></Alert.Root>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>{s.dlgTitle}</Dialog.Title><Dialog.Description>{s.dlgDesc}</Dialog.Description></Dialog.Header><Field.FieldGroup class="flex flex-col gap-4 py-2"><Field.Field><Field.Label>{s.dateLabel}</Field.Label><DatePicker bind:value={holidayDate} label={s.pickHoliday} /></Field.Field><Field.Field><Field.Label for="hn">{s.nameLabel}</Field.Label><Input id="hn" placeholder={s.namePh} /></Field.Field></Field.FieldGroup><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>{s.cancel}</Button><Button onclick={save}>{s.save}</Button></Dialog.Footer></Dialog.Content></Dialog.Root>
<Dialog.Root bind:open={bulk}><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>{s.bulkTitle}</Dialog.Title><Dialog.Description>{s.bulkDesc}</Dialog.Description></Dialog.Header><Dialog.Footer><Button variant="outline" onclick={() => (bulk = false)}>{s.cancel}</Button><Button onclick={() => (bulk = false)}>{s.upload}</Button></Dialog.Footer></Dialog.Content></Dialog.Root>
