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
<svelte:head><title>Recording Archive — DK UI Kit</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between"><div><Card.Title class="flex items-center gap-2"><Server size={18}/> Recording Archive <Badge variant="secondary">{f.length}</Badge></Card.Title><Card.Description>Kolom blade: File Name/ID, Call Date, Path, Size, Recording, Actions. Cari via phone/recording ID + range tanggal.</Card.Description></div><div class="flex items-center gap-2 text-sm">Hanya ada audio <Switch bind:checked={only}/></div></Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">Semua</Tabs.Trigger><Tabs.Trigger value="audio">Ada audio</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-3 md:items-end">
      <Field.Field><Field.Label>Search Files</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder="phone / recording ID"/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>Periode</Field.Label><DateRangePicker bind:value={range} label="Pilih periode arsip"/></Field.Field>
      <Field.Field><Field.Label>Sumber</Field.Label><Select.Root type="single" bind:value={src}><Select.Trigger>{src}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Sumber NAS</Select.GroupHeading><Select.Item value="all" label="Semua"/><Select.Item value="nas1" label="NAS-1"/></Select.Group></Select.Content></Select.Root></Field.Field>
    </Field.FieldGroup>
    <Field.Set class="rounded-lg border p-3"><Field.Legend>Cakupan</Field.Legend><RadioGroup.Root bind:value={scope} class="flex gap-4"><div class="flex items-center gap-2"><RadioGroup.Item value="semua" id="a1"/><label for="a1" class="text-sm">Semua</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="audio" id="a2"/><label for="a2" class="text-sm">Ada audio</label></div></RadioGroup.Root><label class="mt-2 flex items-center gap-2 text-sm"><Checkbox bind:checked={only}/> Sembunyikan tanpa audio</label></Field.Set>
    {#if paged.length}
    <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>File Name/ID</Table.Head><Table.Head>Call Date</Table.Head><Table.Head>Path</Table.Head><Table.Head>Size</Table.Head><Table.Head>Recording</Table.Head><Table.Head class="text-right">Actions</Table.Head></Table.Row></Table.Header>
    <Table.Body>{#each paged as r}<Table.Row><Table.Cell class="font-mono">{r.id}</Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell class="max-w-48 truncate">{r.path}</Table.Cell><Table.Cell><Badge variant="outline">{r.size}</Badge></Table.Cell><Table.Cell><audio controls class="h-8 w-44"><source src="" type="audio/wav"/></audio></Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>{dl=r;}}>Download</Button></Tooltip.Trigger><Tooltip.Content><p>Unduh file</p></Tooltip.Content></Tooltip.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    {:else}<Empty.Root class="py-10"><Empty.Header><Empty.Title>Tidak ada data NAS</Empty.Title><Empty.Description>Ubah kriteria pencarian.</Empty.Description></Empty.Header></Empty.Root>{/if}
    <Pagination.Root count={f.length} perPage={perPage} bind:page>{#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} dari {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}</Pagination.Root>
    <Attachment.Group class="grid gap-2 sm:grid-cols-2"><Attachment.Root><Attachment.Title>nas-index.csv</Attachment.Title><Attachment.Description>12 KB</Attachment.Description></Attachment.Root></Attachment.Group>
    <Field.Field><Field.Label>Catatan arsip</Field.Label><Textarea rows={2} placeholder="Catatan…"/></Field.Field>
  </Card.Content>
</Card.Root>
<AlertDialog.Root open={dl!=null} onOpenChange={(o)=>{if(!o)dl=null;}}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>Download {dl?.id}?</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>Batal</AlertDialog.Cancel><AlertDialog.Action onclick={()=>{dl=null;toast.success('Diunduh');}}>Download</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
<Dialog.Root><Dialog.Content><Dialog.Header><Dialog.Title>Info</Dialog.Title></Dialog.Header></Dialog.Content></Dialog.Root>
