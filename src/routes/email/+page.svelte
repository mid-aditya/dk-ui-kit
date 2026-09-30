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
  import * as RadioGroup from '$lib/components/ui/radio-group';
  import { Switch } from '$lib/components/ui/switch';
  import { Textarea } from '$lib/components/ui/textarea';
  import { toast, Toaster } from 'svelte-sonner';
  import EmailItem from '$lib/components/ui/email-item.svelte';
  import EmailCompose from '$lib/components/ui/email-compose.svelte';
  import { ChevronLeft, ChevronRight, Inbox, Search, Archive } from 'lucide-svelte';

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
  let priority = $state('normal');

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
  const statusVariant = (s:string) => s==='Spam'?'destructive':s==='Terima Kasih'?'success':s==='Draft'?'warning':s==='Close'?'secondary':'outline' as const;
  let filtered = $derived(mails.filter(m => (folder==='Semua'||m.status===folder) && (!q || (m.subject+m.from).toLowerCase().includes(q.toLowerCase()))));
  let totalPages = $derived(Math.max(1, Math.ceil(filtered.length/perPage)));
  let paged = $derived(filtered.slice((page-1)*perPage, page*perPage));
  let detail = $derived(selected!=null ? mails.find(m=>m.id===selected) : null);
</script>

<svelte:head><title>Email Inbox — DK UI Kit</title></svelte:head>
<Toaster position="top-right" />

