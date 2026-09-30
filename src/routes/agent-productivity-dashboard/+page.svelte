<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { agents } from '$lib/mock';

  const hours = ['08', '10', '12', '14', '16', '18'];
  const load = [42, 78, 95, 88, 64, 30];
  const max = Math.max(...load);
</script>

<svelte:head><title>Agent Productivity Dashboard — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Agent Productivity Dashboard</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Utilisasi agent per jam & ringkasan harian.</p>

<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each [{ l: 'Utilisasi', v: '76%' }, { l: 'Avg handle time', v: '6:12' }, { l: 'First response', v: '1:48' }, { l: 'Occupancy', v: '81%' }] as s}
    <Card><CardContent class="p-4"><div class="text-xs font-medium text-slate-500">{s.l}</div><div class="mt-1 text-2xl font-extrabold">{s.v}</div></CardContent></Card>
  {/each}
</div>

<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <Card>
    <CardHeader><CardTitle>Beban percakapan per jam</CardTitle></CardHeader>
    <CardContent>
      <div class="flex h-36 items-end gap-2">
        {#each hours as h, i}
          <div class="flex flex-1 flex-col items-center gap-1">
            <div class="flex w-full flex-1 items-end rounded-lg bg-slate-100 dark:bg-slate-800">
              <div class="w-full rounded-lg bg-gradient-to-t from-brand-600 to-sky-400" style="height:{Math.round((load[i] / max) * 100)}%"></div>
            </div>
            <span class="text-[11px] text-slate-400">{h}</span>
          </div>
        {/each}
      </div>
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>Status agent saat ini</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        {#each agents as a}
          <li class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
            <span class="font-medium">{a.name}</span>
            <span class="flex items-center gap-2">
              <span class="text-xs text-slate-400">{a.chats} chat aktif</span>
              <Badge variant={a.status === 'online' ? 'success' : a.status === 'busy' ? 'warning' : 'secondary'}>{a.status}</Badge>
            </span>
          </li>
        {/each}
      </ul>
    </CardContent>
  </Card>
</div>

<div class="mt-3">
  <Card>
    <CardHeader><CardTitle>Produktivitas vs target</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each agents as a}
        <div>
          <div class="mb-1 flex justify-between text-sm"><span class="font-medium">{a.name}</span><span class="text-slate-500">{a.chats + a.tickets}/30 kasus</span></div>
          <Progress value={((a.chats + a.tickets) / 30) * 100} />
        </div>
      {/each}
    </CardContent>
  </Card>
</div>
