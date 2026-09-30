<script lang="ts">
  import { cn } from '$lib/utils';

  type Props = {
    class?: string;
    inset?: boolean;
    children?: import('svelte').Snippet;
  };

  let { class: className = '', inset = false, children }: Props = $props();
</script>

<div class={cn('px-2 py-1.5 text-xs font-semibold text-muted-foreground', inset && 'pl-8', className)}>
  {@render children?.()}
</div>
