<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Label from '$lib/components/ui/label.svelte';
  import Select from '$lib/components/ui/select.svelte';
  import Tabs from '$lib/components/ui/tabs.svelte';

  let tab = 'profil';
  let saved = '';
  let profile = { name: 'Operator', email: 'op@ahu.id', phone: '+62812' };
  let channel = 'whatsapp';
  let notif = true;

  function save() {
    saved = 'Pengaturan tersimpan.';
    setTimeout(() => (saved = ''), 2500);
  }
</script>

<svelte:head><title>Settings — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Settings</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Profil, kanal & preferensi workspace.</p>

<div class="mt-3 max-w-2xl">
  <Tabs
    bind:value={tab}
    tabs={[
      { value: 'profil', label: 'Profil' },
      { value: 'kanal', label: 'Kanal' },
      { value: 'notifikasi', label: 'Notifikasi' }
    ]}
  />
  <Card class="mt-3">
    <CardContent class="space-y-2 p-5">
      {#if tab === 'profil'}
        <div><Label for="st-name">Nama</Label><Input id="st-name" bind:value={profile.name} /></div>
        <div class="grid grid-cols-2 gap-2">
          <div><Label for="st-email">Email</Label><Input id="st-email" bind:value={profile.email} /></div>
          <div><Label for="st-phone">Telepon</Label><Input id="st-phone" bind:value={profile.phone} /></div>
        </div>
      {:else if tab === 'kanal'}
        <div><Label for="st-ch">Kanal default balasan</Label>
          <Select id="st-ch" bind:value={channel}>
            <option value="whatsapp">WhatsApp</option>
            <option value="email">Email</option>
            <option value="telegram">Telegram</option>
          </Select>
        </div>
        <Card>
          <CardHeader><CardTitle>Konektor aktif</CardTitle></CardHeader>
          <CardContent class="space-y-1 text-sm">
            <div class="flex justify-between"><span>WhatsApp Official</span><span class="font-semibold text-emerald-600">terhubung</span></div>
            <div class="flex justify-between"><span>Gateway unofficial</span><span class="font-semibold text-emerald-600">terhubung</span></div>
            <div class="flex justify-between"><span>SMTP Email</span><span class="font-semibold text-amber-600">perlu verifikasi</span></div>
          </CardContent>
        </Card>
      {:else}
        <label class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 p-3 text-sm dark:border-slate-700">
          <span>Notifikasi tiket urgent</span>
          <input type="checkbox" bind:checked={notif} class="h-4 w-4 accent-blue-600" />
        </label>
        <label class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 p-3 text-sm dark:border-slate-700">
          <span>Ringkasan harian email</span>
          <input type="checkbox" checked class="h-4 w-4 accent-blue-600" />
        </label>
      {/if}
      {#if saved}<p class="rounded-xl bg-emerald-50 border border-emerald-100 px-3 py-2 text-sm text-emerald-700">{saved}</p>{/if}
      <Button onclick={save} class="w-full">Simpan pengaturan</Button>
    </CardContent>
  </Card>
</div>
