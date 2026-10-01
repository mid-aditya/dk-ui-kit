<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Message from '$lib/components/ui/message';
	import * as Bubble from '$lib/components/ui/bubble';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import DateRangePicker from '$lib/components/ui/date-range-picker.svelte';
	import { toast } from 'svelte-sonner';
	import { Search, Filter } from 'lucide-svelte';
	import type { DateRange } from 'bits-ui';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			title: 'Threads — DK UI Kit',
			filters: 'Filters',
			searchPh: 'Search Phone, User or Agent…',
			rangeLabel: 'Pilih rentang tanggal thread',
			clear: 'Clear',
			search: 'Search',
			filter: 'Filter',
			channelH: 'Kanal',
			all: 'Semua',
			tabList: 'Thread List',
			tabTimeline: 'Timeline',
			emptyTitle: 'Tidak ada thread',
			emptyDesc: 'Coba ubah filter pencarian.',
			messages: 'pesan',
			open: 'Buka',
			openTip: 'Lihat timeline thread',
			detail: 'Detail',
			threadPrefix: 'Thread #',
			timelineDesc: 'Timeline vertikal meniru blade threads.',
			found: 'Ditemukan',
			threadUnit: 'thread',
			filterPrefix: 'Filter',
			toastOpened: 'Thread dibuka'
		},
		en: {
			title: 'Threads — DK UI Kit',
			filters: 'Filters',
			searchPh: 'Search Phone, User or Agent…',
			rangeLabel: 'Select thread date range',
			clear: 'Clear',
			search: 'Search',
			filter: 'Filter',
			channelH: 'Channel',
			all: 'All',
			tabList: 'Thread List',
			tabTimeline: 'Timeline',
			emptyTitle: 'No threads',
			emptyDesc: 'Try changing the search filter.',
			messages: 'messages',
			open: 'Open',
			openTip: 'View thread timeline',
			detail: 'Details',
			threadPrefix: 'Thread #',
			timelineDesc: 'Vertical timeline mimicking the threads blade.',
			found: 'Found',
			threadUnit: 'threads',
			filterPrefix: 'Filter',
			toastOpened: 'Thread opened'
		},
		th: {
			title: 'Threads — DK UI Kit',
			filters: 'ตัวกรอง',
			searchPh: 'ค้นหาโทรศัพท์ ผู้ใช้ หรือเจ้าหน้าที่…',
			rangeLabel: 'เลือกช่วงวันที่ของเธรด',
			clear: 'ล้าง',
			search: 'ค้นหา',
			filter: 'กรอง',
			channelH: 'ช่องทาง',
			all: 'ทั้งหมด',
			tabList: 'รายการเธรด',
			tabTimeline: 'ไทม์ไลน์',
			emptyTitle: 'ไม่มีเธรด',
			emptyDesc: 'ลองเปลี่ยนตัวกรองการค้นหา',
			messages: 'ข้อความ',
			open: 'เปิด',
			openTip: 'ดูไทม์ไลน์เธรด',
			detail: 'รายละเอียด',
			threadPrefix: 'เธรด #',
			timelineDesc: 'ไทม์ไลน์แนวตั้งตามแบบ threads blade',
			found: 'พบ',
			threadUnit: 'เธรด',
			filterPrefix: 'ตัวกรอง',
			toastOpened: 'เปิดเธรดแล้ว'
		},
		tl: {
			title: 'Threads — DK UI Kit',
			filters: 'Mga Filter',
			searchPh: 'Maghanap ng Phone, User o Agent…',
			rangeLabel: 'Piliin ang saklaw ng petsa ng thread',
			clear: 'I-clear',
			search: 'Maghanap',
			filter: 'I-filter',
			channelH: 'Channel',
			all: 'Lahat',
			tabList: 'Listahan ng Thread',
			tabTimeline: 'Timeline',
			emptyTitle: 'Walang thread',
			emptyDesc: 'Subukang baguhin ang filter ng paghahanap.',
			messages: 'mensahe',
			open: 'Buksan',
			openTip: 'Tingnan ang timeline ng thread',
			detail: 'Detalye',
			threadPrefix: 'Thread #',
			timelineDesc: 'Vertical timeline gaya ng threads blade.',
			found: 'Nakakita ng',
			threadUnit: 'thread',
			filterPrefix: 'Filter',
			toastOpened: 'Binuksan ang thread'
		}
	} as const;
	let s = $derived(STR[$locale]);

	const rows = [
		{ id: 1, user: 'Budi Santoso', agent: 'Agent Rina', channel: 'Chat', preview: 'Paket belum sampai…', date: '2026-09-28', count: 12 },
		{ id: 2, user: 'Siti Aminah', agent: 'Agent Dodi', channel: 'Email', preview: 'Pengajuan KTP…', date: '2026-09-29', count: 5 },
		{ id: 3, user: 'Andi Wijaya', agent: 'Agent Rina', channel: 'Inbound', preview: 'Refund dana…', date: '2026-09-30', count: 8 }
	];
	let q = $state('');
	let loading = $state(false);
	let range = $state<DateRange | undefined>(undefined);
	let filtered = $derived(rows.filter((r) => !q || r.user.toLowerCase().includes(q.toLowerCase())));
	const initials = (n: string) => n.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
	function search() { loading = true; setTimeout(() => { loading = false; toast.success(`${s.found} ${filtered.length} ${s.threadUnit}`); }, 600); }
