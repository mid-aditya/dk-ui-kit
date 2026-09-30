<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import { recordings } from '$lib/mock';
  import { Play } from 'lucide-svelte';

  let q = $state('');
  let playing = $state<string | null>(null);
  let list = $derived(recordings.filter((r) => !q || (r.agent + r.customer).toLowerCase().includes(q.toLowerCase())));
</script>

<svelte:head><title>Recordings — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Recordings</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Rekaman interaksi voice & evaluasi QA.</p>
  </div>
  <Button size="sm" variant="secondary" href="/recording-archive">Arsip</Button>
</div>

<div class="mt-3 max-w-xs"><Input bind:value={q} placeholder="Cari agent / customer…" /></div>

<Card class="mt-3">
  <CardContent class="divide-y divide-slate-100 p-0 dark:divide-slate-800">
    {#each list as r}
      <div class="flex items-center gap-3 p-3">
        <button
          onclick={() => (playing = playing === r.id ? null : r.id)}
          aria-label={playing === r.id ? 'Jeda' : 'Putar'}
          class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white hover:bg-brand-500"
        >
          {#if playing === r.id}<span class="text-xs font-bold">❚❚</span>{:else}<Play size={16} />{/if}
        </button>
        <span class="min-w-0 flex-1">
          <strong class="block truncate text-sm">{r.agent} → {r.customer}</strong>
          <span class="text-xs text-slate-400">{r.date} · {r.duration}</span>
          {#if playing === r.id}
            <span class="mt-1 block h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800"><span class="block h-full w-1/3 rounded-full bg-brand-500"></span></span>
          {/if}
        </span>
        <Badge variant={r.score >= 85 ? 'success' : r.score >= 80 ? 'warning' : 'destructive'}>QA {r.score}</Badge>
      </div>
    {/each}
    {#if !list.length}<p class="p-6 text-center text-sm text-slate-400">Tidak ada rekaman.</p>{/if}
  </CardContent>
</Card>
