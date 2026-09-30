<script lang="ts">
  import { cn } from '$lib/utils';

  type Props = {
    class?: string;
    children?: import('svelte').Snippet;
    open?: boolean;
    onClose?: () => void;
    title?: string;
  };

  let { class: className = '', children, open = false, onClose, title = '' }: Props = $props();

  function onKey(e: KeyboardEvent) {
    if (e.key === 'Escape') onClose?.();
  }
</script>

<svelte:window on:keydown={onKey} />

{#if open}
  <div class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
    <button aria-label="Tutup" class="absolute inset-0 cursor-default" style="background-color: rgba(0,0,0,0.5);" onclick={onClose}></button>
    <div class={cn('relative w-full max-w-lg max-h-[90vh] overflow-auto rounded-lg border bg-card text-card-foreground shadow-xl', className)}>
      {#if title}
        <div class="flex items-center justify-between border-b px-5 py-4">
          <h2 class="font-bold text-foreground">{title}</h2>
          <button onclick={onClose} class="text-muted-foreground hover:text-foreground text-xl leading-none transition-colors">×</button>
        </div>
      {/if}
      <div class="p-5">{@render children?.()}</div>
    </div>
  </div>
{/if}
