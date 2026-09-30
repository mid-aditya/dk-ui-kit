<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  
  
  
  import { Button } from '$lib/components/ui/button';
  import { Input } from '$lib/components/ui/input';
  import { Label } from '$lib/components/ui/label';
  import { Textarea } from '$lib/components/ui/textarea';
  import Select from '$lib/components/ui/select.svelte';
  import Alert from '$lib/components/ui/alert.svelte';

  let to = $state('');
  let subject = $state('');
  let body = $state('');
  let template = $state('');
  let sent = $state(false);

  function useTemplate() {
    if (template === 'followup') subject = 'Follow-up penawaran Q3';
    if (template === 'csat') subject = 'Seberapa puas Anda dengan layanan kami?';
  }

  function handleSend() {
    if (!to.trim() || !subject.trim()) return;
    sent = true;
    setTimeout(() => sent = false, 3000);
  }
</script>

<svelte:head><title>Compose Email — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-end">
  <Button variant="ghost" href="/email">Kembali ke inbox</Button>
</div>

<div class="mt-3 grid gap-3 lg:grid-cols-3">
  <!-- Compose Form -->
  <div class="lg:col-span-2">
    <Card.Root>
      <Card.Content class="space-y-4 p-5">
        <!-- To -->
        <div>
          <Label for="em-to">Kepada *</Label>
          <Input id="em-to" bind:value={to} required placeholder="nama@perusahaan.id" />
        </div>

        <!-- Subject -->
        <div>
          <Label for="em-subject">Subjek *</Label>
          <Input id="em-subject" bind:value={subject} required placeholder="Subjek email" />
        </div>

        <!-- Body -->
        <div>
          <Label for="em-body">Isi *</Label>
          <Textarea id="em-body" bind:value={body} rows={10} placeholder="Tulis pesan…" />
        </div>

        <!-- Success Alert -->
        {#if sent}
          <Alert variant="success" title="Email dikirim">
            Email masuk antrean kirim.
          </Alert>
        {/if}

        <!-- Actions -->
        <div class="flex gap-2">
          <Button onclick={handleSend} disabled={!to.trim() || !subject.trim()}>Kirim</Button>
          <Button variant="secondary" href="/email?status=draft">Simpan draft</Button>
        </div>
      </Card.Content>
    </Card.Root>
  </div>

  <!-- Template Sidebar -->
  <Card.Root>
    <Card.Header><Card.Title>Dari template</Card.Title></Card.Header>
    <Card.Content class="space-y-4">
      <Select bind:value={template} onchange={useTemplate} options={[
        { value: '', label: 'Pilih template…' },
        { value: 'followup', label: 'Follow-up penawaran' },
        { value: 'csat', label: 'Survei CSAT' }
      ]} />
      <p class="text-xs text-muted-foreground">
        Template lengkap dikelola di <a href="/email/templates" class="font-semibold text-primary">Email Templates</a>.
      </p>
    </Card.Content>
  </Card.Root>
</div>
