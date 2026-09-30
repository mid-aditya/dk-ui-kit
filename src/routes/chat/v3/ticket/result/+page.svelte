<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import Select from '$lib/components/ui/select.svelte';

  let status = $state('');
  const all = [
    { n: 'T-2026-001', s: 'Keterlambatan pengiriman', c: 'PT Maju Jaya', p: 'urgent', st: 'open', sla: '2 jam' },
    { n: 'T-2026-002', s: 'Reset password akun', c: 'Sari Wulandari', p: 'medium', st: 'pending', sla: '6 jam' },
    { n: 'T-2026-003', s: 'Pengajuan refund', c: 'CV Berkah Abadi', p: 'low', st: 'resolved', sla: 'terpenuhi' }
  ];
  let list = $derived(all.filter((t) => !status || t.st === status));
  const prio = (p: string) => (p === 'urgent' ? 'destructive' : p === 'medium' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Hasil Tiket — DK UI Kit</title></svelte:head>

<div></div>

<!-- Toolbar -->
<div class="mt-3 flex flex-wrap items-center gap-2">
  <Select bind:value={status} class="!w-auto" options={[
    { value: '', label: 'Semua status' },
    { value: 'open', label: 'Open' },
    { value: 'pending', label: 'Pending' },
    { value: 'resolved', label: 'Resolved' }
  ]} />
  <Button size="sm" variant="secondary">Export</Button>
</div>

<!-- Tickets Table -->
<Card.Root class="mt-3">
  <Card.Content class="p-0">
    <div class="overflow-auto rounded-lg border">
      <table class="w-full text-sm">
        <thead class="bg-muted text-xs uppercase text-muted-foreground">
          <tr>
            <th class="px-4 py-3 text-left font-semibold">Nomor</th>
            <th class="px-4 py-3 text-left font-semibold">Subjek</th>
            <th class="px-4 py-3 text-left font-semibold">Customer</th>
            <th class="px-4 py-3 text-left font-semibold">Prioritas</th>
            <th class="px-4 py-3 text-left font-semibold">SLA</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          {#each list as t}
            <tr class="border-b border-border last:border-0 hover:bg-muted/50">
              <td class="px-4 py-3 font-mono font-semibold">{t.n}</td>
              <td class="px-4 py-3">{t.s}</td>
              <td class="px-4 py-3">{t.c}</td>
              <td class="px-4 py-3"><Badge variant={prio(t.p)}>{t.p}</Badge></td>
              <td class="px-4 py-3 text-xs text-muted-foreground">{t.sla}</td>
              <td class="px-4 py-3"><Badge variant={t.st === 'resolved' ? 'success' : 'warning'}>{t.st}</Badge></td>
            </tr>
          {:else}
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-muted-foreground">Tidak ada hasil.</td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </Card.Content>
</Card.Root>

<!-- Summary Stats -->
<Card.Root class="mt-3">
  <Card.Header><Card.Title>Ringkasan</Card.Title></Card.Header>
  <Card.Content class="flex flex-wrap gap-6 text-sm">
    <div>
      <div class="text-xs text-muted-foreground">Resolved tepat SLA</div>
      <div class="text-2xl font-extrabold text-emerald-600">86%</div>
    </div>
    <div>
      <div class="text-xs text-muted-foreground">Rata-rata handle</div>
      <div class="text-2xl font-extrabold">5:42</div>
    </div>
    <div>
      <div class="text-xs text-muted-foreground">Reopen rate</div>
      <div class="text-2xl font-extrabold text-amber-600">4%</div>
    </div>
  </Card.Content>
</Card.Root>
