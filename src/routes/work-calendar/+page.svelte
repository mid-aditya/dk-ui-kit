<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';

  const days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
  // 1 = libur nasional/cuti bersama, 2 = shift penuh, 3 = shift terbatas
  const cells = [2, 2, 2, 2, 2, 3, 0, 2, 2, 1, 2, 2, 3, 0, 2, 2, 2, 2, 2, 3, 0, 2, 2, 2, 2, 2, 3, 0, 2, 2, 2];
  const legend = [
    { v: 2, l: 'Operasional penuh', c: 'bg-brand-500' },
    { v: 3, l: 'Shift terbatas', c: 'bg-amber-400' },
    { v: 1, l: 'Libur', c: 'bg-rose-400' },
    { v: 0, l: 'Tutup', c: 'bg-slate-200 dark:bg-slate-800' }
  ];
</script>

<svelte:head><title>Work Calendar — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Work Calendar</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Kalender operasional & hari libur bulan berjalan.</p>

<div class="mt-3 flex flex-wrap gap-3 text-xs text-slate-500">
  {#each legend as l}
    <span class="flex items-center gap-1.5"><span class="inline-block h-3 w-3 rounded {l.c}"></span>{l.l}</span>
  {/each}
</div>

<Card class="mt-3">
  <CardHeader>
    <div class="flex items-center justify-between">
      <CardTitle>September 2026</CardTitle>
      <Badge>28 hari operasional</Badge>
    </div>
  </CardHeader>
  <CardContent>
    <div class="grid grid-cols-7 gap-1.5 text-center text-[11px] font-semibold uppercase text-slate-400">
      {#each days as d}<div class="py-1">{d}</div>{/each}
    </div>
    <div class="mt-1 grid grid-cols-7 gap-1.5">
      {#each cells as c, i}
        <div
          class="flex aspect-square flex-col items-center justify-center rounded-xl border text-sm font-semibold {c === 2
            ? 'border-brand-100 bg-brand-50 text-brand-700 dark:border-brand-900 dark:bg-brand-950/40 dark:text-brand-300'
            : c === 3
              ? 'border-amber-100 bg-amber-50 text-amber-700 dark:border-amber-900 dark:bg-amber-950/40 dark:text-amber-300'
              : c === 1
                ? 'border-rose-100 bg-rose-50 text-rose-600 dark:border-rose-900 dark:bg-rose-950/40 dark:text-rose-300'
                : 'border-slate-100 bg-slate-50 text-slate-300 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-600'}"
        >
          {i + 1}
        </div>
      {/each}
    </div>
  </CardContent>
</Card>
