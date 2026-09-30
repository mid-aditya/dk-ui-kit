<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { agents } from '$lib/mock';

  const stats = [
    { label: 'Utilisasi', value: '76%' },
    { label: 'Avg handle time', value: '6:12' },
    { label: 'First response', value: '1:48' },
    { label: 'Occupancy', value: '81%' }
  ];

  const hours = ['08', '10', '12', '14', '16', '18'];
  const load = [42, 78, 95, 88, 64, 30];
  let max = $derived(Math.max(...load));
</script>

<svelte:head><title>Agent Productivity Dashboard — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Agent Productivity Dashboard</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Utilisasi agent per jam & ringkasan harian.</p>
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

<!-- Charts Row -->
<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <!-- Hourly Load Chart -->
  <Card>
    <CardHeader><CardTitle>Beban percakapan per jam</CardTitle></CardHeader>
    <CardContent>
      <div class="flex h-36 items-end gap-2">
        {#each hours as h, i}
          <div class="flex flex-1 flex-col items-center gap-1">
            <div class="flex w-full flex-1 items-end rounded-lg bg-muted">
              <div 
                class="w-full rounded-lg transition-all" 
                style="height:{Math.round((load[i] / max) * 100)}%; background-color: var(--primary);"
              ></div>
            </div>
            <span class="text-[11px] text-muted-foreground">{h}</span>
          </div>
        {/each}
      </div>
    </CardContent>
  </Card>

  <!-- Agent Status -->
  <Card>
    <CardHeader><CardTitle>Status agent saat ini</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each agents as a}
        <div class="flex items-center justify-between">
          <span class="font-medium">{a.name}</span>
          <div class="flex items-center gap-2">
            <span class="text-xs text-muted-foreground">{a.chats} chat aktif</span>
            <Badge variant={a.status === 'online' ? 'success' : a.status === 'busy' ? 'warning' : 'secondary'}>
              {a.status}
            </Badge>
          </div>
        </div>
      {/each}
    </CardContent>
  </Card>
</div>

<!-- Productivity vs Target -->
<Card class="mt-3">
  <CardHeader><CardTitle>Produktivitas vs target</CardTitle></CardHeader>
  <CardContent class="space-y-4">
    {#each agents as a}
      <div>
        <div class="mb-2 flex justify-between text-sm">
          <span class="font-medium">{a.name}</span>
          <span class="text-muted-foreground">{a.chats + a.tickets}/30 kasus</span>
        </div>
        <Progress value={((a.chats + a.tickets) / 30) * 100} />
      </div>
    {/each}
  </CardContent>
</Card>
