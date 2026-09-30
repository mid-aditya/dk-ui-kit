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
<svelte:head><title>Email Terkirim — DK UI Kit</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
    <div><Card.Title class="flex items-center gap-2"><Send size={18}/> Email Terkirim <Badge>{f.length}</Badge></Card.Title><Card.Description>Kolom blade: From, To, Subject, Date, attachment, aksi view/download.</Card.Description></div>
    <div class="flex gap-2"><Button size="sm" href="/email/compose">Compose</Button><Button size="sm" variant="outline" href="/email">Inbox</Button></div>
  </Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">Semua</Tabs.Trigger><Tabs.Trigger value="week">Minggu ini</Tabs.Trigger></Tabs.List></Tabs.Root>
    <Field.FieldGroup class="grid gap-3 md:grid-cols-[1fr_auto]">
      <Field.Field><Field.Label>Cari email terkirim</Field.Label><InputGroup.Root><InputGroup.Addon><Search size={14}/></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder="Search sent emails…"/></InputGroup.Root></Field.Field>
      <Field.Field><Field.Label>Arsipkan otomatis</Field.Label><div class="pt-2"><Switch bind:checked={words}/></div></Field.Field>
    </Field.FieldGroup>
    <div class="divide-y divide-border rounded-lg border">
      {#each paged as r}<EmailItem from={r.to} subject={r.subject} snippet={'to: '+r.to+' • '+r.body} date={r.date} read attachments={r.att} onClick={()=>{cur=r;open=true;}}/>
      {:else}<Empty.Root class="py-8"><Empty.Header><Empty.Title>Belum ada email terkirim</Empty.Title><Empty.Description>Mulai kirim email.</Empty.Description></Empty.Header></Empty.Root>{/each}
    </div>
    <Card.Root><Card.Content class="p-0">
      <Table.Root><Table.Header><Table.Row><Table.Head>From</Table.Head><Table.Head>To</Table.Head><Table.Head>Subject</Table.Head><Table.Head>Date</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header>
      <Table.Body>{#each paged as r}<Table.Row><Table.Cell>{r.from}</Table.Cell><Table.Cell>{r.to}</Table.Cell><Table.Cell class="font-medium">{r.subject}</Table.Cell><Table.Cell>{r.date}</Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>{cur=r;open=true;}}>View</Button></Tooltip.Trigger><Tooltip.Content><p>Lihat detail</p></Tooltip.Content></Tooltip.Root> <Button size="sm" variant="ghost" onclick={()=>{cur=r;del=true;}}>Hapus</Button></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
    </Card.Content></Card.Root>
    <Pagination.Root count={f.length} perPage={perPage} bind:page>
      {#snippet children({ pages, range })}<div class="flex items-center justify-between"><p class="text-xs text-muted-foreground">{range.start}-{range.end} dari {f.length}</p><div class="flex gap-1"><Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>{#each pages as p (p.key)}{#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>{/if}{/each}<Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton></div></div>{/snippet}
    </Pagination.Root>
    <Attachment.Group class="grid gap-2 sm:grid-cols-2"><Attachment.Root><Attachment.Title>invoice.pdf</Attachment.Title><Attachment.Description>300 KB</Attachment.Description></Attachment.Root></Attachment.Group>
  </Card.Content>
</Card.Root>
<Dialog.Root bind:open><Dialog.Content><Dialog.Header><Dialog.Title>{cur?.subject}</Dialog.Title></Dialog.Header><p class="text-sm">To: {cur?.to}</p><Textarea readonly value={cur?.body??''} rows={4}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root bind:open={del}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>Hapus email terkirim?</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>Batal</AlertDialog.Cancel><AlertDialog.Action onclick={()=>toast.success('Dihapus')}>Hapus</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
