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
	import * as Sheet from '$lib/components/ui/sheet';
	import * as InputOTP from '$lib/components/ui/input-otp';
	import * as Chart from '$lib/components/ui/chart';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Switch } from '$lib/components/ui/switch';
	import DatePicker from "$lib/components/ui/date-picker.svelte";
	import { CalendarDate, type DateValue } from '@internationalized/date';
	import { Chart as LCChart, Svg, Axis, Grid, Bars } from 'layerchart';
	import { toast } from 'svelte-sonner';
	import { RefreshCw, Users, Hourglass, MessagesSquare, CircleCheck, Search, UserPlus, ShieldCheck, TriangleAlert } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'SPV Dashboard — DK UI Kit', heading: 'SPV Dashboard',
			sub: 'Supervisi chat berjalan: queue, handled, open/close, dan assign ulang agent.',
			autoRefresh: 'Auto refresh', refreshBtn: 'Refresh data',
			toastRefresh: 'Data diperbarui', toastRelease: 'Sesi di-release', toastAssign: 'Agent di-assign', toastShift: 'Jadwal shift disimpan',
			alertQueue: 'chat menunggu di queue', alertUpd: 'Terakhir diperbarui', alertAssign: 'Segera assign ke agent ready.',
			openT: 'Chat terbuka', openD: 'Customer · channel · account · agent · status · mulai.',
			sessionsUnit: 'sesi', fSearch: 'Cari sesi', fSearchPh: 'Customer / agent / account',
			fChannel: 'Channel', fAll: 'Semua', fStatus: 'Status',
			stAll: 'Semua', stOpen: 'Open', stQueue: 'Queue', stClose: 'Close',
			hCust: 'Customer', hChannel: 'Channel', hAccount: 'Account', hAgent: 'Agent', hStatus: 'Status', hStart: 'Mulai', hAction: 'Aksi',
			release: 'Release', reassign: 'Re-assign', assign: 'Assign',
			emptyT: 'Tidak ada sesi', emptyPre: 'Tidak ada chat', emptyEnd: 'yang cocok dengan filter.',
			sumT: 'Ringkasan chat', sumQueue: 'Chat in Queue', sumHandled: 'Chat on Handled', sumOpen: 'Total Chat Open', sumClosed: 'Total Chat Closed',
			loadHandled: 'Beban handled',
			loadT: 'Beban sesi', loadD: 'Queue vs handled vs closed.',
			ldQueue: 'Queue', ldHandled: 'Handled', ldClosed: 'Closed', cfgChat: 'Chat',
			shiftBtn: 'Jadwal shift & PIN SPV',
			dlgT: 'List agent ready', dlgD: 'Pilih agent untuk sesi milik',
			hUser: 'Username', hName: 'Nama', dlgAssign: 'Assign', close: 'Tutup',
			shT: 'Jadwal shift SPV', shD: 'Pilih tanggal shift dan verifikasi PIN sebelum release massal.',
			shDate: 'Pilih tanggal shift', pinLabel: 'PIN otorisasi (6 digit)', pinD: 'PIN diminta saat release semua sesi.',
			save: 'Simpan jadwal'
		},
		en: {
			docTitle: 'SPV Dashboard — DK UI Kit', heading: 'SPV Dashboard',
			sub: 'Live chat supervision: queue, handled, open/close, and agent reassignment.',
			autoRefresh: 'Auto refresh', refreshBtn: 'Refresh data',
			toastRefresh: 'Data refreshed', toastRelease: 'Session released', toastAssign: 'Agent assigned', toastShift: 'Shift schedule saved',
			alertQueue: 'chats waiting in queue', alertUpd: 'Last updated', alertAssign: 'Please assign to a ready agent.',
			openT: 'Open chats', openD: 'Customer · channel · account · agent · status · started.',
			sessionsUnit: 'sessions', fSearch: 'Search sessions', fSearchPh: 'Customer / agent / account',
			fChannel: 'Channel', fAll: 'All', fStatus: 'Status',
			stAll: 'All', stOpen: 'Open', stQueue: 'Queue', stClose: 'Closed',
			hCust: 'Customer', hChannel: 'Channel', hAccount: 'Account', hAgent: 'Agent', hStatus: 'Status', hStart: 'Started', hAction: 'Actions',
			release: 'Release', reassign: 'Re-assign', assign: 'Assign',
			emptyT: 'No sessions', emptyPre: 'No', emptyEnd: 'chats match the filter.',
			sumT: 'Chat summary', sumQueue: 'Chats in Queue', sumHandled: 'Chats on Handled', sumOpen: 'Total Open Chats', sumClosed: 'Total Closed Chats',
			loadHandled: 'Handled load',
			loadT: 'Session load', loadD: 'Queue vs handled vs closed.',
			ldQueue: 'Queue', ldHandled: 'Handled', ldClosed: 'Closed', cfgChat: 'Chats',
			shiftBtn: 'Shift schedule & SPV PIN',
			dlgT: 'Ready agent list', dlgD: 'Select an agent for the session of',
			hUser: 'Username', hName: 'Name', dlgAssign: 'Assign', close: 'Close',
			shT: 'SPV shift schedule', shD: 'Pick a shift date and verify the PIN before mass release.',
			shDate: 'Select shift date', pinLabel: 'Authorization PIN (6 digits)', pinD: 'PIN is required when releasing all sessions.',
			save: 'Save schedule'
		},
		th: {
			docTitle: 'แดชบอร์ด SPV — DK UI Kit', heading: 'แดชบอร์ด SPV',
			sub: 'กำกับแชตที่กำลังดำเนิน: คิว รับเรื่อง เปิด/ปิด และมอบหมายเอเจนต์ใหม่',
			autoRefresh: 'รีเฟรชอัตโนมัติ', refreshBtn: 'รีเฟรชข้อมูล',
			toastRefresh: 'อัปเดตข้อมูลแล้ว', toastRelease: 'ปล่อยเซสชันแล้ว', toastAssign: 'มอบหมายเอเจนต์แล้ว', toastShift: 'บันทึกตารางกะแล้ว',
			alertQueue: 'แชตรอคิวอยู่', alertUpd: 'อัปเดตล่าสุด', alertAssign: 'กรุณามอบหมายให้เอเจนต์ที่พร้อม',
			openT: 'แชตที่เปิดอยู่', openD: 'ลูกค้า · ช่องทาง · แอ็กเคาต์ · เอเจนต์ · สถานะ · เริ่ม',
			sessionsUnit: 'เซสชัน', fSearch: 'ค้นหาเซสชัน', fSearchPh: 'ลูกค้า / เอเจนต์ / แอ็กเคาต์',
			fChannel: 'ช่องทาง', fAll: 'ทั้งหมด', fStatus: 'สถานะ',
			stAll: 'ทั้งหมด', stOpen: 'เปิด', stQueue: 'คิว', stClose: 'ปิด',
			hCust: 'ลูกค้า', hChannel: 'ช่องทาง', hAccount: 'แอ็กเคาต์', hAgent: 'เอเจนต์', hStatus: 'สถานะ', hStart: 'เริ่ม', hAction: 'จัดการ',
			release: 'ปล่อย', reassign: 'มอบหมายใหม่', assign: 'มอบหมาย',
			emptyT: 'ไม่มีเซสชัน', emptyPre: 'ไม่มีแชต', emptyEnd: 'ที่ตรงกับตัวกรอง',
			sumT: 'สรุปแชต', sumQueue: 'แชตในคิว', sumHandled: 'แชตที่รับเรื่อง', sumOpen: 'แชตเปิดทั้งหมด', sumClosed: 'แชตปิดทั้งหมด',
			loadHandled: 'ภาระรับเรื่อง',
			loadT: 'ภาระเซสชัน', loadD: 'คิว vs รับเรื่อง vs ปิด',
			ldQueue: 'คิว', ldHandled: 'รับเรื่อง', ldClosed: 'ปิด', cfgChat: 'แชต',
			shiftBtn: 'ตารางกะ & PIN SPV',
			dlgT: 'รายชื่อเอเจนต์ที่พร้อม', dlgD: 'เลือกเอเจนต์สำหรับเซสชันของ',
			hUser: 'ชื่อผู้ใช้', hName: 'ชื่อ', dlgAssign: 'มอบหมาย', close: 'ปิด',
			shT: 'ตารางกะ SPV', shD: 'เลือกวันที่กะและยืนยัน PIN ก่อนปล่อยทั้งหมด',
			shDate: 'เลือกวันที่กะ', pinLabel: 'PIN อนุมัติ (6 หลัก)', pinD: 'ต้องใช้ PIN เมื่อปล่อยทุกเซสชัน',
			save: 'บันทึกตาราง'
		},
		tl: {
			docTitle: 'SPV Dashboard — DK UI Kit', heading: 'SPV Dashboard',
			sub: 'Supervision ng live chat: queue, handled, open/close, at reassignment ng agent.',
			autoRefresh: 'Auto refresh', refreshBtn: 'I-refresh ang datos',
			toastRefresh: 'Na-update ang datos', toastRelease: 'Na-release ang session', toastAssign: 'Na-assign ang agent', toastShift: 'Nai-save ang shift schedule',
			alertQueue: 'chat na naghihintay sa queue', alertUpd: 'Huling na-update', alertAssign: 'Pakitalaga sa ready na agent.',
			openT: 'Bukas na chat', openD: 'Customer · channel · account · agent · status · simula.',
			sessionsUnit: 'session', fSearch: 'Maghanap ng session', fSearchPh: 'Customer / agent / account',
			fChannel: 'Channel', fAll: 'Lahat', fStatus: 'Status',
			stAll: 'Lahat', stOpen: 'Open', stQueue: 'Queue', stClose: 'Close',
			hCust: 'Customer', hChannel: 'Channel', hAccount: 'Account', hAgent: 'Agent', hStatus: 'Status', hStart: 'Simula', hAction: 'Aksyon',
			release: 'I-release', reassign: 'I-re-assign', assign: 'I-assign',
			emptyT: 'Walang session', emptyPre: 'Walang', emptyEnd: 'chat na tumutugma sa filter.',
			sumT: 'Buod ng chat', sumQueue: 'Chat sa Queue', sumHandled: 'Chat na Hina-handle', sumOpen: 'Kabuuang Open Chat', sumClosed: 'Kabuuang Closed Chat',
			loadHandled: 'Handled load',
			loadT: 'Session load', loadD: 'Queue vs handled vs closed.',
			ldQueue: 'Queue', ldHandled: 'Handled', ldClosed: 'Closed', cfgChat: 'Chat',
			shiftBtn: 'Shift schedule & SPV PIN',
			dlgT: 'Listahan ng ready na agent', dlgD: 'Pumili ng agent para sa session ni',
			hUser: 'Username', hName: 'Pangalan', dlgAssign: 'I-assign', close: 'Isara',
			shT: 'Shift schedule ng SPV', shD: 'Pumili ng petsa ng shift at i-verify ang PIN bago mag-mass release.',
			shDate: 'Pumili ng petsa ng shift', pinLabel: 'Authorization PIN (6 digit)', pinD: 'Kailangan ang PIN sa pag-release ng lahat ng session.',
			save: 'I-save ang schedule'
		}
	} as const;
	let s = $derived(STR[$locale]);

	let statusFilter: string | undefined = $state('all');
	let channelFilter = $state('all');
	let search = $state('');
	let page = $state(1);
	const perPage = 5;
	let autoRefresh = $state(true);
	let assignOpen = $state(false);
	let sheetOpen = $state(false);
	let selectedChat = $state('');
	let otp = $state('');
	let shiftDate = $state<DateValue | undefined>(new CalendarDate(2026, 9, 30));

	type Chat = { customer: string; channel: string; account: string; agent: string | null; status: 'open' | 'queue' | 'close'; started: string };
	const chats: Chat[] = [
		{ customer: 'NINA', channel: 'WhatsApp', account: 'CS AHU 1', agent: 'Ayu Lestari', status: 'open', started: '10:02' },
		{ customer: 'EVA SITI', channel: 'Live Chat', account: 'Web AHU', agent: null, status: 'queue', started: '10:05' },
		{ customer: 'BUDI SANTOSO', channel: 'Voice', account: 'PBX 101', agent: 'Rizky Pratama', status: 'open', started: '10:11' },
		{ customer: 'SITI AMINAH', channel: 'Email', account: 'info@ahu', agent: 'Dewi Anggraini', status: 'open', started: '10:18' },
		{ customer: 'ANDI WIJAYA', channel: 'WhatsApp', account: 'CS AHU 2', agent: null, status: 'queue', started: '10:22' },
		{ customer: 'RINA MARLINA', channel: 'Live Chat', account: 'Web AHU', agent: 'Fajar Nugraha', status: 'close', started: '09:47' },
		{ customer: 'HENDRA G', channel: 'WhatsApp', account: 'CS AHU 1', agent: 'Sari Wulandari', status: 'close', started: '09:31' }
	];
	const readyAgents = [
		{ username: 'ayu.lestari', name: 'Ayu Lestari' },
		{ username: 'rizky.p', name: 'Rizky Pratama' },
		{ username: 'dewi.a', name: 'Dewi Anggraini' }
	];

	const filtered = $derived(chats.filter((c) => {
		if (statusFilter !== 'all' && c.status !== statusFilter) return false;
		if (channelFilter !== 'all' && c.channel !== channelFilter) return false;
		const q = search.trim().toLowerCase();
		if (q && !`${c.customer} ${c.agent ?? ''} ${c.account}`.toLowerCase().includes(q)) return false;
		return true;
	}));
	const inQueue = chats.filter((c) => c.status === 'queue').length;
	const onHandled = chats.filter((c) => c.status === 'open').length;
	const totalOpen = inQueue + onHandled;
	const totalClosed = chats.filter((c) => c.status === 'close').length;
	const pageCount = $derived(Math.max(1, Math.ceil(filtered.length / perPage)));
	const safePage = $derived(Math.min(page, pageCount));
	const pageRows = $derived(filtered.slice((safePage - 1) * perPage, safePage * perPage));
	let loadData = $derived([
		{ label: s.ldQueue, value: inQueue }, { label: s.ldHandled, value: onHandled }, { label: s.ldClosed, value: totalClosed }
	]);
	let chartConfig = $derived({ value: { label: s.cfgChat } });
	let statusName = $derived(statusFilter === 'open' ? s.stOpen : statusFilter === 'queue' ? s.stQueue : statusFilter === 'close' ? s.stClose : s.stAll);
	function statusText(st: Chat['status']) { return st === 'open' ? s.stOpen : st === 'queue' ? s.stQueue : s.stClose; }
	let summaryCards = $derived([
		{ icon: Users, label: s.sumQueue, value: String(inQueue) },
		{ icon: Hourglass, label: s.sumHandled, value: String(onHandled) },
		{ icon: MessagesSquare, label: s.sumOpen, value: String(totalOpen) },
		{ icon: CircleCheck, label: s.sumClosed, value: String(totalClosed) }
	]);

	function statusVariant(sv: Chat['status']) { return sv === 'open' ? 'success' as const : sv === 'queue' ? 'warning' as const : 'secondary' as const; }
	function openAssign(customer: string) { selectedChat = customer; assignOpen = true; }
	let refreshedAt = $state('10:24:00');
	function refresh() { toast.success(s.toastRefresh); refreshedAt = new Date().toLocaleTimeString('id-ID'); }
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-center">
		<div><h1 class="flex items-center gap-2 text-xl font-bold"><ShieldCheck size={20} class="text-primary" />{s.heading}</h1><p class="mt-1 text-sm text-muted-foreground">{s.sub}</p></div>
		<div class="flex items-center gap-3">
			<label class="flex items-center gap-2 text-sm"><Switch bind:checked={autoRefresh} />{s.autoRefresh}</label>
			<Button size="sm" onclick={refresh}><RefreshCw data-icon="inline-start" />{s.refreshBtn}</Button>
		</div>
	</div>

	{#if inQueue > 0}
		<Alert.Root variant="warning"><TriangleAlert /><Alert.Title>{inQueue} {s.alertQueue}</Alert.Title><Alert.Description>{s.alertUpd} {refreshedAt}. {s.alertAssign}</Alert.Description></Alert.Root>
	{/if}

	<div class="grid gap-4 lg:grid-cols-[1.6fr_1fr]">
		<Card.Root>
			<Card.Header class="flex-row items-center justify-between space-y-0">
				<div><Card.Title>{s.openT}</Card.Title><p class="mt-1 text-sm text-muted-foreground">{s.openD}</p></div>
				<Badge variant="secondary">{filtered.length} {s.sessionsUnit}</Badge>
			</Card.Header>
			<Card.Content>
				<Field.FieldGroup class="mb-4 grid gap-3 md:grid-cols-[1fr_auto_auto]">
					<Field.Field><Field.Label for="spv-q">{s.fSearch}</Field.Label><div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="spv-q" bind:value={search} placeholder={s.fSearchPh} class="pl-8" /></div></Field.Field>
					<Field.Field><Field.Label>{s.fChannel}</Field.Label>
						<Select.Root type="single" bind:value={channelFilter}><Select.Trigger><Select.Value placeholder={s.fAll} /></Select.Trigger><Select.Content><Select.Item value="all">{s.fAll}</Select.Item><Select.Item value="WhatsApp">WhatsApp</Select.Item><Select.Item value="Live Chat">Live Chat</Select.Item><Select.Item value="Voice">Voice</Select.Item><Select.Item value="Email">Email</Select.Item></Select.Content></Select.Root>
					</Field.Field>
					<Field.Field><Field.Label>{s.fStatus}</Field.Label>
						<ToggleGroup.Root type="single" bind:value={statusFilter}><ToggleGroup.Item value="all">{s.stAll}</ToggleGroup.Item><ToggleGroup.Item value="open">{s.stOpen}</ToggleGroup.Item><ToggleGroup.Item value="queue">{s.stQueue}</ToggleGroup.Item><ToggleGroup.Item value="close">{s.stClose}</ToggleGroup.Item></ToggleGroup.Root>
					</Field.Field>
				</Field.FieldGroup>
				{#if filtered.length > 0}
					<div class="overflow-x-auto rounded-xl border">
						<Table.Root>
							<Table.Header><Table.Row><Table.Head>{s.hCust}</Table.Head><Table.Head>{s.hChannel}</Table.Head><Table.Head>{s.hAccount}</Table.Head><Table.Head>{s.hAgent}</Table.Head><Table.Head>{s.hStatus}</Table.Head><Table.Head>{s.hStart}</Table.Head><Table.Head class="text-right">{s.hAction}</Table.Head></Table.Row></Table.Header>
							<Table.Body>
								{#each pageRows as c}
									<Table.Row>
										<Table.Cell class="font-medium">{c.customer}</Table.Cell><Table.Cell>{c.channel}</Table.Cell><Table.Cell class="text-muted-foreground">{c.account}</Table.Cell>
										<Table.Cell>{c.agent ?? '—'}</Table.Cell><Table.Cell><Badge variant={statusVariant(c.status)}>{statusText(c.status)}</Badge></Table.Cell><Table.Cell>{c.started}</Table.Cell>
										<Table.Cell class="text-right"><div class="flex justify-end gap-1">{#if c.agent}<Button size="sm" variant="outline" onclick={() => toast.success(s.toastRelease)}>{s.release}</Button><Button size="sm" variant="destructive" onclick={() => openAssign(c.customer)}>{s.reassign}</Button>{:else}<Button size="sm" onclick={() => openAssign(c.customer)}><UserPlus data-icon="inline-start" />{s.assign}</Button>{/if}</div></Table.Cell>
									</Table.Row>
								{/each}
							</Table.Body>
						</Table.Root>
					</div>
					<div class="mt-4 flex justify-center">
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
					<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><MessagesSquare size={20} /></Empty.Media><Empty.Title>{s.emptyT}</Empty.Title><Empty.Description>{s.emptyPre} {statusName} {s.emptyEnd}</Empty.Description></Empty.Header></Empty.Root>
				{/if}
			</Card.Content>
		</Card.Root>

		<div class="flex flex-col gap-4">
			<Card.Root>
				<Card.Header><Card.Title>{s.sumT}</Card.Title></Card.Header>
				<Card.Content class="flex flex-col gap-3">
					{#each summaryCards as sc}
						<div class="flex items-center gap-3 rounded-xl border p-3"><div class="flex size-9 items-center justify-center rounded-full bg-primary/10 text-primary"><sc.icon size={16} /></div><div class="flex-1"><p class="text-xs text-muted-foreground">{sc.label}</p><p class="text-base font-bold">{sc.value}</p></div></div>
					{/each}
					<Separator />
					<div class="flex items-center justify-between text-xs"><span class="text-muted-foreground">{s.loadHandled}</span><span class="font-semibold">{Math.round((onHandled / Math.max(1, totalOpen + totalClosed)) * 100)}%</span></div>
					<Progress value={(onHandled / Math.max(1, totalOpen + totalClosed)) * 100} />
				</Card.Content>
			</Card.Root>
			<Card.Root>
				<Card.Header><Card.Title>{s.loadT}</Card.Title><p class="text-sm text-muted-foreground">{s.loadD}</p></Card.Header>
				<Card.Content>
					<Chart.Container config={chartConfig} class="aspect-auto h-48">
						<LCChart data={loadData} x="label" y="value" padding={{ left: 8, right: 8 }}>
							<Svg><Grid vertical={false} /><Axis placement="bottom" /><Axis placement="left" grid rule /><Bars radius={6} /></Svg>
						</LCChart>
					</Chart.Container>
					<Button size="sm" variant="outline" class="mt-3 w-full" onclick={() => (sheetOpen = true)}>{s.shiftBtn}</Button>
				</Card.Content>
			</Card.Root>
		</div>
	</div>

	<Dialog.Root bind:open={assignOpen}>
		<Dialog.Content>
			<Dialog.Header><Dialog.Title>{s.dlgT}</Dialog.Title><Dialog.Description>{s.dlgD} {selectedChat || '—'}.</Dialog.Description></Dialog.Header>
			<div class="overflow-x-auto rounded-xl border">
				<Table.Root><Table.Header><Table.Row><Table.Head>{s.hUser}</Table.Head><Table.Head>{s.hName}</Table.Head><Table.Head class="text-right">{s.hAction}</Table.Head></Table.Row></Table.Header>
				<Table.Body>{#each readyAgents as a}<Table.Row><Table.Cell class="font-mono text-xs">{a.username}</Table.Cell><Table.Cell>{a.name}</Table.Cell><Table.Cell class="text-right"><Button size="sm" onclick={() => { assignOpen = false; toast.success(s.toastAssign); }}>{s.dlgAssign}</Button></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
			</div>
			<Dialog.Footer><Button size="sm" variant="outline" onclick={() => (assignOpen = false)}>{s.close}</Button></Dialog.Footer>
		</Dialog.Content>
	</Dialog.Root>

	<Sheet.Root bind:open={sheetOpen}>
		<Sheet.Content side="right">
			<Sheet.Header><Sheet.Title>{s.shT}</Sheet.Title><Sheet.Description>{s.shD}</Sheet.Description></Sheet.Header>
			<div class="flex flex-col gap-4 px-4 pb-4">
				<DatePicker bind:value={shiftDate} label={s.shDate} placeholder={s.shDate} />
				<Field.Field><Field.Label>{s.pinLabel}</Field.Label>
					<InputOTP.Root maxlength={6} bind:value={otp}>
						<InputOTP.Group>
							<InputOTP.Slot index={0} /><InputOTP.Slot index={1} /><InputOTP.Slot index={2} /><InputOTP.Slot index={3} /><InputOTP.Slot index={4} /><InputOTP.Slot index={5} />
						</InputOTP.Group>
					</InputOTP.Root>
					<Field.Description>{s.pinD}</Field.Description>
				</Field.Field>
				<Button size="sm" onclick={() => { sheetOpen = false; toast.success(s.toastShift); }}>{s.save}</Button>
			</div>
		</Sheet.Content>
	</Sheet.Root>
</div>
