<script lang="ts">
  import { page } from '$app/state';
  import { goto } from '$app/navigation';
  import { darkMode, toggleTheme, initTheme } from '$lib/theme';
  import { onMount } from 'svelte';
  import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
  import * as Collapsible from '$lib/components/ui/collapsible';
  import * as Sidebar from '$lib/components/ui/sidebar';
  import { Input } from '$lib/components/ui/input';
  import { Separator } from '$lib/components/ui/separator';
  import {
    LayoutDashboard, MessagesSquare, Ticket, Mail, BarChart3, Trophy,
    PhoneCall, Settings, CalendarDays, Users, Headset,
    Sun, Moon, Archive, Send, Gauge, FileText, ClipboardList, Menu,
    LogOut, ChevronRight, CircleHelp, Search, MoreHorizontal, Command, ChevronDown
  } from 'lucide-svelte';
  import '../app.css';

  const workspaceLinks = [
    { to: '/threads', label: 'Threads', icon: MessagesSquare },
    { to: '/chat/v3', label: 'Chat', icon: Headset },
    { to: '/ticketing', label: 'Ticketing', icon: Ticket },
    { to: '/email', label: 'Email', icon: Mail }
  ];
  const operationalLinks = [
    { to: '/spv', label: 'SPV', icon: Users },
    { to: '/recordings', label: 'Recordings', icon: PhoneCall },
    { to: '/recording-archive', label: 'Recording Archive', icon: Archive },
    { to: '/agent-schedule', label: 'Agent Schedule', icon: CalendarDays },
    { to: '/work-calendar', label: 'Work Calendar', icon: ClipboardList }
  ];
  const reportLinks = [
    { to: '/report', label: 'Overview', icon: BarChart3 },
    { to: '/report/csat', label: 'CSAT', icon: Gauge },
    { to: '/report/csat-interaction', label: 'CSAT Interaction', icon: FileText },
    { to: '/agent/performance', label: 'Agent Performance', icon: Trophy },
    { to: '/agent-productivity-dashboard', label: 'Productivity', icon: Send }
  ];

  let { children } = $props();
  let sidebarOpen = $state(true);
  let reportOpen = $state(true);
  let searchQuery = $state('');
  let now = $state('');
  let dateStr = $state('');
  let timer: ReturnType<typeof setInterval>;

  function tick() {
    const d = new Date();
    dateStr = d.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    now = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
  }

  onMount(() => {
    initTheme();
    try { sidebarOpen = localStorage.getItem('dk-sidebar') !== '1'; } catch { /* browser storage unavailable */ }
    tick();
    timer = setInterval(tick, 1000);
    return () => clearInterval(timer);
  });

  function updateSidebar(open: boolean) {
    sidebarOpen = open;
    try { localStorage.setItem('dk-sidebar', open ? '0' : '1'); } catch { /* browser storage unavailable */ }
  }

  function isActive(to: string) {
    const path = page.url.pathname;
    return to === '/home' ? path === '/home' || path === '/' : path === to || path.startsWith(to + '/');
  }

  function submitSearch(event: KeyboardEvent) {
    if (event.key === 'Enter' && searchQuery.trim()) {
      goto(`/threads?q=${encodeURIComponent(searchQuery.trim())}`);
    }
  }

  const pageTitles: Record<string, string> = {
    '/home': 'Home', '/threads': 'My Threads', '/chat/v3': 'Omnichat', '/ticketing': 'Ticketing',
    '/email': 'Email', '/spv': 'Monitoring', '/recordings': 'Call Recordings',
    '/recording-archive': 'Recording Archive', '/agent-schedule': 'Agent Schedule',
    '/work-calendar': 'Work Calendar', '/report': 'Report', '/report/csat': 'CSAT',
    '/report/csat-interaction': 'CSAT Interaction', '/agent/performance': 'Agent Performance',
    '/agent-productivity-dashboard': 'Agent Productivity', '/settings': 'Settings'
  };
  let pageTitle = $derived(pageTitles[page.url.pathname] ?? 'DK CRM');
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
              </a>
            {/snippet}
          </Sidebar.MenuButton>
        </Sidebar.MenuItem>
      </Sidebar.Menu>
    </Sidebar.Header>
    <Sidebar.Content>
      <Sidebar.Group>
        <Sidebar.GroupLabel>Utama</Sidebar.GroupLabel>
        <Sidebar.GroupContent>
          <Sidebar.Menu>
            <Sidebar.MenuItem>
              <Sidebar.MenuButton isActive={isActive('/home')} tooltipContent="Home">
                {#snippet child({ props })}<a href="/home" {...props} aria-current={isActive('/home') ? 'page' : undefined}><LayoutDashboard /><span>Home</span></a>{/snippet}
              </Sidebar.MenuButton>
            </Sidebar.MenuItem>
          </Sidebar.Menu>
        </Sidebar.GroupContent>
      </Sidebar.Group>
      <Sidebar.Group>
        <Sidebar.GroupLabel>Workspace</Sidebar.GroupLabel>
        <Sidebar.GroupContent>
          <Sidebar.Menu>
            {#each workspaceLinks as link (link.to)}
              <Sidebar.MenuItem>
                <Sidebar.MenuButton isActive={isActive(link.to)} tooltipContent={link.label}>
                  {#snippet child({ props })}<a href={link.to} {...props} aria-current={isActive(link.to) ? 'page' : undefined}><link.icon /><span>{link.label}</span></a>{/snippet}
                </Sidebar.MenuButton>
              </Sidebar.MenuItem>
            {/each}
          </Sidebar.Menu>
        </Sidebar.GroupContent>
      </Sidebar.Group>
      <Sidebar.Group>
        <Sidebar.GroupLabel>Operasional</Sidebar.GroupLabel>
        <Sidebar.GroupContent>
          <Sidebar.Menu>
            {#each operationalLinks as link (link.to)}
              <Sidebar.MenuItem>
                <Sidebar.MenuButton isActive={isActive(link.to)} tooltipContent={link.label}>
                  {#snippet child({ props })}<a href={link.to} {...props} aria-current={isActive(link.to) ? 'page' : undefined}><link.icon /><span>{link.label}</span></a>{/snippet}
                </Sidebar.MenuButton>
              </Sidebar.MenuItem>
            {/each}
          </Sidebar.Menu>
        </Sidebar.GroupContent>
      </Sidebar.Group>
      <Sidebar.Group>
        <Sidebar.GroupLabel>Insight</Sidebar.GroupLabel>
        <Sidebar.GroupContent>
          <Sidebar.Menu>
            <Collapsible.Root bind:open={reportOpen} class="group/collapsible">
              <Sidebar.MenuItem>
                <Collapsible.Trigger>
                  {#snippet child({ props })}
                    <Sidebar.MenuButton {...props} isActive={reportLinks.some((link) => isActive(link.to))} tooltipContent="Report">
                      <BarChart3 /><span>Report</span><ChevronDown class="ms-auto transition-transform group-data-[state=open]/collapsible:rotate-180" />
                    </Sidebar.MenuButton>
                  {/snippet}
                </Collapsible.Trigger>
                <Collapsible.Content>
                  <Sidebar.MenuSub>
                    {#each reportLinks.filter((link) => link.to !== '/report') as link (link.to)}
                      <Sidebar.MenuSubItem><Sidebar.MenuSubButton href={link.to} isActive={isActive(link.to)}><link.icon /><span>{link.label}</span></Sidebar.MenuSubButton></Sidebar.MenuSubItem>
                    {/each}
                  </Sidebar.MenuSub>
                </Collapsible.Content>
              </Sidebar.MenuItem>
            </Collapsible.Root>
          </Sidebar.Menu>
        </Sidebar.GroupContent>
      </Sidebar.Group>
    </Sidebar.Content>
    <Sidebar.Footer>
      <Sidebar.Menu>
        <Sidebar.MenuItem>
          <Sidebar.MenuButton isActive={isActive('/settings')} tooltipContent="Settings">
            {#snippet child({ props })}<a href="/settings" {...props} aria-current={isActive('/settings') ? 'page' : undefined}><Settings /><span>Settings</span></a>{/snippet}
          </Sidebar.MenuButton>
        </Sidebar.MenuItem>
      </Sidebar.Menu>
    </Sidebar.Footer>
  </Sidebar.Root>

  <Sidebar.Inset class="min-h-svh min-w-0 overflow-hidden">
    <header class="z-30 flex h-16 shrink-0 items-center justify-between gap-3 border-b border-border/80 bg-card/95 px-4 backdrop-blur md:px-6">
      <div class="flex min-w-0 items-center gap-3"><Sidebar.Trigger class="shrink-0" aria-label="Buka atau ciutkan sidebar"><Menu /></Sidebar.Trigger><h1 class="truncate text-lg font-semibold tracking-tight text-foreground md:text-xl">{pageTitle}</h1></div>
      <div class="flex min-w-0 flex-1 items-center justify-end gap-1.5 md:gap-2">
        <div class="relative hidden w-full max-w-sm sm:block"><Search size={16} class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" /><Input bind:value={searchQuery} onkeydown={submitSearch} placeholder="Cari threads, tiket, email..." aria-label="Pencarian universal" class="h-9 bg-background pl-9 pr-16" /><kbd class="pointer-events-none absolute right-2 top-1/2 hidden -translate-y-1/2 items-center gap-1 rounded border border-border bg-muted px-1.5 py-0.5 text-[10px] text-muted-foreground lg:flex"><Command size={11} />K</kbd></div>
        <div class="hidden items-center gap-2 border-r border-border pr-3 text-right xl:flex"><div><div class="text-[11px] capitalize text-muted-foreground">{dateStr}</div><div class="font-mono text-xs font-semibold text-foreground">{now}</div></div></div>
        <DropdownMenu.Root><DropdownMenu.Trigger class="rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground" aria-label="Menu bantuan dan utilitas"><MoreHorizontal /></DropdownMenu.Trigger><DropdownMenu.Content align="end" class="w-52"><DropdownMenu.Label>Menu auxiliary</DropdownMenu.Label><DropdownMenu.Separator /><DropdownMenu.Item onclick={() => goto('/threads')}><MessagesSquare />My Threads</DropdownMenu.Item><DropdownMenu.Item onclick={() => goto('/settings')}><Settings />Settings</DropdownMenu.Item><DropdownMenu.Item><CircleHelp />Help center</DropdownMenu.Item></DropdownMenu.Content></DropdownMenu.Root>
        <button type="button" onclick={toggleTheme} class="rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring" aria-label={$darkMode ? 'Gunakan mode terang' : 'Gunakan mode gelap'}>{#if $darkMode}<Sun size={18} />{:else}<Moon size={18} />{/if}</button>
        <Separator orientation="vertical" class="mx-1 hidden h-7 sm:block" />
        <DropdownMenu.Root><DropdownMenu.Trigger class="flex items-center gap-2 rounded-lg px-1.5 py-1.5 text-left hover:bg-accent" aria-label="Menu profil"><span class="flex size-8 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-foreground">OP</span><span class="hidden md:block"><span class="block text-xs font-semibold">Operator</span><span class="flex items-center gap-1 text-[10px] text-muted-foreground"><span class="size-1.5 rounded-full bg-emerald-500"></span>Online</span></span></DropdownMenu.Trigger><DropdownMenu.Content align="end" class="w-56"><DropdownMenu.Label><span class="block font-semibold">Operator</span><span class="text-xs text-muted-foreground">Customer service team</span></DropdownMenu.Label><DropdownMenu.Separator /><DropdownMenu.Item onclick={() => goto('/settings')}><Settings />Settings</DropdownMenu.Item><DropdownMenu.Item variant="destructive"><LogOut />Keluar</DropdownMenu.Item></DropdownMenu.Content></DropdownMenu.Root>
      </div>
    </header>
    <main class="min-h-0 min-w-0 flex-1 overflow-y-auto bg-background p-4 md:p-6">{@render children()}</main>
  </Sidebar.Inset>
</Sidebar.Provider>
