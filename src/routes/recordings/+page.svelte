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
  import { Textarea } from '$lib/components/ui/textarea';
  import { Checkbox } from '$lib/components/ui/checkbox';
  import * as RadioGroup from '$lib/components/ui/radio-group';
  import { Switch } from '$lib/components/ui/switch';
  import { toast, Toaster } from 'svelte-sonner';
  import { ChevronLeft, ChevronRight, Search, PhoneCall } from 'lucide-svelte';
  import DateRangePicker from '$lib/components/ui/date-range-picker.svelte';
  import type { DateRange } from 'bits-ui';
  import { locale } from '$lib/i18n';

  const STR = {
    id: {
      docTitle: 'Call Recordings — DK UI Kit',
      title: 'Call Recordings',
      desc: 'Kolom blade: Unique ID, Call Date, Disposition, Customer, Agent, Duration, Recording, STT, QA.',
      autoRefresh: 'Auto refresh',
      tabTable: 'Tabel',
      tabCompact: 'Ringkas',
      searchLabel: 'Cari Unique ID',
      searchPh: 'Search by Unique ID',
      periodLabel: 'Periode',
      periodPh: 'Pilih periode rekaman',
      dispLabel: 'Disposition',
      dispAll: 'Semua',
      optLegend: 'Opsi tampil',
      showStt: 'Tampilkan STT',
      showQa: 'Tampilkan QA',
      thId: 'Unique ID',
      thDate: 'Call Date',
      thDisp: 'Disposition',
      thCust: 'Customer',
      thAgent: 'Agent',
      thDur: 'Duration',
      thRec: 'Recording',
      thStt: 'STT',
      thQa: 'QA',
      sttBtn: 'STT',
      sttTip: 'Lihat transkrip',
      pushQa: 'Push QA',
      emptyTitle: 'Tidak ada rekaman',
      emptyDesc: 'Ubah filter pencarian.',
      qaNote: 'Catatan QA',
      qaNotePh: 'Catatan…',
      transcriptT: 'Transcript {id}',
      pushTitle: 'Push recording ke QA?',
      cancel: 'Batal',
      pushBtn: 'Push',
      pushedToast: 'Pushed',
      of: 'dari'
    },
    en: {
      docTitle: 'Call Recordings — DK UI Kit',
      title: 'Call Recordings',
      desc: 'Blade columns: Unique ID, Call Date, Disposition, Customer, Agent, Duration, Recording, STT, QA.',
      autoRefresh: 'Auto refresh',
      tabTable: 'Table',
      tabCompact: 'Compact',
      searchLabel: 'Search Unique ID',
      searchPh: 'Search by Unique ID',
      periodLabel: 'Period',
      periodPh: 'Pick recording period',
      dispLabel: 'Disposition',
      dispAll: 'All',
      optLegend: 'Display options',
      showStt: 'Show STT',
      showQa: 'Show QA',
      thId: 'Unique ID',
      thDate: 'Call Date',
      thDisp: 'Disposition',
      thCust: 'Customer',
      thAgent: 'Agent',
      thDur: 'Duration',
      thRec: 'Recording',
      thStt: 'STT',
      thQa: 'QA',
      sttBtn: 'STT',
      sttTip: 'View transcript',
      pushQa: 'Push QA',
      emptyTitle: 'No recordings',
      emptyDesc: 'Adjust your search filters.',
      qaNote: 'QA Notes',
      qaNotePh: 'Notes…',
      transcriptT: 'Transcript {id}',
      pushTitle: 'Push recording to QA?',
      cancel: 'Cancel',
      pushBtn: 'Push',
      pushedToast: 'Pushed',
      of: 'of'
    },
    th: {
      docTitle: 'บันทึกการโทร — DK UI Kit',
      title: 'บันทึกการโทร',
      desc: 'คอลัมน์ blade: รหัสเฉพาะ วันที่โทร การจัดการ ลูกค้า เจ้าหน้าที่ ระยะเวลา เสียงบันทึก STT QA',
      autoRefresh: 'รีเฟรชอัตโนมัติ',
      tabTable: 'ตาราง',
      tabCompact: 'แบบย่อ',
      searchLabel: 'ค้นหารหัสเฉพาะ',
      searchPh: 'ค้นหาด้วยรหัสเฉพาะ',
      periodLabel: 'ช่วงเวลา',
      periodPh: 'เลือกช่วงเวลาบันทึก',
      dispLabel: 'การจัดการสาย',
      dispAll: 'ทั้งหมด',
      optLegend: 'ตัวเลือกการแสดง',
      showStt: 'แสดง STT',
      showQa: 'แสดง QA',
      thId: 'รหัสเฉพาะ',
      thDate: 'วันที่โทร',
      thDisp: 'การจัดการ',
      thCust: 'ลูกค้า',
      thAgent: 'เจ้าหน้าที่',
      thDur: 'ระยะเวลา',
      thRec: 'เสียงบันทึก',
      thStt: 'STT',
      thQa: 'QA',
      sttBtn: 'STT',
      sttTip: 'ดูบทถอดเสียง',
      pushQa: 'ส่ง QA',
      emptyTitle: 'ไม่มีบันทึก',
      emptyDesc: 'ปรับตัวกรองการค้นหา',
      qaNote: 'บันทึก QA',
      qaNotePh: 'บันทึก…',
      transcriptT: 'บทถอดเสียง {id}',
      pushTitle: 'ส่งบันทึกไปยัง QA?',
      cancel: 'ยกเลิก',
      pushBtn: 'ส่ง',
      pushedToast: 'ส่งแล้ว',
      of: 'จาก'
    },
    tl: {
      docTitle: 'Mga Recording ng Tawag — DK UI Kit',
      title: 'Mga Recording ng Tawag',
      desc: 'Mga column ng blade: Unique ID, Petsa ng Tawag, Disposition, Customer, Agent, Tagal, Recording, STT, QA.',
      autoRefresh: 'Awtomatikong refresh',
      tabTable: 'Talahanayan',
      tabCompact: 'Maikli',
      searchLabel: 'Hanapin ang Unique ID',
      searchPh: 'Hanapin via Unique ID',
      periodLabel: 'Panahon',
      periodPh: 'Piliin ang panahon ng recording',
      dispLabel: 'Disposition',
      dispAll: 'Lahat',
      optLegend: 'Mga opsyon sa display',
      showStt: 'Ipakita ang STT',
      showQa: 'Ipakita ang QA',
      thId: 'Unique ID',
      thDate: 'Petsa ng Tawag',
      thDisp: 'Disposition',
      thCust: 'Customer',
      thAgent: 'Agent',
      thDur: 'Tagal',
      thRec: 'Recording',
      thStt: 'STT',
      thQa: 'QA',
      sttBtn: 'STT',
      sttTip: 'Tingnan ang transcript',
      pushQa: 'I-push sa QA',
      emptyTitle: 'Walang recording',
      emptyDesc: 'Baguhin ang mga filter sa paghahanap.',
      qaNote: 'Tala ng QA',
      qaNotePh: 'Tala…',
      transcriptT: 'Transcript {id}',
      pushTitle: 'I-push ang recording sa QA?',
      cancel: 'Kanselahin',
      pushBtn: 'I-push',
      pushedToast: 'Na-push na',
      of: 'mula sa'
    }
  } as const;
  let s = $derived(STR[$locale]);

  let q=$state(''); let range=$state<DateRange|undefined>(undefined); let disp=$state('all'); let page=$state(1); const perPage=4;
  let tr:any=$state(null); let push=$state(false); let auto=$state(true); let view=$state('table');
  const rows=[
    {id:'REC-001',date:'2026-09-28',disp:'ANSWERED',cust:'0812xxxx001',agent:'Rina',dur:'03:12',stt:'Ada'},
    {id:'REC-002',date:'2026-09-28',disp:'NO ANSWER',cust:'0812xxxx002',agent:'Budi',dur:'00:00',stt:'-'},
    {id:'REC-003',date:'2026-09-27',disp:'ANSWERED',cust:'0812xxxx003',agent:'Sari',dur:'05:44',stt:'Ada'},
    {id:'REC-004',date:'2026-09-27',disp:'BUSY',cust:'0812xxxx004',agent:'Doni',dur:'00:30',stt:'-'},
    {id:'REC-005',date:'2026-09-26',disp:'ANSWERED',cust:'0812xxxx005',agent:'Rina',dur:'02:10',stt:'Ada'}
  ];
  let f=$derived(rows.filter(r=>(disp==='all'||r.disp===disp)&&(!q||r.id.toLowerCase().includes(q.toLowerCase()))));
  let paged=$derived(view==='table'?f.slice((page-1)*perPage,page*perPage):f);
  const dv=(d:string)=>d==='ANSWERED'?'success':d==='NO ANSWER'?'warning':'secondary' as const;
