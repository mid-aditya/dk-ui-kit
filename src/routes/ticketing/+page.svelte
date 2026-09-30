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
  import Alert from '$lib/components/ui/alert.svelte';
  import { tickets } from '$lib/mock';

  let status = $state('');
  let modal = $state(false);
  let form = $state({ subject: '', customer: '', priority: 'medium' });
  let list = $derived(tickets.filter((t) => !status || t.status === status));
  const prio = (p: string) => (p === 'urgent' ? 'destructive' : p === 'medium' ? 'warning' : 'secondary');
</script>

<svelte:head><title>Ticketing — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-end">
  <Button size="sm" onclick={() => (modal = true)}>Buat tiket</Button>
</div>

<!-- Toolbar -->
<div class="mt-3 flex flex-wrap items-center gap-2">
  <Select bind:value={status} class="!w-auto" options={[
    { value: '', label: 'Semua status' },
    { value: 'open', label: 'Open' },
    { value: 'pending', label: 'Pending' },
    { value: 'resolved', label: 'Resolved' }
  ]} />
  <Button size="sm" variant="secondary" href="/chat/v3/ticket/result">Hasil tiket</Button>
  <Button size="sm" variant="secondary" href="/chat/v3/ticket/kirana-monitoring">Monitoring</Button>
</div>

<!-- Alert for urgent tickets -->
{#if list.some(t => t.priority === 'urgent')}
  <div class="mt-3">
    <Alert variant="destructive" title="Peringatan">
      Terdapat tiket dengan prioritas urgent yang perlu segera ditindaklanjuti.
    </Alert>
  </div>
{/if}

<!-- Tickets Table -->
<Card class="mt-3">
  <CardContent class="p-0">
    <div class="overflow-auto rounded-lg border">
      <table class="w-full text-sm">
        <thead class="bg-muted text-xs uppercase text-muted-foreground">
          <tr>
            <th class="px-4 py-3 text-left font-semibold">Nomor</th>
            <th class="px-4 py-3 text-left font-semibold">Subjek</th>
            <th class="px-4 py-3 text-left font-semibold">Customer</th>
            <th class="px-4 py-3 text-left font-semibold">Prioritas</th>
            <th class="px-4 py-3 text-left font-semibold">SLA</th>
            <th class="px-4 py-3 text-left font-semibold">Agent</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          {#each list as t}
            <tr class="border-b border-border last:border-0 hover:bg-muted/50">
              <td class="px-4 py-3 font-mono font-semibold">{t.number}</td>
              <td class="px-4 py-3">{t.subject}</td>
              <td class="px-4 py-3">{t.customer}</td>
              <td class="px-4 py-3"><Badge variant={prio(t.priority)}>{t.priority}</Badge></td>
              <td class="px-4 py-3 text-xs text-muted-foreground">{t.sla}</td>
              <td class="px-4 py-3 text-xs text-muted-foreground">{t.agent}</td>
              <td class="px-4 py-3"><Badge variant={t.status === 'resolved' ? 'success' : 'warning'}>{t.status}</Badge></td>
            </tr>
          {:else}
            <tr>
              <td colspan="7" class="px-4 py-8 text-center text-muted-foreground">Belum ada tiket.</td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </CardContent>
</Card>

<!-- Create Ticket Dialog -->
<Dialog open={modal} title="Tiket baru" onClose={() => (modal = false)}>
  <form class="space-y-4" onsubmit={(e) => { e.preventDefault(); modal = false; }}>
    <div>
      <Label for="tk-s">Subjek *</Label>
      <Input id="tk-s" bind:value={form.subject} placeholder="Judul tiket" required />
    </div>
    <div>
      <Label for="tk-c">Customer</Label>
      <Input id="tk-c" bind:value={form.customer} placeholder="Nama customer" />
    </div>
    <div>
      <Label for="tk-p">Prioritas</Label>
      <Select id="tk-p" bind:value={form.priority} options={[
        { value: 'low', label: 'Low' },
        { value: 'medium', label: 'Medium' },
        { value: 'urgent', label: 'Urgent' }
      ]} />
    </div>
    <Button type="submit" class="w-full">Simpan</Button>
  </form>
</Dialog>
