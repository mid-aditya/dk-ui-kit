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
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import * as Empty from '$lib/components/ui/empty';
	import DatePicker from "$lib/components/ui/date-picker.svelte";
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Phone, MessageCircle, Mail, Share2, Star, TriangleAlert, CircleCheck, Info, CalendarDays, Inbox } from 'lucide-svelte';
	import { CalendarDate, type DateValue } from '@internationalized/date';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'Home — Statistik Kanal',
			filterTitle: 'Statistik Kanal | Real-time Performance Monitoring',
			filterDesc: 'Filter rentang tanggal dan periode untuk memperbarui metrik kanal.',
			startDate: 'Start Date',
			pickStart: 'Pilih start date',
			pickDatePh: 'Pilih tanggal',
			period: 'Periode',
			monthAug: 'Agustus 2026',
			monthSep: 'September 2026',
			monthOct: 'Oktober 2026',
			apply: 'Apply Filter',
			loading: 'Memuat',
			rangeLabel: 'Rentang',
			d7: '7 hari', d30: '30 hari', d90: '90 hari',
			daily: 'Harian', weekly: 'Mingguan', monthly: 'Bulanan',
			scope: 'Scope data: semua kanal · diperbarui real-time',
			sectionLabel: 'Statistik kanal',
			active: 'Aktif',
			channelConnected: 'Kanal terhubung',
			resp: 'Respons', avg: 'Rata-rata', satis: 'Kepuasan',
			totalPrefix: 'Total:',
			alertWait: '4 chat menunggu balasan lebih dari 5 menit.',
			alertAll: 'Semua channel aktif dan terhubung.',
			volTitle: 'Volume kanal', volDesc: 'Distribusi 7 hari terakhir.',
			latestTitle: 'Tiket terbaru', latestDesc: 'Aktivitas tiket terakhir.',
			emptyTitle: 'Belum ada tiket', emptyDesc: 'Tiket baru akan muncul di sini.',
			thId: 'ID', thSubject: 'Subjek', thOwner: 'Owner', thStatus: 'Status',
			showing3: 'Menampilkan 3 tiket terbaru',
			stUrgent: 'Urgent', stOpen: 'Open', stProgress: 'In Progress',
			channels: [
				{ key: 'phone', label: 'Phone Calls', total: '248 panggilan', answered: '212 terjawab (85%)', avg: '3m 24s', score: '4.6/5' },
				{ key: 'chat', label: 'Live Chat', total: '186 chat', answered: '174 direspon (94%)', avg: '42 detik', score: '4.8/5' },
				{ key: 'email', label: 'Email', total: '124 email', answered: '96 dibalas (77%)', avg: '2j 18m', score: '4.5/5' },
				{ key: 'wa', label: 'WhatsApp Business', total: '316 chat', answered: '294 direspon (93%)', avg: '1m 06s', score: '4.9/5' },
				{ key: 'soc', label: 'Social Media', total: '92 interaksi', answered: '81 direspon (88%)', avg: '18 menit', score: '4.4/5' },
				{ key: 'cmt', label: 'Comment & More', total: '74 interaksi', answered: '61 direspon (82%)', avg: '26 menit', score: '4.3/5' }
			]
		},
		en: {
			docTitle: 'Home — Channel Statistics',
			filterTitle: 'Channel Statistics | Real-time Performance Monitoring',
			filterDesc: 'Filter date range and period to refresh channel metrics.',
			startDate: 'Start Date',
			pickStart: 'Pick start date',
			pickDatePh: 'Pick a date',
			period: 'Period',
			monthAug: 'August 2026',
			monthSep: 'September 2026',
			monthOct: 'October 2026',
			apply: 'Apply Filter',
			loading: 'Loading',
			rangeLabel: 'Range',
			d7: '7 days', d30: '30 days', d90: '90 days',
			daily: 'Daily', weekly: 'Weekly', monthly: 'Monthly',
			scope: 'Data scope: all channels · updated real-time',
			sectionLabel: 'Channel statistics',
			active: 'Active',
			channelConnected: 'Channel connected',
			resp: 'Response', avg: 'Average', satis: 'Satisfaction',
			totalPrefix: 'Total:',
			alertWait: '4 chats waiting for reply over 5 minutes.',
			alertAll: 'All channels active and connected.',
			volTitle: 'Channel volume', volDesc: 'Last 7 days distribution.',
			latestTitle: 'Latest tickets', latestDesc: 'Recent ticket activity.',
			emptyTitle: 'No tickets yet', emptyDesc: 'New tickets will appear here.',
			thId: 'ID', thSubject: 'Subject', thOwner: 'Owner', thStatus: 'Status',
			showing3: 'Showing 3 latest tickets',
			stUrgent: 'Urgent', stOpen: 'Open', stProgress: 'In Progress',
			channels: [
				{ key: 'phone', label: 'Phone Calls', total: '248 calls', answered: '212 answered (85%)', avg: '3m 24s', score: '4.6/5' },
				{ key: 'chat', label: 'Live Chat', total: '186 chats', answered: '174 responded (94%)', avg: '42 sec', score: '4.8/5' },
				{ key: 'email', label: 'Email', total: '124 emails', answered: '96 replied (77%)', avg: '2h 18m', score: '4.5/5' },
				{ key: 'wa', label: 'WhatsApp Business', total: '316 chats', answered: '294 responded (93%)', avg: '1m 06s', score: '4.9/5' },
				{ key: 'soc', label: 'Social Media', total: '92 interactions', answered: '81 responded (88%)', avg: '18 min', score: '4.4/5' },
				{ key: 'cmt', label: 'Comment & More', total: '74 interactions', answered: '61 responded (82%)', avg: '26 min', score: '4.3/5' }
			]
		},
		th: {
			docTitle: 'หน้าแรก — สถิติช่องทาง',
			filterTitle: 'สถิติช่องทาง | ติดตามประสิทธิภาพแบบเรียลไทม์',
			filterDesc: 'กรองช่วงวันที่และรอบเพื่ออัปเดตเมตริกช่องทาง',
			startDate: 'วันที่เริ่ม',
			pickStart: 'เลือกวันที่เริ่ม',
			pickDatePh: 'เลือกวันที่',
			period: 'รอบ',
			monthAug: 'สิงหาคม 2026',
			monthSep: 'กันยายน 2026',
			monthOct: 'ตุลาคม 2026',
			apply: 'ใช้ตัวกรอง',
			loading: 'กำลังโหลด',
			rangeLabel: 'ช่วง',
			d7: '7 วัน', d30: '30 วัน', d90: '90 วัน',
			daily: 'รายวัน', weekly: 'รายสัปดาห์', monthly: 'รายเดือน',
			scope: 'ขอบเขตข้อมูล: ทุกช่องทาง · อัปเดตแบบเรียลไทม์',
			sectionLabel: 'สถิติช่องทาง',
			active: 'ใช้งาน',
			channelConnected: 'เชื่อมต่อช่องทางแล้ว',
			resp: 'การตอบสนอง', avg: 'ค่าเฉลี่ย', satis: 'ความพึงพอใจ',
			totalPrefix: 'รวม:',
			alertWait: '4 แชทรอตอบกลับเกิน 5 นาที',
			alertAll: 'ทุกช่องทางใช้งานและเชื่อมต่อแล้ว',
			volTitle: 'ปริมาณช่องทาง', volDesc: 'การกระจาย 7 วันที่ผ่านมา',
			latestTitle: 'ตั๋วล่าสุด', latestDesc: 'กิจกรรมตั๋วล่าสุด',
			emptyTitle: 'ยังไม่มีตั๋ว', emptyDesc: 'ตั๋วใหม่จะปรากฏที่นี่',
			thId: 'ID', thSubject: 'หัวข้อ', thOwner: 'เจ้าของ', thStatus: 'สถานะ',
			showing3: 'แสดงตั๋วล่าสุด 3 รายการ',
			stUrgent: 'ด่วน', stOpen: 'เปิด', stProgress: 'กำลังดำเนินการ',
			channels: [
				{ key: 'phone', label: 'โทรศัพท์', total: '248 สาย', answered: '212 รับสาย (85%)', avg: '3น 24ว', score: '4.6/5' },
				{ key: 'chat', label: 'แชทสด', total: '186 แชท', answered: '174 ตอบแล้ว (94%)', avg: '42 วินาที', score: '4.8/5' },
				{ key: 'email', label: 'อีเมล', total: '124 ฉบับ', answered: '96 ตอบกลับ (77%)', avg: '2ช 18น', score: '4.5/5' },
				{ key: 'wa', label: 'WhatsApp Business', total: '316 แชท', answered: '294 ตอบแล้ว (93%)', avg: '1น 06ว', score: '4.9/5' },
				{ key: 'soc', label: 'โซเชียลมีเดีย', total: '92 ครั้ง', answered: '81 ตอบแล้ว (88%)', avg: '18 นาที', score: '4.4/5' },
				{ key: 'cmt', label: 'ความคิดเห็น & อื่นๆ', total: '74 ครั้ง', answered: '61 ตอบแล้ว (82%)', avg: '26 นาที', score: '4.3/5' }
			]
		},
		tl: {
			docTitle: 'Home — Estadistika ng Channel',
			filterTitle: 'Estadistika ng Channel | Real-time Performance Monitoring',
			filterDesc: 'I-filter ang saklaw ng petsa at panahon upang i-refresh ang mga metric.',
			startDate: 'Petsa ng simula',
			pickStart: 'Piliin ang petsa ng simula',
			pickDatePh: 'Pumili ng petsa',
			period: 'Panahon',
			monthAug: 'Agosto 2026',
			monthSep: 'Setyembre 2026',
			monthOct: 'Oktubre 2026',
			apply: 'Ilapat ang Filter',
			loading: 'Naglo-load',
			rangeLabel: 'Saklaw',
			d7: '7 araw', d30: '30 araw', d90: '90 araw',
			daily: 'Araw-araw', weekly: 'Lingguhan', monthly: 'Buwanan',
			scope: 'Saklaw ng datos: lahat ng channel · real-time na na-update',
			sectionLabel: 'Estadistika ng channel',
			active: 'Aktibo',
			channelConnected: 'Nakakonektang channel',
			resp: 'Tugon', avg: 'Average', satis: 'Kasiyahan',
			totalPrefix: 'Kabuuan:',
			alertWait: '4 chat na naghihintay ng reply nang higit 5 minuto.',
			alertAll: 'Lahat ng channel aktibo at nakakonekta.',
			volTitle: 'Volume ng channel', volDesc: 'Distribusyon sa huling 7 araw.',
			latestTitle: 'Pinakabagong ticket', latestDesc: 'Kamakailang aktibidad ng ticket.',
			emptyTitle: 'Wala pang ticket', emptyDesc: 'Ang mga bagong ticket ay lilitaw dito.',
			thId: 'ID', thSubject: 'Paksa', thOwner: 'May-ari', thStatus: 'Katayuan',
			showing3: 'Ipinapakita ang 3 pinakabagong ticket',
			stUrgent: 'Urgent', stOpen: 'Open', stProgress: 'In Progress',
			channels: [
				{ key: 'phone', label: 'Phone Calls', total: '248 tawag', answered: '212 nasagot (85%)', avg: '3m 24s', score: '4.6/5' },
				{ key: 'chat', label: 'Live Chat', total: '186 chat', answered: '174 natugunan (94%)', avg: '42 segundo', score: '4.8/5' },
				{ key: 'email', label: 'Email', total: '124 email', answered: '96 nareplyan (77%)', avg: '2h 18m', score: '4.5/5' },
				{ key: 'wa', label: 'WhatsApp Business', total: '316 chat', answered: '294 natugunan (93%)', avg: '1m 06s', score: '4.9/5' },
				{ key: 'soc', label: 'Social Media', total: '92 interaksyon', answered: '81 natugunan (88%)', avg: '18 minuto', score: '4.4/5' },
				{ key: 'cmt', label: 'Comment & More', total: '74 interaksyon', answered: '61 natugunan (82%)', avg: '26 minuto', score: '4.3/5' }
			]
		}
	} as const;
	let s = $derived(STR[$locale]);

	const channelIcons: Record<string, typeof Phone> = { phone: Phone, chat: MessageCircle, email: Mail, wa: MessageCircle, soc: Share2, cmt: Star };
	let channels = $derived(s.channels.map((c) => ({ ...c, icon: channelIcons[c.key] ?? Star })));
	const tickets = [
		{ id: 'T-2026-001', subject: 'Keterlambatan pengiriman', channel: 'WhatsApp', owner: 'Rina', status: 'Urgent' },
		{ id: 'T-2026-002', subject: 'Reset password akun', channel: 'Live Chat', owner: 'Budi', status: 'Open' },
		{ id: 'T-2026-003', subject: 'Permintaan invoice bulanan', channel: 'Email', owner: 'Sari', status: 'In Progress' }
	];
	function statusLabel(st: string): string {
		if (st === 'Urgent') return s.stUrgent;
		if (st === 'Open') return s.stOpen;
		return s.stProgress;
	}
	const dist = [
		{ label: 'WhatsApp', value: 82 }, { label: 'Live Chat', value: 68 },
		{ label: 'Email', value: 46 }, { label: 'Voice', value: 32 }
	];
	let tab = $state('harian');
	let range = $state('30h');
	let loading = $state(false);
	let date = $state<DateValue | undefined>(new CalendarDate(2026, 9, 30));
	let period = $state('2026-09');
	function apply() { loading = true; setTimeout(() => (loading = false), 600); }
	const ApplyIcon = $derived(loading ? Spinner : CalendarDays);
	const chartConfig = { volume: { label: 'Volume', color: 'var(--primary)' } };
	const bars = [42, 68, 55, 80, 62, 90, 74];
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header><Card.Title>{s.filterTitle}</Card.Title><Card.Description>{s.filterDesc}</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_1fr_auto]">
				<Field.Field><Field.Label for="start">{s.startDate}</Field.Label><DatePicker bind:value={date} label={s.pickStart} placeholder={s.pickDatePh} /></Field.Field>
				<Field.Field>
					<Field.Label for="period">{s.period}</Field.Label>
					<Select.Root type="single" bind:value={period}>
						<Select.Trigger id="period" class="w-full">{period}</Select.Trigger>
						<Select.Content><Select.Group><Select.GroupHeading>{s.period}</Select.GroupHeading><Select.Item value="2026-08">{s.monthAug}</Select.Item><Select.Item value="2026-09">{s.monthSep}</Select.Item><Select.Item value="2026-10">{s.monthOct}</Select.Item></Select.Group></Select.Content>
					</Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button onclick={apply} disabled={loading}><ApplyIcon data-icon="inline-start" /><span>{loading ? s.loading : s.apply}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={range} class="w-fit" aria-label={s.rangeLabel}>
				<ToggleGroup.Item value="7h">{s.d7}</ToggleGroup.Item><ToggleGroup.Item value="30h">{s.d30}</ToggleGroup.Item><ToggleGroup.Item value="90h">{s.d90}</ToggleGroup.Item>
			</ToggleGroup.Root>
			<Tabs.Root bind:value={tab}>
				<Tabs.List><Tabs.Trigger value="harian">{s.daily}</Tabs.Trigger><Tabs.Trigger value="mingguan">{s.weekly}</Tabs.Trigger><Tabs.Trigger value="bulanan">{s.monthly}</Tabs.Trigger></Tabs.List>
			</Tabs.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">{s.scope}</Card.Footer>
	</Card.Root>

	{#if loading}
		<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">{#each [1, 2, 3] as _}<Skeleton class="h-44 w-full" />{/each}</div>
	{:else}
		<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3" aria-label={s.sectionLabel}>
			{#each channels as c}
				<Card.Root class={cn('transition-shadow hover:shadow-md', c.key === 'wa' && 'border-primary/40')}>
					<Card.Header class="flex flex-row items-center gap-3">
						<div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary"><c.icon data-icon="card" /></div>
						<div class="min-w-0 flex-1"><Card.Title class="truncate text-base">{c.label}</Card.Title><Card.Description class="truncate">{s.totalPrefix} {c.total}</Card.Description></div>
						<Tooltip.Root><Tooltip.Trigger class="shrink-0"><Badge variant="secondary" class="shrink-0 whitespace-nowrap">{s.active}</Badge></Tooltip.Trigger><Tooltip.Content>{s.channelConnected}</Tooltip.Content></Tooltip.Root>
					</Card.Header>
					<Card.Content class="flex flex-col gap-2 text-sm">
						<div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">{s.resp}</span><span class="font-medium">{c.answered}</span></div>
						<div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">{s.avg}</span><span class="font-medium">{c.avg}</span></div>
						<div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">{s.satis}</span><span class="font-medium">{c.score}</span></div>
					</Card.Content>
					<Card.Footer><Progress value={85} class="w-full" /></Card.Footer>
				</Card.Root>
			{/each}
		</section>
	{/if}

	<Alert.Root variant="warning"><TriangleAlert data-icon="alert" /><Alert.Description>{s.alertWait}</Alert.Description></Alert.Root>
	<Alert.Root variant="success"><CircleCheck data-icon="alert" /><Alert.Description>{s.alertAll}</Alert.Description></Alert.Root>

	<div class="grid gap-4 lg:grid-cols-2">
		<Card.Root>
			<Card.Header><Card.Title>{s.volTitle}</Card.Title><Card.Description>{s.volDesc}</Card.Description></Card.Header>
			<Card.Content>
				<Chart.Container config={chartConfig} class="min-h-40">
					<div class="flex h-36 w-full items-end gap-2">{#each bars as b}<div class="flex-1 rounded bg-primary/80" style="height:{b}%"></div>{/each}</div>
				</Chart.Container>
			</Card.Content>
			<Card.Footer class="flex flex-col gap-3">
				{#each dist as d}<div class="flex flex-col gap-1.5"><div class="flex justify-between text-sm"><span>{d.label}</span><span class="text-muted-foreground">{d.value}%</span></div><Progress value={d.value} /></div>{/each}
			</Card.Footer>
		</Card.Root>
		<Card.Root>
			<Card.Header><Card.Title>{s.latestTitle}</Card.Title><Card.Description>{s.latestDesc}</Card.Description></Card.Header>
			<Card.Content>
				{#if tickets.length === 0}
					<Empty.Root><Empty.Header><Empty.Media><Inbox data-icon="empty" /></Empty.Media><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>
				{:else}
					<Table.Root><Table.Header><Table.Row><Table.Head>{s.thId}</Table.Head><Table.Head>{s.thSubject}</Table.Head><Table.Head>{s.thOwner}</Table.Head><Table.Head class="text-right">{s.thStatus}</Table.Head></Table.Row></Table.Header>
					<Table.Body>{#each tickets as t}<Table.Row><Table.Cell class="font-mono text-xs">{t.id}</Table.Cell><Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-6"><Avatar.Fallback>{t.owner.slice(0, 1)}</Avatar.Fallback></Avatar.Root><span class="font-medium">{t.subject}</span></div></Table.Cell><Table.Cell>{t.owner}</Table.Cell><Table.Cell class="text-right"><Badge variant={t.status === 'Urgent' ? 'destructive' : 'secondary'}>{statusLabel(t.status)}</Badge></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
				{/if}
			</Card.Content>
			<Card.Footer><Separator class="my-1" /><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> {s.showing3}</p></Card.Footer>
		</Card.Root>
	</div>
</div>
