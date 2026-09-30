<script lang="ts">
  import { cn } from '$lib/utils';

  type Props = {
    class?: string;
    variant?: 'sent' | 'received';
    children?: import('svelte').Snippet;
    timestamp?: string;
    avatar?: string;
    showAvatar?: boolean;
  };

  let {
    class: className = '',
    variant = 'received',
    children,
    timestamp,
    avatar,
    showAvatar = true
  }: Props = $props();
</script>

<div
  class={cn('flex gap-2', variant === 'sent' ? 'flex-row-reverse' : 'flex-row', className)}
>
  <!-- Avatar -->
  {#if showAvatar && avatar}
    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-muted text-xs font-bold">
      {avatar.slice(0, 2).toUpperCase()}
    </div>
  {:else if showAvatar}
    <div class="w-8 shrink-0"></div>
  {/if}

  <!-- Bubble -->
  <div class="flex max-w-[75%] flex-col gap-1" class:items-end={variant === 'sent'} class:items-start={variant === 'received'}>
    <div
      class={cn(
        'rounded-2xl px-4 py-2 text-sm shadow-sm',
        variant === 'sent'
          ? 'rounded-br-md bg-primary text-primary-foreground'
          : 'rounded-bl-md border bg-background dark:bg-card'
      )}
    >
      {@render children?.()}
    </div>
    
    {#if timestamp}
      <span class="text-[10px] text-muted-foreground">
        {timestamp}
      </span>
    {/if}
  </div>
</div>
