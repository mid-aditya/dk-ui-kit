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
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Checkbox } from '$lib/components/ui/checkbox';
  import * as RadioGroup from '$lib/components/ui/radio-group';
  import { Switch } from '$lib/components/ui/switch';
  import { Textarea } from '$lib/components/ui/textarea';
  import { toast, Toaster } from 'svelte-sonner';
  import { ChevronLeft, ChevronRight, Search, History } from 'lucide-svelte';
  import { locale } from '$lib/i18n';

  const STR = {
    id: {
      docTitle: 'Email History — DK UI Kit',
      title: 'Email History',
      desc: 'Kolom blade: From, To, Subject, Status, Date, Actions.',
      tabAll: 'Semua',
      tabSent: 'Sent',
      tabDraft: 'Draft',
      searchLabel: 'Cari history',
      searchPh: 'Search email history…',
      rangeLabel: 'Rentang',
      range7: '7 hari',
      range30: '30 hari',
      rangeGroup: 'Rentang',
      exportBtn: 'Export',
      exportTip: 'Export CSV/Excel/PDF',
      inbox: 'Inbox',
      filterLegend: 'Filter status',
      allLabel: 'Semua',
      sentLabel: 'Sent',
      draftLabel: 'Draft',
      includeAtt: 'Sertakan attachment',
      notifLabel: 'Notifikasi',
      thFrom: 'From',
      thTo: 'To',
      thSubject: 'Subject',
      thStatus: 'Status',
      thDate: 'Date',
      thAction: 'Actions',
      attT: '{n} lampiran',
      view: 'View',
      emptyTitle: 'Tidak ada history',
      emptyDesc: 'Mulai kirim email.',
      noteLabel: 'Catatan',
      notePh: 'Catatan history…',
      cancel: 'Batal',
      exportTitle: 'Export ({fmt})?',
      exportBtn2: 'Export',
      exportedToast: 'Diexport',
      of: 'dari'
    },
    en: {
      docTitle: 'Email History — DK UI Kit',
      title: 'Email History',
      desc: 'Blade columns: From, To, Subject, Status, Date, Actions.',
      tabAll: 'All',
      tabSent: 'Sent',
      tabDraft: 'Draft',
      searchLabel: 'Search history',
      searchPh: 'Search email history…',
      rangeLabel: 'Range',
      range7: '7 days',
      range30: '30 days',
      rangeGroup: 'Range',
      exportBtn: 'Export',
      exportTip: 'Export CSV/Excel/PDF',
      inbox: 'Inbox',
      filterLegend: 'Status filter',
      allLabel: 'All',
      sentLabel: 'Sent',
      draftLabel: 'Draft',
      includeAtt: 'Include attachments',
      notifLabel: 'Notifications',
      thFrom: 'From',
      thTo: 'To',
      thSubject: 'Subject',
      thStatus: 'Status',
      thDate: 'Date',
      thAction: 'Actions',
      attT: '{n} attachments',
      view: 'View',
      emptyTitle: 'No history',
      emptyDesc: 'Start sending emails.',
      noteLabel: 'Notes',
      notePh: 'History notes…',
      cancel: 'Cancel',
      exportTitle: 'Export ({fmt})?',
      exportBtn2: 'Export',
      exportedToast: 'Exported',
      of: 'of'
    },
    th: {
      docTitle: 'ประวัติอีเมล — DK UI Kit',
      title: 'ประวัติอีเมล',
      desc: 'คอลัมน์ blade: จาก ถึง หัวข้อ สถานะ วันที่ การดำเนินการ',
      tabAll: 'ทั้งหมด',
      tabSent: 'ส่งแล้ว',
      tabDraft: 'ร่าง',
      searchLabel: 'ค้นหาประวัติ',
      searchPh: 'ค้นหาประวัติอีเมล…',
      rangeLabel: 'ช่วง',
      range7: '7 วัน',
      range30: '30 วัน',
      rangeGroup: 'ช่วง',
      exportBtn: 'ส่งออก',
      exportTip: 'ส่งออก CSV/Excel/PDF',
      inbox: 'กล่องจดหมาย',
      filterLegend: 'กรองตามสถานะ',
      allLabel: 'ทั้งหมด',
      sentLabel: 'ส่งแล้ว',
      draftLabel: 'ร่าง',
      includeAtt: 'รวมไฟล์แนบ',
      notifLabel: 'การแจ้งเตือน',
      thFrom: 'จาก',
      thTo: 'ถึง',
      thSubject: 'หัวข้อ',
      thStatus: 'สถานะ',
      thDate: 'วันที่',
      thAction: 'การดำเนินการ',
      attT: '{n} ไฟล์แนบ',
      view: 'ดู',
      emptyTitle: 'ไม่มีประวัติ',
      emptyDesc: 'เริ่มส่งอีเมล',
      noteLabel: 'บันทึก',
      notePh: 'บันทึกประวัติ…',
      cancel: 'ยกเลิก',
      exportTitle: 'ส่งออก ({fmt})?',
      exportBtn2: 'ส่งออก',
      exportedToast: 'ส่งออกแล้ว',
      of: 'จาก'
    },
    tl: {
      docTitle: 'History ng Email — DK UI Kit',
      title: 'History ng Email',
      desc: 'Mga column ng blade: From, To, Subject, Status, Date, Actions.',
      tabAll: 'Lahat',
      tabSent: 'Naipadala',
      tabDraft: 'Draft',
      searchLabel: 'Hanapin sa history',
      searchPh: 'Hanapin sa history ng email…',
      rangeLabel: 'Saklaw',
      range7: '7 araw',
      range30: '30 araw',
      rangeGroup: 'Saklaw',
      exportBtn: 'I-export',
      exportTip: 'I-export CSV/Excel/PDF',
      inbox: 'Inbox',
      filterLegend: 'Filter ng katayuan',
      allLabel: 'Lahat',
      sentLabel: 'Naipadala',
      draftLabel: 'Draft',
      includeAtt: 'Isama ang attachment',
      notifLabel: 'Mga notipikasyon',
      thFrom: 'From',
      thTo: 'To',
      thSubject: 'Subject',
      thStatus: 'Status',
      thDate: 'Date',
      thAction: 'Actions',
      attT: '{n} attachment',
      view: 'Tingnan',
      emptyTitle: 'Walang history',
      emptyDesc: 'Magsimulang magpadala ng email.',
      noteLabel: 'Tala',
      notePh: 'Tala ng history…',
      cancel: 'Kanselahin',
      exportTitle: 'I-export ({fmt})?',
      exportBtn2: 'I-export',
      exportedToast: 'Na-export na',
      of: 'mula sa'
    }
  } as const;
  let s = $derived(STR[$locale]);

  /** Label tampilan untuk value status yang stabil (value filter tidak diubah). */
  function statusLabel(v: string): string {
    if (v === 'Sent') return s.sentLabel;
    if (v === 'Draft') return s.draftLabel;
    return v;
  }

  let q=$state(''); let status=$state('all'); let range=$state('30'); let page=$state(1); const perPage=4;
  let open=$state(false); let exp=$state(false); let cur:any=$state(null); let fmt=$state('csv'); let inc=$state(true);
  const rows=[
    {id:1,from:'Budi <budi@mail.com>',to:'cs@corp.id',subject:'Reset password',status:'Sent',date:'09:00',preview:'Mohon reset…',att:1},
    {id:2,from:'Sari <sari@corp.id>',to:'cs@corp.id',subject:'Invoice',status:'Draft',date:'Kemarin',preview:'Draf invoice…',att:0},
    {id:3,from:'Andi <andi@mail.com>',to:'cs@corp.id',subject:'Terima kasih',status:'Sent',date:'Senin',preview:'Terima kasih…',att:0},
    {id:4,from:'Doni <doni@mail.com>',to:'cs@corp.id',subject:'Tanya produk',status:'Sent',date:'Jumat',preview:'Info produk…',att:2},
    {id:5,from:'Rina <rina@mail.com>',to:'cs@corp.id',subject:'Data',status:'Draft',date:'Kamis',preview:'Draf data…',att:0}
  ];
  let f=$derived(rows.filter(r=>(status==='all'||r.status.toLowerCase()===status)&&(!q||(r.subject+r.from).toLowerCase().includes(q.toLowerCase()))));
  let paged=$derived(f.slice((page-1)*perPage,page*perPage));
