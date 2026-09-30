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
	import { Separator } from "$lib/components/ui/separator";
	import { ScrollArea } from "$lib/components/ui/scroll-area";
	import { Toaster } from "$lib/components/ui/sonner";
	import {
		LayoutDashboard, MessagesSquare, Ticket, Mail, BarChart3, Trophy,
		PhoneCall, Settings, CalendarDays, Users, Sun, Moon, Archive,
		Send, Gauge, FileText, ClipboardList, LogOut, Search, Bell,
		ChevronDown, PenSquare, Inbox, History, LayoutTemplate, CircleDot
	} from "lucide-svelte";
	import "../app.css";

	type Sub = { to: string; label: string };
	type Link = { to: string; label: string; icon: typeof Mail; badge?: string; subs?: Sub[] };

	const groups: { label: string; links: Link[] }[] = [
		{
			label: "Overview",
			links: [{ to: "/home", label: "Home", icon: LayoutDashboard }]
		},
		{
			label: "Engagement",
			links: [
				{ to: "/chat/v3", label: "Chat v3", icon: MessagesSquare, badge: "12" },
				{ to: "/ticketing", label: "Ticketing", icon: Ticket, badge: "5" },
				{ to: "/threads", label: "Threads", icon: CircleDot }
			]
		},
		{
			label: "Workforce",
			links: [
				{ to: "/agent/performance", label: "Agent", icon: Trophy },
				{ to: "/agent-productivity-dashboard", label: "Productivity", icon: Gauge },
				{ to: "/agent-schedule", label: "Schedule", icon: CalendarDays },
				{ to: "/work-calendar", label: "Work Calendar", icon: ClipboardList }
			]
		},
		{
			label: "Media",
			links: [
				{
					to: "/email", label: "Email", icon: Mail, badge: "8",
					subs: [
						{ to: "/email/compose", label: "Compose" },
						{ to: "/email/send", label: "Send" },
						{ to: "/email/history", label: "History" },
						{ to: "/email/templates", label: "Templates" }
					]
				},
				{ to: "/recordings", label: "Recordings", icon: PhoneCall },
				{ to: "/recording-archive", label: "Archive", icon: Archive }
			]
		},
		{
			label: "Insight",
			links: [
				{ to: "/report", label: "Report", icon: BarChart3 },
				{ to: "/report/csat", label: "CSAT", icon: Gauge },
				{ to: "/report/csat-interaction", label: "CSAT Interaction", icon: FileText },
				{ to: "/spv", label: "SPV", icon: Users },
				{ to: "/chat/v3/ticket/result", label: "Result Ticket", icon: Inbox },
				{ to: "/chat/v3/ticket/kirana-monitoring", label: "Kirana", icon: History }
			]
		},
		{
			label: "System",
			links: [{ to: "/settings", label: "Settings", icon: Settings }]
		}
	];

	const emailIcons = [PenSquare, Send, History, LayoutTemplate];

	let { children } = $props();
	let sidebarOpen = $state(true);
	let emailOpen = $state(true);
	let searchQuery = $state("");

	onMount(() => {
		initTheme();
		try {
			sidebarOpen = localStorage.getItem("dk-sidebar") !== "1";
		} catch { /* storage unavailable */ }
	});

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

	function submitSearch(event: KeyboardEvent) {
		if (event.key === "Enter" && searchQuery.trim()) {
			goto(`/threads?q=${encodeURIComponent(searchQuery.trim())}`);
		}
	}

	const pageTitles: Record<string, string> = {
		"/home": "Home", "/chat/v3": "Omnichat", "/ticketing": "Ticketing",
		"/threads": "Threads", "/agent/performance": "Agent Performance",
		"/agent-productivity-dashboard": "Agent Productivity",
		"/agent-schedule": "Agent Schedule", "/work-calendar": "Work Calendar",
		"/email": "Email", "/recordings": "Recordings",
		"/recording-archive": "Recording Archive", "/report": "Report",
		"/report/csat": "CSAT", "/report/csat-interaction": "CSAT Interaction",
		"/spv": "SPV Monitoring", "/settings": "Settings"
	};
	let pageTitle = $derived(pageTitles[page.url.pathname] ?? "DK CRM");
