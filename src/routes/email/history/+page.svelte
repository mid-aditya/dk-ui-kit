<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Alert from '$lib/components/ui/alert.svelte';
  import { emails } from '$lib/mock';

  let list = emails;
</script>

<svelte:head><title>Email History — DK UI Kit</title></svelte:head>

<div></div>

<!-- Info Alert -->
<Alert variant="info" title="Catatan" class="mt-3">
  History email disimpan selama 90 hari untuk keperluan audit dan kepatuhan.
</Alert>

<!-- History Table -->
<Card class="mt-3">
  <CardContent class="p-0">
    <div class="overflow-auto rounded-lg border">
      <table class="w-full text-sm">
        <thead class="bg-muted text-xs uppercase text-muted-foreground">
          <tr>
            <th class="px-4 py-3 text-left font-semibold">Waktu</th>
            <th class="px-4 py-3 text-left font-semibold">Subjek</th>
            <th class="px-4 py-3 text-left font-semibold">Arah</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          {#each list as e}
            <tr class="border-b border-border last:border-0 hover:bg-muted/50">
              <td class="px-4 py-3 text-xs text-muted-foreground">{e.date}</td>
              <td class="px-4 py-3 font-medium">{e.subject}</td>
              <td class="px-4 py-3">
                <Badge variant="outline">{e.status === 'inbox' ? 'Masuk' : 'Keluar'}</Badge>
              </td>
              <td class="px-4 py-3">
                <Badge variant={e.status === 'draft' ? 'warning' : 'success'}>{e.status}</Badge>
              </td>
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </CardContent>
</Card>

<!-- Export Info -->
<Card class="mt-3">
  <CardHeader><CardTitle>Ekspor</CardTitle></CardHeader>
  <CardContent>
    <p class="text-sm text-muted-foreground">
      Unduh history dalam format CSV untuk keperluan audit. Periode default adalah 30 hari terakhir.
    </p>
  </CardContent>
</Card>
