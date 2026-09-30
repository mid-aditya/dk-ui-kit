<script lang="ts">
  import { cn } from '$lib/utils';
  let { value = 0, class: className = '' }: { value?: number; class?: string } = $props();
</script>

<div class={cn('h-2 overflow-hidden rounded-full bg-muted', className)} role="progressbar" aria-valuenow={Math.round(value)}>
  <div class="h-full rounded-full transition-all" style="width:{Math.max(0, Math.min(100, value))}%; background-color: var(--primary);"></div>
</div>