</script>
<svelte:head><title>{s.docTitle}</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header><Card.Title class="flex items-center gap-2"><History size={18}/> {s.title} <Badge variant="secondary">{f.length}</Badge></Card.Title><Card.Description>{s.desc}</Card.Description></Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root value={status} onValueChange={(v)=>{status=String(v);page=1;}}><Tabs.List><Tabs.Trigger value="all">{s.tabAll}</Tabs.Trigger><Tabs.Trigger value="sent">{s.tabSent}</Tabs.Trigger><Tabs.Trigger value="draft">{s.tabDraft}</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-4 md:items-end">
      <Field.Field class="md:col-span-2"><Field.Label>{s.searchLabel}</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder={s.searchPh}/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>{s.rangeLabel}</Field.Label><Select.Root type="single" bind:value={range}><Select.Trigger>{range==='7'?s.range7:s.range30}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.rangeGroup}</Select.GroupHeading><Select.Item value="7" label={s.range7}/><Select.Item value="30" label={s.range30}/></Select.Group></Select.Content></Select.Root></Field.Field>
      <div class="flex gap-2"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>exp=true}>{s.exportBtn}</Button></Tooltip.Trigger><Tooltip.Content><p>{s.exportTip}</p></Tooltip.Content></Tooltip.Root><Button size="sm" variant="ghost" href="/email">{s.inbox}</Button></div>
    </Field.FieldGroup>
    <Field.Set class="rounded-lg border p-3"><Field.Legend>{s.filterLegend}</Field.Legend><RadioGroup.Root bind:value={status} class="flex gap-4"><div class="flex items-center gap-2"><RadioGroup.Item value="all" id="h1"/><label for="h1" class="text-sm">{s.allLabel}</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="sent" id="h2"/><label for="h2" class="text-sm">{s.sentLabel}</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="draft" id="h3"/><label for="h3" class="text-sm">{s.draftLabel}</label></div></RadioGroup.Root><label class="mt-2 flex items-center gap-2 text-sm"><Checkbox bind:checked={inc}/> {s.includeAtt}</label><div class="mt-2 flex items-center gap-2 text-sm">{s.notifLabel} <Switch/></div></Field.Set>
    <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>{s.thFrom}</Table.Head><Table.Head>{s.thTo}</Table.Head><Table.Head>{s.thSubject}</Table.Head><Table.Head>{s.thStatus}</Table.Head><Table.Head>{s.thDate}</Table.Head><Table.Head class="text-right">{s.thAction}</Table.Head></Table.Row></Table.Header>
    <Table.Body>{#each paged as r}<Table.Row><Table.Cell>{r.from}</Table.Cell><Table.Cell class="max-w-40 truncate">{r.to}</Table.Cell><Table.Cell><div class="font-medium">{r.subject}</div><div class="text-xs text-muted-foreground">{r.preview}{#if r.att} • {s.attT.replace('{n}', String(r.att))}{/if}</div></Table.Cell><Table.Cell><Badge variant={r.status==='Sent'?'success':'warning'}>{statusLabel(r.status)}</Badge></Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell class="text-right"><Button size="sm" variant="outline" onclick={()=>{cur=r;open=true;}}>{s.view}</Button></Table.Cell></Table.Row>{:else}<Table.Row><Table.Cell colspan={6}><Empty.Root class="py-8"><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    <Pagination.Root count={f.length} perPage={perPage} bind:page>{#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} {s.of} {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}</Pagination.Root>
    <Field.Field><Field.Label>{s.noteLabel}</Field.Label><Textarea placeholder={s.notePh} rows={2}/></Field.Field>
  </Card.Content>
</Card.Root>
<Dialog.Root bind:open><Dialog.Content><Dialog.Header><Dialog.Title>{cur?.subject}</Dialog.Title></Dialog.Header><Textarea readonly value={cur?.preview??''} rows={3}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root bind:open={exp}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>{s.exportTitle.replace('{fmt}', fmt)}</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>{s.cancel}</AlertDialog.Cancel><AlertDialog.Action onclick={()=>toast.success(s.exportedToast)}>{s.exportBtn2}</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
