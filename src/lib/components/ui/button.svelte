<script lang="ts" module>
  import { cva, type VariantProps } from 'class-variance-authority';

  export const buttonVariants = cva(
    'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-lg text-sm font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 active:scale-[.98]',
    {
      variants: {
        variant: {
          default: 'bg-primary text-primary-foreground shadow hover:bg-primary-hover',
          secondary: 'bg-secondary text-secondary-foreground shadow-sm hover:bg-secondary/80',
          destructive: 'bg-destructive text-destructive-foreground shadow-sm hover:bg-destructive/90',
          outline: 'border border-input bg-transparent hover:bg-accent hover:text-accent-foreground',
          ghost: 'hover:bg-accent hover:text-accent-foreground',
          link: 'text-primary underline-offset-4 hover:underline'
        },
        size: {
          default: 'h-10 px-4 py-2',
          sm: 'h-9 rounded-md px-3',
          lg: 'h-11 rounded-md px-8',
          icon: 'h-10 w-10'
        }
      },
      defaultVariants: {
        variant: 'default',
        size: 'default'
      }
    }
  );

  export type ButtonVariant = VariantProps<typeof buttonVariants>['variant'];
  export type ButtonSize = VariantProps<typeof buttonVariants>['size'];
</script>

<script lang="ts">
  import { cn } from '$lib/utils';
  import type { HTMLAnchorAttributes, HTMLButtonAttributes } from 'svelte/elements';

  type Props = (HTMLButtonAttributes | HTMLAnchorAttributes) & {
    variant?: ButtonVariant;
    size?: ButtonSize;
    href?: string;
  };

  let { class: className = '', variant = 'default', size = 'default', href = undefined, children, ...rest }: Props = $props();
</script>

{#if href}
  <a {href} class={cn(buttonVariants({ variant, size }), className)} {...rest}>{@render children?.()}</a>
{:else}
  <button class={cn(buttonVariants({ variant, size }), className)} {...rest}>{@render children?.()}</button>
{/if}
