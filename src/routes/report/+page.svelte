<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Button } from '$lib/components/ui/button';

  const reports = [
    { title: 'CSAT', description: 'Skor & distribusi kepuasan pelanggan.', to: '/report/csat', icon: 'star' },
    { title: 'CSAT Interaction', description: 'Rating per interaksi & agent.', to: '/report/csat-interaction', icon: 'message' },
    { title: 'Hasil Tiket', description: 'SLA & ringkasan penanganan tiket.', to: '/chat/v3/ticket/result', icon: 'ticket' },
    { title: 'Email History', description: 'Jejak email masuk & keluar.', to: '/email/history', icon: 'mail' },
    { title: 'Agent Performance', description: 'Skor gabungan per agent.', to: '/agent/performance', icon: 'users' },
    { title: 'Productivity', description: 'Utilisasi & beban per jam.', to: '/agent-productivity-dashboard', icon: 'chart' }
  ];
</script>

<svelte:head><title>Report — DK UI Kit</title></svelte:head>

<div></div>

<!-- Reports Grid -->
<div class="mt-3 grid gap-3 md:grid-cols-2 lg:grid-cols-3">
  {#each reports as r}
    <Card.Root class="hover:shadow-md transition-shadow">
      <Card.Header>
        <Card.Title>{r.title}</Card.Title>
      </Card.Header>
      <Card.Content>
        <p class="text-sm text-muted-foreground">{r.description}</p>
        <Button href={r.to} size="sm" variant="secondary" class="mt-4 w-full">Buka laporan</Button>
      </Card.Content>
    </Card.Root>
  {/each}
</div>
