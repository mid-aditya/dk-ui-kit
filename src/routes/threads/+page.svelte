<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Avatar from '$lib/components/ui/avatar.svelte';
  import DropdownMenu from '$lib/components/ui/dropdown-menu.svelte';
  import DropdownMenuItem from '$lib/components/ui/dropdown-menu-item.svelte';
  import DropdownMenuSeparator from '$lib/components/ui/dropdown-menu-separator.svelte';
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

<div></div>

<div class="mt-3 flex flex-wrap items-center gap-3">
  <div class="w-full max-w-xs">
    <Input bind:value={q} placeholder="Cari customer / pesan…" />
  </div>
  
  <!-- Filter Dropdown -->
  <DropdownMenu>
    {#snippet trigger()}
      <Button size="sm" variant="outline">Filter</Button>
    {/snippet}
    <DropdownMenuItem>Semua</DropdownMenuItem>
    <DropdownMenuItem>WhatsApp</DropdownMenuItem>
    <DropdownMenuItem>Email</DropdownMenuItem>
    <DropdownMenuSeparator />
    <DropdownMenuItem>Belum dibaca</DropdownMenuItem>
    <DropdownMenuItem>Assigned ke saya</DropdownMenuItem>
  </DropdownMenu>
</div>

<!-- Threads List -->
<Card class="mt-3">
  <CardContent class="divide-y divide-border p-0">
    {#each filtered as t}
      <a href="/chat/v3" class="flex items-center gap-3 p-4 hover:bg-muted/50 transition-colors">
        <Avatar name={t.customer} />
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
  </CardContent>
</Card>

<!-- Quick Filters -->
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
