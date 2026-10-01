<script lang="ts">
	import { page } from "$app/state";
	import { goto } from "$app/navigation";
	import { onMount } from "svelte";
	import { darkMode, toggleTheme, initTheme } from "$lib/theme";
	import * as Sidebar from "$lib/components/ui/sidebar";
	import * as Collapsible from "$lib/components/ui/collapsible";
	import * as DropdownMenu from "$lib/components/ui/dropdown-menu";
	import * as Popover from "$lib/components/ui/popover";
	import * as Avatar from "$lib/components/ui/avatar";
	import * as InputGroup from "$lib/components/ui/input-group";
	import { Badge } from "$lib/components/ui/badge";
	import { Button } from "$lib/components/ui/button";
	import { Separator } from "$lib/components/ui/separator";
	import { ScrollArea } from "$lib/components/ui/scroll-area";
	import { Switch } from "$lib/components/ui/switch";
	import { Toaster } from "$lib/components/ui/sonner";
	import { toast } from "svelte-sonner";
	import { locale, initLocale, setLocale, locales, type Locale } from "$lib/i18n";
	import { get } from "svelte/store";
	import {
		House, LayoutDashboard, MessagesSquare, Ticket, TicketCheck, MessagesSquare as ThreadsIcon,
		Star, Mail, PenSquare, Inbox, Send, FileEdit, LayoutTemplate, History,
		MonitorDot, Radio, PhoneCall, Archive, Radar, ChartColumn, Settings,
		CalendarClock, CalendarDays, CalendarRange, Clock, Sun, Moon, Search, Bell,
		ChevronDown, LogOut, Gauge, Trophy, LayoutGrid, Tv, Globe
	} from "lucide-svelte";
	import "../app.css";

	type Sub = { key: string; to: string; icon: typeof Mail };
	type Parent = { key: string; icon: typeof Mail; subs: Sub[] };
	type Single = { key: string; to: string; icon: typeof Mail };

	const parents: Parent[] = [
		{
			key: "home", icon: House,
			subs: [
				{ key: "overview", to: "/home", icon: LayoutGrid },
				{ key: "agentPerf", to: "/agent/performance", icon: Trophy },
				{ key: "agentProd", to: "/agent-productivity-dashboard", icon: Gauge }
			]
		},
		{
			key: "dashboard", icon: LayoutDashboard,
			subs: [
				{ key: "ticket", to: "/chat/v3/ticket/result", icon: TicketCheck },
				{ key: "threads", to: "/threads", icon: ThreadsIcon },
				{ key: "csat", to: "/report/csat", icon: Star },
				{ key: "wallboard", to: "/wallboard", icon: Tv }
			]
		},
		{
			key: "workspace", icon: MessagesSquare,
			subs: [
				{ key: "omnichat", to: "/chat/v3", icon: MessagesSquare },
				{ key: "ticketing", to: "/ticketing", icon: Ticket }
			]
		},
		{
			key: "email", icon: Mail,
			subs: [
				{ key: "compose", to: "/email/compose", icon: PenSquare },
				{ key: "inbox", to: "/email", icon: Inbox },
				{ key: "sent", to: "/email/send", icon: Send },
				{ key: "draft", to: "/email", icon: FileEdit },
				{ key: "templates", to: "/email/templates", icon: LayoutTemplate },
				{ key: "history", to: "/email/history", icon: History }
			]
		},
		{
			key: "monitoring", icon: MonitorDot,
			subs: [
				{ key: "channel", to: "/spv", icon: Radio },
				{ key: "recording", to: "/recordings", icon: PhoneCall },
				{ key: "archive", to: "/recording-archive", icon: Archive },
				{ key: "kirana", to: "/chat/v3/ticket/kirana-monitoring", icon: Radar }
			]
		},
		{
			key: "scheduling", icon: CalendarClock,
			subs: [
				{ key: "schedule", to: "/agent-schedule", icon: CalendarDays },
				{ key: "workCal", to: "/work-calendar", icon: CalendarRange },
				{ key: "opHours", to: "/operational-hours", icon: Clock }
			]
		}
	];

	const MENU_STR: Record<string, Record<Locale, string>> = {
		home: { id: "Home", en: "Home", th: "หน้าแรก", tl: "Home" },
		overview: { id: "Overview", en: "Overview", th: "ภาพรวม", tl: "Pangkalahatan" },
		agentPerf: { id: "Agent Performance", en: "Agent Performance", th: "ประสิทธิภาพเอเจนต์", tl: "Performance ng Agent" },
		agentProd: { id: "Agent Productivity", en: "Agent Productivity", th: "ผลิตภาพเอเจนต์", tl: "Produktibidad ng Agent" },
		dashboard: { id: "Dashboard", en: "Dashboard", th: "แดชบอร์ด", tl: "Dashboard" },
		ticket: { id: "Ticket", en: "Ticket", th: "ตั๋วงาน", tl: "Ticket" },
		threads: { id: "Threads", en: "Threads", th: "เธรด", tl: "Threads" },
		csat: { id: "CSAT", en: "CSAT", th: "CSAT", tl: "CSAT" },
		wallboard: { id: "Wallboard", en: "Wallboard", th: "วอลล์บอร์ด", tl: "Wallboard" },
		workspace: { id: "Workspace", en: "Workspace", th: "พื้นที่ทำงาน", tl: "Workspace" },
		omnichat: { id: "Omnichat", en: "Omnichat", th: "ออมนิแชต", tl: "Omnichat" },
		ticketing: { id: "Ticketing", en: "Ticketing", th: "ตั๋วงาน", tl: "Ticketing" },
		email: { id: "Email", en: "Email", th: "อีเมล", tl: "Email" },
		compose: { id: "Compose", en: "Compose", th: "เขียน", tl: "Sumulat" },
		inbox: { id: "Inbox", en: "Inbox", th: "กล่องขาเข้า", tl: "Inbox" },
		sent: { id: "Sent", en: "Sent", th: "ส่งแล้ว", tl: "Naipadala" },
		draft: { id: "Draft", en: "Draft", th: "แบบร่าง", tl: "Draft" },
		templates: { id: "Templates", en: "Templates", th: "เทมเพลต", tl: "Mga Template" },
		history: { id: "History", en: "History", th: "ประวัติ", tl: "Kasaysayan" },
		monitoring: { id: "Monitoring", en: "Monitoring", th: "มอนิเตอร์", tl: "Monitoring" },
		channel: { id: "Channel Interaction", en: "Channel Interaction", th: "ปฏิสัมพันธ์ช่องทาง", tl: "Interaksyon ng Channel" },
		recording: { id: "Call Recording", en: "Call Recording", th: "บันทึกการโทร", tl: "Recording ng Tawag" },
		archive: { id: "Recording Archive", en: "Recording Archive", th: "คลังบันทึก", tl: "Archive ng Recording" },
		kirana: { id: "Kirana Monitoring", en: "Kirana Monitoring", th: "มอนิเตอร์ Kirana", tl: "Monitoring ng Kirana" },
		scheduling: { id: "Scheduling", en: "Scheduling", th: "ตารางงาน", tl: "Iskedyul" },
		schedule: { id: "Agent Schedule", en: "Agent Schedule", th: "ตารางเอเจนต์", tl: "Iskedyul ng Agent" },
		workCal: { id: "Work Calendar", en: "Work Calendar", th: "ปฏิทินงาน", tl: "Kalendaryo ng Trabaho" },
		opHours: { id: "Operational Hours", en: "Operational Hours", th: "เวลาทำการ", tl: "Oras ng Operasyon" },
		report: { id: "Report", en: "Report", th: "รายงาน", tl: "Ulat" },
		settings: { id: "Settings", en: "Settings", th: "ตั้งค่า", tl: "Mga Setting" }
	};
	const menuLabel = (key: string, l: Locale) => MENU_STR[key]?.[l] ?? key;

	const bottom: Single[] = [
		{ key: "report", to: "/report", icon: ChartColumn },
		{ key: "settings", to: "/settings", icon: Settings }
	];

	const CHROME = {
		id: {
			search: "Cari threads, tiket, email...",
			notif: "Notifikasi", notifDesc: "Kelola pemberitahuan perangkat ini.",
			notifOn: "Aktif", notifOff: "Mati",
			notifEnabledMsg: "Notifikasi diaktifkan", notifDisabledMsg: "Notifikasi dimatikan",
			notifEmpty: "Notifikasi dimatikan — tidak ada pemberitahuan baru.",
			notifA: "menunggu assignment", notifB: "antre di omnichat", notifC: "CSAT minggu ini naik 2,1%",
			tickets: "tiket", chats: "chat",
			auxLabel: "Status kehadiran", auxHeading: "Status kehadiran",
			auxOnline: "Online", auxAux: "Aux — Istirahat", auxOffline: "Offline",
			light: "Gunakan mode terang", dark: "Gunakan mode gelap",
			operator: "Operator", cs: "Customer service", team: "Customer service team",
			language: "Bahasa", profile: "Menu profil", logout: "Keluar"
		},
		en: {
			search: "Search threads, tickets, emails...",
			notif: "Notifications", notifDesc: "Manage notifications on this device.",
			notifOn: "On", notifOff: "Off",
			notifEnabledMsg: "Notifications enabled", notifDisabledMsg: "Notifications disabled",
			notifEmpty: "Notifications are off — no new alerts.",
			notifA: "awaiting assignment", notifB: "queued in omnichat", notifC: "CSAT up 2.1% this week",
			tickets: "tickets", chats: "chats",
			auxLabel: "Presence status", auxHeading: "Presence status",
			auxOnline: "Online", auxAux: "Aux — Break", auxOffline: "Offline",
			light: "Use light mode", dark: "Use dark mode",
			operator: "Operator", cs: "Customer service", team: "Customer service team",
			language: "Language", profile: "Profile menu", logout: "Log out"
		},
		th: {
			search: "ค้นหาเธรด ตั๋วงาน อีเมล...",
			notif: "การแจ้งเตือน", notifDesc: "จัดการการแจ้งเตือนบนอุปกรณ์นี้",
			notifOn: "เปิด", notifOff: "ปิด",
			notifEnabledMsg: "เปิดการแจ้งเตือนแล้ว", notifDisabledMsg: "ปิดการแจ้งเตือนแล้ว",
			notifEmpty: "ปิดการแจ้งเตือนแล้ว — ไม่มีการแจ้งใหม่",
			notifA: "รอการมอบหมาย", notifB: "รอคิวในออมนิแชต", notifC: "CSAT สัปดาห์นี้ขึ้น 2.1%",
			tickets: "ตั๋วงาน", chats: "แชต",
			auxLabel: "สถานะการทำงาน", auxHeading: "สถานะการทำงาน",
			auxOnline: "ออนไลน์", auxAux: "พัก (Aux)", auxOffline: "ออฟไลน์",
			light: "ใช้โหมดสว่าง", dark: "ใช้โหมดมืด",
			operator: "โอเปอเรเตอร์", cs: "บริการลูกค้า", team: "ทีมบริการลูกค้า",
			language: "ภาษา", profile: "เมนูโปรไฟล์", logout: "ออกจากระบบ"
		},
		tl: {
			search: "Maghanap ng threads, ticket, email...",
			notif: "Mga Notification", notifDesc: "Pamahalaan ang mga notification sa device na ito.",
			notifOn: "Bukas", notifOff: "Patay",
			notifEnabledMsg: "Binuksan ang notification", notifDisabledMsg: "Pinatay ang notification",
			notifEmpty: "Patay ang notification — walang bagong abiso.",
			notifA: "naghihintay ng assignment", notifB: "nakapila sa omnichat", notifC: "Tumaas ng 2.1% ang CSAT ngayong linggo",
			tickets: "ticket", chats: "chat",
			auxLabel: "Status ng presensya", auxHeading: "Status ng presensya",
			auxOnline: "Online", auxAux: "Aux — Pahinga", auxOffline: "Offline",
			light: "Gamitin ang light mode", dark: "Gamitin ang dark mode",
			operator: "Operator", cs: "Customer service", team: "Customer service team",
			language: "Wika", profile: "Menu ng profile", logout: "Umalis"
		}
	} as const;
	let chrome = $derived(CHROME[$locale]);

	let { children } = $props();
	let sidebarOpen = $state(true);
	let searchQuery = $state("");
	let openState = $state<Record<string, boolean>>({
		home: true, dashboard: true, workspace: true, email: true, monitoring: true, scheduling: true
	});
	let notifEnabled = $state(true);
	type AuxStatus = "online" | "aux" | "offline";
	let auxStatus = $state<AuxStatus>("online");
	let now = $state(new Date());

	const auxMeta: Record<AuxStatus, { label: string; dot: string }> = {
		online: { label: "Online", dot: "bg-emerald-500" },
		aux: { label: "Aux", dot: "bg-amber-500" },
		offline: { label: "Offline", dot: "bg-muted-foreground" }
	};

	const dateFmt = (l: Locale) => new Intl.DateTimeFormat(l === "id" ? "id-ID" : l === "en" ? "en-US" : l === "th" ? "th-TH" : "fil-PH", { weekday: "short", day: "2-digit", month: "short", year: "numeric" });
	const timeFmt = (l: Locale) => new Intl.DateTimeFormat(l === "id" ? "id-ID" : l === "en" ? "en-US" : l === "th" ? "th-TH" : "fil-PH", { hour: "2-digit", minute: "2-digit", second: "2-digit" });

	onMount(() => {
		initTheme();
		initLocale();
		const t = setInterval(() => (now = new Date()), 1000);
		try {
			sidebarOpen = localStorage.getItem("dk-sidebar") !== "1";
			if (localStorage.getItem("dk-notif") === "0") notifEnabled = false;
			const s = localStorage.getItem("dk-aux");
			if (s === "aux" || s === "offline" || s === "online") auxStatus = s;
		} catch { /* storage unavailable */ }
		return () => clearInterval(t);
	});

	function setNotif(v: boolean) {
		notifEnabled = v;
		const c = CHROME[get(locale)];
		try {
			localStorage.setItem("dk-notif", v ? "1" : "0");
		} catch { /* ignore */ }
		toast.success(v ? c.notifEnabledMsg : c.notifDisabledMsg);
	}

	function setAux(s: AuxStatus) {
		auxStatus = s;
		const c = CHROME[get(locale)];
		const label = s === "online" ? c.auxOnline : s === "aux" ? c.auxAux : c.auxOffline;
		try {
			localStorage.setItem("dk-aux", s);
		} catch { /* ignore */ }
		toast.success(`Status: ${label}`);
	}

	function updateSidebar(open: boolean) {
		sidebarOpen = open;
		try {
			localStorage.setItem("dk-sidebar", open ? "0" : "1");
		} catch { /* storage unavailable */ }
	}

	function isActive(to: string) {
		const path = page.url.pathname;
		if (to === "/home") return path === "/home" || path === "/";
		return path === to || path.startsWith(to + "/");
	}

	function isParentActive(p: Parent) {
		return p.subs.some((s) => isActive(s.to));
	}

	function submitSearch(event: KeyboardEvent) {
		if (event.key === "Enter" && searchQuery.trim()) {
			goto(`/threads?q=${encodeURIComponent(searchQuery.trim())}`);
		}
	}

	const pageTitles: Record<string, string> = {
		"/home": "Home",
		"/agent/performance": "Agent Performance",
		"/agent-productivity-dashboard": "Agent Productivity",
		"/chat/v3/ticket/result": "Ticket",
		"/threads": "Threads",
		"/report/csat": "CSAT",
		"/chat/v3": "Omnichat",
		"/ticketing": "Ticketing",
		"/email/compose": "Compose",
		"/email": "Email",
		"/email/send": "Sent",
		"/email/templates": "Templates",
		"/email/history": "History",
		"/spv": "Channel Interaction",
		"/recordings": "Call Recording",
		"/recording-archive": "Recording Archive",
		"/chat/v3/ticket/kirana-monitoring": "Kirana Monitoring",
		"/report": "Report",
		"/settings": "Settings",
		"/agent-schedule": "Agent Schedule",
		"/work-calendar": "Work Calendar",
		"/operational-hours": "Operational Hours",
		"/wallboard": "Wallboard"
	};
	let pageTitle = $derived(pageTitles[page.url.pathname] ?? "DK CRM");
	let isWallboard = $derived(page.url.pathname === "/wallboard");
