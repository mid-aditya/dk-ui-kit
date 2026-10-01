<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as Empty from '$lib/components/ui/empty';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Separator } from '$lib/components/ui/separator';
	import { Progress } from '$lib/components/ui/progress';
	import {
		LayoutGrid, PhoneCall, Ticket, Tv, Send, Search, Star, MessageSquareText, Mail,
		Users, ChartColumn, Inbox, ArrowUpRight, FolderOpen
	} from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'Reports Hub — DK UI Kit', hubTitle: 'Reports Hub', version: 'Analytics v3.0',
			categories: 'Kategori', totalReports: 'Total laporan', activeCat: 'Kategori aktif:',
			searchLabel: 'Cari laporan', searchPh: 'Cari laporan…',
			tabAll: 'Semua', tabCalls: 'Call', tabTickets: 'Ticketing', tabWall: 'Wallboard', tabOmni: 'Omni',
			catAll: 'Semua Laporan', catAllD: 'Ringkasan data lengkap',
			catCalls: 'Call Analytics', catCallsD: 'Metrik telepon',
			catTick: 'Ticketing & CS', catTickD: 'Produktivitas support',
			catWall: 'Live Wallboards', catWallD: 'Monitoring real-time',
			catOmni: 'Omni Blast', catOmniD: 'Pesan multi-channel',
			metaAllT: 'Reports Hub', metaAllD: 'Akses terpusat data, analitik real-time, dan metrik performa operasional semua kanal.',
			metaCallsT: 'Call Center Analytics', metaCallsD: 'Monitoring transaksi PBX inbound/outbound dan produktivitas agent.',
			metaTickT: 'Support & Ticketing', metaTickD: 'Rekap lifecycle tiket, performa tim, dan benchmark resolusi.',
			metaWallT: 'Monitoring Wallboards', metaWallD: 'Monitoring visual real-time untuk operation center dan pimpinan.',
			metaOmniT: 'Omnichannel & Blast', metaOmniD: 'Statistik kanal chat terintegrasi dan riwayat blast massal.',
			gCalls: 'Call Analytics', gTick: 'Ticketing & CS', gWall: 'Live Wallboards', gOmni: 'Omni Blast',
			unit: 'laporan', open: 'Buka laporan',
			emptyT: 'Tidak ada laporan', emptyPre: 'Tidak ada laporan', emptyMid: 'pada kategori',
			allEmptyT: 'Semua filter kosong', allEmptyD: 'Ubah kata kunci atau kategori untuk melihat laporan.',
			reset: 'Reset filter', scPre: 'Pintasan: CSAT di', scMid: ', interaksi di'
		},
		en: {
			docTitle: 'Reports Hub — DK UI Kit', hubTitle: 'Reports Hub', version: 'Analytics v3.0',
			categories: 'Categories', totalReports: 'Total reports', activeCat: 'Active category:',
			searchLabel: 'Search reports', searchPh: 'Search reports…',
			tabAll: 'All', tabCalls: 'Calls', tabTickets: 'Ticketing', tabWall: 'Wallboards', tabOmni: 'Omni',
			catAll: 'All Reports', catAllD: 'Complete data overview',
			catCalls: 'Call Analytics', catCallsD: 'Telephony metrics',
			catTick: 'Ticketing & CS', catTickD: 'Support productivity',
			catWall: 'Live Wallboards', catWallD: 'Real-time monitoring',
			catOmni: 'Omni Blast', catOmniD: 'Multi-channel messaging',
			metaAllT: 'Reports Hub', metaAllD: 'Centralized access to data, real-time analytics, and operational performance metrics across all channels.',
			metaCallsT: 'Call Center Analytics', metaCallsD: 'Monitor inbound/outbound PBX transactions and agent productivity.',
			metaTickT: 'Support & Ticketing', metaTickD: 'Ticket lifecycle recap, team performance, and resolution benchmarks.',
			metaWallT: 'Monitoring Wallboards', metaWallD: 'Real-time visual monitoring for the operation center and leadership.',
			metaOmniT: 'Omnichannel & Blast', metaOmniD: 'Integrated chat channel statistics and mass blast history.',
			gCalls: 'Call Analytics', gTick: 'Ticketing & CS', gWall: 'Live Wallboards', gOmni: 'Omni Blast',
			unit: 'reports', open: 'Open report',
			emptyT: 'No reports', emptyPre: 'No reports matching', emptyMid: 'in category',
			allEmptyT: 'No results', allEmptyD: 'Change the keyword or category to view reports.',
			reset: 'Reset filters', scPre: 'Shortcuts: CSAT at', scMid: ', interactions at'
		},
		th: {
			docTitle: 'ศูนย์รวมรายงาน — DK UI Kit', hubTitle: 'ศูนย์รวมรายงาน', version: 'Analytics v3.0',
			categories: 'หมวดหมู่', totalReports: 'รายงานทั้งหมด', activeCat: 'หมวดหมู่ที่ใช้งาน:',
			searchLabel: 'ค้นหารายงาน', searchPh: 'ค้นหารายงาน…',
			tabAll: 'ทั้งหมด', tabCalls: 'การโทร', tabTickets: 'ตั๋วงาน', tabWall: 'วอลล์บอร์ด', tabOmni: 'ออมนิ',
			catAll: 'รายงานทั้งหมด', catAllD: 'ภาพรวมข้อมูลครบถ้วน',
			catCalls: 'วิเคราะห์การโทร', catCallsD: 'เมตริกโทรศัพท์',
			catTick: 'ตั๋วงาน & CS', catTickD: 'ผลิตภาพทีมสนับสนุน',
			catWall: 'วอลล์บอร์ดสด', catWallD: 'มอนิเตอร์แบบเรียลไทม์',
			catOmni: 'ออมนิบลาสต์', catOmniD: 'ข้อความหลายช่องทาง',
			metaAllT: 'ศูนย์รวมรายงาน', metaAllD: 'เข้าถึงข้อมูลส่วนกลาง การวิเคราะห์แบบเรียลไทม์ และเมตริกประสิทธิภาพทุกช่องทาง',
			metaCallsT: 'วิเคราะห์คอลเซ็นเตอร์', metaCallsD: 'ติดตามธุรกรรม PBX ขาเข้า/ขาออก และผลิตภาพเอเจนต์',
			metaTickT: 'สนับสนุน & ตั๋วงาน', metaTickD: 'สรุปวงจรตั๋วงาน ประสิทธิภาพทีม และเกณฑ์การแก้ไข',
			metaWallT: 'วอลล์บอร์ดมอนิเตอร์', metaWallD: 'มอนิเตอร์ภาพแบบเรียลไทม์สำหรับศูนย์ปฏิบัติการและผู้บริหาร',
			metaOmniT: 'ออมนิแชนแนล & บลาสต์', metaOmniD: 'สถิติช่องทางแชตรวมและประวัติบลาสต์',
			gCalls: 'วิเคราะห์การโทร', gTick: 'ตั๋วงาน & CS', gWall: 'วอลล์บอร์ดสด', gOmni: 'ออมนิบลาสต์',
			unit: 'รายงาน', open: 'เปิดรายงาน',
			emptyT: 'ไม่มีรายงาน', emptyPre: 'ไม่พบรายงาน', emptyMid: 'ในหมวดหมู่',
			allEmptyT: 'ไม่มีผลลัพธ์', allEmptyD: 'เปลี่ยนคำค้นหรือหมวดหมู่เพื่อดูรายงาน',
			reset: 'รีเซ็ตตัวกรอง', scPre: 'ทางลัด: CSAT ที่', scMid: ', ปฏิสัมพันธ์ที่'
		},
		tl: {
			docTitle: 'Reports Hub — DK UI Kit', hubTitle: 'Reports Hub', version: 'Analytics v3.0',
			categories: 'Mga Kategorya', totalReports: 'Kabuuang ulat', activeCat: 'Aktibong kategorya:',
			searchLabel: 'Maghanap ng ulat', searchPh: 'Maghanap ng ulat…',
			tabAll: 'Lahat', tabCalls: 'Tawag', tabTickets: 'Ticketing', tabWall: 'Wallboard', tabOmni: 'Omni',
			catAll: 'Lahat ng Ulat', catAllD: 'Kumpletong buod ng datos',
			catCalls: 'Call Analytics', catCallsD: 'Mga sukatan ng telepono',
			catTick: 'Ticketing & CS', catTickD: 'Produktibidad ng support',
			catWall: 'Live Wallboards', catWallD: 'Real-time na monitoring',
			catOmni: 'Omni Blast', catOmniD: 'Multi-channel na mensahe',
			metaAllT: 'Reports Hub', metaAllD: 'Sentralisadong access sa datos, real-time analytics, at performance metrics ng lahat ng channel.',
			metaCallsT: 'Call Center Analytics', metaCallsD: 'Subaybayan ang inbound/outbound PBX at produktibidad ng agent.',
			metaTickT: 'Support & Ticketing', metaTickD: 'Buod ng lifecycle ng ticket, performance ng team, at resolution benchmark.',
			metaWallT: 'Monitoring Wallboards', metaWallD: 'Real-time visual monitoring para sa operation center at pamunuan.',
			metaOmniT: 'Omnichannel & Blast', metaOmniD: 'Pinagsamang chat statistics at kasaysayan ng blast.',
			gCalls: 'Call Analytics', gTick: 'Ticketing & CS', gWall: 'Live Wallboards', gOmni: 'Omni Blast',
			unit: 'ulat', open: 'Buksan ang ulat',
			emptyT: 'Walang ulat', emptyPre: 'Walang ulat na tumutugma sa', emptyMid: 'sa kategorya',
			allEmptyT: 'Walang resulta', allEmptyD: 'Baguhin ang keyword o kategorya upang makita ang mga ulat.',
			reset: 'I-reset ang filter', scPre: 'Shortcut: CSAT sa', scMid: ', interaksyon sa'
		}
	} as const;
	let s = $derived(STR[$locale]);

	type Category = 'all' | 'calls' | 'tickets' | 'wallboards' | 'omni';
	let category = $state<Category>('all');
	let query = $state('');

	let meta = $derived<Record<Category, { title: string; desc: string }>>({
		all: { title: s.metaAllT, desc: s.metaAllD },
		calls: { title: s.metaCallsT, desc: s.metaCallsD },
		tickets: { title: s.metaTickT, desc: s.metaTickD },
		wallboards: { title: s.metaWallT, desc: s.metaWallD },
		omni: { title: s.metaOmniT, desc: s.metaOmniD }
	});

	let groups = $derived([
		{ id: 'calls' as const, label: s.gCalls, icon: PhoneCall, cards: [
			{ title: 'Call Report', desc: 'Log transaksi dialer', to: '/report/csat', keys: 'call report dialer' },
			{ title: 'Daily Report', desc: 'Metrik ringkasan harian', to: '/report/csat', keys: 'daily update summary' },
			{ title: 'Agent AHT', desc: 'Pelacakan produktivitas', to: '/agent/performance', keys: 'agent aht productivity tracking' },
			{ title: 'Agent Login', desc: 'Aktivitas login & logout', to: '/agent-schedule', keys: 'agent login logout activity' },
			{ title: 'CSAT Report', desc: 'Survei kepuasan pelanggan', to: '/report/csat', keys: 'csat customer satisfaction survey' }
		]},
		{ id: 'tickets' as const, label: s.gTick, icon: Ticket, cards: [
			{ title: 'Ticketing Summary', desc: 'Distribusi status tiket', to: '/ticketing', keys: 'ticketing summary lifecycle' },
			{ title: 'CS Performance', desc: 'Metrik tim support', to: '/agent/performance', keys: 'cs performance team metrics support' },
			{ title: 'AI Agent Performance', desc: 'Skor analisis rekaman', to: '/agent/performance', keys: 'ai agent performance recording kirana analysis score' },
			{ title: 'CSAT Interaction', desc: 'Rating per interaksi & agent', to: '/report/csat-interaction', keys: 'csat interaction rating agent' }
		]},
		{ id: 'wallboards' as const, label: s.gWall, icon: Tv, cards: [
			{ title: 'Wallboard AHU', desc: 'Traffic real-time', to: '/spv', keys: 'wallboard ahu live traffic' },
			{ title: 'Wallboard Pimpinan', desc: 'Traffic real-time', to: '/spv', keys: 'wallboard pimpinan' },
			{ title: 'Wallboard Agent', desc: 'Traffic real-time', to: '/spv', keys: 'wallboard agent' }
		]},
		{ id: 'omni' as const, label: s.gOmni, icon: Send, cards: [
			{ title: 'Outbound Blast Dashboard', desc: 'KPI & analitik blast', to: '/settings', keys: 'outbound blast dashboard analytics whatsapp email campaign' },
			{ title: 'Blast History', desc: 'Log audit broadcast', to: '/email/history', keys: 'blast history audit logs campaign' },
			{ title: 'Email Templates', desc: 'Kelola template email', to: '/email/templates', keys: 'email templates compose' }
		]}
	]);

	const visibleGroups = $derived(groups.filter((g) => category === 'all' || g.id === category));
	function matches(card: { title: string; desc: string; keys: string }) {
		const q = query.trim().toLowerCase();
		if (!q) return true;
		return `${card.title} ${card.desc} ${card.keys}`.toLowerCase().includes(q);
	}
	const totalVisible = $derived(visibleGroups.reduce((n, g) => n + g.cards.filter(matches).length, 0));
	let cats = $derived([
		{ id: 'all' as Category, label: s.catAll, desc: s.catAllD, icon: LayoutGrid },
		{ id: 'calls' as Category, label: s.catCalls, desc: s.catCallsD, icon: PhoneCall },
		{ id: 'tickets' as Category, label: s.catTick, desc: s.catTickD, icon: Ticket },
		{ id: 'wallboards' as Category, label: s.catWall, desc: s.catWallD, icon: Tv },
		{ id: 'omni' as Category, label: s.catOmni, desc: s.catOmniD, icon: Send }
	]);
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6 lg:flex-row">
	<Card.Root class="w-full shrink-0 lg:w-80">
		<Card.Header>
			<div class="flex items-center gap-3">
				<div class="flex size-10 items-center justify-center rounded-xl bg-primary text-primary-foreground"><ChartColumn size={19} /></div>
				<div><Card.Title>{s.hubTitle}</Card.Title><p class="text-xs font-medium tracking-wider text-primary uppercase">{s.version}</p></div>
			</div>
		</Card.Header>
		<Card.Content class="flex flex-col gap-1">
			<p class="px-2 text-[0.65rem] font-bold tracking-widest text-muted-foreground uppercase">{s.categories}</p>
			{#each cats as c}
				<button type="button" onclick={() => (category = c.id)} class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition-colors {category === c.id ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-foreground'}">
					<c.icon size={20} class="mt-0.5 shrink-0" />
					<span><span class="block text-sm font-medium">{c.label}</span><span class="block text-xs opacity-70">{c.desc}</span></span>
				</button>
			{/each}
			<Separator class="my-2" />
			<div class="flex flex-col gap-2 rounded-xl bg-muted/40 p-3 text-xs text-muted-foreground">
				<div class="flex justify-between"><span>{s.totalReports}</span><span class="font-semibold text-foreground">{totalVisible}</span></div>
				<Progress value={Math.min(100, totalVisible * 8)} />
				<span>{s.activeCat} <span class="font-medium text-foreground">{meta[category].title}</span></span>
			</div>
		</Card.Content>
	</Card.Root>

	<Card.Root class="flex-1">
		<Card.Header class="flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
			<div><Card.Title class="text-2xl">{meta[category].title}</Card.Title><p class="mt-1 max-w-lg text-sm text-muted-foreground">{meta[category].desc}</p></div>
			<Field.FieldGroup class="w-full lg:w-72">
				<Field.Field>
					<Field.Label for="report-search">{s.searchLabel}</Field.Label>
					<div class="relative"><Search size={16} class="absolute top-1/2 left-3 -translate-y-1/2 text-muted-foreground" /><Input id="report-search" bind:value={query} placeholder={s.searchPh} class="pl-9" /></div>
				</Field.Field>
			</Field.FieldGroup>
		</Card.Header>
		<Card.Content>
			<Tabs.Root value={category} onValueChange={(v) => (category = v as Category)}>
				<Tabs.List class="flex-wrap"><Tabs.Trigger value="all">{s.tabAll}</Tabs.Trigger><Tabs.Trigger value="calls">{s.tabCalls}</Tabs.Trigger><Tabs.Trigger value="tickets">{s.tabTickets}</Tabs.Trigger><Tabs.Trigger value="wallboards">{s.tabWall}</Tabs.Trigger><Tabs.Trigger value="omni">{s.tabOmni}</Tabs.Trigger></Tabs.List>
			</Tabs.Root>
			<div class="mt-4 flex flex-col gap-8">
				{#each visibleGroups as group (group.id)}
					{@const cards = group.cards.filter(matches)}
					<section aria-label={group.label}>
						<div class="mb-4 flex items-center gap-3">
							<Badge variant="secondary"><group.icon size={13} />{group.label}</Badge>
							<Separator class="flex-1" />
							<span class="text-xs text-muted-foreground">{cards.length} {s.unit}</span>
						</div>
						{#if cards.length > 0}
							<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
								{#each cards as card}
									<Card.Root class="transition-shadow hover:shadow-md">
										<Card.Header class="flex-row items-center gap-3">
											<div class="flex size-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
												{#if group.id === 'calls'}<PhoneCall size={18} />{:else if group.id === 'tickets'}<Ticket size={18} />{:else if group.id === 'wallboards'}<Tv size={18} />{:else}<Send size={18} />{/if}
											</div>
											<div class="min-w-0"><Card.Title class="truncate text-base">{card.title}</Card.Title><p class="truncate text-xs text-muted-foreground">{card.desc}</p></div>
										</Card.Header>
										<Card.Content><Button href={card.to} size="sm" variant="secondary" class="w-full">{s.open}<ArrowUpRight data-icon="inline-end" /></Button></Card.Content>
									</Card.Root>
								{/each}
							</div>
						{:else}
							<Empty.Root class="border border-dashed">
								<Empty.Header><Empty.Media><FolderOpen size={20} /></Empty.Media><Empty.Title>{s.emptyT}</Empty.Title><Empty.Description>{s.emptyPre} “{query}” {s.emptyMid} {group.label}.</Empty.Description></Empty.Header>
							</Empty.Root>
						{/if}
					</section>
				{/each}
				{#if totalVisible === 0}
					<Empty.Root class="border border-dashed">
						<Empty.Header><Empty.Media><Inbox size={20} /></Empty.Media><Empty.Title>{s.allEmptyT}</Empty.Title><Empty.Description>{s.allEmptyD}</Empty.Description></Empty.Header>
						<Empty.Content><Button size="sm" variant="outline" onclick={() => { query = ''; category = 'all'; }}>{s.reset}</Button></Empty.Content>
					</Empty.Root>
				{/if}
			</div>
			<div class="mt-6 flex items-center gap-2 text-xs text-muted-foreground"><Star size={14} /><MessageSquareText size={14} /><Mail size={14} /><Users size={14} /><span>{s.scPre} <a class="underline" href="/report/csat">/report/csat</a>{s.scMid} <a class="underline" href="/report/csat-interaction">/report/csat-interaction</a>.</span></div>
		</Card.Content>
	</Card.Root>
</div>
