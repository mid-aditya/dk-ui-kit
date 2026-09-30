<script lang="ts">
  import { cn } from '$lib/utils';
  import { X, Send, Paperclip, MoreHorizontal } from 'lucide-svelte';
  import { Button } from '$lib/components/ui/button';

  type Props = {
    class?: string;
    to?: string;
    subject?: string;
    body?: string;
    open?: boolean;
    onClose?: () => void;
    onSend?: (data: { to: string; subject: string; body: string }) => void;
  };

  let {
    class: className = '',
    to = $bindable(''),
    subject = $bindable(''),
    body = $bindable(''),
    open = $bindable(false),
    onClose,
    onSend
  }: Props = $props();

  function handleClose() {
    open = false;
    onClose?.();
  }

  function handleSend() {
    if (!to.trim() || !subject.trim()) return;
    onSend?.({ to, subject, body });
    to = '';
    subject = '';
    body = '';
    open = false;
  }
</script>

{#if open}
  <!-- Backdrop -->
  <button
    class="fixed inset-0 z-40 cursor-default bg-black/20"
    onclick={handleClose}
    aria-label="Close compose"
  ></button>

  <!-- Compose Window -->
  <div class={cn(
    'fixed bottom-0 right-4 z-50 w-full max-w-lg rounded-lg border bg-background shadow-2xl',
    className
  )}>
    <!-- Header -->
    <div class="flex items-center justify-between border-b px-4 py-3">
      <span class="text-sm font-semibold">New Message</span>
      <div class="flex items-center gap-1">
        <button
          type="button"
          class="rounded p-1 hover:bg-accent"
          aria-label="More options"
        >
          <MoreHorizontal size={16} />
        </button>
        <button
          type="button"
          onclick={handleClose}
          class="rounded p-1 hover:bg-accent"
          aria-label="Close"
        >
          <X size={16} />
        </button>
      </div>
    </div>

    <!-- Form -->
    <div class="space-y-2 p-4">
      <!-- To -->
      <div class="flex items-center gap-2 border-b">
        <span class="text-sm text-muted-foreground">To:</span>
        <input
          type="email"
          bind:value={to}
          placeholder="recipient@example.com"
          class="flex-1 border-0 bg-transparent py-2 text-sm outline-none placeholder:text-muted-foreground"
        />
      </div>

      <!-- Subject -->
      <div class="flex items-center gap-2 border-b">
        <span class="text-sm text-muted-foreground">Subject:</span>
        <input
          type="text"
          bind:value={subject}
          placeholder="Enter subject"
          class="flex-1 border-0 bg-transparent py-2 text-sm outline-none placeholder:text-muted-foreground"
        />
      </div>

      <!-- Body -->
      <textarea
        bind:value={body}
        placeholder="Write your message..."
        rows={8}
        class="w-full resize-none border-0 bg-transparent py-2 text-sm outline-none placeholder:text-muted-foreground"
      ></textarea>
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between border-t px-4 py-3">
      <button
        type="button"
        class="rounded p-2 text-muted-foreground hover:bg-accent hover:text-foreground"
        aria-label="Attach file"
      >
        <Paperclip size={20} />
      </button>

      <div class="flex items-center gap-2">
        <Button variant="ghost" size="sm" onclick={handleClose}>
          Discard
        </Button>
        <Button size="sm" onclick={handleSend} disabled={!to.trim() || !subject.trim()}>
          <Send size={14} />
          Send
        </Button>
      </div>
    </div>
  </div>
{/if}
