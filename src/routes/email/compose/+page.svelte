<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Input from '$lib/components/ui/input.svelte';
  import Label from '$lib/components/ui/label.svelte';
  import Textarea from '$lib/components/ui/textarea.svelte';
  import Select from '$lib/components/ui/select.svelte';

  let to = '';
  let subject = '';
  let body = '';
  let template = '';
  let sent = false;

  function useTemplate() {
    if (template === 'followup') subject = 'Follow-up penawaran Q3';
    if (template === 'csat') subject = 'Seberapa puas Anda dengan layanan kami?';
  }
</script>

<svelte:head><title>Compose Email — DK UI Kit</title></svelte:head>

<h1 class="text-2xl font-extrabold tracking-tight">Compose</h1>
<p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Tulis email baru ke pelanggan.</p>

<div class="mt-3 grid gap-3 lg:grid-cols-3">
  <Card class="lg:col-span-2">
    <CardContent class="space-y-2 p-5">
      <div><Label for="em-to">Kepada *</Label><Input id="em-to" bind:value={to} required placeholder="nama@perusahaan.id" /></div>
      <div><Label for="em-subject">Subjek *</Label><Input id="em-subject" bind:value={subject} required placeholder="Subjek email" /></div>
      <div><Label for="em-body">Isi *</Label><Textarea id="em-body" bind:value={body} rows={8} placeholder="Tulis pesan…" /></div>
      {#if sent}<p class="rounded-xl bg-emerald-50 border border-emerald-100 px-3 py-2 text-sm text-emerald-700">Email masuk antrean kirim.</p>{/if}
      <div class="flex gap-2">
        <Button onclick={() => (sent = true)}>Kirim</Button>
        <Button variant="secondary" href="/email?status=draft">Simpan draft</Button>
      </div>
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>Dari template</CardTitle></CardHeader>
    <CardContent class="space-y-2">
      <Select bind:value={template} onchange={useTemplate}>
        <option value="">Pilih template…</option>
        <option value="followup">Follow-up penawaran</option>
        <option value="csat">Survei CSAT</option>
      </Select>
      <p class="text-xs text-slate-400">Template lengkap dikelola di <a class="font-semibold text-brand-600" href="/email/templates">Email Templates</a>.</p>
    </CardContent>
  </Card>
</div>
