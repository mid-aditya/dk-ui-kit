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
  import Alert from '$lib/components/ui/alert.svelte';
  import Badge from '$lib/components/ui/badge.svelte';

  let tab = $state('profil');
  let showSuccess = $state(false);
  let profile = $state({ name: 'Operator', email: 'op@ahu.id', phone: '+62812' });
  let channel = $state('whatsapp');
  let notifTicket = $state(true);
  let notifSummary = $state(true);

  function save() {
    showSuccess = true;
    setTimeout(() => showSuccess = false, 3000);
  }
</script>

<svelte:head><title>Settings — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Settings</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Profil, kanal & preferensi workspace.</p>
  </div>
</div>

<div class="mt-3 max-w-2xl">
  <!-- Tabs -->
  <Tabs bind:value={tab} tabs={[
    { value: 'profil', label: 'Profil' },
    { value: 'kanal', label: 'Kanal' },
    { value: 'notifikasi', label: 'Notifikasi' }
  ]} />

  <!-- Profile Tab -->
  {#if tab === 'profil'}
    <Card class="mt-3">
      <CardContent class="space-y-4 p-5">
        <div>
          <Label for="st-name">Nama</Label>
          <Input id="st-name" bind:value={profile.name} />
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <Label for="st-email">Email</Label>
            <Input id="st-email" bind:value={profile.email} type="email" />
          </div>
          <div>
            <Label for="st-phone">Telepon</Label>
            <Input id="st-phone" bind:value={profile.phone} type="tel" />
          </div>
        </div>
      </CardContent>
    </Card>
  {/if}

  <!-- Channel Tab -->
  {#if tab === 'kanal'}
    <Card class="mt-3">
      <CardContent class="space-y-4 p-5">
        <div>
          <Label for="st-ch">Kanal default balasan</Label>
          <Select id="st-ch" bind:value={channel}>
            <option value="whatsapp">WhatsApp</option>
            <option value="email">Email</option>
            <option value="telegram">Telegram</option>
          </Select>
        </div>

        <Card>
          <CardHeader><CardTitle class="text-sm">Konektor aktif</CardTitle></CardHeader>
          <CardContent class="space-y-2 text-sm">
            <div class="flex items-center justify-between">
              <span>WhatsApp Official</span>
              <Badge variant="success">Terhubung</Badge>
            </div>
            <div class="flex items-center justify-between">
              <span>Gateway unofficial</span>
              <Badge variant="success">Terhubung</Badge>
            </div>
            <div class="flex items-center justify-between">
              <span>SMTP Email</span>
              <Badge variant="warning">Perlu verifikasi</Badge>
            </div>
          </CardContent>
        </Card>
      </CardContent>
    </Card>
  {/if}

  <!-- Notification Tab -->
  {#if tab === 'notifikasi'}
    <Card class="mt-3">
      <CardContent class="space-y-4 p-5">
        <label class="flex cursor-pointer items-center justify-between rounded-lg border border-border p-4 hover:bg-muted/50 transition-colors">
          <div>
            <div class="font-medium">Notifikasi tiket urgent</div>
            <div class="text-xs text-muted-foreground">Terima notifikasi untuk tiket prioritas urgent</div>
          </div>
          <input type="checkbox" bind:checked={notifTicket} class="h-5 w-5 rounded border-input accent-primary" />
        </label>

        <label class="flex cursor-pointer items-center justify-between rounded-lg border border-border p-4 hover:bg-muted/50 transition-colors">
          <div>
            <div class="font-medium">Ringkasan harian email</div>
            <div class="text-xs text-muted-foreground">Kirim ringkasan email setiap pagi</div>
          </div>
          <input type="checkbox" bind:checked={notifSummary} class="h-5 w-5 rounded border-input accent-primary" />
        </label>
      </CardContent>
    </Card>
  {/if}

  <!-- Save Button & Success Alert -->
  {#if showSuccess}
    <div class="mt-3">
      <Alert variant="success" title="Berhasil" dismissible>
        Pengaturan tersimpan.
      </Alert>
    </div>
  {/if}

  <div class="mt-3">
    <Button onclick={save} class="w-full">Simpan pengaturan</Button>
  </div>
</div>
