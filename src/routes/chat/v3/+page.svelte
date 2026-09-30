<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import * as Tabs from '$lib/components/ui/tabs';
  import * as Avatar from '$lib/components/ui/avatar';
  import * as Message from '$lib/components/ui/message';
  import * as Bubble from '$lib/components/ui/bubble';
  import * as InputGroup from '$lib/components/ui/input-group';
  import { Send, Paperclip, Smile } from 'lucide-svelte';
  import { threads, tickets } from '$lib/mock';

  let selected = $state(threads[0]);
  let draft = $state('');
  let sideTab = $state('profile');
  let messages = $state([
    { id: 1, from: 'customer' as const, body: 'Halo, paket saya belum sampai?', time: '10:20' },
    { id: 2, from: 'agent' as const, body: 'Halo kak, boleh info nomor resinya?', time: '10:22' },
    { id: 3, from: 'customer' as const, body: 'Resi JNE123456789', time: '10:23' }
  ]);

  const initials = (name: string) =>
    name.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();

  function sendMessage() {
    if (!draft.trim()) return;
    messages = [...messages, { id: Date.now(), from: 'agent' as const, body: draft, time: 'Baru saja' }];
    draft = '';
  }

  // Enter = baris baru, Ctrl/Cmd+Enter = kirim
  function onInputKeydown(e: KeyboardEvent) {
    if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
      e.preventDefault();
      sendMessage();
    }
  }
</script>

<svelte:head><title>Chat — DK UI Kit</title></svelte:head>

<div class="flex h-[calc(100vh-8rem)] flex-col gap-3 xl:flex-row">
  <!-- Thread List -->
  <Card.Root class="flex w-full shrink-0 flex-col overflow-hidden xl:w-72">
    <div class="divide-y divide-border">
      {#each threads as t (t.id)}
        <button
          onclick={() => (selected = t)}
          class="flex w-full gap-3 p-4 text-left transition-colors hover:bg-muted/50"
          class:bg-muted={selected.id === t.id}
        >
          <Avatar.Root>
            <Avatar.Fallback>{initials(t.customer)}</Avatar.Fallback>
          </Avatar.Root>
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
  </Card.Root>

  <!-- Chat Area -->
  <Card.Root class="flex min-h-0 flex-1 flex-col overflow-hidden">
    <!-- Header -->
    <div class="flex shrink-0 items-center gap-3 border-b border-border px-4 py-3">
      <Avatar.Root>
        <Avatar.Fallback>{initials(selected.customer)}</Avatar.Fallback>
      </Avatar.Root>
      <div class="flex-1">
        <strong class="text-sm">{selected.customer}</strong>
        <Badge variant={selected.status === 'open' ? 'success' : 'warning'} class="ml-2">{selected.status}</Badge>
      </div>
      <Button size="sm" variant="secondary" href="/chat/v3/ticket/result">Lihat tiket</Button>
    </div>

    <!-- Messages -->
    <div class="flex flex-1 flex-col gap-4 overflow-y-auto bg-muted/30 p-4">
      {#each messages as m (m.id)}
        <Message.Root align={m.from === 'agent' ? 'end' : 'start'}>
          <Message.Avatar>
            <Avatar.Root class="size-8 text-xs">
              <Avatar.Fallback>{m.from === 'customer' ? initials(selected.customer) : 'AG'}</Avatar.Fallback>
            </Avatar.Root>
          </Message.Avatar>
          <Message.Content class="max-w-[75%]">
            <Bubble.Root variant={m.from === 'agent' ? 'default' : 'outline'} align={m.from === 'agent' ? 'end' : 'start'}>
              <Bubble.Content>{m.body}</Bubble.Content>
            </Bubble.Root>
            <Message.Footer>{m.time}</Message.Footer>
          </Message.Content>
        </Message.Root>
      {/each}
    </div>

    <!-- Input: shadcn InputGroup, Enter = baris baru, Ctrl/Cmd+Enter = kirim -->
    <div class="shrink-0 border-t border-border p-3">
      <InputGroup.Root class="gap-1 py-2">
        <InputGroup.Addon align="inline-start">
          <InputGroup.Button variant="ghost" size="icon-sm" aria-label="Lampirkan file">
            <Paperclip />
          </InputGroup.Button>
          <InputGroup.Button variant="ghost" size="icon-sm" aria-label="Tambah emoji">
            <Smile />
          </InputGroup.Button>
        </InputGroup.Addon>
        <InputGroup.Textarea
          bind:value={draft}
          placeholder="Tulis balasan… (Enter = baris baru, Ctrl+Enter = kirim)"
          rows={1}
          class="max-h-32 min-h-9 resize-none border-0 shadow-none"
          onkeydown={onInputKeydown}
        />
        <InputGroup.Addon align="inline-end">
          <InputGroup.Button variant="default" size="icon-sm" onclick={sendMessage} disabled={!draft.trim()} aria-label="Kirim pesan">
            <Send />
          </InputGroup.Button>
        </InputGroup.Addon>
      </InputGroup.Root>
    </div>
  </Card.Root>

  <!-- Side Panel -->
  <Card.Root class="hidden w-full shrink-0 flex-col overflow-hidden xl:flex xl:w-80">
    <Tabs.Root bind:value={sideTab} class="flex min-h-0 flex-1 flex-col">
      <Tabs.List class="w-full justify-start rounded-none border-b bg-transparent p-0">
        <Tabs.Trigger value="profile" class="rounded-none px-3 py-2 text-xs">Profil</Tabs.Trigger>
        <Tabs.Trigger value="ticket" class="rounded-none px-3 py-2 text-xs">Tiket</Tabs.Trigger>
        <Tabs.Trigger value="history" class="rounded-none px-3 py-2 text-xs">Riwayat</Tabs.Trigger>
      </Tabs.List>
      <div class="flex-1 overflow-auto p-4">
        {#if sideTab === 'profile'}
          <div class="mb-4 flex items-center gap-3">
            <Avatar.Root>
              <Avatar.Fallback>{initials(selected.customer)}</Avatar.Fallback>
            </Avatar.Root>
            <div>
              <div class="font-bold">{selected.customer}</div>
              <div class="text-xs text-muted-foreground">Customer sejak 2023</div>
            </div>
          </div>
          <dl class="flex flex-col gap-3 text-sm">
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
          <ul class="mt-4 flex flex-col gap-2">
            {#each tickets.slice(0, 3) as t (t.number)}
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
          <ul class="flex flex-col gap-2 text-xs">
            <li class="rounded-lg border border-border p-3">Chat 12 Sep — resolved oleh Kirana</li>
            <li class="rounded-lg border border-border p-3">Tiket T-2026-001 — open</li>
            <li class="rounded-lg border border-border p-3">Email 28 Agu — dibalas</li>
          </ul>
        {/if}
      </div>
    </Tabs.Root>
  </Card.Root>
</div>
