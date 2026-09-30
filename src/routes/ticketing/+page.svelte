<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import * as Select from '$lib/components/ui/select';
  import * as Dialog from '$lib/components/ui/dialog';
  import { Label } from '$lib/components/ui/label';
  import { Alert, AlertTitle, AlertDescription } from '$lib/components/ui/alert';
  import { tickets } from '$lib/mock';

  const statusOptions = [
    { value: '', label: 'Semua status' },
    { value: 'open', label: 'Open' },
    { value: 'pending', label: 'Pending' },
    { value: 'resolved', label: 'Resolved' }
  ];
  const priorityOptions = [
    { value: 'low', label: 'Low' },
    { value: 'medium', label: 'Medium' },
    { value: 'urgent', label: 'Urgent' }
  ];

  let status = $state('');
  let modal = $state(false);
  let form = $state({ subject: '', customer: '', priority: 'medium' });
  let list = $derived(tickets.filter((t) => !status || t.status === status));
  const prio = (p: string) => (p === 'urgent' ? 'destructive' : p === 'medium' ? 'warning' : 'secondary');
  const labelOf = (opts: { value: string; label: string }[], v: string) =>
    opts.find((o) => o.value === v)?.label ?? '';
</script>

<svelte:head><title>Ticketing — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-end">
  <Button size="sm" onclick={() => (modal = true)}>Buat tiket</Button>
</div>

<!-- Toolbar -->
<div class="mt-3 flex flex-wrap items-center gap-2">
  <Select.Root type="single" bind:value={status}>
    <Select.Trigger class="w-44">
      {status ? labelOf(statusOptions, status) : 'Semua status'}
    </Select.Trigger>
    <Select.Content>
      {#each statusOptions as opt (opt.value)}
        <Select.Item value={opt.value} label={opt.label} />
      {/each}
    </Select.Content>
  </Select.Root>
  <Button size="sm" variant="secondary" href="/chat/v3/ticket/result">Hasil tiket</Button>
  <Button size="sm" variant="secondary" href="/chat/v3/ticket/kirana-monitoring">Monitoring</Button>
</div>

<!-- Alert for urgent tickets -->
{#if list.some(t => t.priority === 'urgent')}
  <div class="mt-3">
    <Alert variant="destructive">
      <AlertTitle>Peringatan</AlertTitle>
      <AlertDescription>
        Terdapat tiket dengan prioritas urgent yang perlu segera ditindaklanjuti.
      </AlertDescription>
    </Alert>
  </div>
{/if}

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
            <th class="px-4 py-3 text-left font-semibold">Agent</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          {#each list as t (t.number)}
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
  </Card.Content>
</Card.Root>

<!-- Create Ticket Dialog -->
<Dialog.Root bind:open={modal}>
  <Dialog.Content class="sm:max-w-lg">
    <Dialog.Header>
      <Dialog.Title>Tiket baru</Dialog.Title>
      <Dialog.Description>Buat tiket dukungan baru untuk customer.</Dialog.Description>
    </Dialog.Header>
    <form class="flex flex-col gap-4" onsubmit={(e) => { e.preventDefault(); modal = false; }}>
      <div class="flex flex-col gap-2">
        <Label for="tk-s">Subjek *</Label>
        <Input id="tk-s" bind:value={form.subject} placeholder="Judul tiket" required />
      </div>
      <div class="flex flex-col gap-2">
        <Label for="tk-c">Customer</Label>
        <Input id="tk-c" bind:value={form.customer} placeholder="Nama customer" />
      </div>
      <div class="flex flex-col gap-2">
        <Label for="tk-p">Prioritas</Label>
        <Select.Root type="single" bind:value={form.priority}>
          <Select.Trigger class="w-full" id="tk-p">
            {labelOf(priorityOptions, form.priority)}
          </Select.Trigger>
          <Select.Content>
            {#each priorityOptions as opt (opt.value)}
              <Select.Item value={opt.value} label={opt.label} />
            {/each}
          </Select.Content>
        </Select.Root>
      </div>
      <Button type="submit" class="w-full">Simpan</Button>
    </form>
  </Dialog.Content>
</Dialog.Root>
