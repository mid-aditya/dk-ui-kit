<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import * as Table from '$lib/components/ui/table';
  import * as Pagination from '$lib/components/ui/pagination';
  import * as Dialog from '$lib/components/ui/dialog';
  import * as AlertDialog from '$lib/components/ui/alert-dialog';
  import * as Field from '$lib/components/ui/field';
  import * as InputGroup from '$lib/components/ui/input-group';
  import * as Tabs from '$lib/components/ui/tabs';
  import * as Tooltip from '$lib/components/ui/tooltip';
  import * as Empty from '$lib/components/ui/empty';
  import * as Attachment from '$lib/components/ui/attachment';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Textarea } from '$lib/components/ui/textarea';
  import { Switch } from '$lib/components/ui/switch';
  import { toast, Toaster } from 'svelte-sonner';
  import EmailItem from '$lib/components/ui/email-item.svelte';
  import { ChevronLeft, ChevronRight, Search, Send } from 'lucide-svelte';
  import { locale } from '$lib/i18n';

  const STR = {
    id: {
      docTitle: 'Email Terkirim — DK UI Kit',
      title: 'Email Terkirim',
      desc: 'Kolom blade: From, To, Subject, Date, attachment, aksi view/download.',
      compose: 'Compose',
      inbox: 'Inbox',
      tabAll: 'Semua',
      tabWeek: 'Minggu ini',
      searchLabel: 'Cari email terkirim',
      searchPh: 'Search sent emails…',
      autoArchive: 'Arsipkan otomatis',
      emptyTitle: 'Belum ada email terkirim',
      emptyDesc: 'Mulai kirim email.',
      thFrom: 'From',
      thTo: 'To',
      thSubject: 'Subject',
      thDate: 'Date',
      thAction: 'Aksi',
      view: 'View',
      viewTip: 'Lihat detail',
      delete: 'Hapus',
      delTitle: 'Hapus email terkirim?',
      cancel: 'Batal',
      delBtn: 'Hapus',
      deletedToast: 'Dihapus',
      of: 'dari',
      toPrefix: 'ke: ',
      toLabel: 'Kepada'
    },
    en: {
      docTitle: 'Sent Email — DK UI Kit',
      title: 'Sent Email',
      desc: 'Blade columns: From, To, Subject, Date, attachment, view/download actions.',
      compose: 'Compose',
      inbox: 'Inbox',
      tabAll: 'All',
      tabWeek: 'This week',
      searchLabel: 'Search sent emails',
      searchPh: 'Search sent emails…',
      autoArchive: 'Auto archive',
      emptyTitle: 'No sent emails yet',
      emptyDesc: 'Start sending emails.',
      thFrom: 'From',
      thTo: 'To',
      thSubject: 'Subject',
      thDate: 'Date',
      thAction: 'Actions',
      view: 'View',
      viewTip: 'View details',
      delete: 'Delete',
      delTitle: 'Delete sent email?',
      cancel: 'Cancel',
      delBtn: 'Delete',
      deletedToast: 'Deleted',
      of: 'of',
      toPrefix: 'to: ',
      toLabel: 'To'
    },
    th: {
      docTitle: 'อีเมลที่ส่งแล้ว — DK UI Kit',
      title: 'อีเมลที่ส่งแล้ว',
      desc: 'คอลัมน์ blade: จาก ถึง หัวข้อ วันที่ ไฟล์แนบ การดู/ดาวน์โหลด',
      compose: 'เขียนอีเมล',
      inbox: 'กล่องจดหมาย',
      tabAll: 'ทั้งหมด',
      tabWeek: 'สัปดาห์นี้',
      searchLabel: 'ค้นหาอีเมลที่ส่งแล้ว',
      searchPh: 'ค้นหาอีเมลที่ส่งแล้ว…',
      autoArchive: 'เก็บถาวรอัตโนมัติ',
      emptyTitle: 'ยังไม่มีอีเมลที่ส่งแล้ว',
      emptyDesc: 'เริ่มส่งอีเมล',
      thFrom: 'จาก',
      thTo: 'ถึง',
      thSubject: 'หัวข้อ',
      thDate: 'วันที่',
      thAction: 'การดำเนินการ',
      view: 'ดู',
      viewTip: 'ดูรายละเอียด',
      delete: 'ลบ',
      delTitle: 'ลบอีเมลที่ส่งแล้ว?',
      cancel: 'ยกเลิก',
      delBtn: 'ลบ',
      deletedToast: 'ลบแล้ว',
      of: 'จาก',
      toPrefix: 'ถึง: ',
      toLabel: 'ถึง'
    },
    tl: {
      docTitle: 'Naipadalang Email — DK UI Kit',
      title: 'Naipadalang Email',
      desc: 'Mga column ng blade: From, To, Subject, Date, attachment, view/download na aksyon.',
      compose: 'Sumulat',
      inbox: 'Inbox',
      tabAll: 'Lahat',
      tabWeek: 'Ngayong linggo',
      searchLabel: 'Hanapin ang naipadalang email',
      searchPh: 'Hanapin ang naipadalang email…',
      autoArchive: 'Awtomatikong i-archive',
      emptyTitle: 'Wala pang naipadalang email',
      emptyDesc: 'Magsimulang magpadala ng email.',
      thFrom: 'From',
      thTo: 'To',
      thSubject: 'Subject',
      thDate: 'Date',
      thAction: 'Mga Aksyon',
      view: 'Tingnan',
      viewTip: 'Tingnan ang detalye',
      delete: 'Burahin',
      delTitle: 'Burahin ang naipadalang email?',
      cancel: 'Kanselahin',
      delBtn: 'Burahin',
      deletedToast: 'Nabura na',
      of: 'mula sa',
      toPrefix: 'para sa: ',
      toLabel: 'Para sa'
    }
  } as const;
  let s = $derived(STR[$locale]);

  let q=$state(''); let page=$state(1); const perPage=4; let open=$state(false); let del=$state(false);
  let cur:any=$state(null); let words=$state(true);
  const rows=[
    {id:1,from:'cs@corp.id',to:'budi@mail.com',subject:'Re: Reset password',date:'10:00',att:1,body:'Password berhasil direset.'},
    {id:2,from:'cs@corp.id',to:'sari@corp.id',subject:'Invoice September',date:'Kemarin',att:2,body:'Terlampir invoice.'},
    {id:3,from:'cs@corp.id',to:'andi@mail.com',subject:'Terima kasih',date:'Senin',att:0,body:'Terima kasih.'},
    {id:4,from:'cs@corp.id',to:'doni@mail.com',subject:'Data permintaan',date:'Jumat',att:1,body:'Berikut data.'},
    {id:5,from:'cs@corp.id',to:'hrd@corp.id',subject:'Pengumuman',date:'Kamis',att:0,body:'Pengumuman libur.'}
  ];
  let f=$derived(rows.filter(r=>!q||(r.subject+r.to).toLowerCase().includes(q.toLowerCase())));
  let paged=$derived(f.slice((page-1)*perPage,page*perPage));
