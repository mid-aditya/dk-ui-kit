<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import { recordings } from '$lib/mock';
  import { Play, Pause } from 'lucide-svelte';

  let q = $state('');
  let playing = $state<string | null>(null);
  let list = $derived(recordings.filter((r) => !q || (r.agent + r.customer).toLowerCase().includes(q.toLowerCase())));
</script>

<svelte:head><title>Recordings — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Recordings</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Rekaman interaksi voice & evaluasi QA.</p>
  </div>
  <Button size="sm" variant="secondary" href="/recording-archive">Arsip</Button>
</div>

<!-- Search -->
<div class="mt-3 max-w-sm">
  <Input bind:value={q} placeholder="Cari agent / customer…" />
</div>

<!-- Recordings List -->
<Card class="mt-3">
  <CardContent class="divide-y divide-border p-0">
    {#each list as r}
      <div class="flex items-center gap-4 p-4 hover:bg-muted/50 transition-colors">
        <!-- Play Button -->
        <button
          onclick={() => (playing = playing === r.id ? null : r.id)}
          aria-label={playing === r.id ? 'Jeda' : 'Putar'}
          class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary text-primary-foreground shadow-sm hover:bg-primary-hover transition-colors"
        >
          {#if playing === r.id}
            <Pause size={20} />
          {:else}
            <Play size={20} />
          {/if}
        </button>

        <!-- Info -->
        <div class="min-w-0 flex-1">
          <div class="flex items-center justify-between gap-2">
            <strong class="truncate text-sm">{r.agent} → {r.customer}</strong>
            <Badge variant={r.score >= 85 ? 'success' : r.score >= 80 ? 'warning' : 'destructive'}>
              QA {r.score}
            </Badge>
          </div>
          <div class="flex items-center gap-2 text-xs text-muted-foreground">
            <span>{r.date}</span>
            <span>·</span>
            <span>{r.duration}</span>
          </div>
          
          <!-- Progress Bar (when playing) -->
          {#if playing === r.id}
            <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-muted">
              <div class="h-full w-1/3 rounded-full bg-primary transition-all"></div>
            </div>
          {/if}
        </div>
      </div>
    {:else}
      <div class="p-8 text-center text-sm text-muted-foreground">
        Tidak ada rekaman.
      </div>
    {/each}
  </CardContent>
</Card>
