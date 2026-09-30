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

	type Category = 'all' | 'calls' | 'tickets' | 'wallboards' | 'omni';
	let category = $state<Category>('all');
	let query = $state('');

	const meta: Record<Category, { title: string; desc: string }> = {
		all: { title: 'Reports Hub', desc: 'Akses terpusat data, analitik real-time, dan metrik performa operasional semua kanal.' },
		calls: { title: 'Call Center Analytics', desc: 'Monitoring transaksi PBX inbound/outbound dan produktivitas agent.' },
		tickets: { title: 'Support & Ticketing', desc: 'Rekap lifecycle tiket, performa tim, dan benchmark resolusi.' },
		wallboards: { title: 'Monitoring Wallboards', desc: 'Monitoring visual real-time untuk operation center dan pimpinan.' },
		omni: { title: 'Omnichannel & Blast', desc: 'Statistik kanal chat terintegrasi dan riwayat blast massal.' }
	};

	const groups = [
		{ id: 'calls' as const, label: 'Call Analytics', icon: PhoneCall, cards: [
			{ title: 'Call Report', desc: 'Log transaksi dialer', to: '/report/csat', keys: 'call report dialer' },
			{ title: 'Daily Report', desc: 'Metrik ringkasan harian', to: '/report/csat', keys: 'daily update summary' },
			{ title: 'Agent AHT', desc: 'Pelacakan produktivitas', to: '/agent/performance', keys: 'agent aht productivity tracking' },
			{ title: 'Agent Login', desc: 'Aktivitas login & logout', to: '/agent-schedule', keys: 'agent login logout activity' },
			{ title: 'CSAT Report', desc: 'Survei kepuasan pelanggan', to: '/report/csat', keys: 'csat customer satisfaction survey' }
		]},
		{ id: 'tickets' as const, label: 'Ticketing & CS', icon: Ticket, cards: [
			{ title: 'Ticketing Summary', desc: 'Distribusi status tiket', to: '/ticketing', keys: 'ticketing summary lifecycle' },
			{ title: 'CS Performance', desc: 'Metrik tim support', to: '/agent/performance', keys: 'cs performance team metrics support' },
			{ title: 'AI Agent Performance', desc: 'Skor analisis rekaman', to: '/agent/performance', keys: 'ai agent performance recording kirana analysis score' },
			{ title: 'CSAT Interaction', desc: 'Rating per interaksi & agent', to: '/report/csat-interaction', keys: 'csat interaction rating agent' }
		]},
		{ id: 'wallboards' as const, label: 'Live Wallboards', icon: Tv, cards: [
			{ title: 'Wallboard AHU', desc: 'Traffic real-time', to: '/spv', keys: 'wallboard ahu live traffic' },
			{ title: 'Wallboard Pimpinan', desc: 'Traffic real-time', to: '/spv', keys: 'wallboard pimpinan' },
			{ title: 'Wallboard Agent', desc: 'Traffic real-time', to: '/spv', keys: 'wallboard agent' }
		]},
		{ id: 'omni' as const, label: 'Omni Blast', icon: Send, cards: [
			{ title: 'Outbound Blast Dashboard', desc: 'KPI & analitik blast', to: '/settings', keys: 'outbound blast dashboard analytics whatsapp email campaign' },
			{ title: 'Blast History', desc: 'Log audit broadcast', to: '/email/history', keys: 'blast history audit logs campaign' },
			{ title: 'Email Templates', desc: 'Kelola template email', to: '/email/templates', keys: 'email templates compose' }
		]}
	];

	const visibleGroups = $derived(groups.filter((g) => category === 'all' || g.id === category));
	function matches(card: { title: string; desc: string; keys: string }) {
		const q = query.trim().toLowerCase();
		if (!q) return true;
		return `${card.title} ${card.desc} ${card.keys}`.toLowerCase().includes(q);
	}
	const totalVisible = $derived(visibleGroups.reduce((n, g) => n + g.cards.filter(matches).length, 0));
	const cats = [
		{ id: 'all' as Category, label: 'All Reports', desc: 'Complete data overview', icon: LayoutGrid },
		{ id: 'calls' as Category, label: 'Call Analytics', desc: 'Telephony metrics', icon: PhoneCall },
		{ id: 'tickets' as Category, label: 'Ticketing & CS', desc: 'Support productivity', icon: Ticket },
		{ id: 'wallboards' as Category, label: 'Live Wallboards', desc: 'Real-time monitoring', icon: Tv },
		{ id: 'omni' as Category, label: 'Omni Blast', desc: 'Multi-channel messaging', icon: Send }
	];
</script>