</script>

{#if isWallboard}
	<div class="min-h-svh bg-slate-950 text-slate-100">
		<Toaster position="top-right" />
		{@render children()}
	</div>
{:else}
<Sidebar.Provider bind:open={sidebarOpen} onOpenChange={updateSidebar} class="min-h-svh bg-background text-foreground">
	<Sidebar.Root collapsible="icon" variant="sidebar">
		<Sidebar.Header>
			<Sidebar.Menu>
				<Sidebar.MenuItem>
					<Sidebar.MenuButton size="lg" tooltipContent="DK CRM">
						{#snippet child({ props })}
							<a href="/home" {...props} aria-label="DK CRM Home">
								<img src="/favicon.svg" alt="Logo DK CRM" class="size-8 shrink-0 rounded-md" />
								<span class="flex flex-col gap-0.5 leading-none">
									<span class="font-semibold">DK CRM</span>
									<span class="text-xs text-muted-foreground">Contact Center</span>
								</span>
							</a>
						{/snippet}
					</Sidebar.MenuButton>
				</Sidebar.MenuItem>
			</Sidebar.Menu>
		</Sidebar.Header>
		<Sidebar.Separator />
		<Sidebar.Content>
			<ScrollArea class="h-full">
				<Sidebar.Group>
					<Sidebar.GroupContent>
						<Sidebar.Menu>
							{#each parents as parent (parent.key)}
								<Collapsible.Root bind:open={openState[parent.key]} class="group/collapsible">
									<Sidebar.MenuItem>
										<Collapsible.Trigger>
											{#snippet child({ props })}
												<Sidebar.MenuButton
													{...props}
													isActive={isParentActive(parent)}
													tooltipContent={menuLabel(parent.key, $locale)}
												>
													<parent.icon data-icon="true" />
													<span>{menuLabel(parent.key, $locale)}</span>
													<ChevronDown data-icon="true" class="ms-auto transition-transform group-data-[state=open]/collapsible:rotate-180" />
												</Sidebar.MenuButton>
											{/snippet}
										</Collapsible.Trigger>
										<Collapsible.Content>
											<Sidebar.MenuSub>
												{#each parent.subs as sub (sub.key)}
													<Sidebar.MenuSubItem>
														<Sidebar.MenuSubButton href={sub.to} isActive={isActive(sub.to)}>
															<sub.icon data-icon="true" />
															<span>{menuLabel(sub.key, $locale)}</span>
														</Sidebar.MenuSubButton>
													</Sidebar.MenuSubItem>
												{/each}
											</Sidebar.MenuSub>
										</Collapsible.Content>
									</Sidebar.MenuItem>
								</Collapsible.Root>
							{/each}
							{#each bottom as link (link.key)}
								<Sidebar.MenuItem>
									<Sidebar.MenuButton isActive={isActive(link.to)} tooltipContent={menuLabel(link.key, $locale)}>
										{#snippet child({ props })}
											<a href={link.to} {...props} aria-current={isActive(link.to) ? "page" : undefined}>
												<link.icon data-icon="true" />
												<span>{menuLabel(link.key, $locale)}</span>
											</a>
										{/snippet}
									</Sidebar.MenuButton>
								</Sidebar.MenuItem>
							{/each}
						</Sidebar.Menu>
					</Sidebar.GroupContent>
				</Sidebar.Group>
			</ScrollArea>
		</Sidebar.Content>
		<Sidebar.Rail />
	</Sidebar.Root>

	<Sidebar.Inset class="min-h-svh min-w-0 overflow-hidden">
		<header class="flex h-16 shrink-0 items-center gap-3 border-b border-border/80 bg-card/95 px-4 backdrop-blur md:px-6">
			<Sidebar.Trigger aria-label="Buka atau ciutkan sidebar" />
			<div class="flex min-w-0 flex-col gap-0.5 leading-none">
				<h1 class="truncate text-lg font-semibold tracking-tight md:text-xl">{pageTitle}</h1>
				<p class="hidden text-xs text-muted-foreground tabular-nums sm:block" aria-live="off">
					{dateFmt($locale).format(now)} • {timeFmt($locale).format(now)}
				</p>
			</div>
			<div class="ms-auto flex items-center gap-1.5">
				<InputGroup.Root class="hidden w-full max-w-xs sm:flex lg:max-w-sm">
					<InputGroup.Addon><Search data-icon="true" /></InputGroup.Addon>
					<InputGroup.Input
						bind:value={searchQuery}
						onkeydown={submitSearch}
						placeholder={chrome.search}
						aria-label={chrome.search}
					/>
				</InputGroup.Root>
				<Separator orientation="vertical" class="mx-1 hidden h-7 md:block" />
				<DropdownMenu.Root>
					<DropdownMenu.Trigger aria-label={chrome.language}>
						{#snippet child({ props })}
							<span {...props} class="inline-flex cursor-pointer items-center gap-1 rounded-lg p-2 text-xs font-semibold text-muted-foreground uppercase hover:bg-accent hover:text-foreground">
								<Globe data-icon="true" />
								{$locale}
							</span>
						{/snippet}
					</DropdownMenu.Trigger>
					<DropdownMenu.Content align="end" class="w-44">
						<DropdownMenu.Group>
							<DropdownMenu.GroupHeading>{chrome.language}</DropdownMenu.GroupHeading>
							{#each locales as l (l.id)}
								<DropdownMenu.Item onclick={() => setLocale(l.id)}>
									<span class={l.id === $locale ? "font-semibold" : ""}>{l.label}</span>
									{#if l.id === $locale}<span class="ms-auto text-xs">✓</span>{/if}
								</DropdownMenu.Item>
							{/each}
						</DropdownMenu.Group>
					</DropdownMenu.Content>
				</DropdownMenu.Root>
				<Popover.Root>
					<Popover.Trigger aria-label={chrome.notif}>
						{#snippet child({ props })}
							<span {...props} class="relative inline-flex cursor-pointer rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground">
								<Bell data-icon="true" />
								{#if notifEnabled}<Badge class="absolute -top-0.5 -right-0.5 h-4 min-w-4 px-1 text-[10px]">3</Badge>{/if}
							</span>
						{/snippet}
					</Popover.Trigger>
					<Popover.Content align="end" class="w-72">
						<Popover.Title class="text-sm font-semibold">{chrome.notif}</Popover.Title>
						<Popover.Description class="text-xs">{chrome.notifDesc}</Popover.Description>
						<div class="flex items-center justify-between gap-2 rounded-lg bg-muted/50 px-2.5 py-2">
							<span class="text-xs font-medium">{notifEnabled ? chrome.notifOn : chrome.notifOff}</span>
							<Switch checked={notifEnabled} onCheckedChange={setNotif} aria-label={chrome.notif} />
						</div>
						<Separator />
						{#if notifEnabled}
							<div class="flex flex-col gap-2 text-sm">
								<p><span class="font-medium">5 {chrome.tickets}</span> {chrome.notifA}</p>
								<p><span class="font-medium">12 {chrome.chats}</span> {chrome.notifB}</p>
								<p class="text-muted-foreground">{chrome.notifC}</p>
							</div>
						{:else}
							<p class="text-xs text-muted-foreground">{chrome.notifEmpty}</p>
						{/if}
					</Popover.Content>
				</Popover.Root>
				<DropdownMenu.Root>
					<DropdownMenu.Trigger aria-label={chrome.auxLabel}>
						{#snippet child({ props })}
							<Button {...props} variant="outline" size="sm" class="gap-2">
								<span class="size-2 rounded-full {auxMeta[auxStatus].dot}" aria-hidden="true"></span>
								{auxStatus === "online" ? chrome.auxOnline : auxStatus === "aux" ? chrome.auxAux : chrome.auxOffline}
								<ChevronDown data-icon="true" />
							</Button>
						{/snippet}
					</DropdownMenu.Trigger>
					<DropdownMenu.Content align="end" class="w-52">
						<DropdownMenu.Group>
							<DropdownMenu.GroupHeading>{chrome.auxHeading}</DropdownMenu.GroupHeading>
							<DropdownMenu.Item onclick={() => setAux("online")}>
								<span class="size-2 rounded-full bg-emerald-500" aria-hidden="true"></span>{chrome.auxOnline}
							</DropdownMenu.Item>
							<DropdownMenu.Item onclick={() => setAux("aux")}>
								<span class="size-2 rounded-full bg-amber-500" aria-hidden="true"></span>{chrome.auxAux}
							</DropdownMenu.Item>
							<DropdownMenu.Item onclick={() => setAux("offline")}>
								<span class="size-2 rounded-full bg-muted-foreground" aria-hidden="true"></span>{chrome.auxOffline}
							</DropdownMenu.Item>
						</DropdownMenu.Group>
					</DropdownMenu.Content>
				</DropdownMenu.Root>
				<button
					type="button"
					onclick={toggleTheme}
					class="rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground"
					aria-label={$darkMode ? chrome.light : chrome.dark}
				>
					{#if $darkMode}<Sun data-icon="true" />{:else}<Moon data-icon="true" />{/if}
				</button>
				<Separator orientation="vertical" class="mx-1 hidden h-7 sm:block" />
				<DropdownMenu.Root>
					<DropdownMenu.Trigger aria-label={chrome.profile}>
						{#snippet child({ props })}
							<span {...props} class="flex cursor-pointer items-center gap-2 rounded-lg px-1.5 py-1.5 hover:bg-accent">
								<Avatar.Root class="size-8">
									<Avatar.Fallback>OP</Avatar.Fallback>
								</Avatar.Root>
								<span class="hidden text-left md:block">
									<span class="block text-xs font-semibold">{chrome.operator}</span>
									<span class="flex items-center gap-1 text-[10px] text-muted-foreground">
										<span class="size-1.5 rounded-full {auxMeta[auxStatus].dot}" aria-hidden="true"></span>{auxStatus === "online" ? chrome.auxOnline : auxStatus === "aux" ? chrome.auxAux : chrome.auxOffline}
									</span>
								</span>
							</span>
						{/snippet}
					</DropdownMenu.Trigger>
					<DropdownMenu.Content align="end" class="w-56">
						<DropdownMenu.Label>
							<span class="block font-semibold">{chrome.operator}</span>
							<span class="text-xs text-muted-foreground">{chrome.team}</span>
						</DropdownMenu.Label>
						<DropdownMenu.Separator />
						<DropdownMenu.Item onclick={() => goto("/settings")}><Settings data-icon="true" />{menuLabel("settings", $locale)}</DropdownMenu.Item>
						<DropdownMenu.Item variant="destructive"><LogOut data-icon="true" />{chrome.logout}</DropdownMenu.Item>
					</DropdownMenu.Content>
				</DropdownMenu.Root>
			</div>
		</header>
		<main class="min-h-0 min-w-0 flex-1 overflow-y-auto bg-background p-4 md:p-6">
			<Toaster position="top-right" />
			{@render children()}
		</main>
	</Sidebar.Inset>
</Sidebar.Provider>
{/if}
