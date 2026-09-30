<script lang="ts">
  import { cn } from '$lib/utils';
  let { class: className = '', children }: { class?: string; children?: import('svelte').Snippet } = $props();
</script>

<h3 class={cn('font-bold leading-none tracking-tight text-foreground', className)}>{@render children?.()}</h3>
