<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Badge } from '$lib/components/ui/badge';
  import { Progress } from '$lib/components/ui/progress';
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

<div></div>

<!-- Stats Cards -->
<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each stats as s}
    <Card.Root class="hover:shadow-md transition-shadow">
      <Card.Content class="p-4">
        <div class="text-xs font-medium text-muted-foreground">{s.label}</div>
        <div class="mt-1 text-2xl font-extrabold">{s.value}</div>
      </Card.Content>
    </Card.Root>
  {/each}
</div>

<!-- Charts Row -->
<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <!-- Hourly Load Chart -->
  <Card.Root>
    <Card.Header><Card.Title>Beban percakapan per jam</Card.Title></Card.Header>
    <Card.Content>
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
    </Card.Content>
  </Card.Root>

  <!-- Agent Status -->
  <Card.Root>
    <Card.Header><Card.Title>Status agent saat ini</Card.Title></Card.Header>
    <Card.Content class="space-y-3">
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
    </Card.Content>
  </Card.Root>
</div>

<!-- Productivity vs Target -->
<Card.Root class="mt-3">
  <Card.Header><Card.Title>Produktivitas vs target</Card.Title></Card.Header>
  <Card.Content class="space-y-4">
    {#each agents as a}
      <div>
        <div class="mb-2 flex justify-between text-sm">
          <span class="font-medium">{a.name}</span>
          <span class="text-muted-foreground">{a.chats + a.tickets}/30 kasus</span>
        </div>
        <Progress value={((a.chats + a.tickets) / 30) * 100} />
      </div>
    {/each}
  </Card.Content>
</Card.Root>
