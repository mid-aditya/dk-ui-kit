<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Sheet from '$lib/components/ui/sheet';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Table from '$lib/components/ui/table';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import { toast } from 'svelte-sonner';
	import { Search, RotateCcw, MoreVertical } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			title: 'Kirana Monitoring — DK UI Kit',
			sumSuccess: 'Current Success',
			sumFailed: 'Current Failed',
			sumPending: 'Current Pending',
			sumWebhook: 'Waiting Webhook',
			searchPh: 'Search ticket / request / filename',
			tabAll: 'Semua',
			tabSuccess: 'Success',
			tabFailed: 'Failed',
			source: 'Source',
			sourceH: 'Source',
			manual: 'Manual',
			batch: 'Batch',
			reset: 'Reset',
			resetTip: 'Kembalikan filter awal',
			logDetail: 'Log Detail',
			logTitle: 'Step-by-step Log',
			logSteps: 'Analyze dikirim → webhook diterima → final status success.',
			logDesc: 'Meniru log manual maupun batch pada blade.',
			emptyTitle: 'Tidak ada attempt',
			emptyDesc: 'Ubah kata kunci pencarian.',
			thGroup: 'Request Group',
			thTicket: 'Ticket',
			thSource: 'Source',
			thFile: 'File',
			thStatus: 'Status',
			thAction: 'Aksi',
			retry: 'Retry',
			toastReset: 'Filter direset',
			retryScheduled: 'dijadwalkan',
			stSuccess: 'success',
			stFailed: 'failed',
			stProcessing: 'processing'
		},
		en: {
			title: 'Kirana Monitoring — DK UI Kit',
			sumSuccess: 'Current Success',
			sumFailed: 'Current Failed',
			sumPending: 'Current Pending',
			sumWebhook: 'Waiting Webhook',
			searchPh: 'Search ticket / request / filename',
			tabAll: 'All',
			tabSuccess: 'Success',
			tabFailed: 'Failed',
			source: 'Source',
			sourceH: 'Source',
			manual: 'Manual',
			batch: 'Batch',
			reset: 'Reset',
			resetTip: 'Restore initial filter',
			logDetail: 'Log Details',
			logTitle: 'Step-by-step Log',
			logSteps: 'Analyze sent → webhook received → final status success.',
			logDesc: 'Mimics manual and batch logs on the blade.',
			emptyTitle: 'No attempts',
			emptyDesc: 'Change the search keyword.',
			thGroup: 'Request Group',
			thTicket: 'Ticket',
			thSource: 'Source',
			thFile: 'File',
			thStatus: 'Status',
			thAction: 'Action',
			retry: 'Retry',
			toastReset: 'Filter reset',
			retryScheduled: 'scheduled',
			stSuccess: 'success',
			stFailed: 'failed',
			stProcessing: 'processing'
		},
		th: {
			title: 'Kirana Monitoring — DK UI Kit',
			sumSuccess: 'สำเร็จปัจจุบัน',
			sumFailed: 'ล้มเหลวปัจจุบัน',
			sumPending: 'รอดำเนินการปัจจุบัน',
			sumWebhook: 'รอ Webhook',
			searchPh: 'ค้นหาตั๋ว / คำขอ / ชื่อไฟล์',
			tabAll: 'ทั้งหมด',
			tabSuccess: 'สำเร็จ',
			tabFailed: 'ล้มเหลว',
			source: 'แหล่งที่มา',
			sourceH: 'แหล่งที่มา',
			manual: 'แบบแมนนวล',
			batch: 'แบบแบตช์',
			reset: 'รีเซ็ต',
			resetTip: 'คืนค่าตัวกรองเริ่มต้น',
			logDetail: 'รายละเอียดล็อก',
			logTitle: 'ล็อกทีละขั้นตอน',
			logSteps: 'ส่ง Analyze → ได้รับ webhook → สถานะสุดท้าย success',
			logDesc: 'เลียนแบบล็อกแบบแมนนวลและแบบแบตช์บน blade',
			emptyTitle: 'ไม่มีความพยายาม',
			emptyDesc: 'เปลี่ยนคำค้นหา',
			thGroup: 'กลุ่มคำขอ',
			thTicket: 'ตั๋ว',
			thSource: 'แหล่งที่มา',
			thFile: 'ไฟล์',
			thStatus: 'สถานะ',
			thAction: 'การดำเนินการ',
			retry: 'ลองใหม่',
			toastReset: 'รีเซ็ตตัวกรองแล้ว',
			retryScheduled: 'กำหนดเวลาแล้ว',
			stSuccess: 'สำเร็จ',
			stFailed: 'ล้มเหลว',
			stProcessing: 'กำลังดำเนินการ'
		},
		tl: {
			title: 'Kirana Monitoring — DK UI Kit',
			sumSuccess: 'Kasalukuyang Success',
			sumFailed: 'Kasalukuyang Failed',
			sumPending: 'Kasalukuyang Pending',
			sumWebhook: 'Naghihintay ng Webhook',
			searchPh: 'Maghanap ng ticket / request / filename',
			tabAll: 'Lahat',
			tabSuccess: 'Success',
			tabFailed: 'Failed',
			source: 'Source',
			sourceH: 'Source',
			manual: 'Manual',
			batch: 'Batch',
			reset: 'I-reset',
			resetTip: 'Ibalik ang paunang filter',
			logDetail: 'Detalye ng Log',
			logTitle: 'Step-by-step Log',
			logSteps: 'Naipadala ang Analyze → natanggap ang webhook → final status success.',
			logDesc: 'Ginagaya ang manual at batch log sa blade.',
			emptyTitle: 'Walang attempt',
			emptyDesc: 'Baguhin ang keyword ng paghahanap.',
			thGroup: 'Request Group',
			thTicket: 'Ticket',
			thSource: 'Source',
			thFile: 'File',
			thStatus: 'Status',
			thAction: 'Aksyon',
			retry: 'Subukan muli',
			toastReset: 'Na-reset ang filter',
			retryScheduled: 'naka-iskedyul',
			stSuccess: 'success',
			stFailed: 'failed',
			stProcessing: 'pinoproseso'
		}
	} as const;
	let s = $derived(STR[$locale]);

	const summaryDefs = [
		{ key: 'sumSuccess' as const, value: '1.284', tone: 'text-emerald-500' },
		{ key: 'sumFailed' as const, value: '37', tone: 'text-red-500' },
		{ key: 'sumPending' as const, value: '12', tone: 'text-amber-500' },
		{ key: 'sumWebhook' as const, value: '5', tone: 'text-cyan-500' }
	];
	let summary = $derived(summaryDefs.map((d) => ({ ...d, label: s[d.key] })));
	const rows = [
		{ group: 'REQ-88A1', ticket: 'TCK-101', source: 'manual', type: 'result', status: 'success', file: 'hasil_01.pdf', time: '10:02' },
		{ group: 'REQ-88A2', ticket: 'TCK-102', source: 'batch', type: 'outbound', status: 'failed', file: 'batch_44.csv', time: '10:20' },
		{ group: 'REQ-88A3', ticket: 'TCK-103', source: 'manual', type: 'result', status: 'processing', file: 'hasil_02.pdf', time: '10:31' }
	];
	let q = $state('');
	let loading = $state(false);
	let filtered = $derived(rows.filter((r) => !q || (r.ticket + r.group + r.file).toLowerCase().includes(q.toLowerCase())));
	const statusLabel = (st: string) => st === 'success' ? s.stSuccess : st === 'failed' ? s.stFailed : s.stProcessing;
