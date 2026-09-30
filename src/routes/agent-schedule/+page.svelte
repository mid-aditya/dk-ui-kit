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

<div></div>

<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <!-- Shift Schedule -->
  <Card>
    <CardHeader><CardTitle>Jadwal shift</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each schedule as s}
        <div class="flex items-center justify-between rounded-lg border border-border p-3">
          <div class="flex items-center gap-3">
            <span class="font-semibold">{s.day}</span>
            <Badge variant="outline">{s.shift}</Badge>
          </div>
          <Badge>{s.agents} agent</Badge>
        </div>
      {/each}
    </CardContent>
  </Card>

  <!-- Today's Agents -->
  <Card>
    <CardHeader><CardTitle>Agent bertugas hari ini</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each agents as a}
        <div class="flex items-center justify-between border-b border-border pb-3 last:border-0 last:pb-0">
          <div class="flex items-center gap-3">
            <Avatar name={a.name} />
            <span class="font-medium">{a.name}</span>
          </div>
          <Badge variant={a.status === 'online' ? 'success' : 'secondary'}>{a.status}</Badge>
        </div>
      {/each}
    </CardContent>
  </Card>
</div>
