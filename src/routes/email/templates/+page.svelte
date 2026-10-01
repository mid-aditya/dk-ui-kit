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
  import { locale } from '$lib/i18n';

  const STR = {
    id: {
      docTitle: 'Email Templates — DK UI Kit',
      title: 'Email Templates',
      desc: 'Kolom blade: Nama, Subject, Aksi Edit/Hapus. Form: nama, subject, body HTML.',
      back: 'Kembali',
      listTitle: 'Daftar Template',
      tabAll: 'Semua',
      tabActive: 'Aktif',
      searchPh: 'Cari template…',
      thName: 'Nama',
      thSubject: 'Subject',
      thAction: 'Aksi',
      edit: 'Edit',
      editTip: 'Edit template',
      delete: 'Hapus',
      use: 'Gunakan',
      emptyTitle: 'Belum ada template',
      createTitle: 'Buat Template',
      editTitle: 'Edit Template',
      nameLabel: 'Nama Template',
      subjectLabel: 'Subject',
      bodyLabel: 'Body (HTML)',
      bodyPh: 'Tulis isi template…',
      catLegend: 'Kategori',
      catGeneral: 'Umum',
      catPromo: 'Promo',
      insertSig: 'Sisipkan tanda tangan',
      active: 'Aktif',
      save: 'Simpan',
      update: 'Update',
      cancel: 'Batal',
      nameRequired: 'Nama wajib',
      updatedToast: 'Template diupdate',
      savedToast: 'Template disimpan',
      deletedToast: 'Dihapus',
      delTitle: 'Hapus template ini?',
      delBtn: 'Hapus'
    },
    en: {
      docTitle: 'Email Templates — DK UI Kit',
      title: 'Email Templates',
      desc: 'Blade columns: Name, Subject, Edit/Delete actions. Form: name, subject, HTML body.',
      back: 'Back',
      listTitle: 'Template List',
      tabAll: 'All',
      tabActive: 'Active',
      searchPh: 'Search templates…',
      thName: 'Name',
      thSubject: 'Subject',
      thAction: 'Actions',
      edit: 'Edit',
      editTip: 'Edit template',
      delete: 'Delete',
      use: 'Use',
      emptyTitle: 'No templates yet',
      createTitle: 'Create Template',
      editTitle: 'Edit Template',
      nameLabel: 'Template Name',
      subjectLabel: 'Subject',
      bodyLabel: 'Body (HTML)',
      bodyPh: 'Write template content…',
      catLegend: 'Category',
      catGeneral: 'General',
      catPromo: 'Promo',
      insertSig: 'Insert signature',
      active: 'Active',
      save: 'Save',
      update: 'Update',
      cancel: 'Cancel',
      nameRequired: 'Name is required',
      updatedToast: 'Template updated',
      savedToast: 'Template saved',
      deletedToast: 'Deleted',
      delTitle: 'Delete this template?',
      delBtn: 'Delete'
    },
    th: {
      docTitle: 'เทมเพลตอีเมล — DK UI Kit',
      title: 'เทมเพลตอีเมล',
      desc: 'คอลัมน์ blade: ชื่อ หัวข้อ ปุ่มแก้ไข/ลบ ฟอร์ม: ชื่อ หัวข้อ เนื้อหา HTML',
      back: 'กลับ',
      listTitle: 'รายการเทมเพลต',
      tabAll: 'ทั้งหมด',
      tabActive: 'ใช้งาน',
      searchPh: 'ค้นหาเทมเพลต…',
      thName: 'ชื่อ',
      thSubject: 'หัวข้อ',
      thAction: 'การดำเนินการ',
      edit: 'แก้ไข',
      editTip: 'แก้ไขเทมเพลต',
      delete: 'ลบ',
      use: 'ใช้',
      emptyTitle: 'ยังไม่มีเทมเพลต',
      createTitle: 'สร้างเทมเพลต',
      editTitle: 'แก้ไขเทมเพลต',
      nameLabel: 'ชื่อเทมเพลต',
      subjectLabel: 'หัวข้อ',
      bodyLabel: 'เนื้อหา (HTML)',
      bodyPh: 'เขียนเนื้อหาเทมเพลต…',
      catLegend: 'หมวดหมู่',
      catGeneral: 'ทั่วไป',
      catPromo: 'โปรโมชัน',
      insertSig: 'แทรกลายเซ็น',
      active: 'ใช้งาน',
      save: 'บันทึก',
      update: 'อัปเดต',
      cancel: 'ยกเลิก',
      nameRequired: 'ต้องระบุชื่อ',
      updatedToast: 'อัปเดตเทมเพลตแล้ว',
      savedToast: 'บันทึกเทมเพลตแล้ว',
      deletedToast: 'ลบแล้ว',
      delTitle: 'ลบเทมเพลตนี้?',
      delBtn: 'ลบ'
    },
    tl: {
      docTitle: 'Mga Template ng Email — DK UI Kit',
      title: 'Mga Template ng Email',
      desc: 'Mga column ng blade: Pangalan, Paksa, aksyong Edit/Delete. Form: pangalan, paksa, HTML body.',
      back: 'Bumalik',
      listTitle: 'Listahan ng Template',
      tabAll: 'Lahat',
      tabActive: 'Aktibo',
      searchPh: 'Hanapin ang template…',
      thName: 'Pangalan',
      thSubject: 'Paksa',
      thAction: 'Mga Aksyon',
      edit: 'I-edit',
      editTip: 'I-edit ang template',
      delete: 'Burahin',
      use: 'Gamitin',
      emptyTitle: 'Wala pang template',
      createTitle: 'Gumawa ng Template',
      editTitle: 'I-edit ang Template',
      nameLabel: 'Pangalan ng Template',
      subjectLabel: 'Paksa',
      bodyLabel: 'Body (HTML)',
      bodyPh: 'Isulat ang nilalaman ng template…',
      catLegend: 'Kategorya',
      catGeneral: 'Pangkalahatan',
      catPromo: 'Promo',
      insertSig: 'Isingit ang lagda',
      active: 'Aktibo',
      save: 'I-save',
      update: 'I-update',
      cancel: 'Kanselahin',
      nameRequired: 'Kailangan ang pangalan',
      updatedToast: 'Na-update ang template',
      savedToast: 'Na-save ang template',
      deletedToast: 'Nabura na',
      delTitle: 'Burahin ang template na ito?',
      delBtn: 'Burahin'
    }
  } as const;
  let s = $derived(STR[$locale]);

  let name=$state(''); let tsubject=$state(''); let tbody=$state('');
  let editing:number|null=$state(null); let del:number|null=$state(null); let use=$state<any>(null);
  let active=$state(true); let cat=$state('umum'); let q=$state('');
  let rows=$state([
    {id:1,name:'Follow-up Tiket',subject:'Follow-up tiket Anda',body:'Halo, menindaklanjuti…'},
    {id:2,name:'Pengiriman Invoice',subject:'Invoice September',body:'Terlampir invoice…'},
    {id:3,name:'Ucapan Terima Kasih',subject:'Terima kasih',body:'Terima kasih…'}
  ]);
  let f=$derived(rows.filter(r=>!q||(r.name+r.subject).toLowerCase().includes(q.toLowerCase())));
  function save(){ if(!name.trim()){toast.error(s.nameRequired);return;} if(editing){rows=rows.map(r=>r.id===editing?{...r,name,subject:tsubject,body:tbody}:r);toast.success(s.updatedToast);}else{rows=[...rows,{id:Date.now(),name,subject:tsubject,body:tbody}];toast.success(s.savedToast);} name='';tsubject='';tbody='';editing=null; }
  function edit(r:any){editing=r.id;name=r.name;tsubject=r.subject;tbody=r.body;}
