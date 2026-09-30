<script lang="ts">
  import { cn } from '$lib/utils';

  const AVATAR_BG = ['bg-brand-500', 'bg-sky-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-violet-500'];

  let { name = '?', class: className = '' }: { name?: string; class?: string } = $props();

  let initials = $derived(
    name
      .split(' ')
      .map((w) => w[0])
      .slice(0, 2)
      .join('')
      .toUpperCase() || '?'
  );
  let bg = $derived.by(() => {
    let h = 0;
    for (const ch of name) h += ch.charCodeAt(0);
    return AVATAR_BG[h % AVATAR_BG.length];
  });
</script>

<span class={cn('inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-xs font-bold text-white', bg, className)}>
  {initials}
</span>