</script>

<svelte:head><title>{s.title}</title></svelte:head>

<div class="flex flex-col gap-3">
	<div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
		{#each summary as sm}<Card.Root><Card.Header class="flex flex-row items-center justify-between gap-2"><span class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">{sm.label}</span><Badge variant="outline">{sm.value}</Badge></Card.Header><Card.Content><p class={`text-3xl font-bold ${sm.tone}`}>{sm.value}</p></Card.Content></Card.Root>{/each}
	</div>

	<Card.Root>
		<Card.Header class="flex flex-row flex-wrap items-center gap-2">
			<InputGroup.Root class="max-w-sm"><InputGroup.Addon><Search class="size-4" /></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder={s.searchPh} /></InputGroup.Root>
			<Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">{s.tabAll}</Tabs.Trigger><Tabs.Trigger value="success">{s.tabSuccess}</Tabs.Trigger><Tabs.Trigger value="failed">{s.tabFailed}</Tabs.Trigger></Tabs.List></Tabs.Root>
			<DropdownMenu.Root>
				<DropdownMenu.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><MoreVertical class="size-4" /> {s.source}</Button>{/snippet}</DropdownMenu.Trigger>
				<DropdownMenu.Content><DropdownMenu.Group><DropdownMenu.GroupHeading>{s.sourceH}</DropdownMenu.GroupHeading><DropdownMenu.Item>{s.manual}</DropdownMenu.Item><DropdownMenu.Item>{s.batch}</DropdownMenu.Item></DropdownMenu.Group></DropdownMenu.Content>
			</DropdownMenu.Root>
			<Tooltip.Provider><Tooltip.Root><Tooltip.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" onclick={() => { q = ''; toast.success(s.toastReset); }} {...props}><RotateCcw class="size-4" /> {s.reset}</Button>{/snippet}</Tooltip.Trigger><Tooltip.Content>{s.resetTip}</Tooltip.Content></Tooltip.Root></Tooltip.Provider>
			<Sheet.Root>
				<Sheet.Trigger>{#snippet child({ props })}<Button size="sm" {...props}>{s.logDetail}</Button>{/snippet}</Sheet.Trigger>
				<Sheet.Content><Sheet.Header><Sheet.Title>{s.logTitle}</Sheet.Title></Sheet.Header><div class="flex flex-col gap-2 p-4 text-sm"><p>{s.logSteps}</p><Separator /><p class="text-muted-foreground">{s.logDesc}</p></div></Sheet.Content>
			</Sheet.Root>
		</Card.Header>
		<Separator />
		<ScrollArea.Root class="h-[50vh]">
			{#if loading}<div class="flex flex-col gap-2 p-4"><Skeleton class="h-10 w-full" /><Skeleton class="h-10 w-full" /></div>
			{:else if filtered.length === 0}<Empty.Root><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>
			{:else}
				<Table.Root>
					<Table.Header><Table.Row><Table.Head>{s.thGroup}</Table.Head><Table.Head>{s.thTicket}</Table.Head><Table.Head>{s.thSource}</Table.Head><Table.Head>{s.thFile}</Table.Head><Table.Head>{s.thStatus}</Table.Head><Table.Head>{s.thAction}</Table.Head></Table.Row></Table.Header>
					<Table.Body>
						{#each filtered as r (r.group)}
							<Table.Row>
								<Table.Cell>{r.group}</Table.Cell><Table.Cell>{r.ticket}</Table.Cell><Table.Cell><Badge variant="outline">{r.source}</Badge></Table.Cell><Table.Cell class="max-w-40 truncate">{r.file}</Table.Cell>
								<Table.Cell><Badge variant={r.status === 'success' ? 'default' : r.status === 'failed' ? 'destructive' : 'secondary'}>{statusLabel(r.status)}</Badge></Table.Cell>
								<Table.Cell>
									<Dialog.Root>
										<Dialog.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}>{s.retry}</Button>{/snippet}</Dialog.Trigger>
										<Dialog.Content><Dialog.Header><Dialog.Title>{s.retry} {r.group}?</Dialog.Title></Dialog.Header><Dialog.Footer><Button onclick={() => toast.success(`Retry ${r.group} ${s.retryScheduled}`)}>{s.retry}</Button></Dialog.Footer></Dialog.Content>
									</Dialog.Root>
								</Table.Cell>
							</Table.Row>
						{/each}
					</Table.Body>
				</Table.Root>
			{/if}
		</ScrollArea.Root>
	</Card.Root>
</div>
