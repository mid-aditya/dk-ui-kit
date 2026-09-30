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

  const alignClasses = {
    start: 'left-0',
    center: 'left-1/2 -translate-x-1/2',
    end: 'right-0'
  };

  const sideClasses = {
    top: 'bottom-full mb-2',
    right: 'left-full ml-2',
    bottom: 'top-full mt-2',
    left: 'right-full mr-2'
  };
</script>

<div class={cn('relative inline-block', className)}>
  {#if trigger}
    <button onclick={() => handleOpenChange(!open)} type="button">
      {@render trigger()}
    </button>
  {/if}

  {#if open}
    <div
      class="absolute z-50 min-w-[8rem] overflow-hidden rounded-lg border bg-popover text-popover-foreground shadow-lg"
      class:left-0={align === 'start'}
      class:left-1\/2={align === 'center'}
      class.right-0={align === 'end'}
      class:translate-x-1\/2={align === 'center'}
      class:bottom-full={side === 'top'}
      class:mb-2={side === 'top'}
      class:top-full={side === 'bottom'}
      class:mt-2={side === 'bottom'}
      style={align === 'center' ? '' : ''}
    >
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
