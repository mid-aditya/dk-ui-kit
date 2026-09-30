<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Tabs from '$lib/components/ui/tabs.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import { Send, User } from 'lucide-svelte';
  import { threads, tickets } from '$lib/mock';

  let selected = $state(threads[0]);
  let draft = $state('');
  let sideTab = $state('profile');
  let messages = $state([
    { from: 'customer', body: 'Halo, paket saya belum sampai?', time: '10:20' },
    { from: 'agent', body: 'Halo kak, boleh info nomor resinya?', time: '10:22' },
    { from: 'customer', body: 'Resi JNE123456789', time: '10:23' }
  ]);

  function send() {
    if (!draft.trim()) return;
    messages = [...messages, { from: 'agent', body: draft, time: 'sekarang' }];
    draft = '';
  }
</script>

<svelte:head><title>Chat — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-3 xl:h-[calc(100vh-140px)] xl:flex-row">
  <Card class="flex w-full shrink-0 flex-col overflow-hidden xl:w-72">
    <div class="divide-y divide-slate-100 dark:divide-slate-800">
      {#each threads as t}
        <button
          onclick={() => (selected = t)}
          class="flex w-full gap-3 p-3 text-left hover:bg-slate-50 dark:hover:bg-slate-800 {selected.id === t.id ? 'bg-brand-50 dark:bg-brand-950/40' : ''}"
        >
          <Avatar name={t.customer} />
          <span class="min-w-0 flex-1">
            <span class="flex justify-between gap-2"><strong class="truncate text-sm">{t.customer}</strong><span class="text-[11px] text-slate-400">{t.time}</span></span>
            <span class="mt-0.5 truncate text-xs text-slate-500">{t.last}</span>
          </span>
        </button>
      {/each}
    </div>
  </Card>

  <Card class="flex min-h-[50vh] flex-1 flex-col overflow-hidden">
    <div class="flex items-center gap-2 border-b border-slate-100 px-4 py-3 dark:border-slate-800">
      <strong>{selected.customer}</strong>
      <Badge variant={selected.status === 'open' ? 'success' : 'warning'}>{selected.status}</Badge>
      <div class="flex-1"></div>
      <Button size="sm" variant="secondary" href="/chat/v3/ticket/result">Lihat hasil tiket</Button>
    </div>
    <div class="flex-1 space-y-2 overflow-auto bg-slate-50 p-4 dark:bg-slate-950">
      {#each messages as m}
        <div class="flex {m.from === 'agent' ? 'justify-end' : 'justify-start'}">
          <div
            class="max-w-[75%] rounded-2xl px-3.5 py-2 text-sm shadow-sm {m.from === 'agent'
              ? 'rounded-br-md bg-brand-600 text-white'
              : 'rounded-bl-md border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800'}"
          >
            {m.body}
            <div class="mt-1 text-[10px] opacity-70">{m.time}</div>
          </div>
        </div>
      {/each}
    </div>
    <form onsubmit={(e) => { e.preventDefault(); send(); }} class="flex gap-2 border-t border-slate-100 p-3 dark:border-slate-800">
      <Input bind:value={draft} placeholder="Tulis balasan…" />
      <Button type="submit" disabled={!draft.trim()}><Send size={16} /></Button>
    </form>
  </Card>

  <Card class="hidden w-full shrink-0 flex-col overflow-hidden xl:flex xl:w-80">
    <Tabs bind:value={sideTab} tabs={[{ value: 'profile', label: 'Profil' }, { value: 'ticket', label: 'Tiket' }, { value: 'history', label: 'Riwayat' }]} />
    <div class="flex-1 overflow-auto p-4">
      {#if sideTab === 'profile'}
        <div class="mb-3 flex items-center gap-3">
          <Avatar name={selected.customer} />
          <div><div class="font-bold">{selected.customer}</div><div class="text-xs text-slate-400">Customer sejak 2023</div></div>
        </div>
        <dl class="space-y-2 text-sm">
          <div class="flex justify-between"><dt class="text-slate-500">Kanal</dt><dd class="font-medium">{selected.channel}</dd></div>
          <div class="flex justify-between"><dt class="text-slate-500">Segment</dt><dd class="font-medium">VIP</dd></div>
          <div class="flex justify-between"><dt class="text-slate-500">Total tiket</dt><dd class="font-medium">7</dd></div>
        </dl>
      {:else if sideTab === 'ticket'}
        <Button href="/ticketing" size="sm" class="w-full">Buat tiket baru</Button>
        <ul class="mt-3 space-y-2 text-xs">
          {#each tickets.slice(0, 3) as t}
            <li class="flex justify-between gap-2 rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">
              <span><strong class="font-mono">{t.number}</strong> — {t.subject}</span>
              <a href="/ticketing" class="shrink-0 font-semibold text-brand-600">Buka</a>
            </li>
          {/each}
        </ul>
      {:else}
        <ul class="space-y-1.5 text-xs">
          <li class="rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">Chat 12 Sep — resolved oleh Kirana</li>
          <li class="rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">Tiket T-2026-001 — open</li>
          <li class="rounded-xl border border-slate-200 px-3 py-2 dark:border-slate-700">Email 28 Agu — dibalas</li>
        </ul>
      {/if}
    </div>
  </Card>
</div>
