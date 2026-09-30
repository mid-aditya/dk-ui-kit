<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Select from '$lib/components/ui/select.svelte';
  import Dialog from '$lib/components/ui/dialog.svelte';
  import Label from '$lib/components/ui/label.svelte';
  import Textarea from '$lib/components/ui/textarea.svelte';
  import { tickets } from '$lib/mock';

  let status = $state('');
  let modal = $state(false);
  let form = { subject: '', customer: '', priority: 'medium' };
  let list = $derived(tickets.filter((t) => !status || t.status === status));
  const prio = (p: string) => (p === 'urgent' ? 'destructive' : p === 'medium' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Ticketing — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Ticketing</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Kelola tiket layanan pelanggan + SLA.</p>
  </div>
  <Button size="sm" onclick={() => (modal = true)}>Buat tiket</Button>
</div>

<div class="toolbar mt-3 flex items-center gap-2">
  <Select bind:value={status} class="!w-auto">
    <option value="">Semua status</option>
    <option value="open">Open</option>
    <option value="pending">Pending</option>
    <option value="resolved">Resolved</option>
  </Select>
  <Button size="sm" variant="secondary" href="/chat/v3/ticket/result">Hasil tiket</Button>
  <Button size="sm" variant="secondary" href="/chat/v3/ticket/kirana-monitoring">Monitoring</Button>
</div>

<Card>
  <CardContent class="p-0">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-xs uppercase text-slate-500 dark:bg-slate-800 dark:text-slate-400">
        <tr><th class="px-3 py-2 text-left">Nomor</th><th class="px-3 py-2 text-left">Subjek</th><th class="px-3 py-2 text-left">Customer</th><th class="px-3 py-2 text-left">Prioritas</th><th class="px-3 py-2 text-left">SLA</th><th class="px-3 py-2 text-left">Agent</th><th class="px-3 py-2 text-left">Status</th></tr>
      </thead>
      <tbody>
        {#each list as t}
          <tr class="border-t border-slate-100 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
            <td class="px-3 py-2 font-mono font-semibold">{t.number}</td>
            <td class="px-3 py-2">{t.subject}</td>
            <td class="px-3 py-2">{t.customer}</td>
            <td class="px-3 py-2"><Badge variant={prio(t.priority)}>{t.priority}</Badge></td>
            <td class="px-3 py-2 text-xs">{t.sla}</td>
            <td class="px-3 py-2 text-xs">{t.agent}</td>
            <td class="px-3 py-2"><Badge variant={t.status === 'resolved' ? 'success' : 'warning'}>{t.status}</Badge></td>
          </tr>
        {/each}
      </tbody>
    </table>
    {#if !list.length}<p class="p-6 text-center text-sm text-slate-400">Belum ada tiket.</p>{/if}
  </CardContent>
</Card>

<Dialog open={modal} title="Tiket baru" onClose={() => (modal = false)}>
  <form class="space-y-2" onsubmit={(e) => { e.preventDefault(); modal = false; }}>
    <div><Label for="tk-s">Subjek *</Label><Input id="tk-s" bind:value={form.subject} required /></div>
    <div><Label for="tk-c">Customer</Label><Input id="tk-c" bind:value={form.customer} /></div>
    <div><Label for="tk-p">Prioritas</Label>
      <Select id="tk-p" bind:value={form.priority}><option value="low">low</option><option value="medium">medium</option><option value="urgent">urgent</option></Select>
    </div>
    <Button type="submit" class="w-full">Simpan</Button>
  </form>
</Dialog>
