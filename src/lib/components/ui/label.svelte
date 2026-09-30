<script lang="ts">
  import { cn } from '$lib/utils';
  let { class: className = '', children, for: forId = undefined }: { class?: string; children?: import('svelte').Snippet; for?: string } = $props();
</script>

<label for={forId} class={cn('text-xs font-semibold text-muted-foreground', className)}>{@render children?.()}</label>