</script>
<svelte:head><title>{s.docTitle}</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between"><div><Card.Title class="flex items-center gap-2"><PhoneCall size={18}/> {s.title} <Badge variant="secondary">{f.length}</Badge></Card.Title><Card.Description>{s.desc}</Card.Description></div><div class="flex items-center gap-2 text-sm">{s.autoRefresh} <Switch bind:checked={auto}/></div></Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root bind:value={view}><Tabs.List><Tabs.Trigger value="table">{s.tabTable}</Tabs.Trigger><Tabs.Trigger value="list">{s.tabCompact}</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-3 md:items-end">
      <Field.Field><Field.Label>{s.searchLabel}</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder={s.searchPh}/></InputGroup.Root></Field.Field>
      <Field.Field class="md:col-span-1"><Field.Label>{s.periodLabel}</Field.Label><DateRangePicker bind:value={range} label={s.periodPh}/></Field.Field>
      <Field.Field><Field.Label>{s.dispLabel}</Field.Label><Select.Root type="single" bind:value={disp}><Select.Trigger>{disp==='all'?s.dispAll:disp}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.dispLabel}</Select.GroupHeading><Select.Item value="all" label={s.dispAll}/><Select.Item value="ANSWERED" label="ANSWERED"/><Select.Item value="NO ANSWER" label="NO ANSWER"/><Select.Item value="BUSY" label="BUSY"/></Select.Group></Select.Content></Select.Root></Field.Field>
    </Field.FieldGroup>
    <Field.Set class="rounded-lg border p-3"><Field.Legend>{s.optLegend}</Field.Legend><div class="flex gap-4"><label class="flex items-center gap-2 text-sm"><Checkbox checked/> {s.showStt}</label><label class="flex items-center gap-2 text-sm"><Checkbox checked/> {s.showQa}</label></div><RadioGroup.Root bind:value={view} class="mt-2 flex gap-4"><div class="flex items-center gap-2"><RadioGroup.Item value="table" id="v1"/><label for="v1" class="text-sm">{s.tabTable}</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="list" id="v2"/><label for="v2" class="text-sm">{s.tabCompact}</label></div></RadioGroup.Root></Field.Set>
    {#if paged.length}
    <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>{s.thId}</Table.Head><Table.Head>{s.thDate}</Table.Head><Table.Head>{s.thDisp}</Table.Head><Table.Head>{s.thCust}</Table.Head><Table.Head>{s.thAgent}</Table.Head><Table.Head>{s.thDur}</Table.Head><Table.Head>{s.thRec}</Table.Head><Table.Head>{s.thStt}</Table.Head><Table.Head class="text-right">{s.thQa}</Table.Head></Table.Row></Table.Header>
    <Table.Body>{#each paged as r}<Table.Row><Table.Cell class="font-mono">{r.id}</Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell><Badge variant={dv(r.disp)}>{r.disp}</Badge></Table.Cell><Table.Cell>{r.cust}</Table.Cell><Table.Cell>{r.agent}</Table.Cell><Table.Cell>{r.dur}</Table.Cell><Table.Cell><audio controls class="h-8 w-44"><source src="" type="audio/wav"/></audio></Table.Cell><Table.Cell><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>{tr=r;}}>{s.sttBtn}</Button></Tooltip.Trigger><Tooltip.Content><p>{s.sttTip}</p></Tooltip.Content></Tooltip.Root></Table.Cell><Table.Cell class="text-right"><Button size="sm" variant="ghost" onclick={()=>{tr=r;push=true;}}>{s.pushQa}</Button></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    {:else}<Empty.Root class="py-10"><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>{/if}
    <Pagination.Root count={f.length} perPage={perPage} bind:page>{#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} {s.of} {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}</Pagination.Root>
    <Field.Field><Field.Label>{s.qaNote}</Field.Label><Textarea rows={2} placeholder={s.qaNotePh}/></Field.Field>
  </Card.Content>
</Card.Root>
<Dialog.Root open={tr!=null&&!push} onOpenChange={(o)=>{if(!o)tr=null;}}><Dialog.Content><Dialog.Header><Dialog.Title>{s.transcriptT.replace('{id}', tr?.id ?? '')}</Dialog.Title></Dialog.Header><Textarea readonly value="Transcript & summary…" rows={5}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root bind:open={push}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>{s.pushTitle}</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>{s.cancel}</AlertDialog.Cancel><AlertDialog.Action onclick={()=>{push=false;tr=null;toast.success(s.pushedToast);}}>{s.pushBtn}</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
