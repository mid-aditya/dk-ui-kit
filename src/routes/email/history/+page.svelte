<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
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
<Card.Root class="mt-3">
  <Card.Content class="p-0">
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
  </Card.Content>
</Card.Root>

<!-- Export Info -->
<Card.Root class="mt-3">
  <Card.Header><Card.Title>Ekspor</Card.Title></Card.Header>
  <Card.Content>
    <p class="text-sm text-muted-foreground">
      Unduh history dalam format CSV untuk keperluan audit. Periode default adalah 30 hari terakhir.
    </p>
  </Card.Content>
</Card.Root>