<svelte:head><title>Reports Hub — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6 lg:flex-row">
	<Card.Root class="w-full shrink-0 lg:w-80">
		<Card.Header>
			<div class="flex items-center gap-3">
				<div class="flex size-10 items-center justify-center rounded-xl bg-primary text-primary-foreground"><ChartColumn size={19} /></div>
				<div><Card.Title>Reports Hub</Card.Title><p class="text-xs font-medium tracking-wider text-primary uppercase">Analytics v3.0</p></div>
			</div>
		</Card.Header>
		<Card.Content class="flex flex-col gap-1">
			<p class="px-2 text-[0.65rem] font-bold tracking-widest text-muted-foreground uppercase">Categories</p>
			{#each cats as c}
				<button type="button" onclick={() => (category = c.id)} class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition-colors {category === c.id ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-foreground'}">
					<c.icon size={20} class="mt-0.5 shrink-0" />
					<span><span class="block text-sm font-medium">{c.label}</span><span class="block text-xs opacity-70">{c.desc}</span></span>
				</button>
			{/each}
			<Separator class="my-2" />
			<div class="flex flex-col gap-2 rounded-xl bg-muted/40 p-3 text-xs text-muted-foreground">
				<div class="flex justify-between"><span>Total laporan</span><span class="font-semibold text-foreground">{totalVisible}</span></div>
				<Progress value={Math.min(100, totalVisible * 8)} />
				<span>Kategori aktif: <span class="font-medium text-foreground">{meta[category].title}</span></span>
			</div>
		</Card.Content>
	</Card.Root>

	<Card.Root class="flex-1">
		<Card.Header class="flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
			<div><Card.Title class="text-2xl">{meta[category].title}</Card.Title><p class="mt-1 max-w-lg text-sm text-muted-foreground">{meta[category].desc}</p></div>
			<Field.FieldGroup class="w-full lg:w-72">
				<Field.Field>
					<Field.Label for="report-search">Cari laporan</Field.Label>
					<div class="relative"><Search size={16} class="absolute top-1/2 left-3 -translate-y-1/2 text-muted-foreground" /><Input id="report-search" bind:value={query} placeholder="Search reports…" class="pl-9" /></div>
				</Field.Field>
			</Field.FieldGroup>
		</Card.Header>
		<Card.Content>
			<Tabs.Root value={category} onValueChange={(v) => (category = v as Category)}>
				<Tabs.List class="flex-wrap"><Tabs.Trigger value="all">Semua</Tabs.Trigger><Tabs.Trigger value="calls">Call</Tabs.Trigger><Tabs.Trigger value="tickets">Ticketing</Tabs.Trigger><Tabs.Trigger value="wallboards">Wallboard</Tabs.Trigger><Tabs.Trigger value="omni">Omni</Tabs.Trigger></Tabs.List>
			</Tabs.Root>
			<div class="mt-4 flex flex-col gap-8">
				{#each visibleGroups as group (group.id)}
					{@const cards = group.cards.filter(matches)}
					<section aria-label={group.label}>
						<div class="mb-4 flex items-center gap-3">
							<Badge variant="secondary"><group.icon size={13} />{group.label}</Badge>
							<Separator class="flex-1" />
							<span class="text-xs text-muted-foreground">{cards.length} laporan</span>
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
										<Card.Content><Button href={card.to} size="sm" variant="secondary" class="w-full">Buka laporan<ArrowUpRight data-icon="inline-end" /></Button></Card.Content>
									</Card.Root>
								{/each}
							</div>
						{:else}
							<Empty.Root class="border border-dashed">
								<Empty.Header><Empty.Media><FolderOpen size={20} /></Empty.Media><Empty.Title>Tidak ada laporan</Empty.Title><Empty.Description>Tidak ada laporan “{query}” pada kategori {group.label}.</Empty.Description></Empty.Header>
							</Empty.Root>
						{/if}
					</section>
				{/each}
				{#if totalVisible === 0}
					<Empty.Root class="border border-dashed">
						<Empty.Header><Empty.Media><Inbox size={20} /></Empty.Media><Empty.Title>Semua filter kosong</Empty.Title><Empty.Description>Ubah kata kunci atau kategori untuk melihat laporan.</Empty.Description></Empty.Header>
						<Empty.Content><Button size="sm" variant="outline" onclick={() => { query = ''; category = 'all'; }}>Reset filter</Button></Empty.Content>
					</Empty.Root>
				{/if}
			</div>
			<div class="mt-6 flex items-center gap-2 text-xs text-muted-foreground"><Star size={14} /><MessageSquareText size={14} /><Mail size={14} /><Users size={14} /><span>Pintasan: CSAT di <a class="underline" href="/report/csat">/report/csat</a>, interaksi di <a class="underline" href="/report/csat-interaction">/report/csat-interaction</a>.</span></div>
		</Card.Content>
	</Card.Root>
</div>
