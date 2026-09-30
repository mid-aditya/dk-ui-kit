<script lang="ts">
  import { page } from '$app/state';
  import Card from '$lib/components/ui/card.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import { emails } from '$lib/mock';

  let q = $state('');
  let status = $derived(page.url.searchParams.get('status') ?? 'inbox');
  let list = $derived(
    emails.filter(
      (e) => e.status === status && (!q || (e.subject + e.from).toLowerCase().includes(q.toLowerCase()))
    )
  );
  const tabs = [
    { v: 'inbox', l: 'Inbox' },
    { v: 'draft', l: 'Draft' },
    { v: 'send', l: 'Terkirim' }
  ];
</script>

<svelte:head><title>Email — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Email</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Kotak masuk & arsip email pelanggan.</p>
  </div>
  <Button href="/email/compose" size="sm">Tulis email</Button>
</div>

<div class="mt-3 flex flex-wrap gap-2">
  {#each tabs as t}
    <a
      href={t.v === 'inbox' ? '/email' : `/email?status=${t.v}`}
      class="rounded-lg px-3 py-1.5 text-xs font-semibold {status === t.v ? 'bg-brand-600 text-white' : 'bg-white text-slate-600 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700'}"
    >
      {t.l}
    </a>
  {/each}
  <a href="/email/history" class="rounded-lg px-3 py-1.5 text-xs font-semibold bg-white text-slate-600 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">History</a>
  <a href="/email/templates" class="rounded-lg px-3 py-1.5 text-xs font-semibold bg-white text-slate-600 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">Templates</a>
</div>

<div class="mt-3 max-w-xs"><Input bind:value={q} placeholder="Cari email…" /></div>

<Card class="mt-3">
  <CardContent class="divide-y divide-slate-100 p-0 dark:divide-slate-800">
    {#each list as e}
      <div class="flex gap-3 p-3 hover:bg-slate-50 dark:hover:bg-slate-800">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-700 dark:bg-brand-950 dark:text-brand-300">
          {e.from.slice(0, 1).toUpperCase()}
        </span>
        <span class="min-w-0 flex-1">
          <span class="flex justify-between gap-2"><strong class="truncate text-sm">{e.subject}</strong><span class="shrink-0 text-[11px] text-slate-400">{e.date}</span></span>
          <span class="block truncate text-xs text-slate-500">{e.snippet}</span>
          <span class="text-[11px] text-slate-400">{e.from}</span>
        </span>
      </div>
    {/each}
    {#if !list.length}
      <p class="p-6 text-center text-sm text-slate-400">Kosong. {#if status === 'draft'}<a class="font-semibold text-brand-600" href="/email/compose">Tulis draf baru →</a>{/if}</p>
    {/if}
  </CardContent>
</Card>
