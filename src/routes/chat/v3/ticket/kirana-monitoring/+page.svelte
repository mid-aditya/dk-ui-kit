<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { Radio } from 'lucide-svelte';

  const stats = [
    { label: 'Antrian live', value: '7' },
    { label: 'Agent available', value: '9' },
    { label: 'Wait time', value: '1:22' },
    { label: 'Abandoned', value: '2%' }
  ];

  const queues = [
    { channel: 'WhatsApp', value: 5 },
    { channel: 'Email', value: 1 },
    { channel: 'Voice', value: 1 }
  ];

  const agents = [
    { name: 'Kirana Ayu', status: 'call', duration: '03:12', badge: 'success' },
    { name: 'Bimo Prasetyo', status: 'chat ×3', badge: 'success' },
    { name: 'Sinta Maharani', status: 'wrap-up', badge: 'warning' }
  ];
</script>

<svelte:head><title>Kirana Monitoring — DK UI Kit</title></svelte:head>

<div class="flex items-center gap-3">
  <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-destructive text-white">
    <Radio size={20} />
  </div>
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Kirana Monitoring</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">
      Live monitoring antrian & agent <Badge variant="destructive">LIVE</Badge>
    </p>
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
  <!-- Queue per Channel -->
  <Card>
    <CardHeader><CardTitle>Antrian per kanal</CardTitle></CardHeader>
    <CardContent class="space-y-4">
      {#each queues as q}
        <div>
          <div class="mb-2 flex justify-between text-sm">
            <span class="font-medium">{q.channel}</span>
            <span class="text-muted-foreground">{q.value}</span>
          </div>
          <Progress value={(q.value / 5) * 100} />
        </div>
      {/each}
    </CardContent>
  </Card>

  <!-- Live Agents -->
  <Card>
    <CardHeader><CardTitle>Agent sedang live</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each agents as a}
        <div class="flex items-center justify-between border-b border-border pb-3 last:border-0 last:pb-0">
          <span class="font-medium">{a.name}</span>
          <Badge variant={a.badge}>{a.status}</Badge>
        </div>
      {/each}
    </CardContent>
  </Card>
</div>
