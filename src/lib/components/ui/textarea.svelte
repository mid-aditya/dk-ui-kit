<script lang="ts">
  import { cn } from '$lib/utils';
  import type { HTMLTextareaAttributes } from 'svelte/elements';

  let { class: className = '', value = $bindable(), ...rest }: HTMLTextareaAttributes & { class?: string } = $props();
</script>

<textarea
  bind:value
  class={cn(
    'flex min-h-[80px] w-full rounded-lg border border-input bg-background px-3 py-2 text-sm text-foreground shadow-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:border-ring disabled:opacity-50',
    className
  )}
  {...rest}
></textarea>
