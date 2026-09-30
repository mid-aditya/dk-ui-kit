<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { agents } from '$lib/mock';

  let ranked = [...agents].sort((a, b) => b.csat * 20 + b.chats - (a.csat * 20 + a.chats));
  let maxChats = Math.max(1, ...agents.map((a) => a.chats));
  const statusVariant = (s: string) => (s === 'online' ? 'success' : s === 'busy' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Agent Performance — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Agent Performance</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Skor gabungan chat, tiket & CSAT per agent.</p>

<div class="mt-3 overflow-auto rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
  <table class="w-full text-sm">
    <thead class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
      <tr><th class="px-3 py-2 text-left">Agent</th><th class="px-3 py-2 text-right">Chat</th><th class="px-3 py-2 text-right">Tiket</th><th class="px-3 py-2 text-right">CSAT</th><th class="px-3 py-2 text-left">Beban</th><th class="px-3 py-2 text-left">Status</th></tr>
    </thead>
    <tbody>
      {#each ranked as a}
        <tr class="border-t border-slate-100 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
          <td class="px-3 py-2">
            <div class="flex items-center gap-3"><Avatar name={a.name} /><div><div class="font-semibold">{a.name}</div><div class="text-xs text-slate-400">{a.role}</div></div></div>
          </td>
          <td class="px-3 py-2 text-right">{a.chats}</td>
          <td class="px-3 py-2 text-right">{a.tickets}</td>
          <td class="px-3 py-2 text-right font-bold text-brand-600 dark:text-brand-400">★ {a.csat}</td>
          <td class="px-3 py-2"><Progress value={(a.chats / maxChats) * 100} class="w-28" /></td>
          <td class="px-3 py-2"><Badge variant={statusVariant(a.status)}>{a.status}</Badge></td>
        </tr>
      {/each}
    </tbody>
  </table>
</div>

<div class="mt-3 grid gap-3 md:grid-cols-2">
  <Card><CardHeader><CardTitle>Top CSAT minggu ini</CardTitle></CardHeader>
    <CardContent>
      <div class="flex items-center gap-3"><Avatar name="Sinta Maharani" /><div><div class="font-semibold">Sinta Maharani</div><div class="text-sm text-slate-500">4.9 dari 87 survei</div></div></div>
    </CardContent>
  </Card>
  <Card><CardHeader><CardTitle>Butuh coaching</CardTitle></CardHeader>
    <CardContent>
      <div class="flex items-center gap-3"><Avatar name="Raka Aditya" /><div><div class="font-semibold">Raka Aditya</div><div class="text-sm text-slate-500">CSAT 4.4 · tren turun 0.2</div></div></div>
    </CardContent>
  </Card>
</div>
