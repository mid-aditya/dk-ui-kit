<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as Select from '$lib/components/ui/select';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as Alert from '$lib/components/ui/alert';
	import * as Empty from '$lib/components/ui/empty';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Switch } from '$lib/components/ui/switch';
	import { Separator } from '$lib/components/ui/separator';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import TimePicker from '$lib/components/ui/time-picker.svelte';
	import { toast } from 'svelte-sonner';
	import { cn } from '$lib/utils.js';
	import { Clock, Plus, Pencil, Trash2, Info, CalendarOff, TriangleAlert, CircleCheck } from 'lucide-svelte';
	import { locale } from '$lib/i18n';
	import { get } from 'svelte/store';

	type DayRow = { dayKey: string; active: boolean; open: string; close: string; brk: string };

	const STR = {
		id: {
			docTitle: 'Operational Hours — DK UI Kit',
			title: 'Operational Hours',
			desc: 'Atur jam layanan per kanal, zona waktu, dan pengecualian hari libur.',
			channel: 'Kanal', timezone: 'Zona waktu',
			apply: 'Terapkan', applying: 'Menerapkan…',
			tabSchedule: 'Jadwal mingguan', tabExc: 'Pengecualian',
			schedTitlePre: 'Jadwal mingguan —',
			schedDesc: 'Aktifkan hari layanan dan atur jam buka, tutup, serta istirahat.',
			thDay: 'Hari', thStatus: 'Status', thOpen: 'Buka', thClose: 'Tutup', thBreak: 'Istirahat', thAct: 'Aksi',
			open: 'Buka', closed: 'Tutup',
			enablePre: 'Aktifkan', editHour: 'Ubah jam', editPre: 'Ubah',
			footInfo: 'Di luar jam operasional, chat dialihkan ke chatbot & tiket otomatis.',
			addExc: 'Tambah pengecualian',
			addExcDesc: 'Hari libur atau layanan terbatas di luar jadwal mingguan.',
			excDate: 'Tanggal', excDatePh: 'cth. 25 Des 2026',
			excLabel: 'Keterangan', excLabelPh: 'cth. Hari Raya Natal',
			excClosed: 'Tutup penuh',
			closedNote: 'Tutup — dialihkan ke chatbot', limitedNote: 'Buka terbatas',
			add: 'Tambah',
			excList: 'Daftar pengecualian', excCountPost: 'tanggal khusus terdaftar.',
			emptyTitle: 'Belum ada pengecualian', emptyDesc: 'Tambahkan hari libur atau layanan terbatas.',
			badgeClosed: 'Tutup', badgeLimited: 'Terbatas',
			delPre: 'Hapus',
			alertApply: 'Jadwal berlaku per kanal — perubahan membutuhkan apply agar aktif di routing.',
			alertSync: 'Sinkron dengan Work Calendar untuk hari libur nasional.',
			editTitlePre: 'Ubah jam —',
			editDesc: 'Format 24 jam (JJ:MM).',
			lblOpen: 'Jam buka', lblClose: 'Jam tutup', lblBreak: 'Istirahat',
			breakPh: '12:00–13:00',
			cancel: 'Batal', save: 'Simpan',
			tSavedPre: 'Jam', tSavedPost: 'disimpan',
			tOpen: 'buka', tClosed: 'tutup',
			tRequired: 'Tanggal dan keterangan wajib diisi',
			tExcAdded: 'Pengecualian ditambahkan',
			tAppliedPre: 'Jadwal', tAppliedPost: 'diterapkan',
			tExcDeleted: 'Pengecualian dihapus',
			days: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as readonly string[]
		},
		en: {
			docTitle: 'Operational Hours — DK UI Kit',
			title: 'Operational Hours',
			desc: 'Set service hours per channel, timezone, and holiday exceptions.',
			channel: 'Channel', timezone: 'Timezone',
			apply: 'Apply', applying: 'Applying…',
			tabSchedule: 'Weekly schedule', tabExc: 'Exceptions',
			schedTitlePre: 'Weekly schedule —',
			schedDesc: 'Enable service days and set open, close, and break hours.',
			thDay: 'Day', thStatus: 'Status', thOpen: 'Open', thClose: 'Close', thBreak: 'Break', thAct: 'Actions',
			open: 'Open', closed: 'Closed',
			enablePre: 'Enable', editHour: 'Edit hours', editPre: 'Edit',
			footInfo: 'Outside operational hours, chats are routed to chatbot & auto tickets.',
			addExc: 'Add exception',
			addExcDesc: 'Holidays or limited service outside the weekly schedule.',
			excDate: 'Date', excDatePh: 'e.g. 25 Dec 2026',
			excLabel: 'Description', excLabelPh: 'e.g. Christmas Day',
			excClosed: 'Fully closed',
			closedNote: 'Closed — routed to chatbot', limitedNote: 'Limited open',
			add: 'Add',
			excList: 'Exception list', excCountPost: 'special dates registered.',
			emptyTitle: 'No exceptions yet', emptyDesc: 'Add a holiday or limited service.',
			badgeClosed: 'Closed', badgeLimited: 'Limited',
			delPre: 'Delete',
			alertApply: 'Schedule applies per channel — changes need apply to activate routing.',
			alertSync: 'Synced with Work Calendar for national holidays.',
			editTitlePre: 'Edit hours —',
			editDesc: '24-hour format (HH:MM).',
			lblOpen: 'Opening time', lblClose: 'Closing time', lblBreak: 'Break',
			breakPh: '12:00–13:00',
			cancel: 'Cancel', save: 'Save',
			tSavedPre: '', tSavedPost: 'hours saved',
			tOpen: 'open', tClosed: 'closed',
			tRequired: 'Date and description are required',
			tExcAdded: 'Exception added',
			tAppliedPre: 'Schedule', tAppliedPost: 'applied',
			tExcDeleted: 'Exception deleted',
			days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as readonly string[]
		},
		th: {
			docTitle: 'เวลาทำการ — DK UI Kit',
			title: 'เวลาทำการ',
			desc: 'ตั้งเวลาบริการตามช่องทาง โซนเวลา และข้อยกเว้นวันหยุด',
			channel: 'ช่องทาง', timezone: 'โซนเวลา',
			apply: 'ใช้', applying: 'กำลังใช้…',
			tabSchedule: 'ตารางรายสัปดาห์', tabExc: 'ข้อยกเว้น',
			schedTitlePre: 'ตารางรายสัปดาห์ —',
			schedDesc: 'เปิดวันบริการและตั้งเวลาเปิด ปิด และพัก',
			thDay: 'วัน', thStatus: 'สถานะ', thOpen: 'เปิด', thClose: 'ปิด', thBreak: 'พัก', thAct: 'การดำเนินการ',
			open: 'เปิด', closed: 'ปิด',
			enablePre: 'เปิดใช้งาน', editHour: 'แก้ไขเวลา', editPre: 'แก้ไข',
			footInfo: 'นอกเวลาทำการ แชทจะถูกส่งไปยังแชทบอตและตั๋วอัตโนมัติ',
			addExc: 'เพิ่มข้อยกเว้น',
			addExcDesc: 'วันหยุดหรือบริการจำกัดนอกตารางรายสัปดาห์',
			excDate: 'วันที่', excDatePh: 'เช่น 25 ธ.ค. 2026',
			excLabel: 'คำอธิบาย', excLabelPh: 'เช่น วันคริสต์มาส',
			excClosed: 'ปิดทั้งหมด',
			closedNote: 'ปิด — ส่งไปยังแชทบอต', limitedNote: 'เปิดจำกัด',
			add: 'เพิ่ม',
			excList: 'รายการข้อยกเว้น', excCountPost: 'วันที่พิเศษที่ลงทะเบียน',
			emptyTitle: 'ยังไม่มีข้อยกเว้น', emptyDesc: 'เพิ่มวันหยุดหรือบริการจำกัด',
			badgeClosed: 'ปิด', badgeLimited: 'จำกัด',
			delPre: 'ลบ',
			alertApply: 'ตารางมีผลตามช่องทาง — การเปลี่ยนแปลงต้องกดใช้เพื่อให้ routing ทำงาน',
			alertSync: 'ซิงก์กับ Work Calendar สำหรับวันหยุดนักขัตฤกษ์',
			editTitlePre: 'แก้ไขเวลา —',
			editDesc: 'รูปแบบ 24 ชั่วโมง (ชช:นน)',
			lblOpen: 'เวลาเปิด', lblClose: 'เวลาปิด', lblBreak: 'พัก',
			breakPh: '12:00–13:00',
			cancel: 'ยกเลิก', save: 'บันทึก',
			tSavedPre: '', tSavedPost: 'บันทึกเวลาแล้ว',
			tOpen: 'เปิด', tClosed: 'ปิด',
			tRequired: 'ต้องกรอกวันที่และคำอธิบาย',
			tExcAdded: 'เพิ่มข้อยกเว้นแล้ว',
			tAppliedPre: 'ตาราง', tAppliedPost: 'ถูกใช้แล้ว',
			tExcDeleted: 'ลบข้อยกเว้นแล้ว',
			days: ['วันจันทร์', 'วันอังคาร', 'วันพุธ', 'วันพฤหัสบดี', 'วันศุกร์', 'วันเสาร์', 'วันอาทิตย์'] as readonly string[]
		},
		tl: {
			docTitle: 'Operational Hours — DK UI Kit',
			title: 'Operational Hours',
			desc: 'Itakda ang oras ng serbisyo bawat channel, timezone, at holiday exception.',
			channel: 'Channel', timezone: 'Timezone',
			apply: 'Ilapat', applying: 'Inilalapat…',
			tabSchedule: 'Lingguhang iskedyul', tabExc: 'Mga Exception',
			schedTitlePre: 'Lingguhang iskedyul —',
			schedDesc: 'Paganahin ang mga araw ng serbisyo at itakda ang oras ng bukas, sara, at pahinga.',
			thDay: 'Araw', thStatus: 'Katayuan', thOpen: 'Bukas', thClose: 'Sara', thBreak: 'Pahinga', thAct: 'Mga Aksyon',
			open: 'Bukas', closed: 'Sarado',
			enablePre: 'Paganahin', editHour: 'I-edit ang oras', editPre: 'I-edit',
			footInfo: 'Sa labas ng operational hours, ang chat ay niru-route sa chatbot at auto ticket.',
			addExc: 'Magdagdag ng exception',
			addExcDesc: 'Holiday o limitadong serbisyo sa labas ng lingguhang iskedyul.',
			excDate: 'Petsa', excDatePh: 'hal. 25 Dis 2026',
			excLabel: 'Paglalarawan', excLabelPh: 'hal. Araw ng Pasko',
			excClosed: 'Ganap na sarado',
			closedNote: 'Sarado — niru-route sa chatbot', limitedNote: 'Limitadong bukas',
			add: 'Idagdag',
			excList: 'Listahan ng exception', excCountPost: 'natatanging petsa ang nakarehistro.',
			emptyTitle: 'Wala pang exception', emptyDesc: 'Magdagdag ng holiday o limitadong serbisyo.',
			badgeClosed: 'Sarado', badgeLimited: 'Limitado',
			delPre: 'Tanggalin',
			alertApply: 'Nalalapat ang iskedyul bawat channel — kailangan ng apply upang gumana ang routing.',
			alertSync: 'Naka-sync sa Work Calendar para sa pambansang holiday.',
			editTitlePre: 'I-edit ang oras —',
			editDesc: '24-oras na format (HH:MM).',
			lblOpen: 'Oras ng bukas', lblClose: 'Oras ng sara', lblBreak: 'Pahinga',
			breakPh: '12:00–13:00',
			cancel: 'Kanselahin', save: 'I-save',
			tSavedPre: 'Oras ng', tSavedPost: 'na-save',
			tOpen: 'bukas', tClosed: 'sarado',
			tRequired: 'Kailangan ang petsa at paglalarawan',
			tExcAdded: 'Naidagdag ang exception',
			tAppliedPre: 'Iskedyul ng', tAppliedPost: 'inilapat',
			tExcDeleted: 'Tinanggal ang exception',
			days: ['Lunes', 'Martes', 'Miyerkules', 'Huwebes', 'Biyernes', 'Sabado', 'Linggo'] as readonly string[]
		}
	} as const;
	let s = $derived(STR[$locale]);

	const dayKeys = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
	function dayLabel(key: string): string {
		const i = dayKeys.indexOf(key);
		return i >= 0 ? (s.days[i] as string) : key;
	}
	function dayLabelOf(l: 'id' | 'en' | 'th' | 'tl', key: string): string {
		const i = dayKeys.indexOf(key);
		return i >= 0 ? (STR[l].days[i] as string) : key;
	}

	let tab = $state('jadwal');
	let channel = $state('omnichat');
	let timezone = $state('Asia/Jakarta');
	let loading = $state(false);
	let editOpen = $state(false);
	let editingDay = $state<DayRow | null>(null);
	let editOpen2 = $state('');
	let editClose = $state('');
	let editBrk = $state('');

	let schedule = $state<DayRow[]>([
		{ dayKey: 'mon', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ dayKey: 'tue', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ dayKey: 'wed', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ dayKey: 'thu', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ dayKey: 'fri', active: true, open: '08:00', close: '16:30', brk: '11:30–13:00' },
		{ dayKey: 'sat', active: false, open: '09:00', close: '14:00', brk: '-' },
		{ dayKey: 'sun', active: false, open: '09:00', close: '14:00', brk: '-' }
	]);

	let exceptions = $state([
		{ id: 1, date: '25 Des 2026', label: 'Hari Raya Natal', closed: true },
		{ id: 2, date: '01 Jan 2027', label: 'Tahun Baru', closed: true },
		{ id: 3, date: '17 Agu 2026', label: 'Hari Kemerdekaan — layanan terbatas', closed: false }
	]);
	let excDate = $state('');
	let excLabel = $state('');
	let excClosed = $state(true);

	function openEdit(d: DayRow) {
		editingDay = d;
		editOpen2 = d.open;
		editClose = d.close;
		editBrk = d.brk;
		editOpen = true;
	}

	function saveEdit() {
		if (!editingDay) return;
		editingDay.open = editOpen2;
		editingDay.close = editClose;
		editingDay.brk = editBrk;
		editOpen = false;
		const l = get(locale);
		const t = STR[l];
		toast.success(`${t.tSavedPre} ${dayLabelOf(l, editingDay.dayKey)} ${t.tSavedPost}`.trim());
	}

	function toggleDay(d: DayRow, v: boolean) {
		d.active = v;
		const l = get(locale);
		const t = STR[l];
		toast.success(`${dayLabelOf(l, d.dayKey)}: ${v ? t.tOpen : t.tClosed}`);
	}

	function addException() {
		const l = get(locale);
		const t = STR[l];
		if (!excDate.trim() || !excLabel.trim()) {
			toast.error(t.tRequired);
			return;
		}
		exceptions = [...exceptions, { id: Date.now(), date: excDate.trim(), label: excLabel.trim(), closed: excClosed }];
		excDate = '';
		excLabel = '';
		toast.success(t.tExcAdded);
	}

	function applyChannel() {
		loading = true;
		setTimeout(() => {
			loading = false;
			const t = STR[get(locale)];
			toast.success(`${t.tAppliedPre} ${channel} ${t.tAppliedPost}`);
		}, 500);
	}
	function removeException(id: number) {
		exceptions = exceptions.filter((x) => x.id !== id);
		toast.success(STR[get(locale)].tExcDeleted);
	}
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
			<div>
				<Card.Title class="flex items-center gap-2"><Clock data-icon="inline-start" /> {s.title}</Card.Title>
				<Card.Description>{s.desc}</Card.Description>
			</div>
			<Badge variant="secondary" class="w-fit">{timezone}</Badge>
		</Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_1fr_auto]">
				<Field.Field>
					<Field.Label for="oh-channel">{s.channel}</Field.Label>
					<Select.Root type="single" bind:value={channel}>
						<Select.Trigger id="oh-channel" class="w-full">{channel}</Select.Trigger>
						<Select.Content>
							<Select.Group>
								<Select.GroupHeading>{s.channel}</Select.GroupHeading>
								<Select.Item value="omnichat">Omnichat</Select.Item>
								<Select.Item value="ticketing">Ticketing</Select.Item>
								<Select.Item value="email">Email</Select.Item>
								<Select.Item value="voice">Voice / Call</Select.Item>
							</Select.Group>
						</Select.Content>
					</Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="oh-tz">{s.timezone}</Field.Label>
					<Select.Root type="single" bind:value={timezone}>
						<Select.Trigger id="oh-tz" class="w-full">{timezone}</Select.Trigger>
						<Select.Content>
							<Select.Group>
								<Select.GroupHeading>{s.timezone}</Select.GroupHeading>
								<Select.Item value="Asia/Jakarta">Asia/Jakarta (WIB)</Select.Item>
								<Select.Item value="Asia/Makassar">Asia/Makassar (WITA)</Select.Item>
								<Select.Item value="Asia/Jayapura">Asia/Jayapura (WIT)</Select.Item>
							</Select.Group>
						</Select.Content>
					</Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label>&nbsp;</Field.Label>
					<Button onclick={applyChannel} disabled={loading}>{loading ? s.applying : s.apply}</Button>
				</Field.Field>
			</Field.FieldGroup>
			<Tabs.Root bind:value={tab}>
				<Tabs.List>
					<Tabs.Trigger value="jadwal">{s.tabSchedule}</Tabs.Trigger>
					<Tabs.Trigger value="pengecualian">{s.tabExc} ({exceptions.length})</Tabs.Trigger>
				</Tabs.List>
			</Tabs.Root>
		</Card.Content>
	</Card.Root>

	{#if loading}
		<Skeleton class="h-64 w-full" />
	{:else if tab === 'jadwal'}
		<Card.Root>
			<Card.Header>
				<Card.Title>{s.schedTitlePre} {channel}</Card.Title>
				<Card.Description>{s.schedDesc}</Card.Description>
			</Card.Header>
			<Card.Content class="p-0">
				<Table.Root>
					<Table.Header>
						<Table.Row>
							<Table.Head>{s.thDay}</Table.Head>
							<Table.Head>{s.thStatus}</Table.Head>
							<Table.Head>{s.thOpen}</Table.Head>
							<Table.Head>{s.thClose}</Table.Head>
							<Table.Head>{s.thBreak}</Table.Head>
							<Table.Head class="text-right">{s.thAct}</Table.Head>
						</Table.Row>
					</Table.Header>
					<Table.Body>
						{#each schedule as d (d.dayKey)}
							<Table.Row class={cn(!d.active && 'opacity-60')}>
								<Table.Cell class="font-medium">{dayLabel(d.dayKey)}</Table.Cell>
								<Table.Cell>
									<div class="flex items-center gap-2">
										<Switch checked={d.active} onCheckedChange={(v) => toggleDay(d, v === true)} aria-label={`${s.enablePre} ${dayLabel(d.dayKey)}`} />
										<Badge variant={d.active ? 'success' : 'secondary'}>{d.active ? s.open : s.closed}</Badge>
									</div>
								</Table.Cell>
								<Table.Cell class="tabular-nums">{d.open}</Table.Cell>
								<Table.Cell class="tabular-nums">{d.close}</Table.Cell>
								<Table.Cell class="text-muted-foreground tabular-nums">{d.brk}</Table.Cell>
								<Table.Cell class="text-right">
									<Tooltip.Root>
										<Tooltip.Trigger>
											{#snippet child({ props })}
												<Button {...props} size="icon" variant="ghost" onclick={() => openEdit(d)} aria-label={`${s.editPre} ${dayLabel(d.dayKey)}`}>
													<Pencil data-icon="true" />
												</Button>
											{/snippet}
										</Tooltip.Trigger>
										<Tooltip.Content>{s.editHour}</Tooltip.Content>
									</Tooltip.Root>
								</Table.Cell>
							</Table.Row>
						{/each}
					</Table.Body>
				</Table.Root>
			</Card.Content>
			<Card.Footer>
				<Separator class="my-1" />
				<p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> {s.footInfo}</p>
			</Card.Footer>
		</Card.Root>
	{:else}
		<div class="grid gap-4 lg:grid-cols-[1fr_1.4fr]">
			<Card.Root>
				<Card.Header>
					<Card.Title class="flex items-center gap-2"><Plus data-icon="inline-start" /> {s.addExc}</Card.Title>
					<Card.Description>{s.addExcDesc}</Card.Description>
				</Card.Header>
				<Card.Content>
					<Field.FieldGroup class="flex flex-col gap-4">
						<Field.Field>
							<Field.Label for="exc-date">{s.excDate}</Field.Label>
							<Input id="exc-date" placeholder={s.excDatePh} bind:value={excDate} />
						</Field.Field>
						<Field.Field>
							<Field.Label for="exc-label">{s.excLabel}</Field.Label>
							<Input id="exc-label" placeholder={s.excLabelPh} bind:value={excLabel} />
						</Field.Field>
						<Field.Field>
							<Field.Label for="exc-closed">{s.excClosed}</Field.Label>
							<div class="flex items-center gap-2">
								<Switch id="exc-closed" bind:checked={excClosed} />
								<span class="text-xs text-muted-foreground">{excClosed ? s.closedNote : s.limitedNote}</span>
							</div>
						</Field.Field>
						<Button onclick={addException}><Plus data-icon="inline-start" />{s.add}</Button>
					</Field.FieldGroup>
				</Card.Content>
			</Card.Root>
			<Card.Root>
				<Card.Header>
					<Card.Title>{s.excList}</Card.Title>
					<Card.Description>{exceptions.length} {s.excCountPost}</Card.Description>
				</Card.Header>
				<Card.Content class="flex flex-col gap-2">
					{#if exceptions.length === 0}
						<Empty.Root class="py-8">
							<Empty.Header>
								<Empty.Media><CalendarOff data-icon="empty" /></Empty.Media>
								<Empty.Title>{s.emptyTitle}</Empty.Title>
								<Empty.Description>{s.emptyDesc}</Empty.Description>
							</Empty.Header>
						</Empty.Root>
					{:else}
						{#each exceptions as e (e.id)}
							<div class="flex items-center gap-3 rounded-lg border px-3 py-2.5">
								<div class="min-w-0 flex-1">
									<p class="truncate text-sm font-medium">{e.label}</p>
									<p class="text-xs text-muted-foreground tabular-nums">{e.date}</p>
								</div>
								<Badge variant={e.closed ? 'destructive' : 'warning'} class="shrink-0">{e.closed ? s.badgeClosed : s.badgeLimited}</Badge>
								<Button
									size="icon"
									variant="ghost"
									class="shrink-0"
									aria-label={`${s.delPre} ${e.label}`}
									onclick={() => removeException(e.id)}
								>
									<Trash2 data-icon="true" />
								</Button>
							</div>
						{/each}
					{/if}
				</Card.Content>
			</Card.Root>
		</div>
	{/if}

	<Alert.Root variant="warning"><TriangleAlert data-icon="alert" /><Alert.Description>{s.alertApply}</Alert.Description></Alert.Root>
	<Alert.Root variant="success"><CircleCheck data-icon="alert" /><Alert.Description>{s.alertSync}</Alert.Description></Alert.Root>
</div>

<Dialog.Root bind:open={editOpen}>
	<Dialog.Content>
		<Dialog.Header>
			<Dialog.Title>{s.editTitlePre} {editingDay ? dayLabel(editingDay.dayKey) : ''}</Dialog.Title>
			<Dialog.Description>{s.editDesc}</Dialog.Description>
		</Dialog.Header>
		<Field.FieldGroup class="flex flex-col gap-4">
			<Field.Field>
				<Field.Label>{s.lblOpen}</Field.Label>
				<TimePicker bind:value={editOpen2} label={s.lblOpen} />
			</Field.Field>
			<Field.Field>
				<Field.Label>{s.lblClose}</Field.Label>
				<TimePicker bind:value={editClose} label={s.lblClose} />
			</Field.Field>
			<Field.Field>
				<Field.Label for="edit-brk">{s.lblBreak}</Field.Label>
				<Input id="edit-brk" placeholder={s.breakPh} bind:value={editBrk} />
			</Field.Field>
		</Field.FieldGroup>
		<Dialog.Footer>
			<Button variant="outline" onclick={() => (editOpen = false)}>{s.cancel}</Button>
			<Button onclick={saveEdit}>{s.save}</Button>
		</Dialog.Footer>
	</Dialog.Content>
</Dialog.Root>
