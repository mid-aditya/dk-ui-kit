<script lang="ts">
  import { page } from '$app/state';
  import { darkMode, toggleTheme, initTheme } from '$lib/theme';
  import { onMount } from 'svelte';
  import {
    LayoutDashboard, MessagesSquare, Ticket, Mail, BarChart3, Trophy,
    PhoneCall, Settings, CalendarDays, Users, Headset, LogOut,
    MessageSquareText, PanelLeftClose, PanelLeftOpen, Sun, Moon, Archive,
    Send, Gauge, FileText, ClipboardList, Menu, X
  } from 'lucide-svelte';
  import '../app.css';

  const groups = [
    {
      label: 'Utama',
      links: [{ to: '/home', label: 'Home', icon: LayoutDashboard }]
    },
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

  onMount(() => {
    initTheme();
    try {
      collapsed = localStorage.getItem('dk-sidebar') === '1';
    } catch { /* abaikan */ }
  });

  function toggle() {
    collapsed = !collapsed;
    try {
      localStorage.setItem('dk-sidebar', collapsed ? '1' : '0');
    } catch { /* abaikan */ }
  }

  let path = $derived(page.url.pathname);
  function isActive(to: string) {
    return to === '/home' ? path === '/home' || path === '/' : path === to || path.startsWith(to + '/');
  }
</script>

<div class="flex h-screen overflow-hidden bg-background text-foreground">
  <!-- Sidebar desktop -->
  <aside class="hidden shrink-0 h-full flex-col transition-all md:flex {collapsed ? 'w-16' : 'w-64'}" style="background-color: var(--sidebar-bg); color: var(--sidebar-text);">
    <!-- Logo -->
    <div class="flex items-center gap-3 border-b px-4 py-5" style="border-color: var(--sidebar-border);" class:justify-center={collapsed}>
      <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white" style="background-color: var(--sidebar-logo-bg);">
        <MessageSquareText size={22} />
      </div>
      {#if !collapsed}
        <div>
          <div class="font-bold tracking-tight text-white">DK CRM</div>
          <div class="text-[11px]" style="color: var(--sidebar-text-muted);">Chat · Tiket · Email</div>
        </div>
      {/if}
    </div>

    <!-- Toggle button -->
    <button
      onclick={toggle}
      title={collapsed ? 'Buka sidebar' : 'Minimize sidebar'}
      class="mx-3 mt-3 flex items-center gap-2 rounded-lg p-1.5 text-xs transition-colors hover:brightness-110"
      style="color: var(--sidebar-text-muted);"
    >
      {#if collapsed}<PanelLeftOpen size={16} />{:else}<PanelLeftClose size={16} /><span>Minimize</span>{/if}
    </button>

    <!-- Navigation -->
    <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-2">
      {#each groups as g}
        <div>
          {#if !collapsed}<div class="mb-1.5 px-3 text-[11px] font-semibold uppercase tracking-wider" style="color: var(--sidebar-text-muted);">{g.label}</div>{/if}
          <div class="space-y-0.5">
            {#each g.links as l}
              <a
                href={l.to}
                title={l.label}
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {collapsed ? 'justify-center' : ''}"
                class:bg-primary={isActive(l.to)}
                class:text-white={isActive(l.to)}
                class:shadow-md={isActive(l.to)}
                style={isActive(l.to) ? '' : `hover:brightness-110; color: var(--sidebar-text);`}
              >
                <l.icon size={18} />
                {#if !collapsed}<span>{l.label}</span>{/if}
              </a>
            {/each}
          </div>
        </div>
      {/each}
    </nav>

    <!-- User section -->
    <div class="border-t p-3" style="border-color: var(--sidebar-border);">
      <div class="flex items-center gap-3 px-2 py-2" class:justify-center={collapsed} class:px-0={collapsed}>
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-xs font-bold text-white" style="background-color: var(--sidebar-logo-bg);">OP</div>
        {#if !collapsed}
          <div class="min-w-0 flex-1">
            <div class="truncate text-sm font-semibold text-white">Operator</div>
            <div class="flex items-center gap-1.5 text-[11px] font-medium text-emerald-300">
              <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400"></span>Online
            </div>
          </div>
          <a href="/settings" title="Settings" class="p-1" style="color: var(--sidebar-text-muted);"><Settings size={18} /></a>
        {/if}
      </div>
    </div>
  </aside>

  <!-- Drawer mobile -->
  {#if mobileOpen}
    <div class="fixed inset-0 z-40 md:hidden">
      <button aria-label="Tutup menu" class="absolute inset-0 bg-black/50" onclick={() => (mobileOpen = false)}></button>
      <div class="absolute left-0 top-0 h-full w-64 overflow-y-auto p-3" style="background-color: var(--sidebar-bg); color: var(--sidebar-text);">
        <div class="mb-3 flex items-center justify-between px-2">
          <strong class="text-white">Menu</strong>
          <button onclick={() => (mobileOpen = false)} aria-label="Tutup"><X size={18} /></button>
        </div>
        {#each groups.flatMap((g) => g.links) as l}
          <a 
            href={l.to} 
            onclick={() => (mobileOpen = false)} 
            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition-colors hover:brightness-110"
            style="color: var(--sidebar-text);"
          >
            <l.icon size={18} />{l.label}
          </a>
        {/each}
      </div>
    </div>
  {/if}

  <!-- Main content -->
  <div class="flex min-w-0 flex-1 flex-col overflow-hidden">
    <!-- Topbar -->
    <header class="shrink-0 z-30 flex items-center gap-2 border-b bg-background px-4 py-3 md:px-6">
      <button class="md:hidden" onclick={() => (mobileOpen = true)} aria-label="Buka menu"><Menu size={20} /></button>
      <div class="font-bold md:hidden">DK CRM</div>
      <div class="hidden text-sm text-muted-foreground md:block">Omnichannel · Chat · Tiket · Email · CSAT</div>
      <div class="flex-1"></div>
      <button onclick={toggleTheme} title="Dark / Light" class="inline-flex h-9 items-center gap-1.5 rounded-lg border bg-background px-3 text-sm font-semibold shadow-sm hover:bg-accent">
        {#if $darkMode}<Sun size={16} />{:else}<Moon size={16} />{/if}
      </button>
      <a href="/settings" class="inline-flex h-9 items-center gap-1.5 rounded-lg border bg-background px-3 text-sm font-semibold shadow-sm hover:bg-accent">Settings</a>
    </header>
    <main class="flex-1 overflow-y-auto p-3 md:p-4">
      {@render children()}
    </main>
  </div>
</div>