</script>
<svelte:head><title>{s.docTitle}</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
    <div><Card.Title class="flex items-center gap-2"><Send size={18}/> {s.title} <Badge>{f.length}</Badge></Card.Title><Card.Description>{s.desc}</Card.Description></div>
    <div class="flex gap-2"><Button size="sm" href="/email/compose">{s.compose}</Button><Button size="sm" variant="outline" href="/email">{s.inbox}</Button></div>
  </Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">{s.tabAll}</Tabs.Trigger><Tabs.Trigger value="week">{s.tabWeek}</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-[1fr_auto]">
      <Field.Field><Field.Label>{s.searchLabel}</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder={s.searchPh}/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>{s.autoArchive}</Field.Label><div class="pt-2"><Switch bind:checked={words}/></div></Field.Field>
    </Field.FieldGroup>
    <div class="divide-y divide-border rounded-lg border">
      {#each paged as r}<EmailItem from={r.to} subject={r.subject} snippet={s.toPrefix+r.to+' • '+r.body} date={r.date} read attachments={r.att} onClick={()=>{cur=r;open=true;}}/>
      {:else}<Empty.Root class="py-8"><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>{/each}
    </div>
    <Card.Root><Card.Content class="p-0">
      <Table.Root><Table.Header><Table.Row><Table.Head>{s.thFrom}</Table.Head><Table.Head>{s.thTo}</Table.Head><Table.Head>{s.thSubject}</Table.Head><Table.Head>{s.thDate}</Table.Head><Table.Head class="text-right">{s.thAction}</Table.Head></Table.Row></Table.Header>
      <Table.Body>{#each paged as r}<Table.Row><Table.Cell>{r.from}</Table.Cell><Table.Cell>{r.to}</Table.Cell><Table.Cell class="font-medium">{r.subject}</Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>{cur=r;open=true;}}>{s.view}</Button></Tooltip.Trigger><Tooltip.Content><p>{s.viewTip}</p></Tooltip.Content></Tooltip.Root> <Button size="sm" variant="ghost" onclick={()=>{cur=r;del=true;}}>{s.delete}</Button></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
    </Card.Content></Card.Root>
    <Pagination.Root count={f.length} perPage={perPage} bind:page>
      {#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} {s.of} {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}
    </Pagination.Root>
    <Attachment.Group class="grid gap-2 sm:grid-cols-2"><Attachment.Root><Attachment.Title>invoice.pdf</Attachment.Title><Attachment.Description>300 KB</Attachment.Description></Attachment.Root></Attachment.Group>
  </Card.Content>
</Card.Root>
<Dialog.Root bind:open><Dialog.Content><Dialog.Header><Dialog.Title>{cur?.subject}</Dialog.Title></Dialog.Header><p class="text-sm">{s.toLabel}: {cur?.to}</p><Textarea readonly value={cur?.body??''} rows={4}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root bind:open={del}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>{s.delTitle}</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>{s.cancel}</AlertDialog.Cancel><AlertDialog.Action onclick={()=>toast.success(s.deletedToast)}>{s.delBtn}</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
