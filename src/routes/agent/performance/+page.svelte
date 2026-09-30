<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { agents } from '$lib/mock';

  let ranked = $derived([...agents].sort((a, b) => b.csat * 20 + b.chats - (a.csat * 20 + a.chats)));
  let maxChats = $derived(Math.max(1, ...agents.map((a) => a.chats)));
  const statusVariant = (s: string) => (s === 'online' ? 'success' : s === 'busy' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Agent Performance — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Agent Performance</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Skor gabungan chat, tiket & CSAT per agent.</p>
  </div>
</div>

<!-- Performance Table -->
<Card class="mt-3">
  <CardContent class="p-0">
    <div class="overflow-auto rounded-lg border">
      <table class="w-full text-sm">
        <thead class="bg-muted text-xs uppercase text-muted-foreground">
          <tr>
            <th class="px-4 py-3 text-left font-semibold">Agent</th>
            <th class="px-4 py-3 text-right font-semibold">Chat</th>
            <th class="px-4 py-3 text-right font-semibold">Tiket</th>
            <th class="px-4 py-3 text-right font-semibold">CSAT</th>
            <th class="px-4 py-3 text-left font-semibold">Beban</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          {#each ranked as a}
            <tr class="border-b border-border last:border-0 hover:bg-muted/50">
              <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <Avatar name={a.name} />
                  <div>
                    <div class="font-semibold">{a.name}</div>
                    <div class="text-xs text-muted-foreground">{a.role}</div>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3 text-right">{a.chats}</td>
              <td class="px-4 py-3 text-right">{a.tickets}</td>
              <td class="px-4 py-3 text-right font-bold text-primary">★ {a.csat}</td>
              <td class="px-4 py-3"><Progress value={(a.chats / maxChats) * 100} class="w-28" /></td>
              <td class="px-4 py-3"><Badge variant={statusVariant(a.status)}>{a.status}</Badge></td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </CardContent>
</Card>

<!-- Top & Bottom Performers -->
<div class="mt-3 grid gap-3 md:grid-cols-2">
  <Card>
    <CardHeader><CardTitle>Top CSAT minggu ini</CardTitle></CardHeader>
    <CardContent>
      <div class="flex items-center gap-3">
        <Avatar name="Sinta Maharani" />
        <div>
          <div class="font-semibold">Sinta Maharani</div>
          <div class="text-sm text-muted-foreground">4.9 dari 87 survei</div>
        </div>
      </div>
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>Butuh coaching</CardTitle></CardHeader>
    <CardContent>
      <div class="flex items-center gap-3">
        <Avatar name="Raka Aditya" />
        <div>
          <div class="font-semibold">Raka Aditya</div>
          <div class="text-sm text-muted-foreground">CSAT 4.4 · tren turun 0.2</div>
        </div>
      </div>
    </CardContent>
  </Card>
</div>
