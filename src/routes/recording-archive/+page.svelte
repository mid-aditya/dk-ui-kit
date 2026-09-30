<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Select from '$lib/components/ui/select.svelte';
  import Calendar from '$lib/components/ui/calendar.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Alert from '$lib/components/ui/alert.svelte';
  import { recordings } from '$lib/mock';

  let period = $state('30');
  let selectedDate = $state<Date | null>(null);
</script>

<svelte:head><title>Recording Archive — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Recording Archive</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Arsip rekaman & kebijakan retensi.</p>
  </div>
  <Badge variant="secondary">Retensi 90 hari</Badge>
</div>

<!-- Toolbar -->
<div class="mt-3 flex flex-wrap items-center gap-3">
  <Select bind:value={period} class="!w-auto">
    <option value="7">7 hari terakhir</option>
    <option value="30">30 hari terakhir</option>
    <option value="90">90 hari terakhir</option>
  </Select>
  <Calendar bind:value={selectedDate} />
</div>

<!-- Retention Policy Alert -->
<Alert variant="info" title="Kebijakan Retensi" class="mt-3">
  Rekaman disimpan selama 90 hari, lalu dipindahkan ke cold storage. Unduhan massal tersedia untuk keperluan audit.
</Alert>

<!-- Archive Table -->
<Card class="mt-3">
  <CardContent class="p-0">
    <div class="overflow-auto rounded-lg border">
      <table class="w-full text-sm">
        <thead class="bg-muted text-xs uppercase text-muted-foreground">
          <tr>
            <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
            <th class="px-4 py-3 text-left font-semibold">Agent</th>
            <th class="px-4 py-3 text-left font-semibold">Customer</th>
            <th class="px-4 py-3 text-right font-semibold">Durasi</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          {#each recordings as r}
            <tr class="border-b border-border last:border-0 hover:bg-muted/50">
              <td class="px-4 py-3 text-xs text-muted-foreground">{r.date}</td>
              <td class="px-4 py-3 font-medium">{r.agent}</td>
              <td class="px-4 py-3">{r.customer}</td>
              <td class="px-4 py-3 text-right text-muted-foreground">{r.duration}</td>
              <td class="px-4 py-3"><Badge variant="secondary">Tersimpan</Badge></td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </CardContent>
</Card>
