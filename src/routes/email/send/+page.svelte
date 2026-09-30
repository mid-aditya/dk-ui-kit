<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { emails } from '$lib/mock';

  let list = $derived(emails.filter((e) => e.status === 'send'));
</script>

<svelte:head><title>Email Terkirim — DK UI Kit</title></svelte:head>

<div></div>

<!-- Sent Emails List -->
<Card.Root class="mt-3">
  <Card.Content class="divide-y divide-border p-0">
    {#each list as e}
      <div class="flex items-center gap-4 p-4 hover:bg-muted/50 transition-colors">
        <!-- Icon -->
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" x2="11" y1="2" y2="13"></line>
            <polygon points="22 2 15 22 11 13 2 9 22 2 22 2 22 2"></polygon>
          </svg>
        </div>

        <!-- Content -->
        <div class="min-w-0 flex-1">
          <div class="flex items-center justify-between gap-2">
            <strong class="truncate text-sm">{e.subject}</strong>
            <Badge variant="success" class="shrink-0">Delivered</Badge>
          </div>
          <p class="truncate text-xs text-muted-foreground">{e.snippet}</p>
        </div>

        <!-- Time -->
        <span class="shrink-0 text-xs text-muted-foreground">{e.date}</span>
      </div>
    {:else}
      <div class="p-8 text-center">
        <p class="text-sm text-muted-foreground">Belum ada email terkirim.</p>
        <Button href="/email/compose" size="sm" class="mt-2">Tulis email baru</Button>
      </div>
    {/each}
  </Card.Content>
</Card.Root>
