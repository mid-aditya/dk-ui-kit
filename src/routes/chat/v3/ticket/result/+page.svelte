<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Select from '$lib/components/ui/select.svelte';

  let status = '';
  const all = [
    { n: 'T-2026-001', s: 'Keterlambatan pengiriman', c: 'PT Maju Jaya', p: 'urgent', st: 'open', sla: '2 jam' },
    { n: 'T-2026-002', s: 'Reset password akun', c: 'Sari Wulandari', p: 'medium', st: 'pending', sla: '6 jam' },
    { n: 'T-2026-003', s: 'Pengajuan refund', c: 'CV Berkah Abadi', p: 'low', st: 'resolved', sla: 'terpenuhi' }
  ];
  let list = $derived(all.filter((t) => !status || t.st === status));
  const prio = (p: string) => (p === 'urgent' ? 'destructive' : p === 'medium' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Hasil Tiket — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Hasil Tiket</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Ringkas hasil penanganan tiket dari chat.</p>

<div class="toolbar mt-3 flex items-center gap-2">
  <Select bind:value={status} class="!w-auto">
    <option value="">Semua status</option>
    <option value="open">Open</option>
    <option value="pending">Pending</option>
    <option value="resolved">Resolved</option>
  </Select>
  <Button size="sm" variant="secondary">Export</Button>
</div>

<Card>
  <CardContent class="p-0">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
        <tr><th class="px-3 py-2 text-left">Nomor</th><th class="px-3 py-2 text-left">Subjek</th><th class="px-3 py-2 text-left">Customer</th><th class="px-3 py-2 text-left">Prioritas</th><th class="px-3 py-2 text-left">SLA</th><th class="px-3 py-2 text-left">Status</th></tr>
      </thead>
      <tbody>
        {#each list as t}
          <tr class="border-t border-slate-100 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
            <td class="px-3 py-2 font-mono font-semibold">{t.n}</td>
            <td class="px-3 py-2">{t.s}</td>
            <td class="px-3 py-2">{t.c}</td>
            <td class="px-3 py-2"><Badge variant={prio(t.p)}>{t.p}</Badge></td>
            <td class="px-3 py-2 text-xs">{t.sla}</td>
            <td class="px-3 py-2"><Badge variant={t.st === 'resolved' ? 'success' : 'warning'}>{t.st}</Badge></td>
          </tr>
        {/each}
      </tbody>
    </table>
    {#if !list.length}<p class="p-6 text-center text-sm text-slate-400">Tidak ada hasil.</p>{/if}
  </CardContent>
</Card>

<div class="mt-3">
  <Card>
    <CardHeader><CardTitle>Ringkasan</CardTitle></CardHeader>
    <CardContent class="flex gap-6 text-sm">
      <div><div class="text-xs text-slate-500">Resolved tepat SLA</div><div class="text-xl font-extrabold text-emerald-600">86%</div></div>
      <div><div class="text-xs text-slate-500">Rata-rata handle</div><div class="text-xl font-extrabold">5:42</div></div>
      <div><div class="text-xs text-slate-500">Reopen rate</div><div class="text-xl font-extrabold text-amber-600">4%</div></div>
    </CardContent>
  </Card>
</div>
