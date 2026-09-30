<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import * as Alert from '$lib/components/ui/alert';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import { Switch } from '$lib/components/ui/switch';
  import { Settings2, Mail, Send, Database, Bell, ShieldCheck, Save, Check, UserRound } from 'lucide-svelte';

  type Tab = 'general' | 'email' | 'outbound' | 'master';
  let tab = $state<Tab>('general');
  let saved = $state(false);
  let notifications = $state(true);
  let profile = $state({ name: 'Operator', email: 'op@ahu.id' });
  const tabs = [
    { value: 'general' as Tab, label: 'General', detail: 'Konfigurasi workspace', icon: Settings2 },
    { value: 'email' as Tab, label: 'Email Setting', detail: 'SMTP dan autoreply', icon: Mail },
    { value: 'outbound' as Tab, label: 'Outbound Blasting', detail: 'Template dan kampanye', icon: Send },
    { value: 'master' as Tab, label: 'Master Data', detail: 'Status, kategori, prioritas', icon: Database }
  ];
  const masterItems = ['Status tiket', 'Priority', 'Category', 'Sub category', 'Knowledge base'];
  function save() { saved = true; setTimeout(() => (saved = false), 3000); }
</script>

<svelte:head><title>Settings — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
  <div class="grid gap-6 lg:grid-cols-[260px_1fr]">
    <Card.Root class="h-fit"><Card.Header class="pb-3"><Card.Title class="text-base">Settings menu</Card.Title></Card.Header><Card.Content class="flex flex-col gap-1">{#each tabs as item}<button type="button" onclick={() => (tab = item.value)} class="flex items-start gap-3 rounded-lg px-3 py-3 text-left transition-colors {tab === item.value ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-foreground'}"><item.icon size={17} class="mt-0.5 shrink-0" /><span><span class="block text-sm font-medium">{item.label}</span><span class="mt-0.5 block text-xs opacity-75">{item.detail}</span></span></button>{/each}<div class="mt-4 rounded-lg border border-border bg-muted/30 p-3"><div class="flex items-center gap-2 text-sm font-medium"><ShieldCheck size={16} class="text-success" />Workspace aman</div><p class="mt-1 text-xs leading-5 text-muted-foreground">Perubahan hanya berlaku untuk akun operator aktif.</p></div></Card.Content></Card.Root>
    <div class="flex min-w-0 flex-col gap-4">
      {#if tab === 'general'}<Card.Root><Card.Header><Card.Title>General settings</Card.Title><p class="text-sm text-muted-foreground">Informasi utama workspace dan profil operator.</p></Card.Header><Card.Content class="flex flex-col gap-5"><div class="flex items-center gap-3 rounded-lg border border-border bg-muted/20 p-4"><div class="flex size-11 items-center justify-center rounded-full bg-primary text-sm font-bold text-primary-foreground">OP</div><div><p class="font-semibold">{profile.name}</p><p class="text-sm text-muted-foreground">Operator layanan</p></div><Badge variant="success" class="ml-auto">Aktif</Badge></div><div class="grid gap-4 md:grid-cols-2"><label class="flex flex-col gap-2 text-sm font-medium">Nama operator<Input bind:value={profile.name} /></label><label class="flex flex-col gap-2 text-sm font-medium">Email<Input bind:value={profile.email} type="email" /></label></div></Card.Content></Card.Root><Card.Root><Card.Header><Card.Title>Preferensi notifikasi</Card.Title><p class="text-sm text-muted-foreground">Atur notifikasi operasional yang diterima.</p></Card.Header><Card.Content><div class="flex items-center justify-between gap-4 rounded-lg border border-border p-4"><div><p class="text-sm font-medium">Notifikasi tiket urgent</p><p class="mt-1 text-xs text-muted-foreground">Terima pemberitahuan saat tiket prioritas tinggi masuk.</p></div><Switch bind:checked={notifications} aria-label="Notifikasi tiket urgent" /></div></Card.Content></Card.Root>
      {:else if tab === 'email'}<Card.Root><Card.Header><Card.Title>Email setting</Card.Title><p class="text-sm text-muted-foreground">Koneksi SMTP dan template balasan otomatis.</p></Card.Header><Card.Content class="grid gap-3 sm:grid-cols-2"><Card.Root class="border-dashed"><Card.Content class="flex items-start gap-3 p-4"><Mail class="text-primary" /><div><p class="font-medium">SMTP Email</p><p class="mt-1 text-xs text-muted-foreground">Konfigurasi email keluar dan sender.</p><Badge variant="warning" class="mt-3">Perlu verifikasi</Badge></div></Card.Content></Card.Root><Card.Root class="border-dashed"><Card.Content class="flex items-start gap-3 p-4"><Bell class="text-primary" /><div><p class="font-medium">Autoreply</p><p class="mt-1 text-xs text-muted-foreground">Atur template respons otomatis.</p><Badge variant="secondary" class="mt-3">3 template</Badge></div></Card.Content></Card.Root></Card.Content></Card.Root>
      {:else if tab === 'outbound'}<Card.Root><Card.Header><Card.Title>Outbound blasting</Card.Title><p class="text-sm text-muted-foreground">Kelola resource untuk kampanye outbound.</p></Card.Header><Card.Content class="grid gap-3 sm:grid-cols-2"><Card.Root class="border-dashed"><Card.Content class="flex items-start gap-3 p-4"><Send class="text-primary" /><div><p class="font-medium">Template pesan</p><p class="mt-1 text-xs text-muted-foreground">Template siap digunakan untuk kampanye.</p><Badge variant="secondary" class="mt-3">12 template</Badge></div></Card.Content></Card.Root><Card.Root class="border-dashed"><Card.Content class="flex items-start gap-3 p-4"><UserRound class="text-primary" /><div><p class="font-medium">Target audience</p><p class="mt-1 text-xs text-muted-foreground">Segmentasi kontak outbound.</p><Badge variant="secondary" class="mt-3">4 segment</Badge></div></Card.Content></Card.Root></Card.Content></Card.Root>
      {:else}<Card.Root><Card.Header><Card.Title>Master data</Card.Title><p class="text-sm text-muted-foreground">Data dasar yang dipakai di ticketing dan reporting.</p></Card.Header><Card.Content class="grid gap-3 sm:grid-cols-2">{#each masterItems as item}<div class="flex items-center justify-between rounded-lg border border-border p-4"><div><p class="text-sm font-medium">{item}</p><p class="mt-1 text-xs text-muted-foreground">Kelola data {item.toLowerCase()}.</p></div><Button variant="outline" size="sm">Kelola</Button></div>{/each}</Card.Content></Card.Root>{/if}
      {#if saved}<Alert.Root variant="success"><Check /><Alert.Description>Pengaturan berhasil disimpan.</Alert.Description></Alert.Root>{/if}<div class="flex justify-end"><Button onclick={save}><Save data-icon="inline-start" />Simpan pengaturan</Button></div>
    </div>
  </div>
</div>
