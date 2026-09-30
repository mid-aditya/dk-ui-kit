<script lang="ts">
  import { cn } from '$lib/utils';

  type Props = {
    class?: string;
    align?: 'start' | 'center' | 'end';
    side?: 'top' | 'right' | 'bottom' | 'left';
    sideOffset?: number;
    children?: import('svelte').Snippet;
    trigger?: import('svelte').Snippet;
    open?: boolean;
    onOpenChange?: (open: boolean) => void;
  };

  let {
    class: className = '',
    align = 'end',
    side = 'bottom',
    sideOffset = 4,
    children,
    trigger,
    open = $bindable(false),
    onOpenChange
  }: Props = $props();

  function handleOpenChange(newOpen: boolean) {
    open = newOpen;
    onOpenChange?.(newOpen);
  }

  let dropdownClasses = $derived(cn(
    'absolute z-50 min-w-[8rem] overflow-hidden rounded-lg border bg-popover text-popover-foreground shadow-lg',
    align === 'start' && 'left-0',
    align === 'center' && 'left-1/2 -translate-x-1/2',
    align === 'end' && 'right-0',
    side === 'top' && 'bottom-full mb-2',
    side === 'bottom' && 'top-full mt-2',
    side === 'left' && 'right-full mr-2',
    side === 'right' && 'left-full ml-2'
  ));
</script>

<div class={cn('relative inline-block', className)}>
  {#if trigger}
    <button onclick={() => handleOpenChange(!open)} type="button">
      {@render trigger()}
    </button>
  {/if}

  {#if open}
    <div class={dropdownClasses}>
      {@render children?.()}
    </div>

    <!-- Backdrop -->
    <button
      class="fixed inset-0 z-40 cursor-default"
      onclick={() => handleOpenChange(false)}
      aria-label="Close menu"
    ></button>
  {/if}
</div>