</script>
<svelte:head><title>{s.docTitle}</title></svelte:head>
<Toaster position="top-right"/>
<Card.Root>
  <Card.Header class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between"><div><Card.Title class="flex items-center gap-2"><FileText size={18}/> {s.title} <Badge variant="secondary">{rows.length}</Badge></Card.Title><Card.Description>{s.desc}</Card.Description></div><Button size="sm" variant="outline" href="/email">{s.back}</Button></Card.Header>
  <Card.Content class="grid gap-4 lg:grid-cols-3">
    <Card.Root class="lg:col-span-2"><Card.Header><Card.Title class="text-sm">{s.listTitle}</Card.Title></Card.Header><Card.Content class="flex flex-col gap-3">
      <Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">{s.tabAll}</Tabs.Trigger><Tabs.Trigger value="aktif">{s.tabActive}</Tabs.Trigger></Tabs.List></Tabs.Root>
      <Field.Field><InputGroup.Root><InputGroup.Input bind:value={q} placeholder={s.searchPh}/></InputGroup.Root></Field.Field>
      <div class="overflow-auto rounded-lg border"><Table.Root><Table.Header><Table.Row><Table.Head>{s.thName}</Table.Head><Table.Head>{s.thSubject}</Table.Head><Table.Head class="text-right">{s.thAction}</Table.Head></Table.Row></Table.Header>
      <Table.Body>{#each f as r}<Table.Row><Table.Cell class="font-medium">{r.name}</Table.Cell><Table.Cell>{r.subject}</Table.Cell><Table.Cell class="text-right"><Tooltip.Root><Tooltip.Trigger><Button size="sm" variant="outline" onclick={()=>edit(r)}>{s.edit}</Button></Tooltip.Trigger><Tooltip.Content><p>{s.editTip}</p></Tooltip.Content></Tooltip.Root> <Button size="sm" variant="ghost" onclick={()=>del=r.id}>{s.delete}</Button> <Button size="sm" variant="secondary" onclick={()=>use=r}>{s.use}</Button></Table.Cell></Table.Row>{:else}<Table.Row><Table.Cell colspan={3}><Empty.Root class="py-8"><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title></Empty.Header></Empty.Root></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root></div>
    </Card.Content></Card.Root>
    <Card.Root><Card.Header><Card.Title class="text-sm">{editing?s.editTitle:s.createTitle}</Card.Title></Card.Header><Card.Content>
      <Field.FieldGroup class="grid gap-3">
        <Field.Field><Field.Label>{s.nameLabel}</Field.Label><InputGroup.Root><InputGroup.Input bind:value={name}/></InputGroup.Root></Field.Field>
        <Field.Field><Field.Label>{s.subjectLabel}</Field.Label><InputGroup.Root><InputGroup.Input bind:value={tsubject}/></InputGroup.Root></Field.Field>
        <Field.Field><Field.Label>{s.bodyLabel}</Field.Label><Textarea bind:value={tbody} rows={6} placeholder={s.bodyPh}/></Field.Field>
        <Field.Set class="rounded-lg border p-3"><Field.Legend>{s.catLegend}</Field.Legend><RadioGroup.Root bind:value={cat} class="flex gap-3"><div class="flex items-center gap-2"><RadioGroup.Item value="umum" id="c1"/><label for="c1" class="text-sm">{s.catGeneral}</label></div><div class="flex items-center gap-2"><RadioGroup.Item value="promo" id="c2"/><label for="c2" class="text-sm">{s.catPromo}</label></div></RadioGroup.Root><label class="mt-2 flex items-center gap-2 text-sm"><Checkbox/> {s.insertSig}</label><label class="mt-1 flex items-center gap-2 text-sm"><Switch bind:checked={active}/> {s.active}</label></Field.Set>
        <div class="flex gap-2"><Button size="sm" onclick={save}>{editing?s.update:s.save}</Button>{#if editing}<Button size="sm" variant="ghost" onclick={()=>{editing=null;name='';tsubject='';tbody='';}}>{s.cancel}</Button>{/if}</div>
      </Field.FieldGroup>
    </Card.Content></Card.Root>
  </Card.Content>
</Card.Root>
<Dialog.Root open={use!=null} onOpenChange={(o)=>{if(!o)use=null;}}><Dialog.Content><Dialog.Header><Dialog.Title>{use?.name}</Dialog.Title></Dialog.Header><Textarea readonly value={use?.body??''} rows={5}/></Dialog.Content></Dialog.Root>
<AlertDialog.Root open={del!=null} onOpenChange={(o)=>{if(!o)del=null;}}><AlertDialog.Content><AlertDialog.Header><AlertDialog.Title>{s.delTitle}</AlertDialog.Title></AlertDialog.Header><AlertDialog.Footer><AlertDialog.Cancel>{s.cancel}</AlertDialog.Cancel><AlertDialog.Action onclick={()=>{rows=rows.filter(r=>r.id!==del);del=null;toast.success(s.deletedToast);}}>{s.delBtn}</AlertDialog.Action></AlertDialog.Footer></AlertDialog.Content></AlertDialog.Root>
