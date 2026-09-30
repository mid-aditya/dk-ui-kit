<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import * as Table from '$lib/components/ui/table';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import { Search, Plus, RefreshCw, CalendarDays, Users, ChevronRight } from 'lucide-svelte';

  let query = $state('');
  const schedules = [
    { date: '30 Sep 2026', agents: 12, channels: ['Omnichat', 'Inbound Call'], status: 'Terjadwal' },
    { date: '01 Okt 2026', agents: 14, channels: ['Omnichat', 'Email', 'Inbound Call'], status: 'Terjadwal' },
    { date: '02 Okt 2026', agents: 13, channels: ['Omnichat', 'Email'], status: 'Terjadwal' },
    { date: '03 Okt 2026', agents: 8, channels: ['Omnichat'], status: 'Terbatas' },
    { date: '04 Okt 2026', agents: 0, channels: [], status: 'Libur' }
  ];
  let filtered = $derived(schedules.filter((item) => item.date.toLowerCase().includes(query.toLowerCase())));
</script>

<svelte:head><title>Agent Schedule — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
  <Card.Root>
    <Card.Header class="flex-col gap-4 md:flex-row md:items-center md:justify-between">
      <div><Card.Title>Daftar jadwal agent</Card.Title><p class="mt-1 text-sm text-muted-foreground">{filtered.length} jadwal ditemukan dari mock workspace.</p></div>
      <Button><Plus data-icon="inline-start" />Tambah jadwal</Button>
    </Card.Header>
    <Card.Content class="flex flex-col gap-4">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"><div class="relative w-full sm:max-w-sm"><Search size={16} class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" /><Input bind:value={query} class="pl-9" placeholder="Cari tanggal jadwal..." aria-label="Cari jadwal" /></div><Button variant="outline" size="sm"><RefreshCw data-icon="inline-start" />Reset</Button></div>
      <div class="overflow-x-auto rounded-lg border border-border"><Table.Root><Table.Header><Table.Row><Table.Head>No</Table.Head><Table.Head>Tanggal</Table.Head><Table.Head>Jumlah agent</Table.Head><Table.Head>Channel</Table.Head><Table.Head>Status</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header><Table.Body>{#each filtered as item, index}<Table.Row><Table.Cell class="text-muted-foreground">{index + 1}</Table.Cell><Table.Cell class="font-medium">{item.date}</Table.Cell><Table.Cell><span class="flex items-center gap-2"><Users size={15} class="text-muted-foreground" />{item.agents} agent</span></Table.Cell><Table.Cell><div class="flex min-w-48 flex-wrap gap-1.5">{#each item.channels as channel}<Badge variant="secondary">{channel}</Badge>{:else}<span class="text-sm text-muted-foreground">—</span>{/each}</div></Table.Cell><Table.Cell><Badge variant={item.status === 'Terjadwal' ? 'success' : item.status === 'Terbatas' ? 'warning' : 'secondary'}>{item.status}</Badge></Table.Cell><Table.Cell class="text-right"><Button variant="ghost" size="sm" aria-label={`Lihat jadwal ${item.date}`}>Detail <ChevronRight data-icon="inline-end" /></Button></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    </Card.Content>
  </Card.Root>
</div>
