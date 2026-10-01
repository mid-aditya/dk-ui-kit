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
	import * as Empty from '$lib/components/ui/empty';
	import DateRangePicker from "$lib/components/ui/date-range-picker.svelte";
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Handshake, Ticket, TriangleAlert, CircleCheck, Info, Gauge } from 'lucide-svelte';
	import { CalendarDate } from '@internationalized/date';
	import { goto } from '$app/navigation';
	import { toast } from 'svelte-sonner';
	import { locale } from '$lib/i18n';
	import { get } from 'svelte/store';

	import type { DateRange } from 'bits-ui';

	const STR = {
		id: {
			docTitle: 'Agent Productivity',
			title: 'Agent Productivity',
			desc: 'Monitor performa dan produktivitas agent secara real-time.',
			period: 'Periode', pickPeriod: 'Pilih periode',
			channel: 'Channel', chAll: 'Semua', chChat: 'Live Chat', chCall: 'Inbound Call',
			refresh: 'Refresh', loading: 'Memuat',
			viewLabel: 'Tampilan', tabSum: 'Ringkasan', tabSla: 'SLA', tabTrend: 'Tren',
			welcome: 'Welcome back, Agent · Online',
			above: 'Above target', watch: 'Watch',
			kpi: [
				{ label: 'Total Interaksi', value: '248', target: 'Target: 200', ok: true },
				{ label: 'Tiket Diproses', value: '96', target: 'Target: 90', ok: true },
				{ label: 'Tiket Near SLA', value: '7', target: 'Perlu perhatian', ok: false },
				{ label: 'Tiket Over SLA', value: '2', target: 'Eskalasi', ok: false }
			],
			utilTitle: 'Utilisasi agent', utilDesc: 'Interaksi vs tiket diproses.',
			emptyTitle: 'Belum ada data', emptyDesc: 'Data produktivitas akan muncul di sini.',
			thAgent: 'Agent', thTotal: 'Total Interaksi', thTicket: 'Tiket', thNear: 'Near SLA', thOver: 'Over SLA', thUtil: 'Utilisasi',
			nearTip: 'Mendekati SLA',
			footInfo: 'Klik Near/Over SLA untuk daftar tiket.',
			viewSla: 'Lihat SLA',
			alert: '7 tiket mendekati SLA — prioritaskan antrean.',
			dlgTitle: 'Tiket Near SLA', dlgDesc: '7 tiket membutuhkan perhatian dalam 2 jam.',
			close: 'Tutup', openTicket: 'Buka tiket',
			toastOpen: 'Membuka daftar tiket'
		},
		en: {
			docTitle: 'Agent Productivity',
			title: 'Agent Productivity',
			desc: 'Monitor agent performance and productivity in real-time.',
			period: 'Period', pickPeriod: 'Pick a period',
			channel: 'Channel', chAll: 'All', chChat: 'Live Chat', chCall: 'Inbound Call',
			refresh: 'Refresh', loading: 'Loading',
			viewLabel: 'View', tabSum: 'Summary', tabSla: 'SLA', tabTrend: 'Trend',
			welcome: 'Welcome back, Agent · Online',
			above: 'Above target', watch: 'Watch',
			kpi: [
				{ label: 'Total Interactions', value: '248', target: 'Target: 200', ok: true },
				{ label: 'Tickets Processed', value: '96', target: 'Target: 90', ok: true },
				{ label: 'Near SLA Tickets', value: '7', target: 'Needs attention', ok: false },
				{ label: 'Over SLA Tickets', value: '2', target: 'Escalation', ok: false }
			],
			utilTitle: 'Agent utilization', utilDesc: 'Interactions vs tickets processed.',
			emptyTitle: 'No data yet', emptyDesc: 'Productivity data will appear here.',
			thAgent: 'Agent', thTotal: 'Total Interactions', thTicket: 'Tickets', thNear: 'Near SLA', thOver: 'Over SLA', thUtil: 'Utilization',
			nearTip: 'Approaching SLA',
			footInfo: 'Click Near/Over SLA for the ticket list.',
			viewSla: 'View SLA',
			alert: '7 tickets nearing SLA — prioritize the queue.',
			dlgTitle: 'Near SLA Tickets', dlgDesc: '7 tickets need attention within 2 hours.',
			close: 'Close', openTicket: 'Open tickets',
			toastOpen: 'Opening ticket list'
		},
		th: {
			docTitle: 'ประสิทธิภาพเอเจนต์',
			title: 'ประสิทธิภาพเอเจนต์',
			desc: 'ติดตามประสิทธิภาพและผลิตภาพของเอเจนต์แบบเรียลไทม์',
			period: 'รอบ', pickPeriod: 'เลือกช่วงเวลา',
			channel: 'ช่องทาง', chAll: 'ทั้งหมด', chChat: 'แชทสด', chCall: 'สายเรียกเข้า',
			refresh: 'รีเฟรช', loading: 'กำลังโหลด',
			viewLabel: 'มุมมอง', tabSum: 'สรุป', tabSla: 'SLA', tabTrend: 'แนวโน้ม',
			welcome: 'ยินดีต้อนรับกลับ, เอเจนต์ · ออนไลน์',
			above: 'เกินเป้า', watch: 'จับตา',
			kpi: [
				{ label: 'ปฏิสัมพันธ์ทั้งหมด', value: '248', target: 'เป้า: 200', ok: true },
				{ label: 'ตั๋วที่ดำเนินการ', value: '96', target: 'เป้า: 90', ok: true },
				{ label: 'ตั๋วใกล้ SLA', value: '7', target: 'ต้องใส่ใจ', ok: false },
				{ label: 'ตั๋วเกิน SLA', value: '2', target: 'ยกระดับ', ok: false }
			],
			utilTitle: 'การใช้ประโยชน์เอเจนต์', utilDesc: 'ปฏิสัมพันธ์เทียบกับตั๋วที่ดำเนินการ',
			emptyTitle: 'ยังไม่มีข้อมูล', emptyDesc: 'ข้อมูลผลิตภาพจะปรากฏที่นี่',
			thAgent: 'เอเจนต์', thTotal: 'ปฏิสัมพันธ์ทั้งหมด', thTicket: 'ตั๋ว', thNear: 'ใกล้ SLA', thOver: 'เกิน SLA', thUtil: 'การใช้ประโยชน์',
			nearTip: 'ใกล้ถึง SLA',
			footInfo: 'คลิก Near/Over SLA เพื่อดูรายการตั๋ว',
			viewSla: 'ดู SLA',
			alert: '7 ตั๋วใกล้ถึง SLA — จัดลำดับความสำคัญคิว',
			dlgTitle: 'ตั๋วใกล้ SLA', dlgDesc: '7 ตั๋วต้องการความสนใจภายใน 2 ชั่วโมง',
			close: 'ปิด', openTicket: 'เปิดตั๋ว',
			toastOpen: 'กำลังเปิดรายการตั๋ว'
		},
		tl: {
			docTitle: 'Agent Productivity',
			title: 'Agent Productivity',
			desc: 'Subaybayan ang performance at pagiging produktibo ng agent nang real-time.',
			period: 'Panahon', pickPeriod: 'Pumili ng panahon',
			channel: 'Channel', chAll: 'Lahat', chChat: 'Live Chat', chCall: 'Inbound Call',
			refresh: 'Refresh', loading: 'Naglo-load',
			viewLabel: 'View', tabSum: 'Buod', tabSla: 'SLA', tabTrend: 'Trend',
			welcome: 'Welcome back, Agent · Online',
			above: 'Above target', watch: 'Bantayan',
			kpi: [
				{ label: 'Kabuuang Interaksyon', value: '248', target: 'Target: 200', ok: true },
				{ label: 'Ticket na Naproseso', value: '96', target: 'Target: 90', ok: true },
				{ label: 'Ticket na Near SLA', value: '7', target: 'Nangangailangan ng pansin', ok: false },
				{ label: 'Ticket na Over SLA', value: '2', target: 'Escalation', ok: false }
			],
			utilTitle: 'Paggamit ng agent', utilDesc: 'Interaksyon vs naprosesong ticket.',
			emptyTitle: 'Wala pang datos', emptyDesc: 'Ang datos ng produktibidad ay lilitaw dito.',
			thAgent: 'Agent', thTotal: 'Kabuuang Interaksyon', thTicket: 'Ticket', thNear: 'Near SLA', thOver: 'Over SLA', thUtil: 'Paggamit',
			nearTip: 'Malapit sa SLA',
			footInfo: 'I-click ang Near/Over SLA para sa listahan ng ticket.',
			viewSla: 'Tingnan ang SLA',
			alert: '7 ticket na malapit sa SLA — unahin ang pila.',
			dlgTitle: 'Mga Ticket na Near SLA', dlgDesc: '7 ticket ang nangangailangan ng pansin sa loob ng 2 oras.',
			close: 'Isara', openTicket: 'Buksan ang ticket',
			toastOpen: 'Binubuksan ang listahan ng ticket'
		}
	} as const;
	let s = $derived(STR[$locale]);

	let tab = $state('ringkasan'); let channel = $state('semua'); let loading = $state(false); let open = $state(false);
	let period = $state<DateRange | undefined>({ start: new CalendarDate(2026, 9, 1), end: new CalendarDate(2026, 9, 30) });
	const kpiIcons = [Handshake, Ticket, TriangleAlert, CircleCheck];
	let kpi = $derived(s.kpi.map((k, i) => ({ ...k, icon: kpiIcons[i] ?? Gauge })));
	const rows = [
		{ name: 'Rina Amelia', interaksi: 64, tiket: 28, near: 2, over: 0, util: 88 },
		{ name: 'Budi Santoso', interaksi: 58, tiket: 24, near: 3, over: 1, util: 81 },
		{ name: 'Sari Dewi', interaksi: 47, tiket: 19, near: 1, over: 1, util: 72 }
	];
	function refresh() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : Gauge);

