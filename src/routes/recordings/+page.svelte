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

  let q=$state(''); let start=$state(''); let end=$state(''); let disp=$state('all'); let page=$state(1); const perPage=4;
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
<svelte:head><title>Call Recordings — DK UI Kit</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between"><div><Card.Title class="flex items-center gap-2"><PhoneCall size={18}/> Call Recordings <Badge variant="secondary">{f.length}</Badge></Card.Title><Card.Description>Kolom blade: Unique ID, Call Date, Disposition, Customer, Agent, Duration, Recording, STT, QA.</Card.Description></div><div class="flex items-center gap-2 text-sm">Auto refresh <Switch bind:checked={auto}/></div></Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root bind:value={view}><Tabs.List><Tabs.Trigger value="table">Tabel</Tabs.Trigger><Tabs.Trigger value="list">Ringkas</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-4 md:items-end">
      <Field.Field><Field.Label>Cari Unique ID</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder="Search by Unique ID"/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>Start Date</Field.Label><InputGroup.Root><InputGroup.Input type="date" bind:value={start}/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>End Date</Field.Label><InputGroup.Root><InputGroup.Input type="date" bind:value={end}/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>Disposition</Field.Label><Select.Root type="single" bind:value={disp}><Select.Trigger>{disp}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Disposition</Select.GroupHeading><Select.Item value="all" label="Semua"/><Select.Item value="ANSWERED" label="ANSWERED"/><Select.Item value="NO ANSWER" label="NO ANSWER"/><Select.Item value="BUSY" label="BUSY"/></Select.Group></Select.Content></Select.Root></Field.Field>
    </Field.FieldGroup>
    <Field.Set class="rounded-lg border p-3"><Field.Legend>Opsi tampil</Field.Legend><div class="flex gap-4"><label class="flex items-center gap-2 text-sm"><Checkbox checked/> Tampilkan STT</label><label class="flex items-center gap-2 text-sm"><Checkbox checked/> Tampilkan QA</label></div><RadioGroup.Root bind:value={view} class="mt-2 flex gap-4"><div class="flex items-center gap-2"><RadioGroup.Item value="table" id="v1"/><label for="v1" class="text-sm">Tabel</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="list" id="v2"/><label for="v2" class="text-sm">Ringkas</label></div></RadioGroup.Root></Field.Set>
    {#if paged.length}
    <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>Unique ID</Table.Head><Table.Head>Call Date</Table.Head><Table.Head>Disposition</Table.Head><Table.Head>Customer</Table.Head><Table.Head>Agent</Table.Head><Table.Head>Duration</Table.Head><Table.Head>Recording</Table.Head><Table.Head>STT</Table.Head><Table.Head class="text-right">QA</Table.Head></Table.Row></Table.Header>
    <Table.Body>{#each paged as r}<Table.Row><Table.Cell class="font-mono">{r.id}</Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell><Badge variant={dv(r.disp)}>{r.disp}</Badge></Table.Cell><Table.Cell>{r.cust}</Table.Cell><Table.Cell>{r.agent}</Table.Cell><Table.Cell>{r.dur}</Table.Cell><Table.Cell><audio controls class="h-8 w-44"><source src="" type="audio/wav"/></audio></Table.Cell><Table.Cell><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>{tr=r;}}>STT</Button></Tooltip.Trigger><Tooltip.Content><p>Lihat transkrip</p></Tooltip.Content></Tooltip.Root></Table.Cell><Table.Cell class="text-right"><Button size="sm" variant="ghost" onclick={()=>{tr=r;push=true;}}>Push QA</Button></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    {:else}<Empty.Root class="py-10"><Empty.Header><Empty.Title>Tidak ada rekaman</Empty.Title><Empty.Description>Ubah filter pencarian.</Empty.Description></Empty.Header></Empty.Root>{/if}
    <Pagination.Root count={f.length} perPage={perPage} bind:page>{#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} dari {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}</Pagination.Root>
    <Field.Field><Field.Label>Catatan QA</Field.Label><Textarea rows={2} placeholder="Catatan…"/></Field.Field>
  </Card.Content>
</Card.Root>
<Dialog.Root open={tr!=null&&!push} onOpenChange={(o)=>{if(!o)tr=null;}}><Dialog.Content><Dialog.Header><Dialog.Title>Transcript {tr?.id}</Dialog.Title></Dialog.Header><Textarea readonly value="Transcript & summary…" rows={5}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root bind:open={push}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>Push recording ke QA?</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>Batal</AlertDialog.Cancel><AlertDialog.Action onclick={()=>{push=false;tr=null;toast.success('Pushed');}}>Push</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
