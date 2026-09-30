<script lang="ts">
  import { goto } from '$app/navigation';
  import { onMount } from 'svelte';
  onMount(() => goto('/home', { replaceState: true }));
</script>

<p class="p-6 text-sm text-slate-500">Mengalihkan…</p>
