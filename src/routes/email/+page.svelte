<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import * as Table from '$lib/components/ui/table';
  import * as Pagination from '$lib/components/ui/pagination';
  import * as Dialog from '$lib/components/ui/dialog';
  import * as AlertDialog from '$lib/components/ui/alert-dialog';
  import * as Field from '$lib/components/ui/field';
  import * as InputGroup from '$lib/components/ui/input-group';
  import * as Select from '$lib/components/ui/select';
  import * as Tabs from '$lib/components/ui/tabs';
  import * as Tooltip from '$lib/components/ui/tooltip';
  import * as Empty from '$lib/components/ui/empty';
  import * as Attachment from '$lib/components/ui/attachment';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Checkbox } from '$lib/components/ui/checkbox';
  import { Switch } from '$lib/components/ui/switch';
  import { Textarea } from '$lib/components/ui/textarea';
  import { Separator } from '$lib/components/ui/separator';
  import { toast } from 'svelte-sonner';
  import { cn } from '$lib/utils.js';
  import EmailItem from '$lib/components/ui/email-item.svelte';
  import EmailCompose from '$lib/components/ui/email-compose.svelte';
  import { ChevronLeft, ChevronRight, Inbox, Search, Archive, Trash2, MailOpen } from 'lucide-svelte';
  import { locale } from '$lib/i18n';

  const STR = {
    id: {
      docTitle: 'Email Inbox — DK UI Kit',
      inbox: 'Inbox',
      desc: 'Folder/label: Semua, Belum/Sudah Dibaca, Reply, Terima Kasih, Salah Sambung, Spam, Draft, Close.',
      compose: 'Compose',
      quickCompose: 'Quick compose',
      searchLabel: 'Cari email',
      searchPh: 'Cari subjek atau pengirim…',
      notifLabel: 'Notifikasi',
      on: 'Aktif',
      off: 'Mati',
      actionLabel: 'Aksi',
      sent: 'Terkirim',
      history: 'History',
      templates: 'Templates',
      selectedT: '{n} dipilih',
      markRead: 'Tandai dibaca',
      archive: 'Arsip',
      delete: 'Hapus',
      selectAll: 'Pilih semua email',
      of: 'dari',
      emails: 'email',
      unreadDot: 'Belum dibaca',
      selectEmail: 'Pilih email',
      preview: 'Pratinjau',
      archiveEmail: 'Arsipkan email',
      emptyTitle: 'Kotak masuk kosong',
      emptyDesc: 'Selamat, semua email sudah tertangani.',
      detailFb: 'Detail',
      previewFb: 'Pratinjau email',
      reply: 'Reply',
      repliedToast: 'Email dibalas',
      archiveTitle: 'Arsipkan email?',
      archiveDesc: 'Email yang dipilih akan dipindahkan ke arsip.',
      cancel: 'Batal',
      archiveBtn: 'Arsipkan',
      archivedToast: 'Diarsipkan',
      markedReadT: '{n} email ditandai dibaca',
      deletedT: '{n} email dihapus',
      sentToast: 'Email dikirim',
      folderAll: 'Semua',
      folderUnread: 'Belum Dibaca',
      folderRead: 'Sudah Dibaca',
      folderReplied: 'Sudah Di-reply',
      folderThanks: 'Terima Kasih',
      folderWrong: 'Salah Sambung',
      folderSpam: 'Spam',
      folderDraft: 'Draft',
      folderClose: 'Close'
    },
    en: {
      docTitle: 'Email Inbox — DK UI Kit',
      inbox: 'Inbox',
      desc: 'Folders/labels: All, Unread/Read, Replied, Thanks, Wrong Address, Spam, Draft, Close.',
      compose: 'Compose',
      quickCompose: 'Quick compose',
      searchLabel: 'Search emails',
      searchPh: 'Search subject or sender…',
      notifLabel: 'Notifications',
      on: 'On',
      off: 'Off',
      actionLabel: 'Actions',
      sent: 'Sent',
      history: 'History',
      templates: 'Templates',
      selectedT: '{n} selected',
      markRead: 'Mark as read',
      archive: 'Archive',
      delete: 'Delete',
      selectAll: 'Select all emails',
      of: 'of',
      emails: 'emails',
      unreadDot: 'Unread',
      selectEmail: 'Select email',
      preview: 'Preview',
      archiveEmail: 'Archive email',
      emptyTitle: 'Inbox is empty',
      emptyDesc: 'All caught up — every email is handled.',
      detailFb: 'Detail',
      previewFb: 'Email preview',
      reply: 'Reply',
      repliedToast: 'Email replied',
      archiveTitle: 'Archive emails?',
      archiveDesc: 'Selected emails will be moved to archive.',
      cancel: 'Cancel',
      archiveBtn: 'Archive',
      archivedToast: 'Archived',
      markedReadT: '{n} emails marked as read',
      deletedT: '{n} emails deleted',
      sentToast: 'Email sent',
      folderAll: 'All',
      folderUnread: 'Unread',
      folderRead: 'Read',
      folderReplied: 'Replied',
      folderThanks: 'Thanks',
      folderWrong: 'Wrong Address',
      folderSpam: 'Spam',
      folderDraft: 'Draft',
      folderClose: 'Close'
    },
    th: {
      docTitle: 'กล่องจดหมายอีเมล — DK UI Kit',
      inbox: 'กล่องจดหมาย',
      desc: 'โฟลเดอร์/ป้ายกำกับ: ทั้งหมด ยังไม่ได้อ่าน/อ่านแล้ว ตอบกลับแล้ว ขอบคุณ ส่งผิดที่อยู่ สแปม ร่าง ปิด',
      compose: 'เขียนอีเมล',
      quickCompose: 'เขียนด่วน',
      searchLabel: 'ค้นหาอีเมล',
      searchPh: 'ค้นหาหัวข้อหรือผู้ส่ง…',
      notifLabel: 'การแจ้งเตือน',
      on: 'เปิด',
      off: 'ปิด',
      actionLabel: 'การดำเนินการ',
      sent: 'ส่งแล้ว',
      history: 'ประวัติ',
      templates: 'เทมเพลต',
      selectedT: 'เลือก {n} รายการ',
      markRead: 'ทำเครื่องหมายว่าอ่านแล้ว',
      archive: 'เก็บถาวร',
      delete: 'ลบ',
      selectAll: 'เลือกอีเมลทั้งหมด',
      of: 'จาก',
      emails: 'อีเมล',
      unreadDot: 'ยังไม่ได้อ่าน',
      selectEmail: 'เลือกอีเมล',
      preview: 'ดูตัวอย่าง',
      archiveEmail: 'เก็บถาวรอีเมล',
      emptyTitle: 'กล่องจดหมายว่าง',
      emptyDesc: 'เรียบร้อย อีเมลทั้งหมดได้รับการจัดการแล้ว',
      detailFb: 'รายละเอียด',
      previewFb: 'ดูตัวอย่างอีเมล',
      reply: 'ตอบกลับ',
      repliedToast: 'ตอบกลับอีเมลแล้ว',
      archiveTitle: 'เก็บถาวรอีเมล?',
      archiveDesc: 'อีเมลที่เลือกจะถูกย้ายไปยังที่เก็บถาวร',
      cancel: 'ยกเลิก',
      archiveBtn: 'เก็บถาวร',
      archivedToast: 'เก็บถาวรแล้ว',
      markedReadT: 'ทำเครื่องหมายว่าอ่านแล้ว {n} อีเมล',
      deletedT: 'ลบ {n} อีเมลแล้ว',
      sentToast: 'ส่งอีเมลแล้ว',
      folderAll: 'ทั้งหมด',
      folderUnread: 'ยังไม่ได้อ่าน',
      folderRead: 'อ่านแล้ว',
      folderReplied: 'ตอบกลับแล้ว',
      folderThanks: 'ขอบคุณ',
      folderWrong: 'ส่งผิดที่อยู่',
      folderSpam: 'สแปม',
      folderDraft: 'ร่าง',
      folderClose: 'ปิด'
    },
    tl: {
      docTitle: 'Email Inbox — DK UI Kit',
      inbox: 'Inbox',
      desc: 'Mga folder/label: Lahat, Hindi pa/Nabasa na, Nareplyan, Salamat, Maling Address, Spam, Draft, Sarado.',
      compose: 'Sumulat',
      quickCompose: 'Mabilisang sulat',
      searchLabel: 'Maghanap ng email',
      searchPh: 'Hanapin ang paksa o nagpadala…',
      notifLabel: 'Mga notipikasyon',
      on: 'Bukas',
      off: 'Patay',
      actionLabel: 'Mga aksyon',
      sent: 'Naipadala',
      history: 'History',
      templates: 'Mga Template',
      selectedT: '{n} ang napili',
      markRead: 'Markahan bilang nabasa',
      archive: 'I-archive',
      delete: 'Burahin',
      selectAll: 'Piliin lahat ng email',
      of: 'mula sa',
      emails: 'email',
      unreadDot: 'Hindi pa nabasa',
      selectEmail: 'Piliin ang email',
      preview: 'Silipin',
      archiveEmail: 'I-archive ang email',
      emptyTitle: 'Walang laman ang inbox',
      emptyDesc: 'Ayos — lahat ng email ay naasikaso na.',
      detailFb: 'Detalye',
      previewFb: 'Silipin ang email',
      reply: 'Reply',
      repliedToast: 'Nareplyan ang email',
      archiveTitle: 'I-archive ang mga email?',
      archiveDesc: 'Ang mga napiling email ay ililipat sa archive.',
      cancel: 'Kanselahin',
      archiveBtn: 'I-archive',
      archivedToast: 'Na-archive na',
      markedReadT: '{n} email na minarkahang nabasa',
      deletedT: '{n} email na binura',
      sentToast: 'Naipadala ang email',
      folderAll: 'Lahat',
      folderUnread: 'Hindi Pa Nabasa',
      folderRead: 'Nabasa Na',
      folderReplied: 'Nareplyan Na',
      folderThanks: 'Salamat',
      folderWrong: 'Maling Address',
      folderSpam: 'Spam',
      folderDraft: 'Draft',
      folderClose: 'Sarado'
    }
  } as const;
  let s = $derived(STR[$locale]);

  /** Label tampilan untuk value folder/status yang stabil (value logic tidak diubah). */
  function folderLabel(v: string): string {
    switch (v) {
      case 'Semua': return s.folderAll;
      case 'Belum Dibaca': return s.folderUnread;
      case 'Sudah Dibaca': return s.folderRead;
      case 'Sudah Di-reply': return s.folderReplied;
      case 'Terima Kasih': return s.folderThanks;
      case 'Salah Sambung': return s.folderWrong;
      case 'Spam': return s.folderSpam;
      case 'Draft': return s.folderDraft;
      case 'Close': return s.folderClose;
      default: return v;
    }
  }

  const folders = ['Semua','Belum Dibaca','Sudah Dibaca','Sudah Di-reply','Terima Kasih','Salah Sambung','Spam','Draft','Close'];
  let folder = $state('Semua');
  let q = $state('');
  let page = $state(1);
  const perPage = 5;
  let selected = $state<number | null>(null);
  let composeOpen = $state(false);
  let archiveOpen = $state(false);
  let to = $state(''); let subject = $state(''); let body = $state('');
  let notify = $state(true);
  let checked = $state<number[]>([]);

  type Mail = { id:number; from:string; subject:string; snippet:string; date:string; read:boolean; status:string; ticket?:string; agent?:string; attachments:number };
  const mails: Mail[] = [
    { id:1, from:'Budi Santoso <budi@mail.com>', subject:'Permintaan reset password akun', snippet:'Mohon bantuan reset password untuk akun perusahaan kami…', date:'09:41', read:false, status:'Belum Dibaca', ticket:'T-2026-001', agent:'Rina', attachments:2 },
    { id:2, from:'Sari Dewi <sari@corp.id>', subject:'Invoice bulan September', snippet:'Berikut kami lampirkan invoice bulan berjalan…', date:'Kemarin', read:true, status:'Sudah Dibaca', ticket:'T-2026-002', attachments:1 },
    { id:3, from:'Andi <andi@mail.com>', subject:'Terima kasih atas bantuannya', snippet:'Layanan sangat membantu, terima kasih…', date:'Senin', read:true, status:'Terima Kasih', attachments:0 },
    { id:4, from:'Spam Promo <promo@spam.com>', subject:'Menangkan hadiah!', snippet:'Klik link ini untuk klaim…', date:'Minggu', read:true, status:'Spam', attachments:0 },
    { id:5, from:'HRD <hrd@corp.id>', subject:'Draft: Pengumuman libur', snippet:'Draf pengumuman libur akhir tahun…', date:'Sabtu', read:true, status:'Draft', attachments:0 },
    { id:6, from:'Support <cs@corp.id>', subject:'Tiket Close: Gangguan akses', snippet:'Tiket telah diselesaikan…', date:'Jumat', read:true, status:'Close', attachments:1 },
    { id:7, from:'Doni <doni@mail.com>', subject:'Salah sambung, mohon abaikan', snippet:'Email ini salah alamat…', date:'Kamis', read:false, status:'Salah Sambung', attachments:0 },
    { id:8, from:'Rina <rina@mail.com>', subject:'Re: Permintaan data', snippet:'Sudah kami reply dengan data terlampir…', date:'Rabu', read:true, status:'Sudah Di-reply', attachments:1 }
  ];
  const statusVariant = (v:string) => v==='Spam'?'destructive':v==='Terima Kasih'?'success':v==='Draft'?'warning':v==='Close'?'secondary':'outline' as const;
  let filtered = $derived(mails.filter(m => (folder==='Semua'||m.status===folder) && (!q || (m.subject+m.from).toLowerCase().includes(q.toLowerCase()))));
  let totalPages = $derived(Math.max(1, Math.ceil(filtered.length/perPage)));
  let paged = $derived(filtered.slice((page-1)*perPage, page*perPage));
  let detail = $derived(selected!=null ? mails.find(m=>m.id===selected) : null);

  function toggleCheck(id: number, v: boolean) {
    checked = v ? [...checked, id] : checked.filter((c) => c !== id);
  }

  function markRead() {
    for (const m of mails) if (checked.includes(m.id)) m.read = true;
    toast.success(s.markedReadT.replace('{n}', String(checked.length)));
    checked = [];
  }
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<Card.Root>
  <Card.Header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <div>
      <Card.Title class="flex items-center gap-2"><Inbox data-icon="inline-start" /> {s.inbox} <Badge variant="secondary">{filtered.length}</Badge></Card.Title>
      <Card.Description>{s.desc}</Card.Description>
    </div>
    <div class="flex shrink-0 gap-2">
      <Button size="sm" href="/email/compose">{s.compose}</Button>
      <Button size="sm" variant="outline" onclick={()=>composeOpen=true}>{s.quickCompose}</Button>
    </div>
  </Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root bind:value={folder}>
      <Tabs.List class="w-full justify-start overflow-x-auto">
        {#each folders as f}<Tabs.Trigger value={f} onclick={()=>{page=1;}}>{folderLabel(f)}</Tabs.Trigger>{/each}
      </Tabs.List>
    </Tabs.Root>

    <Field.FieldGroup class="grid gap-3 md:grid-cols-[1fr_auto_auto]">
      <Field.Field>
        <Field.Label for="email-q">{s.searchLabel}</Field.Label>
        <InputGroup.Root>
          <InputGroup.Addon><Search data-icon="true" /></InputGroup.Addon>
          <InputGroup.Input id="email-q" placeholder={s.searchPh} bind:value={q} />
        </InputGroup.Root>
      </Field.Field>
      <Field.Field>
        <Field.Label for="notif">{s.notifLabel}</Field.Label>
        <div class="flex items-center gap-2"><Switch id="notif" bind:checked={notify} /><span class="text-xs text-muted-foreground">{notify ? s.on : s.off}</span></div>
      </Field.Field>
      <Field.Field>
        <Field.Label>{s.actionLabel}</Field.Label>
        <div class="flex gap-2">
          <Button size="sm" variant="ghost" href="/email/send">{s.sent}</Button>
          <Button size="sm" variant="ghost" href="/email/history">{s.history}</Button>
          <Button size="sm" variant="ghost" href="/email/templates">{s.templates}</Button>
        </div>
      </Field.Field>
    </Field.FieldGroup>

    {#if checked.length > 0}
      <div class="flex flex-wrap items-center gap-2 rounded-lg bg-muted/50 px-3 py-2 text-sm">
        <span class="font-medium">{s.selectedT.replace('{n}', String(checked.length))}</span>
        <Separator orientation="vertical" class="h-5" />
        <Button size="sm" variant="ghost" onclick={markRead}><MailOpen data-icon="inline-start" />{s.markRead}</Button>
        <Button size="sm" variant="ghost" onclick={()=>{archiveOpen=true;}}><Archive data-icon="inline-start" />{s.archive}</Button>
        <Button size="sm" variant="ghost" onclick={()=>{toast.success(s.deletedT.replace('{n}', String(checked.length))); checked=[];}}><Trash2 data-icon="inline-start" />{s.delete}</Button>
      </div>
    {/if}

    <div class="overflow-hidden rounded-lg border">
      <div class="flex items-center gap-3 border-b bg-muted/40 px-4 py-2 text-xs text-muted-foreground">
        <Checkbox
          aria-label={s.selectAll}
          checked={paged.length > 0 && paged.every((m) => checked.includes(m.id))}
          onCheckedChange={(v) => { checked = v === true ? paged.map((m) => m.id) : []; }}
        />
        <span class="font-medium">{paged.length} {s.of} {filtered.length} {s.emails}</span>
        <span class="ms-auto hidden items-center gap-1.5 sm:flex">
          <span class="size-1.5 rounded-full bg-primary" aria-hidden="true"></span>{s.unreadDot}
        </span>
      </div>
      <div class="divide-y divide-border/70">
        {#each paged as m (m.id)}
          <div class={cn("group flex items-center gap-3 px-3 transition-colors hover:bg-muted/50", selected === m.id && "bg-muted/60")}>
            <span class="size-1.5 shrink-0 rounded-full {m.read ? 'bg-transparent' : 'bg-primary'}" aria-hidden="true"></span>
            <Checkbox aria-label={`${s.selectEmail} ${m.subject}`} checked={checked.includes(m.id)} onCheckedChange={(v)=>toggleCheck(m.id, v === true)} />
            <div class="min-w-0 flex-1 py-1">
              <EmailItem class="px-0 hover:bg-transparent" from={m.from} subject={m.subject} snippet={m.snippet} date={m.date} read={m.read} attachments={m.attachments} onClick={()=>selected=m.id} />
              <div class="flex flex-wrap gap-1 px-0 pb-2.5 ps-[3.25rem]">
                <Badge variant={statusVariant(m.status)}>{folderLabel(m.status)}</Badge>
                {#if m.ticket}<Badge variant="secondary">{m.ticket}</Badge>{/if}
                {#if m.agent}<Badge variant="outline">{m.agent}</Badge>{/if}
              </div>
            </div>
            <div class="flex shrink-0 gap-1 opacity-0 transition-opacity group-hover:opacity-100 group-focus-within:opacity-100">
              <Tooltip.Root>
                <Tooltip.Trigger>
                  {#snippet child({ props })}
                    <Button {...props} size="icon" variant="ghost" onclick={()=>{selected=m.id;}} aria-label={s.preview}><MailOpen data-icon="true" /></Button>
                  {/snippet}
                </Tooltip.Trigger>
                <Tooltip.Content>{s.preview}</Tooltip.Content>
              </Tooltip.Root>
              <Tooltip.Root>
                <Tooltip.Trigger>
                  {#snippet child({ props })}
                    <Button {...props} size="icon" variant="ghost" onclick={()=>{archiveOpen=true;}} aria-label={s.archiveEmail}><Archive data-icon="true" /></Button>
                  {/snippet}
                </Tooltip.Trigger>
                <Tooltip.Content>{s.archiveEmail}</Tooltip.Content>
              </Tooltip.Root>
            </div>
          </div>
        {:else}
          <Empty.Root class="py-10">
            <Empty.Header><Empty.Media><Inbox data-icon="empty" /></Empty.Media><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header>
          </Empty.Root>
        {/each}
      </div>
    </div>

    <Pagination.Root count={filtered.length} perPage={perPage} bind:page>
      {#snippet children({ pages, range })}
        <div class="flex items-center justify-between gap-2">
          <p class="text-xs text-muted-foreground">{range.start}-{range.end} {s.of} {filtered.length}</p>
          <div class="flex items-center gap-1">
            <Pagination.PrevButton><ChevronLeft data-icon="true" /></Pagination.PrevButton>
            {#each pages as p (p.key)}
              {#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>
              {:else}<span class="px-1 text-xs text-muted-foreground">…</span>{/if}
            {/each}
            <Pagination.NextButton><ChevronRight data-icon="true" /></Pagination.NextButton>
          </div>
        </div>
      {/snippet}
    </Pagination.Root>
  </Card.Content>
</Card.Root>

<Dialog.Root open={selected!=null} onOpenChange={(o)=>{if(!o)selected=null;}}>
  <Dialog.Content>
    <Dialog.Header>
      <Dialog.Title>{detail?.subject ?? s.detailFb}</Dialog.Title>
      <Dialog.Description>{detail?.from ?? s.previewFb}</Dialog.Description>
    </Dialog.Header>
    <p class="text-sm">{detail?.from}</p>
    <Textarea readonly value={detail?.snippet ?? ''} rows={4}/>
    <Dialog.Footer><Button size="sm" onclick={()=>{selected=null;toast.success(s.repliedToast);}}>{s.reply}</Button></Dialog.Footer>
  </Dialog.Content>
</Dialog.Root>

<AlertDialog.Root bind:open={archiveOpen}>
  <AlertDialog.Content>
    <AlertDialog.Header>
      <AlertDialog.Title>{s.archiveTitle}</AlertDialog.Title>
      <AlertDialog.Description>{s.archiveDesc}</AlertDialog.Description>
    </AlertDialog.Header>
    <AlertDialog.Footer>
      <AlertDialog.Cancel>{s.cancel}</AlertDialog.Cancel>
      <AlertDialog.Action onclick={()=>toast.success(s.archivedToast)}>{s.archiveBtn}</AlertDialog.Action>
    </AlertDialog.Footer>
  </AlertDialog.Content>
</AlertDialog.Root>

<EmailCompose bind:open={composeOpen} bind:to bind:subject bind:body onSend={()=>toast.success(s.sentToast)} />
