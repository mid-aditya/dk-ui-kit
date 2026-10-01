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
  import { Textarea } from '$lib/components/ui/textarea';
  import { Checkbox } from '$lib/components/ui/checkbox';
  import * as RadioGroup from '$lib/components/ui/radio-group';
  import { Switch } from '$lib/components/ui/switch';
  import { toast, Toaster } from 'svelte-sonner';
  import { ChevronLeft, ChevronRight, Search, Server } from 'lucide-svelte';
  import DateRangePicker from '$lib/components/ui/date-range-picker.svelte';
  import type { DateRange } from 'bits-ui';
  import { locale } from '$lib/i18n';

  const STR = {
    id: {
      docTitle: 'Recording Archive — DK UI Kit',
      title: 'Recording Archive',
      desc: 'Kolom blade: File Name/ID, Call Date, Path, Size, Recording, Actions. Cari via phone/recording ID + range tanggal.',
      audioOnly: 'Hanya ada audio',
      tabAll: 'Semua',
      tabAudio: 'Ada audio',
      searchLabel: 'Search Files',
      searchPh: 'phone / recording ID',
      periodLabel: 'Periode',
      periodPh: 'Pilih periode arsip',
      srcLabel: 'Sumber',
      srcGroup: 'Sumber NAS',
      srcAll: 'Semua',
      scopeLegend: 'Cakupan',
      scopeAll: 'Semua',
      scopeAudio: 'Ada audio',
      hideNoAudio: 'Sembunyikan tanpa audio',
      thFile: 'File Name/ID',
      thDate: 'Call Date',
      thPath: 'Path',
      thSize: 'Size',
      thRec: 'Recording',
      thAction: 'Actions',
      download: 'Download',
      downloadTip: 'Unduh file',
      emptyTitle: 'Tidak ada data NAS',
      emptyDesc: 'Ubah kriteria pencarian.',
      noteLabel: 'Catatan arsip',
      notePh: 'Catatan…',
      dlTitle: 'Download {id}?',
      cancel: 'Batal',
      dlBtn: 'Download',
      downloadedToast: 'Diunduh',
      infoTitle: 'Info',
      of: 'dari'
    },
    en: {
      docTitle: 'Recording Archive — DK UI Kit',
      title: 'Recording Archive',
      desc: 'Blade columns: File Name/ID, Call Date, Path, Size, Recording, Actions. Search via phone/recording ID + date range.',
      audioOnly: 'Audio only',
      tabAll: 'All',
      tabAudio: 'Has audio',
      searchLabel: 'Search Files',
      searchPh: 'phone / recording ID',
      periodLabel: 'Period',
      periodPh: 'Pick archive period',
      srcLabel: 'Source',
      srcGroup: 'NAS Source',
      srcAll: 'All',
      scopeLegend: 'Scope',
      scopeAll: 'All',
      scopeAudio: 'Has audio',
      hideNoAudio: 'Hide entries without audio',
      thFile: 'File Name/ID',
      thDate: 'Call Date',
      thPath: 'Path',
      thSize: 'Size',
      thRec: 'Recording',
      thAction: 'Actions',
      download: 'Download',
      downloadTip: 'Download file',
      emptyTitle: 'No NAS data',
      emptyDesc: 'Adjust your search criteria.',
      noteLabel: 'Archive notes',
      notePh: 'Notes…',
      dlTitle: 'Download {id}?',
      cancel: 'Cancel',
      dlBtn: 'Download',
      downloadedToast: 'Downloaded',
      infoTitle: 'Info',
      of: 'of'
    },
    th: {
      docTitle: 'คลังบันทึกเสียง — DK UI Kit',
      title: 'คลังบันทึกเสียง',
      desc: 'คอลัมน์ blade: ชื่อไฟล์/รหัส วันที่โทร เส้นทาง ขนาด เสียงบันทึก การดำเนินการ ค้นหาด้วยเบอร์โทร/รหัส + ช่วงวันที่',
      audioOnly: 'เฉพาะที่มีเสียง',
      tabAll: 'ทั้งหมด',
      tabAudio: 'มีเสียง',
      searchLabel: 'ค้นหาไฟล์',
      searchPh: 'เบอร์โทร / รหัสบันทึก',
      periodLabel: 'ช่วงเวลา',
      periodPh: 'เลือกช่วงเวลาคลัง',
      srcLabel: 'แหล่งที่มา',
      srcGroup: 'แหล่ง NAS',
      srcAll: 'ทั้งหมด',
      scopeLegend: 'ขอบเขต',
      scopeAll: 'ทั้งหมด',
      scopeAudio: 'มีเสียง',
      hideNoAudio: 'ซ่อนรายการที่ไม่มีเสียง',
      thFile: 'ชื่อไฟล์/รหัส',
      thDate: 'วันที่โทร',
      thPath: 'เส้นทาง',
      thSize: 'ขนาด',
      thRec: 'เสียงบันทึก',
      thAction: 'การดำเนินการ',
      download: 'ดาวน์โหลด',
      downloadTip: 'ดาวน์โหลดไฟล์',
      emptyTitle: 'ไม่มีข้อมูล NAS',
      emptyDesc: 'ปรับเกณฑ์การค้นหา',
      noteLabel: 'บันทึกคลัง',
      notePh: 'บันทึก…',
      dlTitle: 'ดาวน์โหลด {id}?',
      cancel: 'ยกเลิก',
      dlBtn: 'ดาวน์โหลด',
      downloadedToast: 'ดาวน์โหลดแล้ว',
      infoTitle: 'ข้อมูล',
      of: 'จาก'
    },
    tl: {
      docTitle: 'Archive ng Recording — DK UI Kit',
      title: 'Archive ng Recording',
      desc: 'Mga column ng blade: File Name/ID, Petsa ng Tawag, Path, Size, Recording, Mga Aksyon. Maghanap via phone/recording ID + saklaw ng petsa.',
      audioOnly: 'May audio lamang',
      tabAll: 'Lahat',
      tabAudio: 'May audio',
      searchLabel: 'Maghanap ng Files',
      searchPh: 'phone / recording ID',
      periodLabel: 'Panahon',
      periodPh: 'Piliin ang panahon ng archive',
      srcLabel: 'Pinagmulan',
      srcGroup: 'Pinagmulang NAS',
      srcAll: 'Lahat',
      scopeLegend: 'Saklaw',
      scopeAll: 'Lahat',
      scopeAudio: 'May audio',
      hideNoAudio: 'Itago ang walang audio',
      thFile: 'File Name/ID',
      thDate: 'Petsa ng Tawag',
      thPath: 'Path',
      thSize: 'Size',
      thRec: 'Recording',
      thAction: 'Mga Aksyon',
      download: 'I-download',
      downloadTip: 'I-download ang file',
      emptyTitle: 'Walang datos ng NAS',
      emptyDesc: 'Baguhin ang pamantayan sa paghahanap.',
      noteLabel: 'Tala ng archive',
      notePh: 'Tala…',
      dlTitle: 'I-download ang {id}?',
      cancel: 'Kanselahin',
      dlBtn: 'I-download',
      downloadedToast: 'Na-download na',
      infoTitle: 'Impormasyon',
      of: 'mula sa'
    }
  } as const;
  let s = $derived(STR[$locale]);

  let q=$state(''); let range=$state<DateRange|undefined>(undefined); let src=$state('all'); let page=$state(1); const perPage=4;
  let dl:any=$state(null); let only=$state(true); let scope=$state('semua');
  const rows=[
    {id:'NAS-1001',date:'2026-09-28',path:'/nas/rec/1001.wav',size:'2.1 MB'},{id:'NAS-1002',date:'2026-09-27',path:'/nas/rec/1002.wav',size:'1.4 MB'},
    {id:'NAS-1003',date:'2026-09-26',path:'/nas/rec/1003.wav',size:'3.0 MB'},{id:'NAS-1004',date:'2026-09-25',path:'/nas/rec/1004.wav',size:'900 KB'},
    {id:'NAS-1005',date:'2026-09-24',path:'/nas/rec/1005.wav',size:'2.6 MB'}
  ];
  let f=$derived(rows.filter(r=>!q||r.id.toLowerCase().includes(q.toLowerCase())));
  let paged=$derived(f.slice((page-1)*perPage,page*perPage));
