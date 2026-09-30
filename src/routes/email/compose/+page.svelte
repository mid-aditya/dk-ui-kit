<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import * as Field from '$lib/components/ui/field';
  import * as InputGroup from '$lib/components/ui/input-group';
  import * as Select from '$lib/components/ui/select';
  import * as Attachment from '$lib/components/ui/attachment';
  import * as Tooltip from '$lib/components/ui/tooltip';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Checkbox } from '$lib/components/ui/checkbox';
  import * as RadioGroup from '$lib/components/ui/radio-group';
  import { Switch } from '$lib/components/ui/switch';
  import { Textarea } from '$lib/components/ui/textarea';
  import { toast, Toaster } from 'svelte-sonner';
  import EmailCompose from '$lib/components/ui/email-compose.svelte';

  let toTags = $state(['cs@corp.id']);
  let toInput = $state(''); let cc = $state(''); let bcc = $state('');
  let showCc = $state(false); let showBcc = $state(false);
  let template = $state(''); let subject = $state(''); let message = $state('');
  let track = $state(true); let priority = $state('normal'); let schedule = $state('now');
  let files = $state([{name:'proposal.pdf',size:'240 KB'},{name:'gambar.png',size:'120 KB'}]);
  let quickOpen = $state(false); let qto=$state(''); let qsub=$state(''); let qbody=$state('');

  const templates = [{v:'followup',label:'Follow-up Tiket',sub:'Follow-up tiket Anda',body:'Halo, menindaklanjuti tiket…'},
    {v:'invoice',label:'Pengiriman Invoice',sub:'Invoice September',body:'Terlampir invoice…'},
    {v:'thanks',label:'Terima Kasih',sub:'Terima kasih',body:'Terima kasih atas kepercayaan…'}];
  function applyTemplate(v:string){ const t=templates.find(t=>t.v===v); if(t){subject=t.sub;message=t.body;} }
  function addTag(){ const v=toInput.trim().replace(/,$/,''); if(v&&/^\S+@\S+\.\S+$/.test(v)&&!toTags.includes(v)){toTags=[...toTags,v];toInput='';} }
  function send(){ if(!toTags.length){toast.error('Minimal satu penerima');return;} if(!subject.trim()){toast.error('Subject wajib');return;} toast.success('Email dikirim'); }