</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header><div class="flex items-center gap-3"><Avatar.Root class="size-12"><Avatar.Fallback>AG</Avatar.Fallback></Avatar.Root><div><Card.Title>{s.title}</Card.Title><Card.Description>{s.desc}</Card.Description></div></div></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_200px_auto]">
				<Field.Field><Field.Label>{s.period}</Field.Label><DateRangePicker bind:value={period} label={s.pickPeriod} /></Field.Field>
				<Field.Field>
					<Field.Label for="ch">{s.channel}</Field.Label>
					<Select.Root type="single" bind:value={channel}><Select.Trigger id="ch" class="w-full">{channel}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.channel}</Select.GroupHeading><Select.Item value="semua">{s.chAll}</Select.Item><Select.Item value="chat">{s.chChat}</Select.Item><Select.Item value="call">{s.chCall}</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button onclick={refresh} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? s.loading : s.refresh}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={tab} aria-label={s.viewLabel}><ToggleGroup.Item value="ringkasan">{s.tabSum}</ToggleGroup.Item><ToggleGroup.Item value="sla">{s.tabSla}</ToggleGroup.Item><ToggleGroup.Item value="tren">{s.tabTrend}</ToggleGroup.Item></ToggleGroup.Root>
			<Tabs.Root bind:value={tab}><Tabs.List><Tabs.Trigger value="ringkasan">{s.tabSum}</Tabs.Trigger><Tabs.Trigger value="sla">{s.tabSla}</Tabs.Trigger><Tabs.Trigger value="tren">{s.tabTrend}</Tabs.Trigger></Tabs.List></Tabs.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">{s.welcome}</Card.Footer>
	</Card.Root>

	{#if loading}
		<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">{#each [1, 2, 3, 4] as _}<Skeleton class="h-32 w-full" />{/each}</div>
	{:else}
		<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
			{#each kpi as k}
				<Card.Root class={cn(!k.ok && 'border-amber-500/40')}>
					<Card.Header class="flex-row items-center gap-3"><div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary"><k.icon data-icon="card" /></div><Card.Title class="text-sm">{k.label}</Card.Title></Card.Header>
					<Card.Content><div class="text-2xl font-bold">{k.value}</div><p class="text-muted-foreground text-xs">{k.target}</p></Card.Content>
					<Card.Footer><Badge variant={k.ok ? 'success' : 'warning'}>{k.ok ? s.above : s.watch}</Badge></Card.Footer>
				</Card.Root>
			{/each}
		</section>
	{/if}

	<Card.Root>
		<Card.Header><Card.Title>{s.utilTitle}</Card.Title><Card.Description>{s.utilDesc}</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<div class="flex flex-col gap-2">{#each rows as r}<div class="flex items-center gap-3"><Badge variant="outline" class="min-w-24 justify-center">{r.name.split(' ')[0]}</Badge><Progress value={r.util} class="flex-1" /><span class="text-xs font-medium">{r.util}%</span></div>{/each}</div>
			{#if rows.length === 0}
				<Empty.Root><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>
			{:else}
				<Table.Root><Table.Header><Table.Row><Table.Head>{s.thAgent}</Table.Head><Table.Head>{s.thTotal}</Table.Head><Table.Head>{s.thTicket}</Table.Head><Table.Head>{s.thNear}</Table.Head><Table.Head>{s.thOver}</Table.Head><Table.Head>{s.thUtil}</Table.Head></Table.Row></Table.Header>
				<Table.Body>{#each rows as r}<Table.Row><Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-7"><Avatar.Fallback>{r.name.slice(0, 1)}</Avatar.Fallback></Avatar.Root><span class="font-medium">{r.name}</span></div></Table.Cell><Table.Cell>{r.interaksi}</Table.Cell><Table.Cell>{r.tiket}</Table.Cell><Table.Cell><Tooltip.Root><Tooltip.Trigger><Badge variant="warning">{r.near}</Badge></Tooltip.Trigger><Tooltip.Content>{s.nearTip}</Tooltip.Content></Tooltip.Root></Table.Cell><Table.Cell><Badge variant="destructive">{r.over}</Badge></Table.Cell><Table.Cell><div class="flex items-center gap-2"><Progress value={r.util} class="w-24" /><span class="text-xs">{r.util}%</span></div></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
			{/if}
		</Card.Content>
		<Card.Footer><Separator class="my-1" /><div class="flex items-center justify-between gap-2"><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> {s.footInfo}</p><Button size="sm" variant="outline" onclick={() => (open = true)}>{s.viewSla}</Button></div></Card.Footer>
	</Card.Root>

	<Alert.Root variant="warning"><TriangleAlert data-icon="alert" /><Alert.Description>{s.alert}</Alert.Description></Alert.Root>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>{s.dlgTitle}</Dialog.Title><Dialog.Description>{s.dlgDesc}</Dialog.Description></Dialog.Header><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>{s.close}</Button><Button onclick={() => { open = false; toast.success(STR[get(locale)].toastOpen); goto('/ticketing'); }}>{s.openTicket}</Button></Dialog.Footer></Dialog.Content></Dialog.Root>
