<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Badge } from '$lib/components/ui/badge';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import { Progress } from '$lib/components/ui/progress';
  import { agents } from '$lib/mock';

  let ranked = $derived([...agents].sort((a, b) => b.csat * 20 + b.chats - (a.csat * 20 + a.chats)));
  let maxChats = $derived(Math.max(1, ...agents.map((a) => a.chats)));
  const statusVariant = (s: string) => (s === 'online' ? 'success' : s === 'busy' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Agent Performance — DK UI Kit</title></svelte:head>

<div></div>

<!-- Performance Table -->
<Card.Root class="mt-3">
  <Card.Content class="p-0">
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
              <td class="px-4 py-3 text-right font-bold text-primary">{a.csat >= 4.7 ? "😊" : a.csat >= 4.5 ? "😐" : "😞"} {a.csat}</td>
              <td class="px-4 py-3"><Progress value={(a.chats / maxChats) * 100} class="w-28" /></td>
              <td class="px-4 py-3"><Badge variant={statusVariant(a.status)}>{a.status}</Badge></td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </Card.Content>
</Card.Root>

<!-- Top & Bottom Performers -->
<div class="mt-3 grid gap-3 md:grid-cols-2">
  <Card.Root>
    <Card.Header><Card.Title>Top CSAT minggu ini</Card.Title></Card.Header>
    <Card.Content>
      <div class="flex items-center gap-3">
        <Avatar name="Sinta Maharani" />
        <div>
          <div class="font-semibold">Sinta Maharani</div>
          <div class="text-sm text-muted-foreground">4.9 dari 87 survei</div>
        </div>
      </div>
    </Card.Content>
  </Card.Root>
  <Card.Root>
    <Card.Header><Card.Title>Butuh coaching</Card.Title></Card.Header>
    <Card.Content>
      <div class="flex items-center gap-3">
        <Avatar name="Raka Aditya" />
        <div>
          <div class="font-semibold">Raka Aditya</div>
          <div class="text-sm text-muted-foreground">CSAT 4.4 · tren turun 0.2</div>
        </div>
      </div>
    </Card.Content>
  </Card.Root>
</div>
