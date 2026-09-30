<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import * as Avatar from '$lib/components/ui/avatar';
  import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
  import { threads } from '$lib/mock';

  let q = $state('');
  let filtered = $derived(
    threads.filter(
      (t) => !q || t.customer.toLowerCase().includes(q.toLowerCase()) || t.last.toLowerCase().includes(q.toLowerCase())
    )
  );
  const badge = (s: string) => (s === 'open' ? 'success' : s === 'pending' ? 'warning' : 'secondary');
  const initials = (name: string) =>
    name.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
</script>

<svelte:head><title>Threads — DK UI Kit</title></svelte:head>

<div></div>

<div class="mt-3 flex flex-wrap items-center gap-3">
  <div class="w-full max-w-xs">
    <Input bind:value={q} placeholder="Cari customer / pesan…" />
  </div>

  <!-- Filter Dropdown -->
  <DropdownMenu.Root>
    <DropdownMenu.Trigger>
      {#snippet child({ props })}
        <Button size="sm" variant="outline" {...props}>Filter</Button>
      {/snippet}
    </DropdownMenu.Trigger>
    <DropdownMenu.Content>
      <DropdownMenu.Item>Semua</DropdownMenu.Item>
      <DropdownMenu.Item>WhatsApp</DropdownMenu.Item>
      <DropdownMenu.Item>Email</DropdownMenu.Item>
      <DropdownMenu.Separator />
      <DropdownMenu.Item>Belum dibaca</DropdownMenu.Item>
      <DropdownMenu.Item>Assigned ke saya</DropdownMenu.Item>
    </DropdownMenu.Content>
  </DropdownMenu.Root>
</div>

<!-- Threads List -->
<Card.Root class="mt-3">
  <Card.Content class="divide-y divide-border p-0">
    {#each filtered as t (t.customer)}
      <a href="/chat/v3" class="flex items-center gap-3 p-4 hover:bg-muted/50 transition-colors">
        <Avatar.Root>
          <Avatar.Fallback>{initials(t.customer)}</Avatar.Fallback>
        </Avatar.Root>
        <span class="min-w-0 flex-1">
          <span class="flex justify-between gap-2">
            <strong class="truncate text-sm">{t.customer}</strong>
            <span class="shrink-0 text-xs text-muted-foreground">{t.time}</span>
          </span>
          <span class="mt-0.5 flex items-center gap-2 text-xs text-muted-foreground">
            <Badge variant="outline" class="text-[10px]">{t.channel}</Badge>
            <span class="truncate">{t.last}</span>
          </span>
        </span>
        <span class="flex shrink-0 flex-col items-end gap-1">
          <Badge variant={badge(t.status)}>{t.status}</Badge>
          {#if t.unread}
            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-primary text-[10px] font-bold text-primary-foreground">{t.unread}</span>
          {/if}
        </span>
      </a>
    {:else}
      <div class="p-8 text-center text-sm text-muted-foreground">
        Tidak ada hasil pencarian.
      </div>
    {/each}
  </Card.Content>
</Card.Root>

<!-- Quick Filters -->
<div class="mt-3">
  <Card.Root>
    <Card.Header>
      <Card.Title>Filter cepat</Card.Title>
    </Card.Header>
    <Card.Content class="flex flex-wrap gap-2">
      <Button size="sm" variant="secondary">Semua</Button>
      <Button size="sm" variant="secondary">WhatsApp</Button>
      <Button size="sm" variant="secondary">Email</Button>
      <Button size="sm" variant="secondary">Belum dibaca</Button>
      <Button size="sm" variant="secondary">Assigned ke saya</Button>
    </Card.Content>
  </Card.Root>
</div>
