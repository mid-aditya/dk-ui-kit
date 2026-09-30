<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import { agents } from '$lib/mock';
</script>

<svelte:head><title>SPV — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">SPV</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Ruang kerja supervisor: monitoring, eskalasi & approval.</p>

<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each [{ l: 'Sedang dimonitor', v: '6' }, { l: 'Eskalasi pending', v: '3' }, { l: 'Approval cuti', v: '2' }, { l: 'QA score avg', v: '88' }] as s}
    <Card><CardContent class="p-4"><div class="text-xs font-medium text-slate-500">{s.l}</div><div class="mt-1 text-2xl font-extrabold">{s.v}</div></CardContent></Card>
  {/each}
</div>

<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <Card>
    <CardHeader><CardTitle>Eskalasi menunggu</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        <li class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">
          <span>T-2026-001 · pelanggan meminta SPV</span>
          <span class="flex gap-2"><Button size="sm">Ambil alih</Button><Button size="sm" variant="secondary">Tolak</Button></span>
        </li>
        <li class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">
          <span>Chat CV Berkah · butuh diskresi refund</span>
          <span class="flex gap-2"><Button size="sm">Ambil alih</Button><Button size="sm" variant="secondary">Tolak</Button></span>
        </li>
      </ul>
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>Agent dalam pantauan</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        {#each agents.slice(0, 3) as a}
          <li class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
            <span class="flex items-center gap-3"><Avatar name={a.name} /><span class="font-medium">{a.name}</span></span>
            <span class="flex gap-2">
              <Button size="sm" variant="secondary" href="/recordings">Dengar</Button>
              <Button size="sm" variant="secondary" href="/chat/v3/ticket/kirana-monitoring">Live</Button>
            </span>
          </li>
        {/each}
      </ul>
    </CardContent>
  </Card>
</div>
