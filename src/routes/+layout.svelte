<script lang="ts">
  import { page } from '$app/state';
  import { darkMode, toggleTheme, initTheme } from '$lib/theme';
  import { onMount } from 'svelte';
  import {
    LayoutDashboard, MessagesSquare, Ticket, Mail, BarChart3, Trophy,
    PhoneCall, Settings, CalendarDays, Users, Headset, MessageSquareText,
    PanelLeftClose, PanelLeftOpen, Sun, Moon, Archive, Send, Gauge, FileText,
    ClipboardList, Menu, X, LogOut
  } from 'lucide-svelte';
  import '../app.css';

  const groups = [
    { label: 'Utama', links: [{ to: '/home', label: 'Home', icon: LayoutDashboard }] },
    {
      label: 'Komunikasi',
      links: [
        { to: '/threads', label: 'Threads', icon: MessagesSquare },
        { to: '/chat/v3', label: 'Chat', icon: Headset },
        { to: '/ticketing', label: 'Ticketing', icon: Ticket },
        { to: '/email', label: 'Email', icon: Mail }
      ]
    },
    {
      label: 'Operasional',
      links: [
        { to: '/spv', label: 'SPV', icon: Users },
        { to: '/recordings', label: 'Recordings', icon: PhoneCall },
        { to: '/recording-archive', label: 'Recording Archive', icon: Archive },
        { to: '/agent-schedule', label: 'Agent Schedule', icon: CalendarDays },
        { to: '/work-calendar', label: 'Work Calendar', icon: ClipboardList }
      ]
    },
    {
      label: 'Insight',
      links: [
        { to: '/report', label: 'Report', icon: BarChart3 },
        { to: '/report/csat', label: 'CSAT', icon: Gauge },
        { to: '/report/csat-interaction', label: 'CSAT Interaction', icon: FileText },
        { to: '/agent/performance', label: 'Agent Performance', icon: Trophy },
        { to: '/agent-productivity-dashboard', label: 'Productivity', icon: Send }
      ]
    }
  ];

  let { children } = $props();
  let collapsed = $state(false);
  let mobileOpen = $state(false);
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
    try { collapsed = localStorage.getItem('dk-sidebar') === '1'; } catch { /* browser storage unavailable */ }
    tick();
    timer = setInterval(tick, 1000);
    return () => clearInterval(timer);
  });

  function toggleSidebar() {
    collapsed = !collapsed;
    try { localStorage.setItem('dk-sidebar', collapsed ? '1' : '0'); } catch { /* browser storage unavailable */ }
  }

  let path = $derived(page.url.pathname);
  function isActive(to: string) {
    return to === '/home' ? path === '/home' || path === '/' : path === to || path.startsWith(to + '/');
  }

  const pageTitles: Record<string, string> = {
    '/home': 'Home', '/threads': 'My Threads', '/chat/v3': 'Omnichat', '/ticketing': 'Ticketing',
    '/email': 'Email', '/spv': 'Monitoring', '/recordings': 'Call Recordings',
    '/recording-archive': 'Recording Archive', '/agent-schedule': 'Agent Schedule',
    '/work-calendar': 'Work Calendar', '/report': 'Report', '/report/csat': 'CSAT',
    '/report/csat-interaction': 'CSAT Interaction', '/agent/performance': 'Agent Performance',
    '/agent-productivity-dashboard': 'Agent Productivity', '/settings': 'Settings'
  };
  let pageTitle = $derived(pageTitles[path] ?? 'DK CRM');
</script>

