<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Select from '$lib/components/ui/select';
	import * as Field from '$lib/components/ui/field';
	import * as Pagination from '$lib/components/ui/pagination';
	import * as Empty from '$lib/components/ui/empty';
	import * as Alert from '$lib/components/ui/alert';
	import DateRangePicker from "$lib/components/ui/date-range-picker.svelte";
	import * as Chart from '$lib/components/ui/chart';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { CalendarDate } from '@internationalized/date';
	import type { DateRange } from 'bits-ui';
	import { Chart as LCChart, Svg, Axis, Grid, Bars, Area } from 'layerchart';
	import { Download, Filter, RotateCcw, Search, Smile, Meh, Frown, Info, Phone, CircleCheck, ChartLine, CircleX } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'Dashboard CSAT — DK UI Kit', heading: 'Dashboard CSAT',
			sub: 'Kepuasan pelanggan dari IVR PBX (PABXCC) — 1=Puas, 2=Cukup Puas, 3=Kurang Puas',
			alertT: 'Filter aktif', alertPre: 'Menampilkan', alertMid: 'dari', alertEnd: 'record IVR CSAT pada rentang terpilih.',
			statTotal: 'Total Record CSAT (IVR)', statFilled: 'CSAT Terisi', statRate: 'Tingkat Pengisian', statEmpty: 'CSAT Belum Diisi',
			filterT: 'Filter laporan', filterD: 'Saring berdasarkan periode, kanal, agent, dan status pengisian.',
			fPeriod: 'Periode', fPeriodPh: 'Pilih periode', fChannel: 'Kanal', fAll: 'Semua',
			fAgent: 'Agent', fAgentPh: 'Semua agent', fAgentAll: 'Semua agent',
			fStatus: 'Status CSAT', fFilled: 'Terisi', fEmpty: 'Belum diisi',
			fSearch: 'Pencarian', fSearchPh: 'Pelapor / tiket / agent',
			apply: 'Terapkan filter', reset: 'Reset', export: 'Export Excel',
			distT: 'Distribusi skor CSAT', distD: 'Puas / cukup / kurang / belum mengisi.',
			dist1: 'Puas (1)', dist2: 'Cukup (2)', dist3: 'Kurang (3)', distNone: 'Belum isi',
			trendT: 'Tren CSAT per hari', trendD: 'Total vs terisi.',
			legTotal: 'Total CSAT', legFilled: 'CSAT Terisi', leg1: '1 = Puas', leg2: '2 = Cukup', leg3: '3 = Kurang',
			cfgResp: 'Responden', cfgTotal: 'Total', cfgFilled: 'Terisi',
			detailT: 'Detail laporan CSAT', detailPre: 'Total', detailMid: '· menampilkan', detailEnd: 'tiket per halaman.',
			dataUnit: 'data',
			hNo: 'No', hReporter: 'Pelapor', hChannel: 'Kanal', hTicket: 'No. Tiket', hDate: 'Tgl Tiket', hTime: 'Waktu CSAT', hScore: 'Skor', hDesc: 'Keterangan', hAgent: 'Agent',
			score1: 'Puas', score2: 'Cukup Puas', score3: 'Kurang Puas', noScore: 'Belum diisi',
			emptyT: 'Tidak ada data', emptyD: 'Tidak ada record CSAT yang cocok dengan filter saat ini.'
		},
		en: {
			docTitle: 'CSAT Dashboard — DK UI Kit', heading: 'CSAT Dashboard',
			sub: 'Customer satisfaction from IVR PBX (PABXCC) — 1=Satisfied, 2=Fairly Satisfied, 3=Dissatisfied',
			alertT: 'Active filter', alertPre: 'Showing', alertMid: 'of', alertEnd: 'IVR CSAT records in the selected range.',
			statTotal: 'Total CSAT Records (IVR)', statFilled: 'Completed CSAT', statRate: 'Completion Rate', statEmpty: 'Unfilled CSAT',
			filterT: 'Report filters', filterD: 'Filter by period, channel, agent, and completion status.',
			fPeriod: 'Period', fPeriodPh: 'Select period', fChannel: 'Channel', fAll: 'All',
			fAgent: 'Agent', fAgentPh: 'All agents', fAgentAll: 'All agents',
			fStatus: 'CSAT Status', fFilled: 'Completed', fEmpty: 'Not filled',
			fSearch: 'Search', fSearchPh: 'Reporter / ticket / agent',
			apply: 'Apply filters', reset: 'Reset', export: 'Export Excel',
			distT: 'CSAT score distribution', distD: 'Satisfied / fair / dissatisfied / unfilled.',
			dist1: 'Satisfied (1)', dist2: 'Fair (2)', dist3: 'Dissatisfied (3)', distNone: 'Unfilled',
			trendT: 'Daily CSAT trend', trendD: 'Total vs completed.',
			legTotal: 'Total CSAT', legFilled: 'Completed CSAT', leg1: '1 = Satisfied', leg2: '2 = Fair', leg3: '3 = Poor',
			cfgResp: 'Respondents', cfgTotal: 'Total', cfgFilled: 'Completed',
			detailT: 'CSAT report details', detailPre: 'Total', detailMid: '· showing', detailEnd: 'tickets per page.',
			dataUnit: 'records',
			hNo: 'No', hReporter: 'Reporter', hChannel: 'Channel', hTicket: 'Ticket No.', hDate: 'Ticket Date', hTime: 'CSAT Time', hScore: 'Score', hDesc: 'Remarks', hAgent: 'Agent',
			score1: 'Satisfied', score2: 'Fairly Satisfied', score3: 'Dissatisfied', noScore: 'Not filled',
			emptyT: 'No data', emptyD: 'No CSAT records match the current filters.'
		},
		th: {
			docTitle: 'แดชบอร์ด CSAT — DK UI Kit', heading: 'แดชบอร์ด CSAT',
			sub: 'ความพึงพอใจลูกค้าจาก IVR PBX (PABXCC) — 1=พอใจ, 2=ค่อนข้างพอใจ, 3=ไม่พอใจ',
			alertT: 'ตัวกรองที่ใช้งาน', alertPre: 'แสดง', alertMid: 'จาก', alertEnd: 'ระเบียน IVR CSAT ในช่วงที่เลือก',
			statTotal: 'ระเบียน CSAT ทั้งหมด (IVR)', statFilled: 'CSAT ที่กรอกแล้ว', statRate: 'อัตราการกรอก', statEmpty: 'CSAT ที่ยังไม่กรอก',
			filterT: 'ตัวกรองรายงาน', filterD: 'กรองตามช่วงเวลา ช่องทาง เอเจนต์ และสถานะการกรอก',
			fPeriod: 'ช่วงเวลา', fPeriodPh: 'เลือกช่วงเวลา', fChannel: 'ช่องทาง', fAll: 'ทั้งหมด',
			fAgent: 'เอเจนต์', fAgentPh: 'เอเจนต์ทั้งหมด', fAgentAll: 'เอเจนต์ทั้งหมด',
			fStatus: 'สถานะ CSAT', fFilled: 'กรอกแล้ว', fEmpty: 'ยังไม่กรอก',
			fSearch: 'ค้นหา', fSearchPh: 'ผู้แจ้ง / ตั๋วงาน / เอเจนต์',
			apply: 'ใช้ตัวกรอง', reset: 'รีเซ็ต', export: 'ส่งออก Excel',
			distT: 'การกระจายคะแนน CSAT', distD: 'พอใจ / ปานกลาง / ไม่พอใจ / ยังไม่กรอก',
			dist1: 'พอใจ (1)', dist2: 'ปานกลาง (2)', dist3: 'ไม่พอใจ (3)', distNone: 'ยังไม่กรอก',
			trendT: 'แนวโน้ม CSAT รายวัน', trendD: 'ทั้งหมด vs กรอกแล้ว',
			legTotal: 'CSAT ทั้งหมด', legFilled: 'CSAT ที่กรอกแล้ว', leg1: '1 = พอใจ', leg2: '2 = ปานกลาง', leg3: '3 = น้อย',
			cfgResp: 'ผู้ตอบ', cfgTotal: 'ทั้งหมด', cfgFilled: 'กรอกแล้ว',
			detailT: 'รายละเอียดรายงาน CSAT', detailPre: 'ทั้งหมด', detailMid: '· แสดง', detailEnd: 'ตั๋วต่อหน้า',
			dataUnit: 'ข้อมูล',
			hNo: 'ลำดับ', hReporter: 'ผู้แจ้ง', hChannel: 'ช่องทาง', hTicket: 'เลขตั๋ว', hDate: 'วันที่ตั๋ว', hTime: 'เวลา CSAT', hScore: 'คะแนน', hDesc: 'หมายเหตุ', hAgent: 'เอเจนต์',
			score1: 'พอใจ', score2: 'ค่อนข้างพอใจ', score3: 'ไม่พอใจ', noScore: 'ยังไม่กรอก',
			emptyT: 'ไม่มีข้อมูล', emptyD: 'ไม่มีระเบียน CSAT ที่ตรงกับตัวกรองปัจจุบัน'
		},
		tl: {
			docTitle: 'Dashboard ng CSAT — DK UI Kit', heading: 'Dashboard ng CSAT',
			sub: 'Kasiyahan ng customer mula sa IVR PBX (PABXCC) — 1=Nasiyahan, 2=Medyo Nasiyahan, 3=Hindi Nasiyahan',
			alertT: 'Aktibong filter', alertPre: 'Ipinapakita ang', alertMid: 'mula sa', alertEnd: 'IVR CSAT record sa napiling saklaw.',
			statTotal: 'Kabuuang CSAT Record (IVR)', statFilled: 'Nakumpletong CSAT', statRate: 'Rate ng Pagkumpleto', statEmpty: 'Hindi pa Nasagutang CSAT',
			filterT: 'Mga filter ng ulat', filterD: 'I-filter ayon sa panahon, channel, agent, at status ng pagsagot.',
			fPeriod: 'Panahon', fPeriodPh: 'Pumili ng panahon', fChannel: 'Channel', fAll: 'Lahat',
			fAgent: 'Agent', fAgentPh: 'Lahat ng agent', fAgentAll: 'Lahat ng agent',
			fStatus: 'Status ng CSAT', fFilled: 'Nakumpleto', fEmpty: 'Hindi pa nasagutan',
			fSearch: 'Paghahanap', fSearchPh: 'Nagre-report / ticket / agent',
			apply: 'Ilapat ang filter', reset: 'I-reset', export: 'I-export ang Excel',
			distT: 'Distribusyon ng iskor ng CSAT', distD: 'Nasiyahan / katamtaman / hindi nasiyahan / walang sagot.',
			dist1: 'Nasiyahan (1)', dist2: 'Katamtaman (2)', dist3: 'Hindi nasiyahan (3)', distNone: 'Walang sagot',
			trendT: 'Araw-araw na trend ng CSAT', trendD: 'Kabuuan vs nakumpleto.',
			legTotal: 'Kabuuang CSAT', legFilled: 'Nakumpletong CSAT', leg1: '1 = Nasiyahan', leg2: '2 = Katamtaman', leg3: '3 = Kulang',
			cfgResp: 'Mga sumagot', cfgTotal: 'Kabuuan', cfgFilled: 'Nakumpleto',
			detailT: 'Detalye ng ulat ng CSAT', detailPre: 'Kabuuan', detailMid: '· ipinapakita ang', detailEnd: 'ticket bawat pahina.',
			dataUnit: 'datos',
			hNo: 'Blg', hReporter: 'Nagre-report', hChannel: 'Channel', hTicket: 'Blg. ng Ticket', hDate: 'Petsa ng Ticket', hTime: 'Oras ng CSAT', hScore: 'Iskor', hDesc: 'Puna', hAgent: 'Agent',
			score1: 'Nasiyahan', score2: 'Medyo Nasiyahan', score3: 'Hindi Nasiyahan', noScore: 'Hindi pa nasagutan',
			emptyT: 'Walang datos', emptyD: 'Walang CSAT record na tumutugma sa kasalukuyang filter.'
		}
	} as const;
	let s = $derived(STR[$locale]);

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

	let scoreLabel = $derived<Record<string, string>>({ '1': s.score1, '2': s.score2, '3': s.score3 });
	function scoreVariant(sv: Row['score']) { return sv === '1' ? 'success' as const : sv === '2' ? 'warning' as const : sv === '3' ? 'destructive' as const : 'secondary' as const; }

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

	let dist = $derived([
		{ label: s.dist1, value: 3, color: 'var(--color-success, #16a34a)' },
		{ label: s.dist2, value: 2, color: 'var(--color-warning, #d97706)' },
		{ label: s.dist3, value: 1, color: 'var(--color-destructive, #dc2626)' },
		{ label: s.distNone, value: 2, color: 'var(--color-muted-foreground, #9ca3af)' }
	]);
	const trend = [
		{ day: '12 Sep', total: 2, filled: 2 }, { day: '13 Sep', total: 2, filled: 1 },
		{ day: '14 Sep', total: 2, filled: 2 }, { day: '15 Sep', total: 2, filled: 1 }
	];
	let chartConfig = $derived({ value: { label: s.cfgResp }, total: { label: s.cfgTotal }, filled: { label: s.cfgFilled } });

	function reset() { kanal = 'all'; agent = 'all'; status = 'all'; search = ''; page = 1; period = { start: new CalendarDate(2026, 1, 1), end: new CalendarDate(2026, 9, 30) }; }
	const agents = ['Ayu Lestari', 'Rizky Pratama', 'Dewi Anggraini', 'Fajar Nugraha'];
	let statCards = $derived([
		{ id: 'total' as const, icon: Phone, label: s.statTotal, value: String(total) },
		{ id: 'filled' as const, icon: CircleCheck, label: s.statFilled, value: String(filled) },
		{ id: 'rate' as const, icon: ChartLine, label: s.statRate, value: `${rate}%` },
		{ id: 'empty' as const, icon: CircleX, label: s.statEmpty, value: String(empty) }
	]);
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<div>
		<h1 class="flex items-center gap-2 text-xl font-bold"><Smile size={20} class="text-primary" />{s.heading}</h1>
		<p class="mt-1 flex items-center gap-1 text-xs text-muted-foreground"><ChartLine size={13} />{s.sub}</p>
	</div>

	<Alert.Root variant="warning"><Info /><Alert.Title>{s.alertT}</Alert.Title><Alert.Description>{s.alertPre} {filtered.length} {s.alertMid} {total} {s.alertEnd}</Alert.Description></Alert.Root>

	<div class="grid grid-cols-1 gap-4 md:grid-cols-4">
		{#each statCards as sc}
			<Card.Root><Card.Content class="flex items-center gap-3 p-4"><div class="flex size-10 items-center justify-center rounded-xl bg-primary/10 text-primary"><sc.icon size={19} /></div><div><p class="text-xl font-bold">{sc.value}</p><p class="text-xs text-muted-foreground">{sc.label}</p>{#if sc.id === 'rate'}<Progress value={rate} class="mt-2 w-28" />{/if}</div></Card.Content></Card.Root>
		{/each}
	</div>

	<Card.Root>
		<Card.Header><Card.Title>{s.filterT}</Card.Title><p class="text-sm text-muted-foreground">{s.filterD}</p></Card.Header>
		<Card.Content>
			<Field.FieldGroup class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
				<Field.Field>
					<Field.Label>{s.fPeriod}</Field.Label>
					<DateRangePicker bind:value={period} label={s.fPeriodPh} />
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-kanal">{s.fChannel}</Field.Label>
					<Select.Root type="single" bind:value={kanal}><Select.Trigger id="csat-kanal"><Select.Value placeholder={s.fAll} /></Select.Trigger><Select.Content><Select.Item value="all">{s.fAll}</Select.Item><Select.Item value="Inbound">Inbound</Select.Item><Select.Item value="WA Call">WA Call</Select.Item></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-agent">{s.fAgent}</Field.Label>
					<Select.Root type="single" bind:value={agent}><Select.Trigger id="csat-agent"><Select.Value placeholder={s.fAgentPh} /></Select.Trigger><Select.Content><Select.Item value="all">{s.fAgentAll}</Select.Item>{#each agents as a}<Select.Item value={a}>{a}</Select.Item>{/each}</Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-status">{s.fStatus}</Field.Label>
					<Select.Root type="single" bind:value={status}><Select.Trigger id="csat-status"><Select.Value placeholder={s.fAll} /></Select.Trigger><Select.Content><Select.Item value="all">{s.fAll}</Select.Item><Select.Item value="filled">{s.fFilled}</Select.Item><Select.Item value="empty">{s.fEmpty}</Select.Item></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="csat-q">{s.fSearch}</Field.Label>
					<div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="csat-q" bind:value={search} placeholder={s.fSearchPh} class="pl-8" /></div>
				</Field.Field>
			</Field.FieldGroup>
			<div class="mt-4 flex flex-wrap items-center justify-between gap-2">
				<div class="flex gap-2"><Button size="sm"><Filter data-icon="inline-start" />{s.apply}</Button><Button size="sm" variant="outline" onclick={reset}><RotateCcw data-icon="inline-start" />{s.reset}</Button></div>
				<Button size="sm" variant="secondary"><Download data-icon="inline-start" />{s.export}</Button>
			</div>
		</Card.Content>
	</Card.Root>

	<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
		<Card.Root>
			<Card.Header><Card.Title>{s.distT}</Card.Title><p class="text-sm text-muted-foreground">{s.distD}</p></Card.Header>
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
			<Card.Header><Card.Title>{s.trendT}</Card.Title><p class="text-sm text-muted-foreground">{s.trendD}</p></Card.Header>
			<Card.Content>
				<Chart.Container config={chartConfig} class="aspect-auto h-64">
					<LCChart data={trend} x="day" y="total" yNice padding={{ left: 8, right: 8 }}>
						<Svg><Grid vertical={false} /><Axis placement="bottom" /><Axis placement="left" grid rule /><Area y1="total" fill="var(--color-primary)" fillOpacity={0.15} stroke="var(--color-primary)" /><Area y1="filled" fill="var(--color-success, #16a34a)" fillOpacity={0.2} stroke="var(--color-success, #16a34a)" /></Svg>
					</LCChart>
				</Chart.Container>
				<Separator class="my-3" />
				<div class="flex flex-wrap gap-2 text-xs"><Badge variant="secondary">{s.legTotal}</Badge><Badge variant="secondary">{s.legFilled}</Badge><Badge variant="outline"><Smile size={12} />{s.leg1}</Badge><Badge variant="outline"><Meh size={12} />{s.leg2}</Badge><Badge variant="outline"><Frown size={12} />{s.leg3}</Badge></div>
			</Card.Content>
		</Card.Root>
	</div>

	<Card.Root>
		<Card.Header class="flex-row items-center justify-between space-y-0">
			<div><Card.Title>{s.detailT}</Card.Title><p class="mt-1 text-sm text-muted-foreground">{s.detailPre} {total} {s.detailMid} {pageRows.length} {s.detailEnd}</p></div>
			<Badge variant="secondary">{filtered.length} {s.dataUnit}</Badge>
		</Card.Header>
		<Card.Content>
			{#if filtered.length > 0}
				<div class="overflow-x-auto rounded-xl border">
					<Table.Root>
						<Table.Header><Table.Row><Table.Head>{s.hNo}</Table.Head><Table.Head>{s.hReporter}</Table.Head><Table.Head>{s.hChannel}</Table.Head><Table.Head>{s.hTicket}</Table.Head><Table.Head>{s.hDate}</Table.Head><Table.Head>{s.hTime}</Table.Head><Table.Head>{s.hScore}</Table.Head><Table.Head>{s.hDesc}</Table.Head><Table.Head>{s.hAgent}</Table.Head></Table.Row></Table.Header>
						<Table.Body>
							{#each pageRows as r, i}
								<Table.Row><Table.Cell>{(safePage - 1) * perPage + i + 1}</Table.Cell><Table.Cell class="font-medium">{r.customer}</Table.Cell><Table.Cell>{r.kanal}</Table.Cell><Table.Cell class="font-mono text-xs">{r.ticket}</Table.Cell><Table.Cell>{r.created}</Table.Cell><Table.Cell>{r.time}</Table.Cell><Table.Cell><Badge variant={scoreVariant(r.score)}>{r.score ?? s.noScore}</Badge></Table.Cell><Table.Cell>{r.score ? scoreLabel[r.score] : s.noScore}</Table.Cell><Table.Cell>{r.agent}</Table.Cell></Table.Row>
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
				<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><Search size={20} /></Empty.Media><Empty.Title>{s.emptyT}</Empty.Title><Empty.Description>{s.emptyD}</Empty.Description></Empty.Header><Empty.Content><Button size="sm" variant="outline" onclick={reset}>{s.reset}</Button></Empty.Content></Empty.Root>
			{/if}
		</Card.Content>
	</Card.Root>
</div>
