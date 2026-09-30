<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { Radio } from 'lucide-svelte';
</script>

<svelte:head><title>Kirana Monitoring — DK UI Kit</title></svelte:head>

<div class="flex items-center gap-2">
  <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-500 text-white"><Radio size={18} /></span>
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Kirana Monitoring</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Live monitoring antrian & agent <Badge variant="destructive">LIVE</Badge></p>
  </div>
</div>

<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each [{ l: 'Antrian live', v: '7' }, { l: 'Agent available', v: '9' }, { l: 'Wait time', v: '1:22' }, { l: 'Abandoned', v: '2%' }] as s}
    <Card><CardContent class="p-4"><div class="text-xs font-medium text-slate-500">{s.l}</div><div class="mt-1 text-2xl font-extrabold">{s.v}</div></CardContent></Card>
  {/each}
</div>

<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <Card>
    <CardHeader><CardTitle>Antrian per kanal</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each [{ c: 'WhatsApp', v: 5 }, { c: 'Email', v: 1 }, { c: 'Voice', v: 1 }] as k}
        <div>
          <div class="mb-1 flex justify-between text-sm"><span class="font-medium">{k.c}</span><span class="text-slate-500">{k.v}</span></div>
          <Progress value={(k.v / 5) * 100} />
        </div>
      {/each}
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>Agent sedang live</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        <li class="flex justify-between border-b border-slate-100 pb-2 dark:border-slate-800"><span>Kirana Ayu</span><Badge variant="success">call 03:12</Badge></li>
        <li class="flex justify-between border-b border-slate-100 pb-2 dark:border-slate-800"><span>Bimo Prasetyo</span><Badge variant="success">chat ×3</Badge></li>
        <li class="flex justify-between"><span>Sinta Maharani</span><Badge variant="warning">wrap-up</Badge></li>
      </ul>
    </CardContent>
  </Card>
</div>
