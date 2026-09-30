<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import { Label } from '$lib/components/ui/label';
  import Select from '$lib/components/ui/select.svelte';
  import Alert from '$lib/components/ui/alert.svelte';
  import { Badge } from '$lib/components/ui/badge';
  import { UserRound, PlugZap, Bell, ShieldCheck, Save, Check, Mail, Phone, MessageSquare } from 'lucide-svelte';

  type Tab = 'profil' | 'kanal' | 'notifikasi';
  let tab = $state<Tab>('profil');
  let showSuccess = $state(false);
  let profile = $state({ name: 'Operator', email: 'op@ahu.id', phone: '+62812' });
  let channel = $state('whatsapp');
  let notifTicket = $state(true);
  let notifSummary = $state(true);

  const tabs = [
    { value: 'profil' as Tab, label: 'Profil', description: 'Informasi akun Anda', icon: UserRound },
    { value: 'kanal' as Tab, label: 'Kanal', description: 'Koneksi dan kanal default', icon: PlugZap },
    { value: 'notifikasi' as Tab, label: 'Notifikasi', description: 'Atur pemberitahuan', icon: Bell }
  ];

  function save() {
    showSuccess = true;
    setTimeout(() => (showSuccess = false), 3000);
  }
</script>

<svelte:head><title>Pengaturan — DK CRM</title></svelte:head>

<div class="space-y-6">
  <div><h2 class="text-2xl font-bold tracking-tight text-foreground md:text-3xl">Pengaturan</h2><p class="mt-1 text-sm text-muted-foreground">Kelola profil, kanal, dan preferensi notifikasi akun Anda.</p></div>

  <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
    <Card.Root class="h-fit"><Card.Content class="p-3"><div class="mb-3 px-3 pt-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">Pengaturan akun</div><nav class="space-y-1" aria-label="Menu pengaturan">{#each tabs as item}<button type="button" onclick={() => (tab = item.value)} class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left transition-colors {tab === item.value ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-muted-foreground hover:bg-accent hover:text-foreground'}"><item.icon size={18} /><span class="min-w-0 flex-1"><span class="block text-sm font-semibold">{item.label}</span><span class="mt-0.5 block text-xs {tab === item.value ? 'text-blue-100' : 'text-muted-foreground'}">{item.description}</span></span></button>{/each}</nav><div class="mt-5 rounded-xl border border-border bg-muted/30 p-3"><div class="flex items-center gap-2 text-sm font-medium"><ShieldCheck size={16} class="text-emerald-400" />Akun aman</div><p class="mt-1 text-xs leading-5 text-muted-foreground">Pengaturan hanya berlaku untuk akun Operator yang sedang aktif.</p></div></Card.Content></Card.Root>

    <div class="min-w-0 space-y-5">
      {#if tab === 'profil'}
        <Card.Root><Card.Header><Card.Title>Profil pengguna</Card.Title><p class="text-sm text-muted-foreground">Perbarui informasi dasar yang digunakan pada aktivitas CRM.</p></Card.Header><Card.Content class="space-y-5"><div class="flex items-center gap-4 rounded-xl border border-border bg-muted/20 p-4"><div class="flex h-14 w-14 items-center justify-center rounded-full bg-primary text-lg font-bold text-white">OP</div><div><p class="font-semibold text-foreground">{profile.name}</p><p class="text-sm text-muted-foreground">Operator layanan</p><Badge variant="success" class="mt-2">Aktif</Badge></div></div><div class="grid gap-5 md:grid-cols-2"><div><Label for="st-name">Nama lengkap</Label><div class="relative mt-2"><UserRound size={16} class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" /><Input id="st-name" bind:value={profile.name} class="pl-9" /></div></div><div><Label for="st-email">Email</Label><div class="relative mt-2"><Mail size={16} class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" /><Input id="st-email" bind:value={profile.email} type="email" class="pl-9" /></div></div><div><Label for="st-phone">Nomor telepon</Label><div class="relative mt-2"><Phone size={16} class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" /><Input id="st-phone" bind:value={profile.phone} type="tel" class="pl-9" /></div></div><div><Label for="st-role">Peran</Label><Input id="st-role" value="Operator" disabled class="mt-2" /></div></div></Card.Content></Card.Root>
      {:else if tab === 'kanal'}
        <Card.Root><Card.Header><Card.Title>Pengaturan kanal</Card.Title><p class="text-sm text-muted-foreground">Tentukan kanal default dan lihat status konektor yang aktif.</p></Card.Header><Card.Content class="space-y-5"><div><Label for="st-ch">Kanal default balasan</Label><Select bind:value={channel} options={[{ value: 'whatsapp', label: 'WhatsApp' }, { value: 'email', label: 'Email' }, { value: 'telegram', label: 'Telegram' }]} class="mt-2 w-full" /></div><div class="rounded-xl border border-border"><div class="border-b border-border px-4 py-3"><p class="text-sm font-semibold">Konektor aktif</p><p class="mt-1 text-xs text-muted-foreground">Status koneksi kanal pada workspace ini.</p></div><div class="divide-y divide-border">{#each [{ name: 'WhatsApp Official', detail: 'Pesan masuk dan keluar', icon: MessageSquare, status: 'Terhubung', variant: 'success' as const }, { name: 'Gateway unofficial', detail: 'Kanal percakapan tambahan', icon: PlugZap, status: 'Terhubung', variant: 'success' as const }, { name: 'SMTP Email', detail: 'Email keluar', icon: Mail, status: 'Perlu verifikasi', variant: 'warning' as const }] as connector}<div class="flex items-center justify-between gap-3 px-4 py-4"><div class="flex items-center gap-3"><div class="rounded-lg bg-muted p-2"><connector.icon size={17} class="text-primary" /></div><div><p class="text-sm font-medium">{connector.name}</p><p class="text-xs text-muted-foreground">{connector.detail}</p></div></div><Badge variant={connector.variant}>{connector.status}</Badge></div>{/each}</div></div></Card.Content></Card.Root>
      {:else}
        <Card.Root><Card.Header><Card.Title>Preferensi notifikasi</Card.Title><p class="text-sm text-muted-foreground">Pilih pemberitahuan yang ingin diterima oleh akun Anda.</p></Card.Header><Card.Content class="space-y-3"><label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-border p-4 transition-colors hover:bg-accent/50"><div><div class="font-medium text-foreground">Notifikasi tiket urgent</div><div class="mt-1 text-xs text-muted-foreground">Terima notifikasi untuk tiket prioritas urgent</div></div><input type="checkbox" bind:checked={notifTicket} class="h-5 w-5 rounded border-input accent-primary" /></label><label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-border p-4 transition-colors hover:bg-accent/50"><div><div class="font-medium text-foreground">Ringkasan harian email</div><div class="mt-1 text-xs text-muted-foreground">Kirim ringkasan email setiap pagi</div></div><input type="checkbox" bind:checked={notifSummary} class="h-5 w-5 rounded border-input accent-primary" /></label></Card.Content></Card.Root>
      {/if}

      {#if showSuccess}<Alert variant="success" title="Berhasil" dismissible><div class="flex items-center gap-2"><Check size={15} />Pengaturan tersimpan.</div></Alert>{/if}
      <div class="flex justify-end"><Button onclick={save}><Save size={16} />Simpan pengaturan</Button></div>
    </div>
  </div>
</div>
