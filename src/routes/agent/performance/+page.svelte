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
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Users, Eye, Search, Star, Info, UserRound } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'Agent Performance',
			title: 'Agent Performance',
			desc: 'Monitor dan lacak aktivitas agent secara real-time.',
			search: 'Cari agent', searchPh: 'Cari agent…',
			range: 'Rentang waktu', rangeHead: 'Rentang',
			today: 'Hari ini', week: 'Minggu ini', month: 'Bulan ini',
			refresh: 'Refresh', loading: 'Memuat',
			all: 'Semua', ready: 'Ready', offline: 'Offline',
			updated: 'Terakhir diperbarui: Baru saja',
			statusTitle: 'Status Agent Saat Ini', statusDesc: 'Ringkasan aktivitas agent secara real-time.',
			tabStatus: 'Status', tabHistory: 'Riwayat Performa',
			emptyTitle: 'Tidak ada agent', emptyDesc: 'Ubah kata kunci pencarian.',
			thAgent: 'Agent', thStatus: 'Status', thHandle: 'Current Handle', thClosed: 'Closed Today', thActions: 'Aksi',
			view: 'Lihat Detail', viewTip: 'Lihat detail',
			cols: 'Kolom: Agent, Status, Current Handle, Closed Today, Aksi',
			histTitle: 'Riwayat Performa', histDesc: 'Metrik performa detail agent: Total Handled, Avg Response, Success Rate, Rating.',
			handled: 'handled',
			thTotal: 'Total Handled', thAvg: 'Avg Response', thRate: 'Success Rate', thRating: 'Rating',
			alert: 'Success rate dihitung dari tiket selesai vs target.',
			detail: 'Detail', close: 'Tutup'
		},
		en: {
			docTitle: 'Agent Performance',
			title: 'Agent Performance',
			desc: 'Monitor and track agent activities in real-time.',
			search: 'Search agents', searchPh: 'Search agents…',
			range: 'Time range', rangeHead: 'Range',
			today: 'Today', week: 'This Week', month: 'This Month',
			refresh: 'Refresh', loading: 'Loading',
			all: 'All', ready: 'Ready', offline: 'Offline',
			updated: 'Last updated: Just now',
			statusTitle: 'Current Agent Status', statusDesc: 'Real-time overview of agent activities.',
			tabStatus: 'Status', tabHistory: 'Performance History',
			emptyTitle: 'No agents', emptyDesc: 'Change the search keyword.',
			thAgent: 'Agent', thStatus: 'Status', thHandle: 'Current Handle', thClosed: 'Closed Today', thActions: 'Actions',
			view: 'View Details', viewTip: 'View details of',
			cols: 'Columns: Agent, Status, Current Handle, Closed Today, Actions',
			histTitle: 'Performance History', histDesc: 'Detailed agent performance metrics: Total Handled, Avg Response, Success Rate, Rating.',
			handled: 'handled',
			thTotal: 'Total Handled', thAvg: 'Avg Response', thRate: 'Success Rate', thRating: 'Rating',
			alert: 'Success rate is calculated from resolved tickets vs target.',
			detail: 'Details', close: 'Close'
		},
		th: {
			docTitle: 'ประสิทธิภาพเอเจนต์',
			title: 'ประสิทธิภาพเอเจนต์',
			desc: 'ติดตามและตรวจสอบกิจกรรมเอเจนต์แบบเรียลไทม์',
			search: 'ค้นหาเอเจนต์', searchPh: 'ค้นหาเอเจนต์…',
			range: 'ช่วงเวลา', rangeHead: 'ช่วง',
			today: 'วันนี้', week: 'สัปดาห์นี้', month: 'เดือนนี้',
			refresh: 'รีเฟรช', loading: 'กำลังโหลด',
			all: 'ทั้งหมด', ready: 'พร้อม', offline: 'ออฟไลน์',
			updated: 'อัปเดตล่าสุด: เมื่อสักครู่',
			statusTitle: 'สถานะเอเจนต์ปัจจุบัน', statusDesc: 'ภาพรวมกิจกรรมเอเจนต์แบบเรียลไทม์',
			tabStatus: 'สถานะ', tabHistory: 'ประวัติผลงาน',
			emptyTitle: 'ไม่มีเอเจนต์', emptyDesc: 'เปลี่ยนคำค้นหา',
			thAgent: 'เอเจนต์', thStatus: 'สถานะ', thHandle: 'งานที่ถืออยู่', thClosed: 'ปิดวันนี้', thActions: 'การดำเนินการ',
			view: 'ดูรายละเอียด', viewTip: 'ดูรายละเอียดของ',
			cols: 'คอลัมน์: เอเจนต์, สถานะ, งานที่ถืออยู่, ปิดวันนี้, การดำเนินการ',
			histTitle: 'ประวัติผลงาน', histDesc: 'เมตริกผลงานเอเจนต์โดยละเอียด: งานทั้งหมด, เวลาตอบเฉลี่ย, อัตราสำเร็จ, คะแนน',
			handled: 'งาน',
			thTotal: 'งานทั้งหมด', thAvg: 'ตอบเฉลี่ย', thRate: 'อัตราสำเร็จ', thRating: 'คะแนน',
			alert: 'อัตราสำเร็จคำนวณจากตั๋วที่ปิดได้เทียบกับเป้าหมาย',
			detail: 'รายละเอียด', close: 'ปิด'
		},
		tl: {
			docTitle: 'Agent Performance',
			title: 'Agent Performance',
			desc: 'Subaybayan at i-track ang mga aktibidad ng agent nang real-time.',
			search: 'Maghanap ng agent', searchPh: 'Maghanap ng agent…',
			range: 'Saklaw ng oras', rangeHead: 'Saklaw',
			today: 'Ngayon', week: 'Ngayong Linggo', month: 'Ngayong Buwan',
			refresh: 'Refresh', loading: 'Naglo-load',
			all: 'Lahat', ready: 'Ready', offline: 'Offline',
			updated: 'Huling na-update: Ngayon lang',
			statusTitle: 'Kasalukuyang Katayuan ng Agent', statusDesc: 'Real-time na buod ng mga aktibidad ng agent.',
			tabStatus: 'Katayuan', tabHistory: 'History ng Performance',
			emptyTitle: 'Walang agent', emptyDesc: 'Baguhin ang keyword ng paghahanap.',
			thAgent: 'Agent', thStatus: 'Katayuan', thHandle: 'Current Handle', thClosed: 'Closed Today', thActions: 'Mga Aksyon',
			view: 'Tingnan ang Detalye', viewTip: 'Tingnan ang detalye ni',
			cols: 'Mga column: Agent, Katayuan, Current Handle, Closed Today, Mga Aksyon',
			histTitle: 'History ng Performance', histDesc: 'Detalyadong metric ng performance: Total Handled, Avg Response, Success Rate, Rating.',
			handled: 'handled',
			thTotal: 'Total Handled', thAvg: 'Avg Response', thRate: 'Success Rate', thRating: 'Rating',
			alert: 'Ang success rate ay kinakalkula mula sa mga resolved ticket vs target.',
			detail: 'Detalye', close: 'Isara'
		}
	} as const;
	let s = $derived(STR[$locale]);

	const agents = [
		{ name: 'Rina Amelia', user: 'rina.a', status: 'Ready', handle: 3, closed: 24, total: 128, avg: '1m 12s', rate: 94, rating: 4.9 },
		{ name: 'Budi Santoso', user: 'budi.s', status: 'Ready', handle: 2, closed: 19, total: 112, avg: '1m 48s', rate: 91, rating: 4.7 },
		{ name: 'Sari Dewi', user: 'sari.d', status: 'Offline', handle: 0, closed: 15, total: 96, avg: '2m 05s', rate: 88, rating: 4.6 },
		{ name: 'Andi Pratama', user: 'andi.p', status: 'Offline', handle: 0, closed: 11, total: 74, avg: '2m 40s', rate: 82, rating: 4.3 }
	];
	function statusLabel(st: string): string {
		return st === 'Ready' ? s.ready : s.offline;
	}
	let q = $state(''); let range = $state('today'); let view = $state('semua'); let open = $state(false);
	let detail = $state(agents[0]); let loading = $state(false);
	let filtered = $derived(agents.filter((a) => `${a.name} ${a.user}`.toLowerCase().includes(q.toLowerCase()) && (view === 'semua' || (view === 'ready' ? a.status === 'Ready' : a.status === 'Offline'))));
	function reload() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : Users);

