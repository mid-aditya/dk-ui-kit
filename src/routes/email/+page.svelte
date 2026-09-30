<script lang="ts">
  import { page } from '$app/state';
  import Card from '$lib/components/ui/card.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Tabs from '$lib/components/ui/tabs.svelte';
  import EmailItem from '$lib/components/ui/email-item.svelte';
  import { emails } from '$lib/mock';

  let q = $state('');
  let activeTab = $state('inbox');
  let list = $derived(
    emails.filter(
      (e) => e.status === activeTab && (!q || (e.subject + e.from).toLowerCase().includes(q.toLowerCase()))
    )
  );

  const tabs = [
    { value: 'inbox', label: 'Inbox' },
    { value: 'draft', label: 'Draft' },
    { value: 'send', label: 'Terkirim' }
  ];
</script>

<svelte:head><title>Email — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-end">
  <Button href="/email/compose" size="sm">Tulis email</Button>
</div>

<!-- Tabs -->
<div class="mt-3">
  <Tabs bind:value={activeTab} {tabs} />
</div>

<!-- Quick Links -->
<div class="mt-2 flex flex-wrap gap-2">
  <Button size="sm" variant="ghost" href="/email/history">History</Button>
  <Button size="sm" variant="ghost" href="/email/templates">Templates</Button>
</div>

<!-- Search -->
<div class="mt-3 max-w-sm">
  <Input bind:value={q} placeholder="Cari email…" />
</div>

<!-- Email List -->
<Card class="mt-3">
  <div class="divide-y divide-border">
    {#each list as e}
      <EmailItem
        from={e.from}
        subject={e.subject}
        snippet={e.snippet}
        date={e.date}
        read={e.status === 'send'}
        onClick={() => console.log('Open email:', e.from)}
      />
    {:else}
      <div class="p-8 text-center text-sm text-muted-foreground">
        {#if activeTab === 'draft'}
          Tidak ada draft. <a href="/email/compose" class="font-semibold text-primary">Tulis email baru</a>
        {:else}
          Kotak masuk kosong.
        {/if}
      </div>
    {/each}
  </div>
</Card>
