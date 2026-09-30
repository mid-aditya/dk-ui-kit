<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import { templates } from '$lib/mock';
</script>

<svelte:head><title>Email Templates — DK UI Kit</title></svelte:head>

<div></div>

<!-- Templates Grid -->
<div class="mt-3 grid gap-3 md:grid-cols-2 lg:grid-cols-3">
  {#each templates as t}
    <Card class="hover:shadow-md transition-shadow">
      <CardContent class="p-4">
        <!-- Header -->
        <div class="flex items-center justify-between gap-2">
          <h3 class="font-semibold">{t.name}</h3>
          <Badge variant="success">Aktif</Badge>
        </div>

        <!-- Subject Preview -->
        <div class="mt-3 rounded-lg bg-muted p-3">
          <p class="text-xs text-muted-foreground">Subjek:</p>
          <p class="font-mono text-sm">{t.subject}</p>
        </div>

        <!-- Actions -->
        <div class="mt-4 flex gap-2">
          <Button size="sm" variant="secondary" href="/email/compose" class="flex-1">Pakai</Button>
          <Button size="sm" variant="outline" class="flex-1">Duplikat</Button>
        </div>
      </CardContent>
    </Card>
  {:else}
    <div class="col-span-full p-8 text-center">
      <p class="text-sm text-muted-foreground">Belum ada template.</p>
      <Button size="sm" class="mt-2">Buat template baru</Button>
    </div>
  {/each}
</div>
