<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Resizable from '$lib/components/ui/resizable';
	import * as Sheet from '$lib/components/ui/sheet';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Message from '$lib/components/ui/message';
	import * as Bubble from '$lib/components/ui/bubble';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import EmailItem from '$lib/components/ui/email-item.svelte';
	import { toast } from 'svelte-sonner';
	import { cn } from '$lib/utils';
	import { Search, MoreVertical, Ticket } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			title: 'Ticketing — DK UI Kit',
			tabOpen: 'Open',
			tabPending: 'Pending',
			tabResolved: 'Resolved',
			searchPh: 'Cari tiket…',
			statusH: 'Status',
			assign: 'Assign',
			assignTip: 'Assign ke agen',
			timeline: 'Timeline',
			timelineTitle: 'Timeline Tiket',
			timelineSteps: 'Dibuat • Diproses • Escalated • Selesai',
			timelineDesc: 'Meniru status-card & timeline blade ticketing.',
			closeTicket: 'Close Ticket',
			closeTitle: 'Tutup tiket',
			closeBtn: 'Tutup',
			replyPh: 'Balas tiket…',
			send: 'Kirim',
			toastClosed: 'Tiket ditutup',
			toastReplied: 'Balasan terkirim',
			msgFollowup: 'mohon bantuan follow-up.',
			msgProcPrefix: 'Baik kak, tiket',
			msgProcSuffix: 'sedang kami proses.',
			agentNow: 'Agent • now',
			stOpen: 'open',
			stPending: 'pending',
			stResolved: 'resolved'
		},
		en: {
			title: 'Ticketing — DK UI Kit',
			tabOpen: 'Open',
			tabPending: 'Pending',
			tabResolved: 'Resolved',
			searchPh: 'Search tickets…',
			statusH: 'Status',
			assign: 'Assign',
			assignTip: 'Assign to an agent',
			timeline: 'Timeline',
			timelineTitle: 'Ticket Timeline',
			timelineSteps: 'Created • In progress • Escalated • Done',
			timelineDesc: 'Mimics the ticketing blade status-card & timeline.',
			closeTicket: 'Close Ticket',
			closeTitle: 'Close ticket',
			closeBtn: 'Close',
			replyPh: 'Reply to ticket…',
			send: 'Send',
			toastClosed: 'Ticket closed',
			toastReplied: 'Reply sent',
			msgFollowup: 'please help to follow up.',
			msgProcPrefix: 'Hi, ticket',
			msgProcSuffix: 'is being processed.',
			agentNow: 'Agent • now',
			stOpen: 'open',
			stPending: 'pending',
			stResolved: 'resolved'
		},
		th: {
			title: 'Ticketing — DK UI Kit',
			tabOpen: 'เปิด',
			tabPending: 'รอดำเนินการ',
			tabResolved: 'แก้ไขแล้ว',
			searchPh: 'ค้นหาตั๋ว…',
			statusH: 'สถานะ',
			assign: 'มอบหมาย',
			assignTip: 'มอบหมายให้เจ้าหน้าที่',
			timeline: 'ไทม์ไลน์',
			timelineTitle: 'ไทม์ไลน์ตั๋ว',
			timelineSteps: 'สร้างแล้ว • กำลังดำเนินการ • ส่งต่อ • เสร็จสิ้น',
			timelineDesc: 'เลียนแบบ status-card และไทม์ไลน์ของ ticketing blade',
			closeTicket: 'ปิดตั๋ว',
			closeTitle: 'ปิดตั๋ว',
			closeBtn: 'ปิด',
			replyPh: 'ตอบกลับตั๋ว…',
			send: 'ส่ง',
			toastClosed: 'ปิดตั๋วแล้ว',
			toastReplied: 'ส่งคำตอบแล้ว',
			msgFollowup: 'โปรดช่วยติดตามงาน',
			msgProcPrefix: 'สวัสดี ตั๋ว',
			msgProcSuffix: 'กำลังดำเนินการ',
			agentNow: 'เจ้าหน้าที่ • ขณะนี้',
			stOpen: 'เปิด',
			stPending: 'รอดำเนินการ',
			stResolved: 'แก้ไขแล้ว'
		},
		tl: {
			title: 'Ticketing — DK UI Kit',
			tabOpen: 'Bukas',
			tabPending: 'Nakabinbin',
			tabResolved: 'Nalutas',
			searchPh: 'Maghanap ng ticket…',
			statusH: 'Katayuan',
			assign: 'I-assign',
			assignTip: 'I-assign sa agent',
			timeline: 'Timeline',
			timelineTitle: 'Timeline ng Ticket',
			timelineSteps: 'Ginawa • Pinoproseso • Escalated • Tapos',
			timelineDesc: 'Ginagaya ang status-card at timeline ng ticketing blade.',
			closeTicket: 'Isara ang Ticket',
			closeTitle: 'Isara ang ticket',
			closeBtn: 'Isara',
			replyPh: 'Sumagot sa ticket…',
			send: 'Ipadala',
			toastClosed: 'Isinara ang ticket',
			toastReplied: 'Naipadala ang sagot',
			msgFollowup: 'pakisuyo ng follow-up.',
			msgProcPrefix: 'Hello, ang ticket',
			msgProcSuffix: 'ay pinoproseso.',
			agentNow: 'Agent • ngayon',
			stOpen: 'bukas',
			stPending: 'nakabinbin',
			stResolved: 'nalutas'
		}
	} as const;
	let s = $derived(STR[$locale]);

	const tickets = [
		{ id: 'TCK-001', customer: 'Budi Santoso', subject: 'Paket belum sampai', channel: 'WhatsApp', status: 'open', time: '10:20' },
		{ id: 'TCK-002', customer: 'Siti Aminah', subject: 'Pengajuan KTP', channel: 'Email', status: 'pending', time: '09:45' },
		{ id: 'TCK-003', customer: 'Andi Wijaya', subject: 'Refund dana', channel: 'Live Chat', status: 'resolved', time: '08:15' }
	];
	let sel = $state(tickets[0]);
	let loading = $state(false);
	let reply = $state('');
	const initials = (n: string) => n.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
	const statusLabel = (st: string) => st === 'open' ? s.stOpen : st === 'pending' ? s.stPending : s.stResolved;
