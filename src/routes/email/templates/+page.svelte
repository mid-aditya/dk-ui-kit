<script lang="ts">
  import * as Card from '$lib/components/ui/card';
  import * as Table from '$lib/components/ui/table';
  import * as Dialog from '$lib/components/ui/dialog';
  import * as AlertDialog from '$lib/components/ui/alert-dialog';
  import * as Field from '$lib/components/ui/field';
  import * as InputGroup from '$lib/components/ui/input-group';
  import * as Tabs from '$lib/components/ui/tabs';
  import * as Tooltip from '$lib/components/ui/tooltip';
  import * as Empty from '$lib/components/ui/empty';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Textarea } from '$lib/components/ui/textarea';
  import { Switch } from '$lib/components/ui/switch';
  import { Checkbox } from '$lib/components/ui/checkbox';
  import * as RadioGroup from '$lib/components/ui/radio-group';
  import { toast, Toaster } from 'svelte-sonner';
  import { FileText } from 'lucide-svelte';

  let name=$state(''); let tsubject=$state(''); let tbody=$state('');
  let editing:number|null=$state(null); let del:number|null=$state(null); let use=$state<any>(null);
  let active=$state(true); let cat=$state('umum'); let q=$state('');
  let rows=$state([
    {id:1,name:'Follow-up Tiket',subject:'Follow-up tiket Anda',body:'Halo, menindaklanjuti…'},
    {id:2,name:'Pengiriman Invoice',subject:'Invoice September',body:'Terlampir invoice…'},
    {id:3,name:'Ucapan Terima Kasih',subject:'Terima kasih',body:'Terima kasih…'}
  ]);
  let f=$derived(rows.filter(r=>!q||(r.name+r.subject).toLowerCase().includes(q.toLowerCase())));
  function save(){ if(!name.trim()){toast.error('Nama wajib');return;} if(editing){rows=rows.map(r=>r.id===editing?{...r,name,subject:tsubject,body:tbody}:r);toast.success('Template diupdate');}else{rows=[...rows,{id:Date.now(),name,subject:tsubject,body:tbody}];toast.success('Template disimpan');} name='';tsubject='';tbody='';editing=null; }
  function edit(r:any){editing=r.id;name=r.name;tsubject=r.subject;tbody=r.body;}
</script>
<svelte:head><title>Email Templates — DK UI Kit</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between"><div><Card.Title class="flex items-center gap-2"><FileText size={18}/> Email Templates <Badge variant="secondary">{rows.length}</Badge></Card.Title><Card.Description>Kolom blade: Nama, Subject, Aksi Edit/Hapus. Form: nama, subject, body HTML.</Card.Description></div><Button size="sm" variant="outline" href="/email">Kembali</Button></Card.Header>
  <Card.Content class="grid gap-4 lg:grid-cols-3">
    <Card.Root class="lg:col-span-2"><Card.Header><Card.Title class="text-sm">Daftar Template</Card.Title></Card.Header><Card.Content class="flex flex-col gap-3">
      <Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">Semua</Tabs.Trigger><Tabs.Trigger value="aktif">Aktif</Tabs.Trigger></Tabs.List></Tabs.Root>
      <Field.Field><InputGroup.Root><InputGroup.Input bind:value={q} placeholder="Cari template…"/></InputGroup.Root></Field.Field>
      <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>Nama</Table.Head><Table.Head>Subject</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header>
      <Table.Body>{#each f as r}<Table.Row><Table.Cell class="font-medium">{r.name}</Table.Cell><Table.Cell>{r.subject}</Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>edit(r)}>Edit</Button></Tooltip.Trigger><Tooltip.Content><p>Edit template</p></Tooltip.Content></Tooltip.Root> <Button size="sm" variant="ghost" onclick={()=>del=r.id}>Hapus</Button> <Button size="sm" variant="secondary" onclick={()=>use=r}>Gunakan</Button></Table.Cell></Table.Row>{:else}<Table.Row><Table.Cell colspan={3}><Empty.Root class="py-8"><Empty.Header><Empty.Title>Belum ada template</Empty.Title></Empty.Header></Empty.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    </Card.Content></Card.Root>
    <Card.Root><Card.Header><Card.Title class="text-sm">{editing?'Edit':'Buat'} Template</Card.Title></Card.Header><Card.Content>
      <Field.FieldGroup class="grid gap-3">
        <Field.Field><Field.Label>Nama Template</Field.Label><InputGroup.Root><InputGroup.Input bind:value={name}/></InputGroup.Root></Field.Field>
        <Field.Field><Field.Label>Subject</Field.Label><InputGroup.Root><InputGroup.Input bind:value={tsubject}/></InputGroup.Root></Field.Field>
        <Field.Field><Field.Label>Body (HTML)</Field.Label><Textarea bind:value={tbody} rows={6} placeholder="Tulis isi template…"/></Field.Field>
        <Field.Set class="rounded-lg border p-3"><Field.Legend>Kategori</Field.Legend><RadioGroup.Root bind:value={cat} class="flex gap-3"><div class="flex items-center gap-2"><RadioGroup.Item value="umum" id="c1"/><label for="c1" class="text-sm">Umum</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="promo" id="c2"/><label for="c2" class="text-sm">Promo</label></div></RadioGroup.Root><label class="mt-2 flex items-center gap-2 text-sm"><Checkbox/> Sisipkan tanda tangan</label><label class="mt-1 flex items-center gap-2 text-sm"><Switch bind:checked={active}/> Aktif</label></Field.Set>
        <div class="flex gap-2"><Button size="sm" onclick={save}>{editing?'Update':'Simpan'}</Button>{#if editing}<Button size="sm" variant="ghost" onclick={()=>{editing=null;name='';tsubject='';tbody='';}}>Batal</Button>{/if}</div>
      </Field.FieldGroup>
    </Card.Content></Card.Root>
  </Card.Content>
</Card.Root>
<Dialog.Root open={use!=null} onOpenChange={(o)=>{if(!o)use=null;}}><Dialog.Content><Dialog.Header><Dialog.Title>{use?.name}</Dialog.Title></Dialog.Header><Textarea readonly value={use?.body??''} rows={5}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root open={del!=null} onOpenChange={(o)=>{if(!o)del=null;}}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>Hapus template ini?</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>Batal</AlertDialog.Cancel><AlertDialog.Action onclick={()=>{rows=rows.filter(r=>r.id!==del);del=null;toast.success('Dihapus');}}>Hapus</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
