<script lang="ts">
  import { cn } from '$lib/utils';
  import { Star, Paperclip } from 'lucide-svelte';

  type Props = {
    class?: string;
    from: string;
    subject: string;
    snippet?: string;
    date: string;
    read?: boolean;
    starred?: boolean;
    attachments?: number;
    onClick?: () => void;
  };

  let {
    class: className = '',
    from,
    subject,
    snippet = '',
    date,
    read = false,
    starred = false,
    attachments = 0,
    onClick
  }: Props = $props();

  let isStarred = $state(starred);

  function toggleStar(e: MouseEvent) {
    e.stopPropagation();
    isStarred = !isStarred;
  }

  function getInitial(name: string): string {
    return name.charAt(0).toUpperCase();
  }
</script>

<div
  role="button"
  tabindex="0"
  onclick={onClick}
  onkeydown={(e) => e.key === 'Enter' && onClick?.()}
  class={cn(
    'flex w-full items-start gap-3 px-4 py-3 text-left transition-colors hover:bg-accent/50 cursor-pointer',
    !read && 'bg-muted/30',
    className
  )}
>
  <!-- Avatar -->
  <div
    class={cn(
      'flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-bold',
      read ? 'bg-muted text-muted-foreground' : 'bg-primary text-primary-foreground'
    )}
  >
    {getInitial(from)}
  </div>

  <!-- Content -->
  <div class="flex min-w-0 flex-1 flex-col gap-0.5">
    <!-- Header row -->
    <div class="flex items-center justify-between gap-2">
      <span class={cn('truncate text-sm font-medium', !read && 'font-semibold')}>
        {from}
      </span>
      <span class="shrink-0 text-xs text-muted-foreground">
        {date}
      </span>
    </div>

    <!-- Subject -->
    <div class="flex items-center gap-2">
      <span class={cn('truncate text-sm', !read && 'font-semibold')}>
        {subject}
      </span>
      {#if attachments > 0}
        <Paperclip size={12} class="shrink-0 text-muted-foreground" />
      {/if}
      {#if isStarred}
        <Star size={12} class="shrink-0 fill-yellow-400 text-yellow-400" />
      {/if}
    </div>

    <!-- Snippet -->
    {#if snippet}
      <p class="truncate text-xs text-muted-foreground">
        {snippet}
      </p>
    {/if}
  </div>

  <!-- Star button -->
  <button
    type="button"
    onclick={toggleStar}
    class="shrink-0 rounded p-1 hover:bg-accent"
    aria-label={isStarred ? 'Remove star' : 'Add star'}
  >
    <Star size={16} class={isStarred ? 'fill-yellow-400 text-yellow-400' : 'text-muted-foreground'} />
  </button>
</div>
