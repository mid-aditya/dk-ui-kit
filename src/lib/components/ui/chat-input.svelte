<script lang="ts">
  import { cn } from '$lib/utils';
  import { Send, Paperclip, Smile, Mic } from 'lucide-svelte';

  type Props = {
    class?: string;
    placeholder?: string;
    value?: string;
    onValueChange?: (value: string) => void;
    onSubmit?: () => void;
    disabled?: boolean;
    showAttachments?: boolean;
    showEmoji?: boolean;
    showMic?: boolean;
  };

  let {
    class: className = '',
    placeholder = 'Type a message...',
    value = $bindable(''),
    onValueChange,
    onSubmit,
    disabled = false,
    showAttachments = true,
    showEmoji = true,
    showMic = false
  }: Props = $props();

  function handleInput(e: Event) {
    const target = e.target as HTMLInputElement;
    value = target.value;
    onValueChange?.(value);
  }

  function handleKeyDown(e: KeyboardEvent) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      handleSubmit();
    }
  }

  function handleSubmit() {
    if (!value.trim() || disabled) return;
    onSubmit?.();
    value = '';
    onValueChange?.('');
  }
</script>

<div class={cn('flex items-end gap-2 rounded-lg border bg-background p-2', className)}>
  <!-- Attachment button -->
  {#if showAttachments}
    <button
      type="button"
      class="rounded-md p-2 text-muted-foreground hover:bg-accent hover:text-accent-foreground"
      aria-label="Attach file"
    >
      <Paperclip size={20} />
    </button>
  {/if}

  <!-- Emoji button -->
  {#if showEmoji}
    <button
      type="button"
      class="rounded-md p-2 text-muted-foreground hover:bg-accent hover:text-accent-foreground"
      aria-label="Add emoji"
    >
      <Smile size={20} />
    </button>
  {/if}

  <!-- Input -->
  <div class="flex-1">
    <input
      type="text"
      {value}
      {placeholder}
      {disabled}
      oninput={handleInput}
      onkeydown={handleKeyDown}
      class="w-full resize-none rounded-md border-0 bg-transparent px-2 py-1.5 text-sm outline-none focus:ring-0 placeholder:text-muted-foreground disabled:cursor-not-allowed disabled:opacity-50"
    />
  </div>

  <!-- Mic button -->
  {#if showMic}
    <button
      type="button"
      class="rounded-md p-2 text-muted-foreground hover:bg-accent hover:text-accent-foreground"
      aria-label="Record voice"
    >
      <Mic size={20} />
    </button>
  {/if}

  <!-- Send button -->
  <button
    type="button"
    onclick={handleSubmit}
    disabled={disabled || !value.trim()}
    class="rounded-md p-2 text-primary hover:bg-primary/10 disabled:cursor-not-allowed disabled:opacity-50"
    aria-label="Send message"
  >
    <Send size={20} />
  </button>
</div>
