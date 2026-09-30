<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import { agents, schedule } from '$lib/mock';
</script>

<svelte:head><title>Agent Schedule — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Agent Schedule</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Shift & penugasan agent minggu ini.</p>
  </div>
  <Button size="sm">Atur shift</Button>
</div>

<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <Card>
    <CardHeader><CardTitle>Jadwal shift</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        {#each schedule as s}
          <li class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">
            <span class="font-semibold">{s.day}</span>
            <span class="text-slate-500">{s.shift}</span>
            <Badge>{s.agents} agent</Badge>
          </li>
        {/each}
      </ul>
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>Agent bertugas hari ini</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        {#each agents as a}
          <li class="flex items-center justify-between border-b border-slate-100 pb-2 dark:border-slate-800">
            <span class="flex items-center gap-3"><Avatar name={a.name} /><span class="font-medium">{a.name}</span></span>
            <Badge variant={a.status === 'online' ? 'success' : 'secondary'}>{a.status}</Badge>
          </li>
        {/each}
      </ul>
    </CardContent>
  </Card>
</div>
