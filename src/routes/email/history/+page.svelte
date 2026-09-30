<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import { emails } from '$lib/mock';
</script>

<svelte:head><title>Email History — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Email History</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Jejak lengkap email masuk & keluar.</p>

<Card class="mt-3">
  <CardContent class="p-0">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
        <tr><th class="px-3 py-2 text-left">Waktu</th><th class="px-3 py-2 text-left">Subjek</th><th class="px-3 py-2 text-left">Arah</th><th class="px-3 py-2 text-left">Status</th></tr>
      </thead>
      <tbody>
        {#each emails as e}
          <tr class="border-t border-slate-100 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
            <td class="px-3 py-2 text-xs text-slate-400">{e.date}</td>
            <td class="px-3 py-2 font-medium">{e.subject}</td>
            <td class="px-3 py-2"><Badge variant="outline">{e.status === 'inbox' ? 'masuk' : 'keluar'}</Badge></td>
            <td class="px-3 py-2"><Badge variant={e.status === 'draft' ? 'warning' : 'success'}>{e.status}</Badge></td>
          </tr>
        {/each}
      </tbody>
    </table>
  </CardContent>
</Card>

<div class="mt-3">
  <Card>
    <CardHeader><CardTitle>Ekspor</CardTitle></CardHeader>
    <CardContent class="text-sm text-slate-500">Unduh history dalam CSV untuk audit. Periode default 30 hari terakhir.</CardContent>
  </Card>
</div>
