<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Select from '$lib/components/ui/select.svelte';

  let agent = $state('');
  const rows = [
    { id: 'i1', customer: 'PT Maju Jaya', agent: 'Kirana Ayu', rating: 5, channel: 'WhatsApp', date: 'Hari ini' },
    { id: 'i2', customer: 'Sari Wulandari', agent: 'Bimo Prasetyo', channel: 'Email', rating: 4, date: 'Hari ini' },
    { id: 'i3', customer: 'CV Berkah Abadi', agent: 'Raka Aditya', channel: 'Voice', rating: 3, date: 'Kemarin' }
  ];
  let list = $derived(rows.filter((r) => !agent || r.agent === agent));
</script>

<svelte:head><title>CSAT Interaction — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">CSAT Interaction</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Setiap interaksi yang diberi rating pelanggan.</p>

<div class="toolbar mt-3 flex items-center gap-2">
  <Select bind:value={agent} class="!w-auto">
    <option value="">Semua agent</option>
    <option>Kirana Ayu</option>
    <option>Bimo Prasetyo</option>
    <option>Raka Aditya</option>
  </Select>
  <Badge>★ rata-rata 4.6</Badge>
</div>

<Card>
  <CardContent class="p-0">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
        <tr><th class="px-3 py-2 text-left">Customer</th><th class="px-3 py-2 text-left">Agent</th><th class="px-3 py-2 text-left">Kanal</th><th class="px-3 py-2 text-left">Rating</th><th class="px-3 py-2 text-left">Waktu</th></tr>
      </thead>
      <tbody>
        {#each list as r}
          <tr class="border-t border-slate-100 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
            <td class="px-3 py-2 font-medium">{r.customer}</td>
            <td class="px-3 py-2">{r.agent}</td>
            <td class="px-3 py-2"><Badge variant="outline">{r.channel}</Badge></td>
            <td class="px-3 py-2"><Badge variant={r.rating >= 4 ? 'success' : r.rating === 3 ? 'warning' : 'destructive'}>★ {r.rating}</Badge></td>
            <td class="px-3 py-2 text-xs text-slate-400">{r.date}</td>
          </tr>
        {/each}
      </tbody>
    </table>
    {#if !list.length}<p class="p-6 text-center text-sm text-slate-400">Tidak ada data.</p>{/if}
  </CardContent>
</Card>

<div class="mt-3">
  <Card>
    <CardHeader><CardTitle>Tindak lanjut rating rendah</CardTitle></CardHeader>
    <CardContent class="text-sm text-slate-500">1 interaksi rating ≤ 3 menunggu callback SPV. Eskalasi otomatis dibuat sebagai tiket.</CardContent>
  </Card>
</div>