</script>

<svelte:head><title>{s.title}</title></svelte:head>

<div class="flex flex-col gap-3">
	<Card.Root>
		<Card.Header class="flex flex-row items-center gap-2">
			<strong class="text-sm">{s.filters}</strong>
			<div class="flex flex-1 flex-col gap-2 md:flex-row">
				<InputGroup.Root class="max-w-md"><InputGroup.Addon><Search class="size-4" /></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder={s.searchPh} /></InputGroup.Root>
				<DateRangePicker bind:value={range} label={s.rangeLabel} class="max-w-xs" />
			</div>
			<Button variant="outline" size="sm" onclick={() => (q = '')}>{s.clear}</Button>
			<Button size="sm" onclick={search}>{s.search}</Button>
			<DropdownMenu.Root>
				<DropdownMenu.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><Filter class="size-4" /> {s.filter}</Button>{/snippet}</DropdownMenu.Trigger>
				<DropdownMenu.Content><DropdownMenu.Group><DropdownMenu.GroupHeading>{s.channelH}</DropdownMenu.GroupHeading><DropdownMenu.Item onclick={() => toast.success(`${s.filterPrefix}: ${s.all}`)}>{s.all}</DropdownMenu.Item><DropdownMenu.Item onclick={() => toast.success(`${s.filterPrefix}: Chat`)}>Chat</DropdownMenu.Item><DropdownMenu.Item onclick={() => toast.success(`${s.filterPrefix}: Email`)}>Email</DropdownMenu.Item><DropdownMenu.Item onclick={() => toast.success(`${s.filterPrefix}: Inbound`)}>Inbound</DropdownMenu.Item></DropdownMenu.Group></DropdownMenu.Content>
			</DropdownMenu.Root>
		</Card.Header>
	</Card.Root>

	<Tabs.Root value="list">
		<Tabs.List><Tabs.Trigger value="list">{s.tabList}</Tabs.Trigger><Tabs.Trigger value="timeline">{s.tabTimeline}</Tabs.Trigger></Tabs.List>
		<Tabs.Content value="list">
			<Card.Root>
				<ScrollArea.Root class="h-[55vh]">
					{#if loading}<div class="flex flex-col gap-2 p-4"><Skeleton class="h-14 w-full" /><Skeleton class="h-14 w-full" /></div>
					{:else if filtered.length === 0}<Empty.Root><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>
					{:else}
						<div class="flex flex-col gap-2 p-3">
							{#each filtered as r (r.id)}
								<div class="flex items-center gap-3 rounded-lg border p-3">
									<Avatar.Root><Avatar.Fallback>{initials(r.user)}</Avatar.Fallback></Avatar.Root>
									<span class="min-w-0 flex-1"><span class="flex items-center gap-2"><strong class="truncate text-sm">{r.user}</strong><Badge variant="outline" class="text-[10px]">{r.channel}</Badge><Badge variant="secondary">{r.count} {s.messages}</Badge></span>
									<span class="block truncate text-xs text-muted-foreground">{r.preview} • {r.agent} • {r.date}</span></span>
									<Tooltip.Provider><Tooltip.Root><Tooltip.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props} onclick={() => toast.success(s.toastOpened)}>{s.open}</Button>{/snippet}</Tooltip.Trigger><Tooltip.Content>{s.openTip}</Tooltip.Content></Tooltip.Root></Tooltip.Provider>
									<Dialog.Root>
										<Dialog.Trigger>{#snippet child({ props })}<Button size="sm" {...props}>{s.detail}</Button>{/snippet}</Dialog.Trigger>
										<Dialog.Content><Dialog.Header><Dialog.Title>{s.threadPrefix}{r.id} — {r.user}</Dialog.Title></Dialog.Header>
											<Message.Group>
												<Message.Root><div class="flex flex-col gap-1"><Message.Header>{r.user}</Message.Header><Bubble.Root variant="received"><Bubble.Content>{r.preview}</Bubble.Content></Bubble.Root><Message.Footer>{r.date}</Message.Footer></div></Message.Root>
											</Message.Group>
											<Separator class="my-2" />
											<p class="text-xs text-muted-foreground">{s.timelineDesc}</p>
										</Dialog.Content>
									</Dialog.Root>
								</div>
							{/each}
						</div>
					{/if}
				</ScrollArea.Root>
			</Card.Root>
		</Tabs.Content>
		<Tabs.Content value="timeline">
			<Card.Root><Card.Content class="flex flex-col gap-2 p-4">
				{#each filtered as r (r.id)}<div class="flex items-center gap-3"><span class="h-8 w-1 rounded bg-primary"></span><Avatar.Root><Avatar.Fallback>{initials(r.user)}</Avatar.Fallback></Avatar.Root><span class="text-sm">{r.user} — {r.preview}</span><Badge variant="outline">{r.date}</Badge></div><Separator />{/each}
			</Card.Content></Card.Root>
		</Tabs.Content>
	</Tabs.Root>
</div>
