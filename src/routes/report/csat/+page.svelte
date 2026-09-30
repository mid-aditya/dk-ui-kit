<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { csat } from '$lib/mock';

  let max = $derived(Math.max(...csat.map((c) => c.pct)));

  const stats = [
    { label: 'Skor CSAT', value: '4.7' },
    { label: 'Responden', value: '1.284' },
    { label: 'Tren', value: '+0.2' },
    { label: 'Target', value: '4.5' }
  ];

  const comments = [
    { text: 'Respon cepat, masalah selesai.', rating: 5 },
    { text: 'Agent ramah, recommended.', rating: 5 },
    { text: 'Menunggu agak lama di antrean.', rating: 3 }
  ];
</script>

<svelte:head><title>Report CSAT — DK UI Kit</title></svelte:head>

<div></div>

<!-- Stats Cards -->
<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each stats as s}
    <Card class="hover:shadow-md transition-shadow">
      <CardContent class="p-4">
        <div class="text-xs font-medium text-muted-foreground">{s.label}</div>
        <div class="mt-1 text-2xl font-extrabold">{s.value}</div>
      </CardContent>
    </Card>
  {/each}
</div>

<!-- Content Grid -->
<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <!-- Distribution -->
  <Card>
    <CardHeader><CardTitle>Distribusi jawaban</CardTitle></CardHeader>
    <CardContent class="space-y-4">
      {#each csat as c}
        <div>
          <div class="mb-2 flex justify-between text-sm">
            <span class="font-medium">{c.label}</span>
            <span class="text-muted-foreground">{c.pct}%</span>
          </div>
          <Progress value={(c.pct / max) * 100} />
        </div>
      {/each}
    </CardContent>
  </Card>

  <!-- CSAT per Channel -->
  <Card>
    <CardHeader><CardTitle>CSAT per kanal</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-3 text-sm">
        {#each [{ k: 'WhatsApp', v: '4.8' }, { k: 'Email', v: '4.6' }, { k: 'Voice', v: '4.5' }, { k: 'Telegram', v: '4.7' }] as r}
          <li class="flex justify-between border-b border-border pb-2 last:border-0 last:pb-0">
            <span>{r.k}</span>
            <strong class="text-primary">★ {r.v}</strong>
          </li>
        {/each}
      </ul>
    </CardContent>
  </Card>
</div>

<!-- Recent Comments -->
<Card class="mt-3">
  <CardHeader><CardTitle>Komentar terbaru</CardTitle></CardHeader>
  <CardContent class="space-y-3">
    {#each comments as c}
      <div class="flex items-center justify-between rounded-lg border border-border p-3">
        <span class="text-sm">"{c.text}"</span>
        <Badge variant={c.rating >= 4 ? 'success' : 'warning'}>★ {c.rating}</Badge>
      </div>
    {/each}
  </CardContent>
</Card>
