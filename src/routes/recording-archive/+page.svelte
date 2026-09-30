<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Select from '$lib/components/ui/select.svelte';
  import { recordings } from '$lib/mock';

  let period = $state('30');
</script>

<svelte:head><title>Recording Archive — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Recording Archive</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Arsip rekaman & kebijakan retensi.</p>

<div class="toolbar mt-3 flex items-center gap-2">
  <Select bind:value={period} class="!w-auto">
    <option value="7">7 hari terakhir</option>
    <option value="30">30 hari terakhir</option>
    <option value="90">90 hari terakhir</option>
  </Select>
  <Badge>retensi 90 hari</Badge>
</div>

<Card>
  <CardContent class="p-0">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
        <tr><th class="px-3 py-2 text-left">Tanggal</th><th class="px-3 py-2 text-left">Agent</th><th class="px-3 py-2 text-left">Customer</th><th class="px-3 py-2 text-right">Durasi</th><th class="px-3 py-2 text-left">Status</th></tr>
      </thead>
      <tbody>
        {#each recordings as r}
          <tr class="border-t border-slate-100 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
            <td class="px-3 py-2 text-xs text-slate-400">{r.date}</td>
            <td class="px-3 py-2 font-medium">{r.agent}</td>
            <td class="px-3 py-2">{r.customer}</td>
            <td class="px-3 py-2 text-right">{r.duration}</td>
            <td class="px-3 py-2"><Badge variant="secondary">tersimpan</Badge></td>
          </tr>
        {/each}
      </tbody>
    </table>
  </CardContent>
</Card>

<div class="mt-3">
  <Card>
    <CardHeader><CardTitle>Kebijakan retensi</CardTitle></CardHeader>
    <CardContent class="text-sm text-slate-500">Rekaman disimpan 90 hari, lalu dipindah ke cold storage. Unduhan massal tersedia untuk audit.</CardContent>
  </Card>
</div>