<Card.Root>
  <Card.Header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <div>
      <Card.Title class="flex items-center gap-2"><Inbox size={18}/> Inbox <Badge variant="secondary">{filtered.length}</Badge></Card.Title>
      <Card.Description>Folder/label: Semua, Belum/Sudah Dibaca, Reply, Terima Kasih, Salah Sambung, Spam, Draft, Close.</Card.Description>
    </div>
    <div class="flex gap-2">
      <Button size="sm" href="/email/compose">Compose</Button>
      <Button size="sm" variant="outline" onclick={()=>composeOpen=true}>Quick compose</Button>
    </div>
  </Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root value={folder} onValueChange={(v)=>{folder=String(v);page=1;}}>
      <Tabs.List class="flex flex-wrap">
        {#each folders as f}<Tabs.Trigger value={f}>{f}</Tabs.Trigger>{/each}
      </Tabs.List>
    </Tabs.Root>

    <Field.FieldGroup class="grid gap-3 md:grid-cols-[1fr_auto]">
      <Field.Field>
        <Field.Label for="email-q">Cari email</Field.Label>
        <InputGroup.Root>
          <InputGroup.Addon><Search size={14}/></InputGroup.Addon>
          <InputGroup.Input id="email-q" placeholder="Search mail…" bind:value={q} />
        </InputGroup.Root>
      </Field.Field>
      <Field.Field>
        <Field.Label>Notifikasi</Field.Label>
        <div class="flex items-center gap-2 pt-2"><Switch bind:checked={notify} id="notif"/><label for="notif" class="text-xs">Aktif</label></div>
      </Field.Field>
    </Field.FieldGroup>

    <div class="flex gap-2">
      <Button size="sm" variant="ghost" href="/email/send">Terkirim</Button>
      <Button size="sm" variant="ghost" href="/email/history">History</Button>
      <Button size="sm" variant="ghost" href="/email/templates">Templates</Button>
      <Tooltip.Root>
        <Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>archiveOpen=true}><Archive size={14}/> Arsip</Button></Tooltip.Trigger>
        <Tooltip.Content><p>Arsipkan email terpilih</p></Tooltip.Content>
      </Tooltip.Root>
    </div>

    <div class="divide-y divide-border rounded-lg border">
      {#each paged as m (m.id)}
        <div class="flex items-center gap-2 px-2">
          <Checkbox aria-label="pilih" />
          <div class="min-w-0 flex-1">
            <EmailItem from={m.from} subject={m.subject} snippet={m.snippet} date={m.date} read={m.read} attachments={m.attachments} onClick={()=>selected=m.id} />
            <div class="flex gap-1 px-14 pb-2">
              <Badge variant={statusVariant(m.status)}>{m.status}</Badge>
              {#if m.ticket}<Badge variant="secondary">{m.ticket}</Badge>{/if}
              {#if m.agent}<Badge variant="outline">{m.agent}</Badge>{/if}
            </div>
          </div>
        </div>
      {:else}
        <Empty.Root class="py-10">
          <Empty.Header><Empty.Title>Kotak masuk kosong</Empty.Title><Empty.Description>Selamat, semua email sudah tertangani.</Empty.Description></Empty.Header>
        </Empty.Root>
      {/each}
    </div>

    <Pagination.Root count={filtered.length} perPage={perPage} bind:page>
      {#snippet children({ pages, range })}
        <div class="flex items-center justify-between">
          <p class="text-xs text-muted-foreground">{range.start}-{range.end} dari {filtered.length}</p>
          <div class="flex gap-1">
            <Pagination.PrevButton size="icon"><ChevronLeft size={14}/></Pagination.PrevButton>
            {#each pages as p (p.key)}
              {#if p.type==='page'}<Pagination.Link page={p.value}>{p.value}</Pagination.Link>
              {:else}<span class="px-1 text-xs">…</span>{/if}
            {/each}
            <Pagination.NextButton size="icon"><ChevronRight size={14}/></Pagination.NextButton>
          </div>
        </div>
      {/snippet}
    </Pagination.Root>

    <Field.Set class="rounded-lg border p-3">
      <Field.Legend>Prioritas balasan</Field.Legend>
      <RadioGroup.Root bind:value={priority} class="flex gap-4">
        <div class="flex items-center gap-2"><RadioGroup.Item value="normal" id="pn"/><label for="pn" class="text-sm">Normal</label></div>
        <div class="flex items-center gap-2"><RadioGroup.Item value="urgent" id="pu"/><label for="pu" class="text-sm">Urgent</label></div>
      </RadioGroup.Root>
    </Field.Set>

    <Attachment.Group class="grid gap-2 sm:grid-cols-2">
      <Attachment.Root><Attachment.Title>laporan.pdf</Attachment.Title><Attachment.Description>240 KB</Attachment.Description></Attachment.Root>
      <Attachment.Root><Attachment.Title>bukti.png</Attachment.Title><Attachment.Description>120 KB</Attachment.Description></Attachment.Root>
    </Attachment.Group>
  </Card.Content>
</Card.Root>

<Dialog.Root open={selected!=null} onOpenChange={(o)=>{if(!o)selected=null;}}>
  <Dialog.Content>
    <Dialog.Header><Dialog.Title>{detail?.subject ?? 'Detail'}</Dialog.Title></Dialog.Header>
    <p class="text-sm">{detail?.from}</p>
    <Textarea readonly value={detail?.snippet ?? ''} rows={4}/>
    <Dialog.Footer><Button size="sm" onclick={()=>{selected=null;toast.success('Email dibalas');}}>Reply</Button></Dialog.Footer>
  </Dialog.Content>
</Dialog.Root>

<AlertDialog.Root bind:open={archiveOpen}>
  <AlertDialog.Content>
    <AlertDialog.Header><AlertDialog.Title>Arsipkan email?</AlertDialog.Title></AlertDialog.Header>
    <AlertDialog.Footer>
      <AlertDialog.Cancel>Batal</AlertDialog.Cancel>
      <AlertDialog.Action onclick={()=>toast.success('Diarsipkan')}>Arsipkan</AlertDialog.Action>
    </AlertDialog.Footer>
  </AlertDialog.Content>
</AlertDialog.Root>

<EmailCompose bind:open={composeOpen} bind:to bind:subject bind:body onSend={()=>toast.success('Email dikirim')} />

<!-- Select grup label (filter template cepat) -->
<div class="hidden">
<Select.Root type="single" value="all">
  <Select.Trigger>Semua</Select.Trigger>
  <Select.Content><Select.Group><Select.GroupHeading>Label</Select.GroupHeading><Select.Item value="all" label="Semua"/></Select.Group></Select.Content>
</Select.Root>
</div>
