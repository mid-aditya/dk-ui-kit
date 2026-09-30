<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Tabs from '$lib/components/ui/tabs.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import ChatBubble from '$lib/components/ui/chat-bubble.svelte';
  import ChatInput from '$lib/components/ui/chat-input.svelte';
  import { threads, tickets } from '$lib/mock';

  let selected = $state(threads[0]);
  let draft = $state('');
  let sideTab = $state('profile');
  let messages = $state([
    { id: 1, from: 'customer' as const, body: 'Halo, paket saya belum sampai?', time: '10:20' },
    { id: 2, from: 'agent' as const, body: 'Halo kak, boleh info nomor resinya?', time: '10:22' },
    { id: 3, from: 'customer' as const, body: 'Resi JNE123456789', time: '10:23' }
  ]);

  function sendMessage() {
    if (!draft.trim()) return;
    messages = [...messages, { id: Date.now(), from: 'agent' as const, body: draft, time: 'Baru saja' }];
    draft = '';
  }
</script>

<svelte:head><title>Chat — DK UI Kit</title></svelte:head>

<div class="flex h-[calc(100vh-8rem)] flex-col gap-3 xl:flex-row">
  <!-- Thread List -->
  <Card class="flex w-full shrink-0 flex-col overflow-hidden xl:w-72">
    <div class="divide-y divide-border">
      {#each threads as t}
        <button
          onclick={() => (selected = t)}
          class="flex w-full gap-3 p-4 text-left transition-colors hover:bg-muted/50"
          class:bg-muted={selected.id === t.id}
        >
          <Avatar name={t.customer} />
          <span class="min-w-0 flex-1">
            <span class="flex justify-between gap-2">
              <strong class="truncate text-sm">{t.customer}</strong>
              <span class="text-[11px] text-muted-foreground">{t.time}</span>
            </span>
            <span class="mt-0.5 block truncate text-xs text-muted-foreground">{t.last}</span>
          </span>
        </button>
      {/each}
    </div>
  </Card>

  <!-- Chat Area -->
  <Card class="flex min-h-0 flex-1 flex-col overflow-hidden">
    <!-- Header -->
    <div class="flex shrink-0 items-center gap-3 border-b border-border px-4 py-3">
      <Avatar name={selected.customer} />
      <div class="flex-1">
        <strong class="text-sm">{selected.customer}</strong>
        <Badge variant={selected.status === 'open' ? 'success' : 'warning'} class="ml-2">{selected.status}</Badge>
      </div>
      <Button size="sm" variant="secondary" href="/chat/v3/ticket/result">Lihat tiket</Button>
    </div>

    <!-- Messages -->
    <div class="flex-1 space-y-4 overflow-y-auto bg-muted/30 p-4">
      {#each messages as m}
        <ChatBubble 
          variant={m.from === 'agent' ? 'sent' : 'received'}
          timestamp={m.time}
          avatar={m.from === 'customer' ? selected.customer : undefined}
        >
          {m.body}
        </ChatBubble>
      {/each}
    </div>

    <!-- Input -->
    <div class="shrink-0 border-t border-border p-3">
      <ChatInput bind:value={draft} placeholder="Tulis balasan..." onSubmit={sendMessage} />
    </div>
  </Card>

  <!-- Side Panel -->
  <Card class="hidden w-full shrink-0 flex-col overflow-hidden xl:flex xl:w-80">
    <Tabs bind:value={sideTab} tabs={[
      { value: 'profile', label: 'Profil' },
      { value: 'ticket', label: 'Tiket' },
      { value: 'history', label: 'Riwayat' }
    ]} />
    <div class="flex-1 overflow-auto p-4">
      {#if sideTab === 'profile'}
        <div class="mb-4 flex items-center gap-3">
          <Avatar name={selected.customer} />
          <div>
            <div class="font-bold">{selected.customer}</div>
            <div class="text-xs text-muted-foreground">Customer sejak 2023</div>
          </div>
        </div>
        <dl class="space-y-3 text-sm">
          <div class="flex justify-between">
            <dt class="text-muted-foreground">Kanal</dt>
            <dd class="font-medium">{selected.channel}</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-muted-foreground">Segment</dt>
            <dd class="font-medium">VIP</dd>
          </div>
          <div class="flex justify-between">
            <dt class="text-muted-foreground">Total tiket</dt>
            <dd class="font-medium">7</dd>
          </div>
        </dl>
      {:else if sideTab === 'ticket'}
        <Button href="/ticketing" size="sm" class="w-full">Buat tiket baru</Button>
        <ul class="mt-4 space-y-2">
          {#each tickets.slice(0, 3) as t}
            <li class="rounded-lg border border-border p-3 text-xs">
              <div class="flex justify-between gap-2">
                <span class="font-mono font-semibold">{t.number}</span>
                <span>— {t.subject}</span>
              </div>
              <a href="/ticketing" class="mt-1 block font-semibold text-primary">Buka</a>
            </li>
          {/each}
        </ul>
      {:else}
        <ul class="space-y-2 text-xs">
          <li class="rounded-lg border border-border p-3">Chat 12 Sep — resolved oleh Kirana</li>
          <li class="rounded-lg border border-border p-3">Tiket T-2026-001 — open</li>
          <li class="rounded-lg border border-border p-3">Email 28 Agu — dibalas</li>
        </ul>
      {/if}
    </div>
  </Card>
</div>