</script>
<svelte:head><title>Compose Email — DK UI Kit</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
    <div><Card.Title>Compose Email</Card.Title><Card.Description>Buat dan kirim email baru. Tiru form blade: To/CC/BCC, template, subject, attachment, WYSIWYG.</Card.Description></div>
    <div class="flex gap-2"><Button size="sm" variant="outline" href="/email">Inbox</Button><Button size="sm" variant="secondary" href="/email/send">Terkirim</Button></div>
  </Card.Header>
  <Card.Content>
    <Field.FieldGroup class="grid gap-4">
      <Field.Field>
        <Field.Label>Kepada *</Field.Label>
        <InputGroup.Root>
          <InputGroup.Input placeholder="Masukkan email + Enter" bind:value={toInput} onkeydown={(e)=>{if(e.key==='Enter'){e.preventDefault();addTag();}}} />
          <InputGroup.Button onclick={addTag}>Tambah</InputGroup.Button>
        </InputGroup.Root>
        <div class="mt-2 flex flex-wrap gap-1">{#each toTags as t}<Badge variant="secondary">{t} <button onclick={()=>toTags=toTags.filter(x=>x!==t)} aria-label="hapus">×</button></Badge>{/each}</div>
      </Field.Field>
      <div class="flex gap-2">
        <Tooltip.Root><Tooltip.Trigger><Button size="sm" variant={showCc?'default':'outline'} onclick={()=>showCc=!showCc}>CC</Button></Tooltip.Trigger><Tooltip.Content><p>Tampilkan field CC</p></Tooltip.Content></Tooltip.Root>
        <Tooltip.Root><Tooltip.Trigger><Button size="sm" variant={showBcc?'default':'outline'} onclick={()=>showBcc=!showBcc}>BCC</Button></Tooltip.Trigger><Tooltip.Content><p>Tampilkan field BCC</p></Tooltip.Content></Tooltip.Root>
      </div>
      {#if showCc}<Field.Field><Field.Label>CC</Field.Label><InputGroup.Root><InputGroup.Input bind:value={cc} placeholder="cc@mail.com"/></InputGroup.Root></Field.Field>{/if}
      {#if showBcc}<Field.Field><Field.Label>BCC</Field.Label><InputGroup.Root><InputGroup.Input bind:value={bcc} placeholder="bcc@mail.com"/></InputGroup.Root></Field.Field>{/if}
      <Field.Field>
        <Field.Label>Template</Field.Label>
        <Select.Root type="single" bind:value={template} onValueChange={(v)=>applyTemplate(String(v))}>
          <Select.Trigger>{template||'Pilih template…'}</Select.Trigger>
          <Select.Content>
            <Select.Group><Select.GroupHeading>Template Email</Select.GroupHeading>
              {#each templates as t}<Select.Item value={t.v} label={t.label}/>{/each}
            </Select.Group>
          </Select.Content>
        </Select.Root>
      </Field.Field>
      <Field.Field><Field.Label>Subject *</Field.Label><InputGroup.Root><InputGroup.Input bind:value={subject} placeholder="Email subject"/></InputGroup.Root></Field.Field>
      <Field.Field>
        <Field.Label>Message *</Field.Label>
        <Textarea bind:value={message} rows={6} placeholder="Tulis pesan…"/>
        <Field.Description>Toolbar B/I/U/list/link di blade disederhanakan jadi textarea.</Field.Description>
      </Field.Field>
      <Attachment.Group class="grid gap-2 sm:grid-cols-2">
        {#each files as f}<Attachment.Root><Attachment.Title>{f.name}</Attachment.Title><Attachment.Description>{f.size}</Attachment.Description></Attachment.Root>{/each}
      </Attachment.Group>
      <Field.Set class="rounded-lg border p-3">
        <Field.Legend>Opsi pengiriman</Field.Legend>
        <div class="flex flex-wrap items-center gap-4">
          <label class="flex items-center gap-2 text-sm"><Checkbox/> Tanda tangan</label>
          <label class="flex items-center gap-2 text-sm"><Switch bind:checked={track}/> Lacak dibuka</label>
        </div>
        <RadioGroup.Root bind:value={schedule} class="mt-2 flex gap-4">
          <div class="flex items-center gap-2"><RadioGroup.Item value="now" id="s1"/><label for="s1" class="text-sm">Kirim sekarang</label></div>
          <div class="flex items-center gap-2"><RadioGroup.Item value="later" id="s2"/><label for="s2" class="text-sm">Jadwalkan</label></div>
        </RadioGroup.Root>
        <RadioGroup.Root bind:value={priority} class="mt-2 flex gap-4">
          <div class="flex items-center gap-2"><RadioGroup.Item value="normal" id="p1"/><label for="p1" class="text-sm">Normal</label></div>
          <div class="flex items-center gap-2"><RadioGroup.Item value="urgent" id="p2"/><label for="p2" class="text-sm">Urgent</label></div>
        </RadioGroup.Root>
      </Field.Set>
      <div class="flex justify-end gap-2">
        <Button variant="outline" onclick={()=>quickOpen=true}>Quick popup</Button>
        <Button variant="ghost" href="/email">Batal</Button>
        <Button variant="secondary" onclick={()=>toast.success('Draft disimpan')}>Simpan Draft</Button>
        <Button onclick={send}>Kirim Email</Button>
      </div>
    </Field.FieldGroup>
  </Card.Content>
</Card.Root>
<EmailCompose bind:open={quickOpen} bind:to={qto} bind:subject={qsub} bind:body={qbody} onSend={()=>toast.success('Terkirim via popup')} />
