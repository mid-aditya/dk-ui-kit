<script lang="ts">
  import { cn } from '$lib/utils';
  import type { HTMLSelectAttributes } from 'svelte/elements';

  let { class: className = '', value = $bindable(), children }: HTMLSelectAttributes & { class?: string; children?: import('svelte').Snippet } = $props();
</script>

<div class="relative">
  <select
    bind:value
    class={cn(
      'flex h-9 w-full appearance-none rounded-lg border border-input bg-background pl-3 pr-9 py-1 text-sm font-medium text-foreground shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring hover:border-ring transition-colors',
      className
    )}
  >
    {@render children?.()}
  </select>
  <div 
    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
    style="color: var(--foreground); opacity: 0.5;"
  >
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
      <path d="m6 9 6 6 6-6"/>
    </svg>
  </div>
</div>
