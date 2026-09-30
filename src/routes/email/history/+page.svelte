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
<svelte:head><title>Email History — DK UI Kit</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header><Card.Title class="flex items-center gap-2"><History size={18}/> Email History <Badge variant="secondary">{f.length}</Badge></Card.Title><Card.Description>Kolom blade: From, To, Subject, Status, Date, Actions.</Card.Description></Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root value={status} onValueChange={(v)=>{status=String(v);page=1;}}><Tabs.List><Tabs.Trigger value="all">Semua</Tabs.Trigger><Tabs.Trigger value="sent">Sent</Tabs.Trigger><Tabs.Trigger value="draft">Draft</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-4 md:items-end">
      <Field.Field class="md:col-span-2"><Field.Label>Cari history</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder="Search email history…"/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>Rentang</Field.Label><Select.Root type="single" bind:value={range}><Select.Trigger>{range==='7'?'7 hari':'30 hari'}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Rentang</Select.GroupHeading><Select.Item value="7" label="7 hari"/><Select.Item value="30" label="30 hari"/></Select.Group></Select.Content></Select.Root></Field.Field>
      <div class="flex gap-2"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>exp=true}>Export</Button></Tooltip.Trigger><Tooltip.Content><p>Export CSV/Excel/PDF</p></Tooltip.Content></Tooltip.Root><Button size="sm" variant="ghost" href="/email">Inbox</Button></div>
    </Field.FieldGroup>
    <Field.Set class="rounded-lg border p-3"><Field.Legend>Filter status</Field.Legend><RadioGroup.Root bind:value={status} class="flex gap-4"><div class="flex items-center gap-2"><RadioGroup.Item value="all" id="h1"/><label for="h1" class="text-sm">Semua</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="sent" id="h2"/><label for="h2" class="text-sm">Sent</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="draft" id="h3"/><label for="h3" class="text-sm">Draft</label></div></RadioGroup.Root><label class="mt-2 flex items-center gap-2 text-sm"><Checkbox bind:checked={inc}/> Sertakan attachment</label><div class="mt-2 flex items-center gap-2 text-sm">Notifikasi <Switch/></div></Field.Set>
    <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>From</Table.Head><Table.Head>To</Table.Head><Table.Head>Subject</Table.Head><Table.Head>Status</Table.Head><Table.Head>Date</Table.Head><Table.Head class="text-right">Actions</Table.Head></Table.Row></Table.Header>
    <Table.Body>{#each paged as r}<Table.Row><Table.Cell>{r.from}</Table.Cell><Table.Cell class="max-w-40 truncate">{r.to}</Table.Cell><Table.Cell><div class="font-medium">{r.subject}</div><div class="text-xs text-muted-foreground">{r.preview}{#if r.att} • {r.att} lampiran{/if}</div></Table.Cell><Table.Cell><Badge variant={r.status==='Sent'?'success':'warning'}>{r.status}</Badge></Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell class="text-right"><Button size="sm" variant="outline" onclick={()=>{cur=r;open=true;}}>View</Button></Table.Cell></Table.Row>{:else}<Table.Row><Table.Cell colspan={6}><Empty.Root class="py-8"><Empty.Header><Empty.Title>Tidak ada history</Empty.Title><Empty.Description>Mulai kirim email.</Empty.Description></Empty.Header></Empty.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    <Pagination.Root count={f.length} perPage={perPage} bind:page>{#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} dari {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}</Pagination.Root>
    <Field.Field><Field.Label>Catatan</Field.Label><Textarea placeholder="Catatan history…" rows={2}/></Field.Field>
  </Card.Content>
</Card.Root>
<Dialog.Root bind:open><Dialog.Content><Dialog.Header><Dialog.Title>{cur?.subject}</Dialog.Title></Dialog.Header><Textarea readonly value={cur?.preview??''} rows={3}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root bind:open={exp}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>Export ({fmt})?</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>Batal</AlertDialog.Cancel><AlertDialog.Action onclick={()=>toast.success('Diexport')}>Export</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
