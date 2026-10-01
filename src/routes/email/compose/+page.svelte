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
  import { locale } from '$lib/i18n';

  const STR = {
    id: {
      docTitle: 'Compose Email — DK UI Kit',
      title: 'Compose Email',
      desc: 'Buat dan kirim email baru. Tiru form blade: To/CC/BCC, template, subject, attachment, WYSIWYG.',
      inbox: 'Inbox',
      sent: 'Terkirim',
      toLabel: 'Kepada',
      toPh: 'Masukkan email + Enter',
      add: 'Tambah',
      removeLabel: 'hapus',
      ccTip: 'Tampilkan field CC',
      bccTip: 'Tampilkan field BCC',
      templateLabel: 'Template',
      templatePh: 'Pilih template…',
      templateGroup: 'Template Email',
      subjectLabel: 'Subject',
      messageLabel: 'Message',
      messagePh: 'Tulis pesan…',
      messageDesc: 'Toolbar B/I/U/list/link di blade disederhanakan jadi textarea.',
      sendOpts: 'Opsi pengiriman',
      signature: 'Tanda tangan',
      trackOpen: 'Lacak dibuka',
      sendNow: 'Kirim sekarang',
      schedule: 'Jadwalkan',
      normal: 'Normal',
      urgent: 'Urgent',
      quickPopup: 'Quick popup',
      cancel: 'Batal',
      saveDraft: 'Simpan Draft',
      sendEmail: 'Kirim Email',
      minRecipient: 'Minimal satu penerima',
      subjectRequired: 'Subject wajib',
      sentToast: 'Email dikirim',
      draftToast: 'Draft disimpan',
      popupToast: 'Terkirim via popup'
    },
    en: {
      docTitle: 'Compose Email — DK UI Kit',
      title: 'Compose Email',
      desc: 'Create and send a new email. Mirrors the blade form: To/CC/BCC, template, subject, attachment, WYSIWYG.',
      inbox: 'Inbox',
      sent: 'Sent',
      toLabel: 'To',
      toPh: 'Enter email + press Enter',
      add: 'Add',
      removeLabel: 'remove',
      ccTip: 'Show CC field',
      bccTip: 'Show BCC field',
      templateLabel: 'Template',
      templatePh: 'Choose a template…',
      templateGroup: 'Email Templates',
      subjectLabel: 'Subject',
      messageLabel: 'Message',
      messagePh: 'Write your message…',
      messageDesc: 'The blade B/I/U/list/link toolbar is simplified into a textarea.',
      sendOpts: 'Send options',
      signature: 'Signature',
      trackOpen: 'Track opens',
      sendNow: 'Send now',
      schedule: 'Schedule',
      normal: 'Normal',
      urgent: 'Urgent',
      quickPopup: 'Quick popup',
      cancel: 'Cancel',
      saveDraft: 'Save Draft',
      sendEmail: 'Send Email',
      minRecipient: 'At least one recipient',
      subjectRequired: 'Subject is required',
      sentToast: 'Email sent',
      draftToast: 'Draft saved',
      popupToast: 'Sent via popup'
    },
    th: {
      docTitle: 'เขียนอีเมล — DK UI Kit',
      title: 'เขียนอีเมล',
      desc: 'สร้างและส่งอีเมลใหม่ เลียนแบบฟอร์ม blade: ถึง/สำเนา/สำเนาลับ เทมเพลต หัวข้อ ไฟล์แนบ WYSIWYG',
      inbox: 'กล่องจดหมาย',
      sent: 'ส่งแล้ว',
      toLabel: 'ถึง',
      toPh: 'กรอกอีเมลแล้วกด Enter',
      add: 'เพิ่ม',
      removeLabel: 'ลบ',
      ccTip: 'แสดงช่อง CC',
      bccTip: 'แสดงช่อง BCC',
      templateLabel: 'เทมเพลต',
      templatePh: 'เลือกเทมเพลต…',
      templateGroup: 'เทมเพลตอีเมล',
      subjectLabel: 'หัวข้อ',
      messageLabel: 'ข้อความ',
      messagePh: 'เขียนข้อความ…',
      messageDesc: 'แถบเครื่องมือ B/I/U/รายการ/ลิงก์ใน blade ถูกย่อเป็น textarea',
      sendOpts: 'ตัวเลือกการส่ง',
      signature: 'ลายเซ็น',
      trackOpen: 'ติดตามการเปิดอ่าน',
      sendNow: 'ส่งทันที',
      schedule: 'ตั้งเวลาส่ง',
      normal: 'ปกติ',
      urgent: 'ด่วน',
      quickPopup: 'ป๊อปอัปด่วน',
      cancel: 'ยกเลิก',
      saveDraft: 'บันทึกร่าง',
      sendEmail: 'ส่งอีเมล',
      minRecipient: 'ต้องมีผู้รับอย่างน้อยหนึ่งคน',
      subjectRequired: 'ต้องระบุหัวข้อ',
      sentToast: 'ส่งอีเมลแล้ว',
      draftToast: 'บันทึกร่างแล้ว',
      popupToast: 'ส่งผ่านป๊อปอัปแล้ว'
    },
    tl: {
      docTitle: 'Sumulat ng Email — DK UI Kit',
      title: 'Sumulat ng Email',
      desc: 'Gumawa at magpadala ng bagong email. Katulad ng blade form: To/CC/BCC, template, paksa, attachment, WYSIWYG.',
      inbox: 'Inbox',
      sent: 'Naipadala',
      toLabel: 'Para sa',
      toPh: 'Ilagay ang email + Enter',
      add: 'Idagdag',
      removeLabel: 'alisin',
      ccTip: 'Ipakita ang CC field',
      bccTip: 'Ipakita ang BCC field',
      templateLabel: 'Template',
      templatePh: 'Pumili ng template…',
      templateGroup: 'Mga Template ng Email',
      subjectLabel: 'Paksa',
      messageLabel: 'Mensahe',
      messagePh: 'Isulat ang mensahe…',
      messageDesc: 'Ang toolbar na B/I/U/list/link sa blade ay pinasimple bilang textarea.',
      sendOpts: 'Mga opsyon sa pagpapadala',
      signature: 'Lagda',
      trackOpen: 'Subaybayan ang pagbukas',
      sendNow: 'Ipadala ngayon',
      schedule: 'Iiskedyul',
      normal: 'Normal',
      urgent: 'Urgent',
      quickPopup: 'Mabilisang popup',
      cancel: 'Kanselahin',
      saveDraft: 'I-save ang Draft',
      sendEmail: 'Ipadala ang Email',
      minRecipient: 'Kailangan ng kahit isang tatanggap',
      subjectRequired: 'Kailangan ang paksa',
      sentToast: 'Naipadala ang email',
      draftToast: 'Na-save ang draft',
      popupToast: 'Naipadala via popup'
    }
  } as const;
  let s = $derived(STR[$locale]);

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
  function send(){ if(!toTags.length){toast.error(s.minRecipient);return;} if(!subject.trim()){toast.error(s.subjectRequired);return;} toast.success(s.sentToast); }
