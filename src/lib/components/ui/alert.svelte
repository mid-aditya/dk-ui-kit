<script lang="ts">
  import { cn } from '$lib/utils';
  import { AlertCircle, CheckCircle2, XCircle, Info, X } from 'lucide-svelte';

  type AlertVariant = 'default' | 'success' | 'warning' | 'destructive' | 'info';

  type Props = {
    class?: string;
    variant?: AlertVariant;
    title?: string;
    children?: import('svelte').Snippet;
    dismissible?: boolean;
    onDismiss?: () => void;
  };

  let {
    class: className = '',
    variant = 'default',
    title,
    children,
    dismissible = false,
    onDismiss
  }: Props = $props();

  let visible = $state(true);

  function dismiss() {
    visible = false;
    onDismiss?.();
  }

  const variantConfig = {
    default: {
      container: 'border-border bg-muted/50',
      icon: Info,
      iconClass: 'text-muted-foreground'
    },
    success: {
      container: 'border-emerald-200 bg-emerald-50 dark:border-emerald-900 dark:bg-emerald-950/50',
      icon: CheckCircle2,
      iconClass: 'text-emerald-600 dark:text-emerald-400'
    },
    warning: {
      container: 'border-amber-200 bg-amber-50 dark:border-amber-900 dark:bg-amber-950/50',
      icon: AlertCircle,
      iconClass: 'text-amber-600 dark:text-amber-400'
    },
    destructive: {
      container: 'border-red-200 bg-red-50 dark:border-red-900 dark:bg-red-950/50',
      icon: XCircle,
      iconClass: 'text-red-600 dark:text-red-400'
    },
    info: {
      container: 'border-blue-200 bg-blue-50 dark:border-blue-900 dark:bg-blue-950/50',
      icon: Info,
      iconClass: 'text-blue-600 dark:text-blue-400'
    }
  };

  const config = $derived(variantConfig[variant]);
  const Icon = config.icon;
</script>

{#if visible}
  <div
    class={cn(
      'relative w-full rounded-lg border p-4 pr-10',
      config.container,
      className
    )}
    role="alert"
  >
    <div class="flex gap-3">
      <div class={cn('shrink-0', config.iconClass)}>
        <Icon size={20} />
      </div>
      <div class="flex-1">
        {#if title}
          <h5 class="mb-1 font-semibold text-foreground">
            {title}
          </h5>
        {/if}
        <div class="text-sm text-muted-foreground">
          {@render children?.()}
        </div>
      </div>
    </div>

    {#if dismissible}
      <button
        type="button"
        onclick={dismiss}
        class="absolute right-2 top-2 rounded-md p-1 text-muted-foreground hover:bg-accent hover:text-foreground"
        aria-label="Dismiss"
      >
        <X size={16} />
      </button>
    {/if}
  </div>
{/if}
