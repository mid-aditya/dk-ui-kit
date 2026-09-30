<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Badge } from '$lib/components/ui/badge';
  import Select from '$lib/components/ui/select.svelte';
  import Calendar from '$lib/components/ui/calendar.svelte';
  import { Button } from '$lib/components/ui/button';
  import Alert from '$lib/components/ui/alert.svelte';
  import { recordings } from '$lib/mock';

  let period = $state('30');
  let selectedDate = $state<Date | null>(null);
</script>

<svelte:head><title>Recording Archive — DK UI Kit</title></svelte:head>

<div></div>

<!-- Toolbar -->
<div class="mt-3 flex flex-wrap items-center gap-3">
  <Select bind:value={period} class="!w-auto" options={[
    { value: '7', label: '7 hari terakhir' },
    { value: '30', label: '30 hari terakhir' },
    { value: '90', label: '90 hari terakhir' }
  ]} />
  <Calendar value={selectedDate} />
</div>

<!-- Retention Policy Alert -->
<Alert variant="info" title="Kebijakan Retensi" class="mt-3">
  Rekaman disimpan selama 90 hari, lalu dipindahkan ke cold storage. Unduhan massal tersedia untuk keperluan audit.
</Alert>

<!-- Archive Table -->
<Card.Root class="mt-3">
  <Card.Content class="p-0">
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
  </Card.Content>
</Card.Root>