<div class="flex h-screen overflow-hidden bg-background text-foreground">
  <aside class="hidden h-full shrink-0 flex-col transition-all duration-300 md:flex {collapsed ? 'w-20' : 'w-64'}" style="background-color: var(--sidebar-bg);">
    <div class="flex items-center gap-3 border-b px-4 py-5" style="border-color: var(--sidebar-border);" class:justify-center={collapsed}>
      <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary text-white"><MessageSquareText size={22} /></div>
      {#if !collapsed}<div><div class="font-bold tracking-tight text-white">DK CRM</div><div class="text-[11px] text-gray-400">Omnichannel</div></div>{/if}
    </div>
    <button type="button" onclick={toggleSidebar} title={collapsed ? 'Buka sidebar' : 'Ciutkan sidebar'} class="mx-3 mt-3 flex items-center gap-2 rounded-lg p-2 text-xs text-gray-400 transition-colors hover:bg-white/5 hover:text-white" class:justify-center={collapsed}>
      {#if collapsed}<PanelLeftOpen size={16} />{:else}<PanelLeftClose size={16} /><span>Ciutkan menu</span>{/if}
    </button>
    <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-2">
      {#each groups as group}
        <div>
          {#if !collapsed}<div class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500">{group.label}</div>{/if}
          <div class="space-y-1">
            {#each group.links as link}
              <a href={link.to} title={link.label} class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {collapsed ? 'justify-center' : ''} {isActive(link.to) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-gray-300 hover:bg-white/5 hover:text-white'}">
                <link.icon size={18} />{#if !collapsed}<span>{link.label}</span>{/if}
              </a>
            {/each}
          </div>
        </div>
      {/each}
    </nav>
  </aside>

  {#if mobileOpen}
    <div class="fixed inset-0 z-40 md:hidden"><button type="button" aria-label="Tutup menu" class="absolute inset-0 bg-black/60" onclick={() => (mobileOpen = false)}></button><div class="absolute left-0 top-0 h-full w-72 overflow-y-auto bg-gray-900 p-3"><div class="mb-4 flex items-center justify-between px-2"><strong class="text-white">DK CRM</strong><button type="button" onclick={() => (mobileOpen = false)} aria-label="Tutup"><X size={18} /></button></div>{#each groups.flatMap((group) => group.links) as link}<a href={link.to} onclick={() => (mobileOpen = false)} class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white"><link.icon size={18} />{link.label}</a>{/each}</div></div>
  {/if}

  <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
    <header class="flex h-16 shrink-0 items-center justify-between border-b bg-card px-4 md:px-6" style="border-color: var(--border);">
      <div class="flex items-center gap-3"><button type="button" class="rounded-lg p-2 text-muted-foreground hover:bg-accent md:hidden" aria-label="Buka menu" onclick={() => (mobileOpen = true)}><Menu size={20} /></button><div><h1 class="text-lg font-bold text-foreground md:text-xl">{pageTitle}</h1><p class="hidden text-xs text-muted-foreground md:block">Kelola operasional customer service Anda</p></div></div>
      <div class="flex items-center gap-2 md:gap-4"><div class="hidden text-right md:block"><div class="text-xs capitalize text-muted-foreground">{dateStr}</div><div class="font-mono text-sm font-semibold text-foreground">{now}</div></div><button type="button" onclick={toggleTheme} class="rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground" aria-label={$darkMode ? 'Gunakan mode terang' : 'Gunakan mode gelap'}>{#if $darkMode}<Sun size={18} />{:else}<Moon size={18} />{/if}</button><a href="/settings" class="flex items-center gap-2 rounded-xl border border-border bg-background px-2 py-1.5 text-left transition-colors hover:bg-accent md:px-3" title="Buka profil dan pengaturan"><span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary text-xs font-bold text-white">OP</span><span class="hidden md:block"><span class="block text-xs font-semibold text-foreground">Operator</span><span class="flex items-center gap-1 text-[10px] text-emerald-400"><span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>Online</span></span></a><button type="button" class="hidden rounded-lg p-2 text-muted-foreground hover:bg-accent hover:text-foreground md:block" aria-label="Keluar"><LogOut size={18} /></button></div>
    </header>
    <main class="min-w-0 flex-1 overflow-y-auto bg-background p-4 md:p-6">{@render children()}</main>
  </div>
</div>