</script>
<svelte:head><title>{s.docTitle}</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
    <div><Card.Title>{s.title}</Card.Title><Card.Description>{s.desc}</Card.Description></div>
    <div class="flex gap-2"><Button size="sm" variant="outline" href="/email">{s.inbox}</Button><Button size="sm" variant="secondary" href="/email/send">{s.sent}</Button></div>
  </Card.Header>
  <Card.Content>
    <Field.FieldGroup class="grid gap-4">
      <Field.Field>
        <Field.Label>{s.toLabel} *</Field.Label>
        <InputGroup.Root>
          <InputGroup.Input placeholder={s.toPh} bind:value={toInput} onkeydown={(e)=>{if(e.key==='Enter'){e.preventDefault();addTag();}}} />
          <InputGroup.Button onclick={addTag}>{s.add}</InputGroup.Button>
        </InputGroup.Root>
        <div class="mt-2 flex flex-wrap gap-1">{#each toTags as t}<Badge variant="secondary">{t} <button onclick={()=>toTags=toTags.filter(x=>x!==t)} aria-label={s.removeLabel}>×</button></Badge>{/each}</div>
      </Field.Field>
      <div class="flex gap-2">
        <Tooltip.Root><Tooltip.Trigger><Button size="sm" variant={showCc?'default':'outline'} onclick={()=>showCc=!showCc}>CC</Button></Tooltip.Trigger><Tooltip.Content><p>{s.ccTip}</p></Tooltip.Content></Tooltip.Root>
        <Tooltip.Root><Tooltip.Trigger><Button size="sm" variant={showBcc?'default':'outline'} onclick={()=>showBcc=!showBcc}>BCC</Button></Tooltip.Trigger><Tooltip.Content><p>{s.bccTip}</p></Tooltip.Content></Tooltip.Root>
      </div>
      {#if showCc}<Field.Field><Field.Label>CC</Field.Label><InputGroup.Root><InputGroup.Input bind:value={cc} placeholder="cc@mail.com"/></InputGroup.Root></Field.Field>{/if}
      {#if showBcc}<Field.Field><Field.Label>BCC</Field.Label><InputGroup.Root><InputGroup.Input bind:value={bcc} placeholder="bcc@mail.com"/></InputGroup.Root></Field.Field>{/if}
      <Field.Field>
        <Field.Label>{s.templateLabel}</Field.Label>
        <Select.Root type="single" bind:value={template} onValueChange={(v)=>applyTemplate(String(v))}>
          <Select.Trigger>{template||s.templatePh}</Select.Trigger>
          <Select.Content>
            <Select.Group><Select.GroupHeading>{s.templateGroup}</Select.GroupHeading>
              {#each templates as t}<Select.Item value={t.v} label={t.label}/>{/each}
            </Select.Group>
          </Select.Content>
        </Select.Root>
      </Field.Field>
      <Field.Field><Field.Label>{s.subjectLabel} *</Field.Label><InputGroup.Root><InputGroup.Input bind:value={subject} placeholder="Email subject"/></InputGroup.Root></Field.Field>
      <Field.Field>
        <Field.Label>{s.messageLabel} *</Field.Label>
        <Textarea bind:value={message} rows={6} placeholder={s.messagePh}/>
        <Field.Description>{s.messageDesc}</Field.Description>
      </Field.Field>
      <Attachment.Group class="grid gap-2 sm:grid-cols-2">
        {#each files as f}<Attachment.Root><Attachment.Title>{f.name}</Attachment.Title><Attachment.Description>{f.size}</Attachment.Description></Attachment.Root>{/each}
      </Attachment.Group>
      <Field.Set class="rounded-lg border p-3">
        <Field.Legend>{s.sendOpts}</Field.Legend>
        <div class="flex flex-wrap items-center gap-4">
          <label class="flex items-center gap-2 text-sm"><Checkbox/> {s.signature}</label>
          <label class="flex items-center gap-2 text-sm"><Switch bind:checked={track}/> {s.trackOpen}</label>
        </div>
        <RadioGroup.Root bind:value={schedule} class="mt-2 flex gap-4">
          <div class="flex items-center gap-2"><RadioGroup.Item value="now" id="s1"/><label for="s1" class="text-sm">{s.sendNow}</label></div>
          <div class="flex items-center gap-2"><RadioGroup.Item value="later" id="s2"/><label for="s2" class="text-sm">{s.schedule}</label></div>
        </RadioGroup.Root>
        <RadioGroup.Root bind:value={priority} class="mt-2 flex gap-4">
          <div class="flex items-center gap-2"><RadioGroup.Item value="normal" id="p1"/><label for="p1" class="text-sm">{s.normal}</label></div>
          <div class="flex items-center gap-2"><RadioGroup.Item value="urgent" id="p2"/><label for="p2" class="text-sm">{s.urgent}</label></div>
        </RadioGroup.Root>
      </Field.Set>
      <div class="flex justify-end gap-2">
        <Button variant="outline" onclick={()=>quickOpen=true}>{s.quickPopup}</Button>
        <Button variant="ghost" href="/email">{s.cancel}</Button>
        <Button variant="secondary" onclick={()=>toast.success(s.draftToast)}>{s.saveDraft}</Button>
        <Button onclick={send}>{s.sendEmail}</Button>
      </div>
    </Field.FieldGroup>
  </Card.Content>
</Card.Root>
<EmailCompose bind:open={quickOpen} bind:to={qto} bind:subject={qsub} bind:body={qbody} onSend={()=>toast.success(s.popupToast)} />