</script>
<svelte:head><title>{s.docTitle}</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between"><div><Card.Title class="flex items-center gap-2"><Server size={18}/> {s.title} <Badge variant="secondary">{f.length}</Badge></Card.Title><Card.Description>{s.desc}</Card.Description></div><div class="flex items-center gap-2 text-sm">{s.audioOnly} <Switch bind:checked={only}/></div></Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">{s.tabAll}</Tabs.Trigger><Tabs.Trigger value="audio">{s.tabAudio}</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-3 md:items-end">
      <Field.Field><Field.Label>{s.searchLabel}</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder={s.searchPh}/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>{s.periodLabel}</Field.Label><DateRangePicker bind:value={range} label={s.periodPh}/></Field.Field>
      <Field.Field><Field.Label>{s.srcLabel}</Field.Label><Select.Root type="single" bind:value={src}><Select.Trigger>{src==='all'?s.srcAll:src}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>{s.srcGroup}</Select.GroupHeading><Select.Item value="all" label={s.srcAll}/><Select.Item value="nas1" label="NAS-1"/></Select.Group></Select.Content></Select.Root></Field.Field>
    </Field.FieldGroup>
    <Field.Set class="rounded-lg border p-3"><Field.Legend>{s.scopeLegend}</Field.Legend><RadioGroup.Root bind:value={scope} class="flex gap-4"><div class="flex items-center gap-2"><RadioGroup.Item value="semua" id="a1"/><label for="a1" class="text-sm">{s.scopeAll}</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="audio" id="a2"/><label for="a2" class="text-sm">{s.scopeAudio}</label></div></RadioGroup.Root><label class="mt-2 flex items-center gap-2 text-sm"><Checkbox bind:checked={only}/> {s.hideNoAudio}</label></Field.Set>
    {#if paged.length}
    <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>{s.thFile}</Table.Head><Table.Head>{s.thDate}</Table.Head><Table.Head>{s.thPath}</Table.Head><Table.Head>{s.thSize}</Table.Head><Table.Head>{s.thRec}</Table.Head><Table.Head class="text-right">{s.thAction}</Table.Head></Table.Row></Table.Header>
    <Table.Body>{#each paged as r}<Table.Row><Table.Cell class="font-mono">{r.id}</Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell class="max-w-48 truncate">{r.path}</Table.Cell><Table.Cell><Badge variant="outline">{r.size}</Badge></Table.Cell><Table.Cell><audio controls class="h-8 w-44"><source src="" type="audio/wav"/></audio></Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>{dl=r;}}>{s.download}</Button></Tooltip.Trigger><Tooltip.Content><p>{s.downloadTip}</p></Tooltip.Content></Tooltip.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    {:else}<Empty.Root class="py-10"><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>{/if}
    <Pagination.Root count={f.length} perPage={perPage} bind:page>{#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} {s.of} {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}</Pagination.Root>
    <Attachment.Group class="grid gap-2 sm:grid-cols-2"><Attachment.Root><Attachment.Title>nas-index.csv</Attachment.Title><Attachment.Description>12 KB</Attachment.Description></Attachment.Root></Attachment.Group>
    <Field.Field><Field.Label>{s.noteLabel}</Field.Label><Textarea rows={2} placeholder={s.notePh}/></Field.Field>
  </Card.Content>
</Card.Root>
<AlertDialog.Root open={dl!=null} onOpenChange={(o)=>{if(!o)dl=null;}}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>{s.dlTitle.replace('{id}', dl?.id ?? '')}</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>{s.cancel}</AlertDialog.Cancel><AlertDialog.Action onclick={()=>{dl=null;toast.success(s.downloadedToast);}}>{s.dlBtn}</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
<Dialog.Root><Dialog.Content><Dialog.Header><Dialog.Title>{s.infoTitle}</Dialog.Title></Dialog.Header></Dialog.Content></Dialog.Root>
