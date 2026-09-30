<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import { Download, Filter, Search, Smile, Meh, Frown } from 'lucide-svelte';

  type Row = { customer: string; channel: string; ticket: string; created: string; time: string; score: number | null; note: string; agent: string };
  const rows: Row[] = [
    { customer: 'NINA- NOT', channel: 'WhatsApp', ticket: 'T-2026-001', created: '05 Jan 2026', time: '10:34', score: 1, note: 'Sangat baik', agent: 'Ayu Lestari' },
    { customer: 'EVA SITI RAHMATILLAH', channel: 'Voice', ticket: 'T-2026-002', created: '05 Jan 2026', time: '11:10', score: 2, note: 'Cukup', agent: 'Rizky Pratama' },
    { customer: 'Costumer', channel: 'WhatsApp', ticket: 'T-2026-003', created: '06 Jan 2026', time: '09:22', score: 3, note: 'Buruk', agent: 'Dewi Anggraini' },
    { customer: 'BUDI SANTOSO', channel: 'Email', ticket: 'T-2026-004', created: '06 Jan 2026', time: '13:45', score: null, note: 'Belum mengisi', agent: 'Fajar Nugraha' }
  ];
  let search = $state('');
  let period = $state('Bulan ini');
  let filtered = $derived(rows.filter((row) => `${row.customer} ${row.ticket} ${row.agent}`.toLowerCase().includes(search.toLowerCase())));
  const stats = [
    { label: 'Total tiket CSAT', value: '128', hint: 'Periode berjalan' },
    { label: 'Sudah mengisi', value: '96', hint: '75% tingkat respons' },
    { label: 'Skor sangat baik', value: '72', hint: 'Tekan 1' },
    { label: 'Belum mengisi', value: '32', hint: 'Menunggu respons' }
  ];
  function scoreLabel(score: number | null) { return score === 1 ? 'Sangat baik' : score === 2 ? 'Cukup' : score === 3 ? 'Buruk' : 'Belum mengisi'; }
</script>

<svelte:head><title>CSAT — DK CRM</title></svelte:head>

<div class="space-y-6">
  <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-end"><div><div class="mb-2 flex items-center gap-2 text-sm text-muted-foreground"><span>Insight</span><span>/</span><span class="text-foreground">CSAT</span></div><h2 class="text-2xl font-bold tracking-tight text-foreground md:text-3xl">Laporan CSAT</h2><p class="mt-1 text-sm text-muted-foreground">Pantau penilaian layanan agent berdasarkan data IVR CSAT.</p></div><div class="flex gap-2"><Button variant="outline" size="sm"><Download size={16} />Ekspor laporan</Button><Button size="sm"><Filter size={16} />Filter</Button></div></div>

  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">{#each stats as stat}<Card.Root><Card.Content class="p-5"><p class="text-sm text-muted-foreground">{stat.label}</p><p class="mt-2 text-3xl font-bold text-foreground">{stat.value}</p><p class="mt-1 text-xs text-muted-foreground">{stat.hint}</p></Card.Content></Card.Root>{/each}</div>

  <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
    <Card.Root><Card.Header><div class="flex items-center justify-between gap-3"><div><Card.Title>Data CSAT</Card.Title><p class="mt-1 text-sm text-muted-foreground">Daftar tiket dan respons CSAT yang diterima dari IVR.</p></div><Badge variant="secondary">{filtered.length} data</Badge></div></Card.Header><Card.Content><div class="mb-4 flex flex-col gap-3 sm:flex-row"><div class="relative flex-1"><Search size={16} class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" /><Input bind:value={search} placeholder="Cari pelapor, tiket, atau agent" class="pl-9" /></div><select bind:value={period} class="h-9 rounded-lg border border-input bg-background px-3 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring"><option>Bulan ini</option><option>3 bulan terakhir</option><option>Tahun ini</option></select></div><div class="overflow-x-auto rounded-xl border border-border"><table class="w-full min-w-[900px] text-left text-sm"><thead class="table-header-crm"><tr><th class="px-4 py-3 font-semibold">Customer name (pelapor)</th><th class="px-4 py-3 font-semibold">Channel name (kanal)</th><th class="px-4 py-3 font-semibold">Ticket number</th><th class="px-4 py-3 font-semibold">Date ticket create</th><th class="px-4 py-3 font-semibold">Waktu CSAT</th><th class="px-4 py-3 font-semibold">Skor</th><th class="px-4 py-3 font-semibold">Keterangan</th><th class="px-4 py-3 font-semibold">Agent</th></tr></thead><tbody class="divide-y divide-border">{#each filtered as row}<tr class="transition-colors hover:bg-accent/50"><td class="px-4 py-3 font-medium text-foreground">{row.customer}</td><td class="px-4 py-3 text-muted-foreground">{row.channel}</td><td class="px-4 py-3 font-mono text-xs text-foreground">{row.ticket}</td><td class="px-4 py-3 text-muted-foreground">{row.created}</td><td class="px-4 py-3 text-muted-foreground">{row.time}</td><td class="px-4 py-3">{#if row.score === 1}<span title="Sangat baik" class="text-xl">😊</span>{:else if row.score === 2}<span title="Cukup" class="text-xl">😐</span>{:else if row.score === 3}<span title="Buruk" class="text-xl">😞</span>{:else}<span class="text-muted-foreground">—</span>{/if}</td><td class="px-4 py-3"><Badge variant={row.score === null ? 'secondary' : row.score === 1 ? 'success' : row.score === 2 ? 'warning' : 'destructive'}>{scoreLabel(row.score)}</Badge></td><td class="px-4 py-3 text-muted-foreground">{row.agent}</td></tr>{/each}</tbody></table></div><div class="mt-4 flex items-center justify-between text-xs text-muted-foreground"><span>Menampilkan {filtered.length} dari {rows.length} data</span><div class="flex gap-1"><Button variant="outline" size="sm">Sebelumnya</Button><Button variant="secondary" size="sm">1</Button><Button variant="outline" size="sm">Berikutnya</Button></div></div></Card.Content></Card.Root>

    <Card.Root><Card.Header><Card.Title>Ringkasan respons</Card.Title><p class="text-sm text-muted-foreground">Pemetaan nilai IVR</p></Card.Header><Card.Content class="space-y-4">{#each [{ icon: Smile, label: 'Sangat baik', key: 'Tekan 1', count: 72, color: 'text-emerald-400', bar: 'bg-emerald-500' }, { icon: Meh, label: 'Cukup', key: 'Tekan 2', count: 18, color: 'text-amber-400', bar: 'bg-amber-500' }, { icon: Frown, label: 'Buruk', key: 'Tekan 3', count: 6, color: 'text-red-400', bar: 'bg-red-500' }] as item}<div><div class="mb-2 flex items-center justify-between"><div class="flex items-center gap-2"><item.icon size={20} class={item.color} /><div><p class="text-sm font-medium">{item.label}</p><p class="text-xs text-muted-foreground">{item.key}</p></div></div><span class="text-sm font-semibold">{item.count}</span></div><div class="h-2 overflow-hidden rounded-full bg-muted"><div class="h-full rounded-full {item.bar}" style={`width: ${item.count}%`}></div></div></div>{/each}<div class="rounded-xl border border-border bg-muted/30 p-4 text-sm text-muted-foreground">Data hanya menampilkan tiket yang memiliki <span class="font-medium text-foreground">ivr_type = csat</span> dan genesis id sesuai flagging 1 atau 7.</div></Card.Content></Card.Root>
  </div>
</div>
