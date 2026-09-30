<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import Alert from '$lib/components/ui/alert.svelte';
  import { agents } from '$lib/mock';

  const stats = [
    { label: 'Sedang dimonitor', value: '6' },
    { label: 'Eskalasi pending', value: '3', urgent: true },
    { label: 'Approval cuti', value: '2' },
    { label: 'QA score avg', value: '88' }
  ];

  const escalations = [
    { id: 'T-2026-001', reason: 'Pelanggan meminta SPV', type: 'ticket' },
    { id: 'chat-001', reason: 'Perlu diskresi refund', type: 'chat' }
  ];
</script>

<svelte:head><title>SPV — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">SPV</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Ruang kerja supervisor: monitoring, eskalasi & approval.</p>
  </div>
</div>

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
  <!-- Escalations -->
  <Card>
    <CardHeader><CardTitle>Eskalasi menunggu</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each escalations as e}
        <div class="flex items-center justify-between rounded-lg border border-border p-3">
          <div class="flex items-center gap-2">
            <Badge variant="warning">Pending</Badge>
            <span class="text-sm">
              {#if e.type === 'ticket'}
                {e.id} · {e.reason}
              {:else}
                {e.id} · {e.reason}
              {/if}
            </span>
          </div>
          <div class="flex gap-2">
            <Button size="sm">Ambil alih</Button>
            <Button size="sm" variant="secondary">Tolak</Button>
          </div>
        </div>
      {:else}
        <p class="text-sm text-muted-foreground">Tidak ada eskalasi.</p>
      {/each}
    </CardContent>
  </Card>

  <!-- Agent Monitoring -->
  <Card>
    <CardHeader><CardTitle>Agent dalam pantauan</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each agents.slice(0, 3) as a}
        <div class="flex items-center justify-between border-b border-border pb-3 last:border-0 last:pb-0">
          <div class="flex items-center gap-3">
            <Avatar name={a.name} />
            <span class="font-medium">{a.name}</span>
          </div>
          <div class="flex gap-2">
            <Button size="sm" variant="secondary" href="/recordings">Dengar</Button>
            <Button size="sm" variant="secondary" href="/chat/v3/ticket/kirana-monitoring">Live</Button>
          </div>
        </div>
      {/each}
    </CardContent>
  </Card>
</div>

<!-- Info Alert -->
<div class="mt-3">
  <Alert variant="info" title="Tips">
    Gunakan panel eskalasi untuk menangani ticket atau chat yang membutuhkan persetujuan supervisor.
  </Alert>
</div>
