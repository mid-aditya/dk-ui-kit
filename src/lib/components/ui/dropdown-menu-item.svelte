<script lang="ts">
  import { cn } from '$lib/utils';

  type Props = {
    class?: string;
    disabled?: boolean;
    variant?: 'default' | 'destructive';
    children?: import('svelte').Snippet;
    onclick?: () => void;
  };

  let { class: className = '', disabled = false, variant = 'default', children, onclick }: Props = $props();
</script>

<button
  type="button"
  class={cn(
    'relative flex w-full cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none transition-colors',
    variant === 'default' && 'hover:bg-accent hover:text-accent-foreground',
    variant === 'destructive' && 'text-destructive hover:bg-destructive hover:text-destructive-foreground',
    disabled && 'pointer-events-none opacity-50',
    className
  )}
  {disabled}
  {onclick}
>
  {@render children?.()}
</button>
