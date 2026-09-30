<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { csat } from '$lib/mock';

  const max = Math.max(...csat.map((c) => c.pct));
</script>

<svelte:head><title>Report CSAT — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Report CSAT</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Kepuasan pelanggan periode berjalan.</p>

<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each [{ l: 'Skor CSAT', v: '4.7' }, { l: 'Responden', v: '1.284' }, { l: 'Tren', v: '+0.2' }, { l: 'Target', v: '4.5' }] as s}
    <Card><CardContent class="p-4"><div class="text-xs font-medium text-slate-500">{s.l}</div><div class="mt-1 text-2xl font-extrabold">{s.v}</div></CardContent></Card>
  {/each}
</div>

<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <Card>
    <CardHeader><CardTitle>Distribusi jawaban</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each csat as c}
        <div>
          <div class="mb-1 flex justify-between text-sm"><span class="font-medium">{c.label}</span><span class="text-slate-500">{c.pct}%</span></div>
          <Progress value={(c.pct / max) * 100} />
        </div>
      {/each}
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>CSAT per kanal</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        {#each [{ k: 'WhatsApp', v: '4.8' }, { k: 'Email', v: '4.6' }, { k: 'Voice', v: '4.5' }, { k: 'Telegram', v: '4.7' }] as r}
          <li class="flex justify-between border-b border-slate-100 pb-2 dark:border-slate-800"><span>{r.k}</span><strong class="text-brand-600 dark:text-brand-400">★ {r.v}</strong></li>
        {/each}
      </ul>
    </CardContent>
  </Card>
</div>

<div class="mt-3">
  <Card>
    <CardHeader><CardTitle>Komentar terbaru</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        <li class="rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">“Respon cepat, masalah selesai.” <Badge variant="success" class="ml-2">5</Badge></li>
        <li class="rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">“Agent ramah, recommended.” <Badge variant="success" class="ml-2">5</Badge></li>
        <li class="rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">“Menunggu agak lama di antrean.” <Badge variant="warning" class="ml-2">3</Badge></li>
      </ul>
    </CardContent>
  </Card>
</div>