</script>

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
				{#each groups as group, gi (group.label)}
					<Sidebar.Group>
						<Sidebar.GroupLabel>{group.label}</Sidebar.GroupLabel>
						<Sidebar.GroupContent>
							<Sidebar.Menu>
								{#each group.links as link (link.to)}
									{#if link.subs}
										<Collapsible.Root bind:open={emailOpen} class="group/collapsible">
											<Sidebar.MenuItem>
												<Collapsible.Trigger>
													{#snippet child({ props })}
														<Sidebar.MenuButton
															{...props}
															isActive={isActive(link.to)}
															tooltipContent={link.label}
														>
															<link.icon data-icon="true" />
															<span>{link.label}</span>
															{#if link.badge}<Sidebar.MenuBadge>{link.badge}</Sidebar.MenuBadge>{/if}
															<ChevronDown data-icon="true" class="ms-auto transition-transform group-data-[state=open]/collapsible:rotate-180" />
														</Sidebar.MenuButton>
													{/snippet}
												</Collapsible.Trigger>
												<Collapsible.Content>
													<Sidebar.MenuSub>
														{#each link.subs as sub, si (sub.to)}
															<Sidebar.MenuSubItem>
																<Sidebar.MenuSubButton href={sub.to} isActive={isActive(sub.to)}>
																	{@const SubIcon = emailIcons[si % emailIcons.length]}
																	<SubIcon data-icon="true" />
																	<span>{sub.label}</span>
																</Sidebar.MenuSubButton>
															</Sidebar.MenuSubItem>
														{/each}
													</Sidebar.MenuSub>
												</Collapsible.Content>
											</Sidebar.MenuItem>
										</Collapsible.Root>
									{:else}
										<Sidebar.MenuItem>
											<Sidebar.MenuButton isActive={isActive(link.to)} tooltipContent={link.label}>
												{#snippet child({ props })}
													<a href={link.to} {...props} aria-current={isActive(link.to) ? "page" : undefined}>
														<link.icon data-icon="true" />
														<span>{link.label}</span>
														{#if link.badge}<Badge variant="secondary" class="ms-auto">{link.badge}</Badge>{/if}
													</a>
												{/snippet}
											</Sidebar.MenuButton>
										</Sidebar.MenuItem>
									{/if}
								{/each}
							</Sidebar.Menu>
						</Sidebar.GroupContent>
					</Sidebar.Group>
					{#if gi < groups.length - 1}<Sidebar.Separator class="mx-2 w-auto" />{/if}
				{/each}
			</ScrollArea>
		</Sidebar.Content>
		<Sidebar.Separator />
		<Sidebar.Footer>
			<Sidebar.Menu>
				<Sidebar.MenuItem>
					<Sidebar.MenuButton size="sm" tooltipContent="Operator — Online">
						{#snippet child({ props })}
							<span {...props} class="flex items-center gap-2">
								<span class="flex size-8 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-foreground">OP</span>
								<span class="flex flex-col gap-0.5 leading-none">
									<span class="text-xs font-semibold">Operator</span>
									<span class="text-[10px] text-muted-foreground">Online</span>
								</span>
							</span>
						{/snippet}
					</Sidebar.MenuButton>
				</Sidebar.MenuItem>
			</Sidebar.Menu>
		</Sidebar.Footer>
		<Sidebar.Rail />
	</Sidebar.Root>

	<Sidebar.Inset class="min-h-svh min-w-0 overflow-hidden">
		<header class="flex h-16 shrink-0 items-center gap-3 border-b border-border/80 bg-card/95 px-4 backdrop-blur md:px-6">
			<Sidebar.Trigger aria-label="Buka atau ciutkan sidebar" />
			<h1 class="truncate text-lg font-semibold tracking-tight md:text-xl">{pageTitle}</h1>
			<div class="ms-auto flex items-center gap-2">
				<InputGroup.Root class="hidden w-full max-w-sm sm:flex">
					<InputGroup.Addon><Search data-icon="true" /></InputGroup.Addon>
					<InputGroup.Input
						bind:value={searchQuery}
						onkeydown={submitSearch}
						placeholder="Cari threads, tiket, email..."
						aria-label="Pencarian universal"
					/>
				</InputGroup.Root>
				<Popover.Root>
					<Popover.Trigger aria-label="Notifikasi">
						{#snippet child({ props })}
							<span {...props} class="relative inline-flex cursor-pointer rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground">
								<Bell data-icon="true" />
								<Badge class="absolute -top-0.5 -right-0.5 h-4 min-w-4 px-1 text-[10px]">3</Badge>
							</span>
						{/snippet}
					</Popover.Trigger>
					<Popover.Content align="end" class="w-72">
						<p class="text-sm font-semibold">Notifikasi</p>
						<Separator class="my-2" />
						<div class="flex flex-col gap-2 text-sm">
							<p><span class="font-medium">5 tiket</span> menunggu assignment</p>
							<p><span class="font-medium">12 chat</span> antre di omnichat</p>
							<p class="text-muted-foreground">CSAT minggu ini naik 2,1%</p>
						</div>
					</Popover.Content>
				</Popover.Root>
				<button
					type="button"
					onclick={toggleTheme}
					class="rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground"
					aria-label={$darkMode ? "Gunakan mode terang" : "Gunakan mode gelap"}
				>
					{#if $darkMode}<Sun data-icon="true" />{:else}<Moon data-icon="true" />{/if}
				</button>
				<Separator orientation="vertical" class="mx-1 hidden h-7 sm:block" />
				<DropdownMenu.Root>
					<DropdownMenu.Trigger aria-label="Menu profil">
						{#snippet child({ props })}
							<span {...props} class="flex cursor-pointer items-center gap-2 rounded-lg px-1.5 py-1.5 hover:bg-accent">
								<Avatar.Root class="size-8">
									<Avatar.Fallback>OP</Avatar.Fallback>
								</Avatar.Root>
								<span class="hidden text-left md:block">
									<span class="block text-xs font-semibold">Operator</span>
									<span class="text-[10px] text-muted-foreground">Customer service</span>
								</span>
							</span>
						{/snippet}
					</DropdownMenu.Trigger>
					<DropdownMenu.Content align="end" class="w-56">
						<DropdownMenu.Label>
							<span class="block font-semibold">Operator</span>
							<span class="text-xs text-muted-foreground">Customer service team</span>
						</DropdownMenu.Label>
						<DropdownMenu.Separator />
						<DropdownMenu.Item onclick={() => goto("/settings")}><Settings data-icon="true" />Settings</DropdownMenu.Item>
						<DropdownMenu.Item variant="destructive"><LogOut data-icon="true" />Keluar</DropdownMenu.Item>
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
