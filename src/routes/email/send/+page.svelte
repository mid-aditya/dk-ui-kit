<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import { emails } from '$lib/mock';

  let list = emails.filter((e) => e.status === 'send');
</script>

<svelte:head><title>Email Terkirim — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Email Terkirim</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Outbox & status pengiriman.</p>

<Card class="mt-3">
  <CardContent class="divide-y divide-slate-100 p-0 dark:divide-slate-800">
    {#each list as e}
      <div class="flex items-center gap-3 p-3">
        <span class="min-w-0 flex-1">
          <strong class="block truncate text-sm">{e.subject}</strong>
          <span class="text-xs text-slate-500">{e.snippet}</span>
        </span>
        <span class="flex shrink-0 items-center gap-2">
          <Badge variant="success">delivered</Badge>
          <span class="text-[11px] text-slate-400">{e.date}</span>
        </span>
      </div>
    {/each}
    {#if !list.length}<p class="p-6 text-center text-sm text-slate-400">Belum ada email terkirim.</p>{/if}
  </CardContent>
</Card>
