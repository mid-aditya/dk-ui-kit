<script lang="ts">
  import { cn } from '$lib/utils';

  type Tab = { value: string; label: string };
  let { tabs, value = $bindable(''), class: className = '' }: { tabs: Tab[]; value?: string; class?: string } = $props();

  $effect(() => { if (!value && tabs.length) value = tabs[0].value; });
</script>

<div class={cn('flex gap-1 border-b border-border', className)} role="tablist">
  {#each tabs as t}
    <button
      role="tab"
      aria-selected={value === t.value}
      onclick={() => (value = t.value)}
      class={cn(
        'px-3 py-2 text-xs font-semibold transition-colors',
        value === t.value
          ? 'text-primary border-b-2 border-primary'
          : 'text-muted-foreground hover:text-foreground'
      )}
    >
      {t.label}
    </button>
  {/each}
</div>
