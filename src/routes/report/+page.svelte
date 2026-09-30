<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Button from '$lib/components/ui/button.svelte';
</script>

<svelte:head><title>Report — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Report</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Pusat semua laporan operasional.</p>

<div class="mt-3 grid gap-3 md:grid-cols-2 lg:grid-cols-3">
  {#each [
    { t: 'CSAT', d: 'Skor & distribusi kepuasan pelanggan.', to: '/report/csat' },
    { t: 'CSAT Interaction', d: 'Rating per interaksi & agent.', to: '/report/csat-interaction' },
    { t: 'Hasil Tiket', d: 'SLA & ringkasan penanganan tiket.', to: '/chat/v3/ticket/result' },
    { t: 'Email History', d: 'Jejak email masuk & keluar.', to: '/email/history' },
    { t: 'Agent Performance', d: 'Skor gabungan per agent.', to: '/agent/performance' },
    { t: 'Productivity', d: 'Utilisasi & beban per jam.', to: '/agent-productivity-dashboard' }
  ] as r}
    <Card>
      <CardHeader><CardTitle>{r.t}</CardTitle></CardHeader>
      <CardContent>
        <p class="text-sm text-slate-500">{r.d}</p>
        <Button href={r.to} size="sm" variant="secondary" class="mt-3">Buka laporan</Button>
      </CardContent>
    </Card>
  {/each}
</div>
