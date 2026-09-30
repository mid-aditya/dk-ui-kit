<script lang="ts">
  import { cn } from '$lib/utils';
  import type { HTMLInputAttributes } from 'svelte/elements';

  let { class: className = '', value = $bindable(), ...rest }: HTMLInputAttributes & { class?: string } = $props();
</script>

<input
  bind:value
  class={cn(
    'flex h-9 w-full rounded-lg border border-input bg-background px-3 py-1 text-sm text-foreground shadow-sm transition-colors placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring disabled:cursor-not-allowed disabled:opacity-50',
    className
  )}
  {...rest}
/>
