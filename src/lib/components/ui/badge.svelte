<script lang="ts" module>
  import { cva, type VariantProps } from 'class-variance-authority';

  export const badgeVariants = cva(
    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors',
    {
      variants: {
        variant: {
          default: 'bg-primary text-primary-foreground',
          secondary: 'bg-secondary text-secondary-foreground',
          destructive: 'bg-destructive text-destructive-foreground',
          outline: 'border border-input text-foreground',
          success: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
          warning: 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300'
        }
      },
      defaultVariants: {
        variant: 'default'
      }
    }
  );
  export type BadgeVariant = VariantProps<typeof badgeVariants>['variant'];
</script>

<script lang="ts">
  import { cn } from '$lib/utils';
  let { class: className = '', variant = 'default', children }: { class?: string; variant?: BadgeVariant; children?: import('svelte').Snippet } = $props();
</script>

<span class={cn(badgeVariants({ variant }), className)}>{@render children?.()}</span>
