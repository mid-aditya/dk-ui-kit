<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import { threads } from '$lib/mock';

  let q = $state('');
  let filtered = $derived(
    threads.filter(
      (t) => !q || t.customer.toLowerCase().includes(q.toLowerCase()) || t.last.toLowerCase().includes(q.toLowerCase())
    )
  );
  const badge = (s: string) => (s === 'open' ? 'success' : s === 'pending' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Threads — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Threads</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Semua percakapan lintas kanal.</p>
  </div>
  <Button href="/chat/v3" size="sm">Buka chat</Button>
</div>

<div class="mt-3 max-w-xs"><Input bind:value={q} placeholder="Cari customer / pesan…" /></div>

<Card class="mt-3">
  <CardContent class="divide-y divide-slate-100 p-0 dark:divide-slate-800">
    {#each filtered as t}
      <a href="/chat/v3" class="flex items-center gap-3 p-3 hover:bg-slate-50 dark:hover:bg-slate-800">
        <Avatar name={t.customer} />
        <span class="min-w-0 flex-1">
          <span class="flex justify-between gap-2">
            <strong class="truncate text-sm">{t.customer}</strong>
            <span class="shrink-0 text-[11px] text-slate-400">{t.time}</span>
          </span>
          <span class="mt-0.5 flex items-center gap-2 text-xs text-slate-500">
            <Badge variant="outline">{t.channel}</Badge>
            <span class="truncate">{t.last}</span>
          </span>
        </span>
        <span class="flex shrink-0 flex-col items-end gap-1">
          <Badge variant={badge(t.status)}>{t.status}</Badge>
          {#if t.unread}<span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-600 text-[10px] font-bold text-white">{t.unread}</span>{/if}
        </span>
      </a>
    {/each}
    {#if !filtered.length}<p class="p-6 text-center text-sm text-slate-400">Tidak ada hasil.</p>{/if}
  </CardContent>
</Card>

<div class="mt-3">
  <Card>
    <CardHeader><CardTitle>Filter cepat</CardTitle></CardHeader>
    <CardContent class="flex flex-wrap gap-2">
      <Button size="sm" variant="secondary">Semua</Button>
      <Button size="sm" variant="secondary">WhatsApp</Button>
      <Button size="sm" variant="secondary">Email</Button>
      <Button size="sm" variant="secondary">Belum dibaca</Button>
      <Button size="sm" variant="secondary">Assigned ke saya</Button>
    </CardContent>
  </Card>
</div>