</script>

<svelte:head><title>{s.title}</title></svelte:head>

<div class="flex flex-col gap-3">
	<Tabs.Root value="open">
		<Tabs.List>
			<Tabs.Trigger value="open">{s.tabOpen}</Tabs.Trigger>
			<Tabs.Trigger value="pending">{s.tabPending}</Tabs.Trigger>
			<Tabs.Trigger value="resolved">{s.tabResolved}</Tabs.Trigger>
		</Tabs.List>
	</Tabs.Root>

	<Resizable.PaneGroup direction="horizontal" class="min-h-[70vh] gap-3">
		<Resizable.Pane defaultSize={32}>
			<Card.Root class="flex h-full flex-col">
				<Card.Header class="flex flex-row items-center gap-2">
					<InputGroup.Root><InputGroup.Addon><Search class="size-4" /></InputGroup.Addon><InputGroup.Input placeholder={s.searchPh} /></InputGroup.Root>
					<DropdownMenu.Root>
						<DropdownMenu.Trigger>
							{#snippet child({ props })}<Button size="icon" variant="outline" {...props}><MoreVertical class="size-4" /></Button>{/snippet}
						</DropdownMenu.Trigger>
						<DropdownMenu.Content>
							<DropdownMenu.Group><DropdownMenu.GroupHeading>{s.statusH}</DropdownMenu.GroupHeading><DropdownMenu.Item>{s.tabOpen}</DropdownMenu.Item><DropdownMenu.Item>{s.tabPending}</DropdownMenu.Item><DropdownMenu.Item>{s.tabResolved}</DropdownMenu.Item></DropdownMenu.Group>
						</DropdownMenu.Content>
					</DropdownMenu.Root>
				</Card.Header>
				<Separator />
				<ScrollArea.Root class="h-[55vh]">
					<div class="flex flex-col gap-2 p-3">
						{#each tickets as t (t.id)}
							<button onclick={() => { sel = t; loading = true; setTimeout(() => (loading = false), 600); }} class={cn('flex items-center gap-3 rounded-lg p-3 text-left hover:bg-muted/50', sel.id === t.id && 'bg-muted')}>
								<Avatar.Root><Avatar.Fallback>{initials(t.customer)}</Avatar.Fallback></Avatar.Root>
								<span class="min-w-0 flex-1"><span class="flex items-center gap-2"><Ticket class="size-3" /><strong class="truncate text-sm">{t.id}</strong><Badge variant="outline" class="text-[10px]">{t.channel}</Badge></span>
								<span class="block truncate text-xs text-muted-foreground">{t.subject}</span></span>
								<Badge variant={t.status === 'open' ? 'default' : t.status === 'pending' ? 'secondary' : 'outline'}>{statusLabel(t.status)}</Badge>
							</button>
						{/each}
					</div>
				</ScrollArea.Root>
			</Card.Root>
		</Resizable.Pane>
		<Resizable.Handle />
		<Resizable.Pane defaultSize={68}>
			<Card.Root class="flex h-full flex-col">
				<Card.Header class="flex flex-row items-center gap-3">
					<div class="flex flex-1 flex-col gap-0.5"><strong class="text-sm">{sel.id} — {sel.subject}</strong><span class="text-xs text-muted-foreground">{sel.customer} • {sel.channel}</span></div>
					<Tooltip.Provider><Tooltip.Root><Tooltip.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}>{s.assign}</Button>{/snippet}</Tooltip.Trigger><Tooltip.Content>{s.assignTip}</Tooltip.Content></Tooltip.Root></Tooltip.Provider>
					<Sheet.Root>
						<Sheet.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}>{s.timeline}</Button>{/snippet}</Sheet.Trigger>
						<Sheet.Content><Sheet.Header><Sheet.Title>{s.timelineTitle} {sel.id}</Sheet.Title></Sheet.Header><div class="flex flex-col gap-2 p-4 text-sm"><p>{s.timelineSteps}</p><Separator /><p class="text-muted-foreground">{s.timelineDesc}</p></div></Sheet.Content>
					</Sheet.Root>
					<Dialog.Root>
						<Dialog.Trigger>{#snippet child({ props })}<Button size="sm" {...props}>{s.closeTicket}</Button>{/snippet}</Dialog.Trigger>
						<Dialog.Content><Dialog.Header><Dialog.Title>{s.closeTitle} {sel.id}?</Dialog.Title></Dialog.Header><Dialog.Footer><Button onclick={() => toast.success(s.toastClosed)}>{s.closeBtn}</Button></Dialog.Footer></Dialog.Content>
					</Dialog.Root>
				</Card.Header>
				<Separator />
				<ScrollArea.Root class="h-[45vh] p-4">
					{#if loading}<div class="flex flex-col gap-2"><Skeleton class="h-12 w-full" /><Skeleton class="h-12 w-5/6" /></div>
					{:else}
						<Message.Group>
							<Message.Root><Message.Avatar><Avatar.Root><Avatar.Fallback>{initials(sel.customer)}</Avatar.Fallback></Avatar.Root></Message.Avatar><div class="flex flex-col gap-1"><Message.Header>{sel.customer}</Message.Header><Bubble.Root variant="received"><Bubble.Content>{sel.subject} — {s.msgFollowup}</Bubble.Content></Bubble.Root><Message.Footer>{sel.time}</Message.Footer></div></Message.Root>
							<Message.Root class="justify-end"><div class="flex flex-col gap-1"><Bubble.Root variant="sent"><Bubble.Content>{s.msgProcPrefix} {sel.id} {s.msgProcSuffix}</Bubble.Content></Bubble.Root><Message.Footer>{s.agentNow}</Message.Footer></div></Message.Root>
						</Message.Group>
						<div class="mt-3 flex flex-col gap-2"><EmailItem from={sel.customer} subject={sel.subject} preview="Lampiran dokumen pengajuan…" time={sel.time} /></div>
					{/if}
				</ScrollArea.Root>
				<Card.Footer>
					<InputGroup.Root><InputGroup.Input bind:value={reply} placeholder={s.replyPh} /><InputGroup.Button onclick={() => { toast.success(s.toastReplied); reply = ''; }}>{s.send}</InputGroup.Button></InputGroup.Root>
				</Card.Footer>
			</Card.Root>
		</Resizable.Pane>
	</Resizable.PaneGroup>
</div>