</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header><Card.Title>{s.title}</Card.Title><Card.Description>{s.desc}</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_200px_auto]">
				<Field.Field><Field.Label for="q">{s.search}</Field.Label><div class="relative"><Search data-icon="input" /><Input id="q" bind:value={q} placeholder={s.searchPh} class="pl-9" /></div></Field.Field>
				<Field.Field>
					<Field.Label for="range">{s.range}</Field.Label>
					<Select.Root type="single" bind:value={range}><Select.Trigger id="range" class="w-full">{range}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.rangeHead}</Select.GroupHeading><Select.Item value="today">{s.today}</Select.Item><Select.Item value="week">{s.week}</Select.Item><Select.Item value="month">{s.month}</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button onclick={reload} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? s.loading : s.refresh}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={view} aria-label={s.thStatus}><ToggleGroup.Item value="semua">{s.all}</ToggleGroup.Item><ToggleGroup.Item value="ready">{s.ready}</ToggleGroup.Item><ToggleGroup.Item value="offline">{s.offline}</ToggleGroup.Item></ToggleGroup.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">{s.updated}</Card.Footer>
	</Card.Root>

	<Card.Root>
		<Card.Header><Card.Title>{s.statusTitle}</Card.Title><Card.Description>{s.statusDesc}</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Tabs.Root value="status"><Tabs.List><Tabs.Trigger value="status">{s.tabStatus}</Tabs.Trigger><Tabs.Trigger value="history">{s.tabHistory}</Tabs.Trigger></Tabs.List></Tabs.Root>
			{#if loading}
				<div class="flex flex-col gap-2">{#each [1, 2, 3] as _}<Skeleton class="h-12 w-full" />{/each}</div>
			{:else if filtered.length === 0}
				<Empty.Root><Empty.Header><Empty.Media><UserRound data-icon="empty" /></Empty.Media><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>
			{:else}
				<Table.Root><Table.Header><Table.Row><Table.Head>{s.thAgent}</Table.Head><Table.Head>{s.thStatus}</Table.Head><Table.Head>{s.thHandle}</Table.Head><Table.Head>{s.thClosed}</Table.Head><Table.Head class="text-right">{s.thActions}</Table.Head></Table.Row></Table.Header>
				<Table.Body>{#each filtered as a}<Table.Row>
					<Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-8"><Avatar.Fallback>{a.name.slice(0, 1)}</Avatar.Fallback></Avatar.Root><div><div class="font-medium">{a.name}</div><div class="text-muted-foreground text-xs">{a.user}</div></div></div></Table.Cell>
					<Table.Cell><Badge variant={a.status === 'Ready' ? 'success' : 'secondary'} class={cn(a.status === 'Ready' && 'border-green-500/30')}>{statusLabel(a.status)}</Badge></Table.Cell>
					<Table.Cell>{a.handle}</Table.Cell><Table.Cell>{a.closed}</Table.Cell>
					<Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button variant="ghost" size="sm" onclick={() => { detail = a; open = true; }}><Eye data-icon="inline-start" />{s.view}</Button></Tooltip.Trigger><Tooltip.Content>{s.viewTip} {a.name}</Tooltip.Content></Tooltip.Root></Table.Cell>
				</Table.Row>{/each}</Table.Body></Table.Root>
			{/if}
		</Card.Content>
		<Card.Footer><Separator class="my-1" /><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> {s.cols}</p></Card.Footer>
	</Card.Root>

	<Card.Root>
		<Card.Header><Card.Title>{s.histTitle}</Card.Title><Card.Description>{s.histDesc}</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<div class="flex flex-col gap-2">{#each filtered as a}<div class="flex items-center gap-3"><Badge variant="outline" class="min-w-24 justify-center">{a.name.split(' ')[0]}</Badge><Progress value={Math.round((a.total / 128) * 100)} class="flex-1" /><span class="text-xs font-medium">{a.total} {s.handled}</span></div>{/each}</div>

			<Table.Root><Table.Header><Table.Row><Table.Head>{s.thAgent}</Table.Head><Table.Head>{s.thTotal}</Table.Head><Table.Head>{s.thAvg}</Table.Head><Table.Head>{s.thRate}</Table.Head><Table.Head>{s.thRating}</Table.Head></Table.Row></Table.Header>
			<Table.Body>{#each filtered as a}<Table.Row><Table.Cell class="font-medium">{a.name}</Table.Cell><Table.Cell>{a.total}</Table.Cell><Table.Cell>{a.avg}</Table.Cell><Table.Cell><div class="flex items-center gap-2"><Progress value={a.rate} class="w-20" /><span class="text-xs">{a.rate}%</span></div></Table.Cell><Table.Cell><span class="flex items-center gap-1 font-medium"><Star data-icon="inline" />{a.rating}</span></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
		</Card.Content>
		<Card.Footer><Alert.Root variant="success"><Info data-icon="alert" /><Alert.Description>{s.alert}</Alert.Description></Alert.Root></Card.Footer>
	</Card.Root>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>{s.detail} — {detail.name}</Dialog.Title><Dialog.Description>{detail.user} · {statusLabel(detail.status)} · {detail.total} {s.handled}</Dialog.Description></Dialog.Header><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>{s.close}</Button></Dialog.Footer></Dialog.Content></Dialog.Root>
