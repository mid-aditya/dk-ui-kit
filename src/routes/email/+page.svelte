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
  const statusVariant = (s:string) => s==='Spam'?'destructive':s==='Terima Kasih'?'success':s==='Draft'?'warning':s==='Close'?'secondary':'outline' as const;
  let filtered = $derived(mails.filter(m => (folder==='Semua'||m.status===folder) && (!q || (m.subject+m.from).toLowerCase().includes(q.toLowerCase()))));
  let totalPages = $derived(Math.max(1, Math.ceil(filtered.length/perPage)));
  let paged = $derived(filtered.slice((page-1)*perPage, page*perPage));
  let detail = $derived(selected!=null ? mails.find(m=>m.id===selected) : null);

  function toggleCheck(id: number, v: boolean) {
    checked = v ? [...checked, id] : checked.filter((c) => c !== id);
  }

  function markRead() {
    for (const m of mails) if (checked.includes(m.id)) m.read = true;
    toast.success(`${checked.length} email ditandai dibaca`);
    checked = [];
  }
</script>

<svelte:head><title>Email Inbox — DK UI Kit</title></svelte:head>

<Card.Root>
  <Card.Header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <div>
      <Card.Title class="flex items-center gap-2"><Inbox data-icon="inline-start" /> Inbox <Badge variant="secondary">{filtered.length}</Badge></Card.Title>
      <Card.Description>Folder/label: Semua, Belum/Sudah Dibaca, Reply, Terima Kasih, Salah Sambung, Spam, Draft, Close.</Card.Description>
    </div>
    <div class="flex shrink-0 gap-2">
      <Button size="sm" href="/email/compose">Compose</Button>
      <Button size="sm" variant="outline" onclick={()=>composeOpen=true}>Quick compose</Button>
    </div>
  </Card.Header>
  <Card.Content class="flex flex-col gap-4">
    <Tabs.Root bind:value={folder}>
      <Tabs.List class="w-full justify-start overflow-x-auto">
        {#each folders as f}<Tabs.Trigger value={f} onclick={()=>{page=1;}}>{f}</Tabs.Trigger>{/each}
      </Tabs.List>
    </Tabs.Root>

    <Field.FieldGroup class="grid gap-3 md:grid-cols-[1fr_auto_auto]">
      <Field.Field>
        <Field.Label for="email-q">Cari email</Field.Label>
        <InputGroup.Root>
          <InputGroup.Addon><Search data-icon="true" /></InputGroup.Addon>
          <InputGroup.Input id="email-q" placeholder="Cari subjek atau pengirim…" bind:value={q} />
        </InputGroup.Root>
      </Field.Field>
      <Field.Field>
        <Field.Label for="notif">Notifikasi</Field.Label>
        <div class="flex items-center gap-2"><Switch id="notif" bind:checked={notify} /><span class="text-xs text-muted-foreground">{notify ? "Aktif" : "Mati"}</span></div>
      </Field.Field>
      <Field.Field>
        <Field.Label>Aksi</Field.Label>
        <div class="flex gap-2">
          <Button size="sm" variant="ghost" href="/email/send">Terkirim</Button>
          <Button size="sm" variant="ghost" href="/email/history">History</Button>
          <Button size="sm" variant="ghost" href="/email/templates">Templates</Button>
        </div>
      </Field.Field>
    </Field.FieldGroup>

    {#if checked.length > 0}
      <div class="flex flex-wrap items-center gap-2 rounded-lg bg-muted/50 px-3 py-2 text-sm">
        <span class="font-medium">{checked.length} dipilih</span>
        <Separator orientation="vertical" class="h-5" />
        <Button size="sm" variant="ghost" onclick={markRead}><MailOpen data-icon="inline-start" />Tandai dibaca</Button>
        <Button size="sm" variant="ghost" onclick={()=>{archiveOpen=true;}}><Archive data-icon="inline-start" />Arsip</Button>
        <Button size="sm" variant="ghost" onclick={()=>{toast.success(`${checked.length} email dihapus`); checked=[];}}><Trash2 data-icon="inline-start" />Hapus</Button>
      </div>
    {/if}

    <div class="overflow-hidden rounded-lg border">
      <div class="flex items-center gap-3 border-b bg-muted/40 px-4 py-2 text-xs text-muted-foreground">
        <Checkbox
          aria-label="Pilih semua email"
          checked={paged.length > 0 && paged.every((m) => checked.includes(m.id))}
          onCheckedChange={(v) => { checked = v === true ? paged.map((m) => m.id) : []; }}
        />
        <span class="font-medium">{paged.length} dari {filtered.length} email</span>
        <span class="ms-auto hidden items-center gap-1.5 sm:flex">
          <span class="size-1.5 rounded-full bg-primary" aria-hidden="true"></span>Belum dibaca
        </span>
      </div>
      <div class="divide-y divide-border/70">
        {#each paged as m (m.id)}
          <div class={cn("group flex items-center gap-3 px-3 transition-colors hover:bg-muted/50", selected === m.id && "bg-muted/60")}>
            <span class="size-1.5 shrink-0 rounded-full {m.read ? 'bg-transparent' : 'bg-primary'}" aria-hidden="true"></span>
            <Checkbox aria-label={`Pilih email ${m.subject}`} checked={checked.includes(m.id)} onCheckedChange={(v)=>toggleCheck(m.id, v === true)} />
            <div class="min-w-0 flex-1 py-1">
              <EmailItem class="px-0 hover:bg-transparent" from={m.from} subject={m.subject} snippet={m.snippet} date={m.date} read={m.read} attachments={m.attachments} onClick={()=>selected=m.id} />
              <div class="flex flex-wrap gap-1 px-0 pb-2.5 ps-[3.25rem]">
                <Badge variant={statusVariant(m.status)}>{m.status}</Badge>
                {#if m.ticket}<Badge variant="secondary">{m.ticket}</Badge>{/if}
                {#if m.agent}<Badge variant="outline">{m.agent}</Badge>{/if}
              </div>
            </div>
            <div class="flex shrink-0 gap-1 opacity-0 transition-opacity group-hover:opacity-100 group-focus-within:opacity-100">
              <Tooltip.Root>
                <Tooltip.Trigger>
                  {#snippet child({ props })}
                    <Button {...props} size="icon" variant="ghost" onclick={()=>{selected=m.id;}} aria-label="Pratinjau"><MailOpen data-icon="true" /></Button>
                  {/snippet}
                </Tooltip.Trigger>
                <Tooltip.Content>Pratinjau</Tooltip.Content>
              </Tooltip.Root>
              <Tooltip.Root>
                <Tooltip.Trigger>
                  {#snippet child({ props })}
                    <Button {...props} size="icon" variant="ghost" onclick={()=>{archiveOpen=true;}} aria-label="Arsipkan"><Archive data-icon="true" /></Button>
                  {/snippet}
                </Tooltip.Trigger>
                <Tooltip.Content>Arsipkan email</Tooltip.Content>
              </Tooltip.Root>
            </div>
          </div>
        {:else}
          <Empty.Root class="py-10">
            <Empty.Header><Empty.Media><Inbox data-icon="empty" /></Empty.Media><Empty.Title>Kotak masuk kosong</Empty.Title><Empty.Description>Selamat, semua email sudah tertangani.</Empty.Description></Empty.Header>
          </Empty.Root>
        {/each}
      </div>
    </div>

    <Pagination.Root count={filtered.length} perPage={perPage} bind:page>
      {#snippet children({ pages, range })}
        <div class="flex items-center justify-between gap-2">
          <p class="text-xs text-muted-foreground">{range.start}-{range.end} dari {filtered.length}</p>
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
      <Dialog.Title>{detail?.subject ?? 'Detail'}</Dialog.Title>
      <Dialog.Description>{detail?.from ?? 'Pratinjau email'}</Dialog.Description>
    </Dialog.Header>
    <p class="text-sm">{detail?.from}</p>
    <Textarea readonly value={detail?.snippet ?? ''} rows={4}/>
    <Dialog.Footer><Button size="sm" onclick={()=>{selected=null;toast.success('Email dibalas');}}>Reply</Button></Dialog.Footer>
  </Dialog.Content>
</Dialog.Root>

<AlertDialog.Root bind:open={archiveOpen}>
  <AlertDialog.Content>
    <AlertDialog.Header>
      <AlertDialog.Title>Arsipkan email?</AlertDialog.Title>
      <AlertDialog.Description>Email yang dipilih akan dipindahkan ke arsip.</AlertDialog.Description>
    </AlertDialog.Header>
    <AlertDialog.Footer>
      <AlertDialog.Cancel>Batal</AlertDialog.Cancel>
      <AlertDialog.Action onclick={()=>toast.success('Diarsipkan')}>Arsipkan</AlertDialog.Action>
    </AlertDialog.Footer>
  </AlertDialog.Content>
</AlertDialog.Root>

<EmailCompose bind:open={composeOpen} bind:to bind:subject bind:body onSend={()=>toast.success('Email dikirim')} />
