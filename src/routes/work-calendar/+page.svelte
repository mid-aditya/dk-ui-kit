<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import * as Table from '$lib/components/ui/table';
  import * as Dialog from '$lib/components/ui/dialog';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import { Label } from '$lib/components/ui/label';
  import { Search, Plus, Upload, CalendarDays, Pencil, Trash2 } from 'lucide-svelte';

  let year = $state('2026');
  let category = $state('all');
  let query = $state('');
  let dialogOpen = $state(false);
  let holidays = $state([
    { date: '01 Jan 2026', name: 'Tahun Baru 2026', category: 'Libur Nasional', status: 'Aktif' },
    { date: '16 Jan 2026', name: 'Isra Mikraj Nabi Muhammad SAW', category: 'Libur Nasional', status: 'Aktif' },
    { date: '17 Agu 2026', name: 'Hari Kemerdekaan Republik Indonesia', category: 'Libur Nasional', status: 'Aktif' },
    { date: '25 Des 2026', name: 'Hari Raya Natal', category: 'Libur Nasional', status: 'Aktif' }
  ]);
  let filtered = $derived(holidays.filter((item) => (category === 'all' || item.category === category) && `${item.date} ${item.name}`.toLowerCase().includes(query.toLowerCase())));
  function addHoliday() { holidays = [...holidays, { date: '31 Des 2026', name: 'Hari Libur Custom', category: 'Custom', status: 'Aktif' }]; dialogOpen = false; }
</script>

<svelte:head><title>Work Calendar — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
  <Card.Root>
    <Card.Header class="flex-col gap-4 md:flex-row md:items-center md:justify-between"><div><Card.Title>Hari libur dan kalender kerja</Card.Title><p class="mt-1 text-sm text-muted-foreground">{filtered.length} hari libur pada kalender {year}.</p></div><div class="flex flex-wrap gap-2"><Button onclick={() => (dialogOpen = true)}><Plus data-icon="inline-start" />Tambah hari libur</Button><Button variant="outline"><Upload data-icon="inline-start" />Import bulk</Button></div></Card.Header>
    <Card.Content class="flex flex-col gap-4"><div class="grid gap-3 md:grid-cols-[140px_190px_1fr]"><select bind:value={year} aria-label="Pilih tahun" class="h-9 rounded-md border border-input bg-background px-3 text-sm"><option>2025</option><option>2026</option><option>2027</option><option>2028</option></select><select bind:value={category} aria-label="Pilih kategori" class="h-9 rounded-md border border-input bg-background px-3 text-sm"><option value="all">Semua kategori</option><option value="Libur Nasional">Libur Nasional</option><option value="Libur Pemerintahan">Libur Pemerintahan</option><option value="Custom">Custom</option></select><div class="relative"><Search size={16} class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" /><Input bind:value={query} class="pl-9" placeholder="Cari nama hari libur..." aria-label="Cari hari libur" /></div></div><div class="overflow-x-auto rounded-lg border border-border"><Table.Root><Table.Header><Table.Row><Table.Head>No</Table.Head><Table.Head>Tanggal</Table.Head><Table.Head>Nama</Table.Head><Table.Head>Kategori</Table.Head><Table.Head>Status</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header><Table.Body>{#each filtered as holiday, index}<Table.Row><Table.Cell class="text-muted-foreground">{index + 1}</Table.Cell><Table.Cell class="whitespace-nowrap font-medium">{holiday.date}</Table.Cell><Table.Cell>{holiday.name}</Table.Cell><Table.Cell><Badge variant={holiday.category === 'Custom' ? 'secondary' : 'outline'}>{holiday.category}</Badge></Table.Cell><Table.Cell><Badge variant="success">{holiday.status}</Badge></Table.Cell><Table.Cell class="text-right"><div class="flex justify-end gap-1"><Button variant="ghost" size="icon" aria-label={`Edit ${holiday.name}`}><Pencil /></Button><Button variant="ghost" size="icon" aria-label={`Hapus ${holiday.name}`}><Trash2 /></Button></div></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div></Card.Content>
  </Card.Root>
</div>

<Dialog.Root bind:open={dialogOpen}><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>Tambah hari libur</Dialog.Title><Dialog.Description>Tambahkan hari libur custom ke kalender kerja.</Dialog.Description></Dialog.Header><div class="flex flex-col gap-4 py-2"><div class="flex flex-col gap-2"><Label for="holiday-date">Tanggal</Label><Input id="holiday-date" type="date" /></div><div class="flex flex-col gap-2"><Label for="holiday-name">Nama hari libur</Label><Input id="holiday-name" placeholder="Contoh: Cuti bersama" /></div></div><Dialog.Footer><Button variant="outline" onclick={() => (dialogOpen = false)}>Batal</Button><Button onclick={addHoliday}>Simpan</Button></Dialog.Footer></Dialog.Content></Dialog.Root>
