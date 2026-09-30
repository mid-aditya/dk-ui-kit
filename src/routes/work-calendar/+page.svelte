<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';

  const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
  // 1 = libur nasional/cuti bersama, 2 = shift penuh, 3 = shift terbatas, 0 = tutup
  const cells = [2, 2, 2, 2, 2, 3, 0, 2, 2, 1, 2, 2, 3, 0, 2, 2, 2, 2, 2, 3, 0, 2, 2, 2, 2, 2, 3, 0, 2, 2, 2];
  
  const getDayStyle = (c: number) => {
    switch (c) {
      case 2: return 'bg-primary/10 border-primary/20 text-primary';
      case 3: return 'bg-amber-100 border-amber-200 text-amber-700 dark:bg-amber-950/40 dark:border-amber-900 dark:text-amber-300';
      case 1: return 'bg-rose-100 border-rose-200 text-rose-700 dark:bg-rose-950/40 dark:border-rose-900 dark:text-rose-300';
      default: return 'bg-muted border-border text-muted-foreground';
    }
  };
</script>

<svelte:head><title>Work Calendar — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Work Calendar</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Kalender operasional & hari libur bulan berjalan.</p>
  </div>
</div>

<!-- Legend -->
<div class="mt-3 flex flex-wrap gap-4 text-xs text-muted-foreground">
  <span class="flex items-center gap-1.5">
    <span class="inline-block h-3 w-3 rounded bg-primary"></span>Operasional penuh
  </span>
  <span class="flex items-center gap-1.5">
    <span class="inline-block h-3 w-3 rounded bg-amber-400"></span>Shift terbatas
  </span>
  <span class="flex items-center gap-1.5">
    <span class="inline-block h-3 w-3 rounded bg-rose-400"></span>Libur
  </span>
  <span class="flex items-center gap-1.5">
    <span class="inline-block h-3 w-3 rounded bg-muted"></span>Tutup
  </span>
</div>

<!-- Calendar -->
<Card class="mt-3">
  <CardHeader>
    <div class="flex items-center justify-between">
      <CardTitle>September 2026</CardTitle>
      <Badge>28 hari operasional</Badge>
    </div>
  </CardHeader>
  <CardContent>
    <!-- Weekday Headers -->
    <div class="grid grid-cols-7 gap-1.5 text-center text-[11px] font-semibold uppercase text-muted-foreground">
      {#each days as d}
        <div class="py-1">{d}</div>
      {/each}
    </div>
    
    <!-- Calendar Grid -->
    <div class="mt-1 grid grid-cols-7 gap-1.5">
      {#each cells as c, i}
        <div
          class="flex aspect-square flex-col items-center justify-center rounded-lg border text-sm font-semibold {getDayStyle(c)}"
        >
          {i + 1}
        </div>
      {/each}
    </div>
  </CardContent>
</Card>
