<script lang="ts">
  import { cn } from '$lib/utils';

  type Option = {
    value: string;
    label: string;
    disabled?: boolean;
  };

  type Props = {
    class?: string;
    value?: string;
    placeholder?: string;
    options?: Option[];
    disabled?: boolean;
    onchange?: (value: string) => void;
  };

  let {
    class: className = '',
    value = $bindable(''),
    placeholder = 'Select...',
    options = [],
    disabled = false,
    onchange
  }: Props = $props();

  let open = $state(false);
  let triggerEl: HTMLButtonElement;

  function handleSelect(optValue: string) {
    value = optValue;
    open = false;
    onchange?.(optValue);
  }

  function handleKeydown(e: KeyboardEvent) {
    if (e.key === 'Escape') {
      open = false;
      triggerEl?.focus();
    }
  }

  function handleClickOutside(e: MouseEvent) {
    if (open && triggerEl && !triggerEl.closest('.select-wrapper')?.contains(e.target as Node)) {
      open = false;
    }
  }

  $effect(() => {
    if (open) {
      document.addEventListener('keydown', handleKeydown);
      document.addEventListener('click', handleClickOutside);
    } else {
      document.removeEventListener('keydown', handleKeydown);
      document.removeEventListener('click', handleClickOutside);
    }
    return () => {
      document.removeEventListener('keydown', handleKeydown);
      document.removeEventListener('click', handleClickOutside);
    };
  });

  let selectedLabel = $derived(
    options.find(o => o.value === value)?.label || placeholder
  );
</script>

<div class={cn('relative inline-block select-wrapper', className)}>
  <button
    bind:this={triggerEl}
    type="button"
    {disabled}
    onclick={() => !disabled && (open = !open)}
    class={cn(
      'flex h-9 w-full items-center justify-between rounded-lg border border-input bg-background px-3 py-1.5 text-sm font-medium text-foreground shadow-sm cursor-pointer',
      'focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring',
      'hover:border-ring transition-colors',
      'disabled:cursor-not-allowed disabled:opacity-50',
      open && 'ring-2 ring-ring border-ring'
    )}
  >
    <span class={cn(value ? 'text-foreground' : 'text-muted-foreground')}>
      {selectedLabel}
    </span>
    <svg 
      class={cn('transition-transform', open && 'rotate-180')} 
      width="14" 
      height="14" 
      viewBox="0 0 24 24" 
      fill="none" 
      stroke="currentColor" 
      stroke-width="2.6" 
      stroke-linecap="round" 
      stroke-linejoin="round"
    >
      <path d="m6 9 6 6 6-6"/>
    </svg>
  </button>

  {#if open}
    <div 
      class="absolute z-50 mt-1 w-full min-w-[8rem] overflow-hidden rounded-lg border bg-popover text-popover-foreground shadow-lg animate-in fade-in-0 zoom-in-95"
    >
      <div class="max-h-60 overflow-y-auto p-1">
        {#each options as opt}
          <button
            type="button"
            {disabled}
            onclick={() => !opt.disabled && handleSelect(opt.value)}
            class={cn(
              'relative flex w-full cursor-pointer select-none items-center rounded-md px-2 py-1.5 text-sm outline-none',
              'transition-colors',
              opt.value === value && 'bg-accent text-accent-foreground',
              opt.disabled && 'cursor-not-allowed opacity-50',
              !opt.disabled && opt.value !== value && 'hover:bg-accent hover:text-accent-foreground'
            )}
          >
            {opt.label}
            {#if opt.value === value}
              <svg class="ml-auto" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            {/if}
          </button>
        {/each}
      </div>
    </div>
  {/if}
</div>
