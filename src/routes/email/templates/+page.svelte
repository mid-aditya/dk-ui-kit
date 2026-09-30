<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import { templates } from '$lib/mock';
</script>

<svelte:head><title>Email Templates — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Email Templates</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Template siap pakai dengan variabel.</p>
  </div>
  <Button size="sm">Template baru</Button>
</div>

<div class="mt-3 grid gap-3 md:grid-cols-2 lg:grid-cols-3">
  {#each templates as t}
    <Card>
      <CardContent class="p-4">
        <div class="flex items-center justify-between gap-2">
          <strong>{t.name}</strong>
          <Badge>aktif</Badge>
        </div>
        <p class="mt-2 rounded-lg bg-slate-50 p-2 font-mono text-xs text-slate-500 dark:bg-slate-800 dark:text-slate-400">{t.subject}</p>
        <div class="mt-3 flex gap-2">
          <Button size="sm" variant="secondary" class="flex-1" href="/email/compose">Pakai</Button>
          <Button size="sm" variant="secondary" class="flex-1">Duplikat</Button>
        </div>
      </CardContent>
    </Card>
  {/each}
</div>
