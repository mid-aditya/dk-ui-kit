<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Select from '$lib/components/ui/select.svelte';
  import Alert from '$lib/components/ui/alert.svelte';

  let agent = $state('');
  const rows = [
    { id: 'i1', customer: 'PT Maju Jaya', agent: 'Kirana Ayu', rating: 5, channel: 'WhatsApp', date: 'Hari ini' },
    { id: 'i2', customer: 'Sari Wulandari', agent: 'Bimo Prasetyo', channel: 'Email', rating: 4, date: 'Hari ini' },
    { id: 'i3', customer: 'CV Berkah Abadi', agent: 'Raka Aditya', channel: 'Voice', rating: 3, date: 'Kemarin' }
  ];
  let list = $derived(rows.filter((r) => !agent || r.agent === agent));
  const getRatingVariant = (r: number) => r >= 4 ? 'success' : r === 3 ? 'warning' : 'destructive';
</script>

<svelte:head><title>CSAT Interaction — DK UI Kit</title></svelte:head>

<div></div>

<!-- Toolbar -->
<div class="mt-3 flex flex-wrap items-center gap-2">
  <Select bind:value={agent} class="!w-auto" options={[
    { value: '', label: 'Semua agent' },
    { value: 'kirana', label: 'Kirana Ayu' },
    { value: 'bimo', label: 'Bimo Prasetyo' },
    { value: 'raka', label: 'Raka Aditya' }
  ]} />
</div>

<!-- Low Rating Alert -->
{#if list.some(r => r.rating <= 3)}
  <div class="mt-3">
    <Alert variant="warning" title="Rating Rendah" dismissible>
      1 interaksi dengan rating ≤ 3 menunggu callback SPV. Eskalasi otomatis dibuat sebagai tiket.
    </Alert>
  </div>
{/if}

<!-- CSAT Table -->
<Card class="mt-3">
  <CardContent class="p-0">
    <div class="overflow-auto rounded-lg border">
      <table class="w-full text-sm">
        <thead class="bg-muted text-xs uppercase text-muted-foreground">
          <tr>
            <th class="px-4 py-3 text-left font-semibold">Customer</th>
            <th class="px-4 py-3 text-left font-semibold">Agent</th>
            <th class="px-4 py-3 text-left font-semibold">Kanal</th>
            <th class="px-4 py-3 text-left font-semibold">Rating</th>
            <th class="px-4 py-3 text-left font-semibold">Waktu</th>
          </tr>
        </thead>
        <tbody>
          {#each list as r}
            <tr class="border-b border-border last:border-0 hover:bg-muted/50">
              <td class="px-4 py-3 font-medium">{r.customer}</td>
              <td class="px-4 py-3">{r.agent}</td>
              <td class="px-4 py-3"><Badge variant="outline">{r.channel}</Badge></td>
              <td class="px-4 py-3"><Badge variant={getRatingVariant(r.rating)}>★ {r.rating}</Badge></td>
              <td class="px-4 py-3 text-xs text-muted-foreground">{r.date}</td>
            </tr>
          {:else}
            <tr>
              <td colspan="5" class="px-4 py-8 text-center text-muted-foreground">Tidak ada data.</td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </CardContent>
</Card>

<!-- Info Card -->
<Card class="mt-3">
  <CardHeader><CardTitle>Tindak lanjut rating rendah</CardTitle></CardHeader>
  <CardContent>
    <Alert variant="info">
      Interaksi dengan rating ≤ 3 akan otomatis dibuatkan tiket eskalasi untuk ditindaklanjuti oleh SPV.
    </Alert>
  </CardContent>
</Card>
