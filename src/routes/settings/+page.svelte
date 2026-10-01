<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as ToggleGroup from '$lib/components/ui/toggle-group';
	import * as Empty from '$lib/components/ui/empty';
	import * as Alert from '$lib/components/ui/alert';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as Select from '$lib/components/ui/select';
	import * as Table from '$lib/components/ui/table';
	import * as Pagination from '$lib/components/ui/pagination';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Switch } from '$lib/components/ui/switch';
	import { Slider } from '$lib/components/ui/slider';
	import DatePicker from "$lib/components/ui/date-picker.svelte";
	import { CalendarDate, type DateValue } from '@internationalized/date';

	import { toast } from 'svelte-sonner';
	import { Settings, Mail, Send, LayoutTemplate, Search, CircleCheck, TriangleAlert, KeyRound, History } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'Company Settings — DK UI Kit', menuT: 'Settings Menu',
			menuD: 'General · email · blasting · form builder · master data.',
			mGeneral: 'General', mGeneralD: 'Common configuration',
			mEmail: 'Email Setting', mEmailD: 'SMTP dan autoreply',
			mBlast: 'Outbound Blasting', mBlastD: 'Template dan blast',
			mForm: 'Form Builder Ticket', mFormD: 'Custom field form',
			quotaUsed: 'Kuota blast terpakai',
			gT: 'General Settings', gD: 'Modul perusahaan, user, channel, dan PBX.',
			modulesUnit: 'modul', fMod: 'Cari modul', fModPh: 'Cari modul setting…',
			viewMode: 'Mode tampilan', grid: 'Grid kartu', list: 'Daftar',
			manage: 'Kelola', openBtn: 'Buka', viewHist: 'Lihat riwayat',
			toastModule: 'Membuka modul', toastTemplate: 'Membuka template', toastHist: 'Membuka riwayat blast', toastForm: 'Membuka form',
			emptyModT: 'Modul tidak ditemukan', emptyModPre: 'Tidak ada modul',
			dUser: 'Kelola user & peran', dGroup: 'Aturan routing grup', dDiv: 'Kelola divisi user',
			dConfig: 'Kelola konfigurasi', dChannel: 'Kelola channel', dBot: 'Kelola bot',
			dPbx: 'Kelola konfigurasi PBX', dKirana: 'Sync & batch manual',
			alertSmtpT: 'SMTP terhubung', alertRelay: 'Relay utama merespons dalam 240ms. Autoreply',
			active: 'Aktif', inactive: 'Nonaktif',
			emailT: 'Email Setting', emailD: 'SMTP dan autoreply email (tiruan partial email-setting-cards).',
			testBtn: 'Uji',
			dSmtp: 'Kelola SMTP email', dAuto: 'Autoreply di luar jam operasional', dEmail: 'Kelola konfigurasi email',
			ctrlT: 'Kontrol layanan email', smtpL: 'Relay SMTP', smtpD: 'Aktifkan pengiriman keluar.',
			autoL: 'Autoreply luar jam kerja', autoD: 'Balas otomatis malam hari.',
			limitPre: 'Batas kirim per jam:', limitD: 'Geser untuk simulasi kuota.',
			schedL: 'Jadwal deploy config', schedPh: 'Pilih tanggal deploy',
			bT: 'Outbound Blasting', bD: 'Template WA HSM, template email, dan riwayat eksekusi.',
			waTab: 'WhatsApp', emailTab: 'Email', dataTab: 'Data & History',
			waT: 'WhatsApp Blasting', waD: '— template HSM, plain text, dan blast official.',
			emailBT: 'Email Blasting', emailBD: '— template, variabel, dan batch blast.',
			dataT: 'Data & History', dataDD: '— dataset import dan riwayat semua channel.',
			dTmplCat: 'Mapping variabel template HSM', dHsm: 'Buat, submit, sinkron template Meta',
			dBlastWa: 'Kirim via template HSM disetujui',
			dEmailCat: 'Mapping variabel blast email', dEmailTmpl: 'Buat template email blasting',
			dBlastEmail: 'Kirim batch email dari data import',
			dImport: 'Siapkan dataset blast WA & email', dHist: 'Riwayat eksekusi blast outbound',
			histT: 'Blast history', histPre: 'batch · target vs terkirim.', audit: 'Audit',
			hID: 'ID', hChannel: 'Channel', hTemplate: 'Template', hTarget: 'Target', hSent: 'Terkirim', hDate: 'Tanggal', hStatus: 'Status',
			usageT: 'Pemakaian channel', usageD: 'Persentase kuota blast.',
			formT: 'Form Builder Ticket', formD: 'Status, prioritas, kategori, jenis, field, dan komponen.',
			fStatusD: 'Kelola status', fPrioD: 'Kelola prioritas', fCatD: 'Kategori form',
			fJenisD: 'Jenis per kategori', fFieldD: 'Field setiap jenis', fCompD: 'Komponen field',
			emptyFieldT: 'Belum ada field', emptyFieldD: 'Tambahkan field pertama untuk jenis pengaduan.',
			apiT: 'Butuh API key blast?', apiD: 'Gunakan PIN otorisasi 6 digit di halaman SPV sebelum menjalankan blast massal.',
			keyEx: 'Contoh kunci:',
			dlgT: 'Uji koneksi email', dlgD: 'Kirim email percobaan untuk memverifikasi relay SMTP.',
			sendTo: 'Kirim ke', cancel: 'Batal', sendTest: 'Kirim uji'
		},
		en: {
			docTitle: 'Company Settings — DK UI Kit', menuT: 'Settings Menu',
			menuD: 'General · email · blasting · form builder · master data.',
			mGeneral: 'General', mGeneralD: 'Common configuration',
			mEmail: 'Email Settings', mEmailD: 'SMTP and autoreply',
			mBlast: 'Outbound Blasting', mBlastD: 'Templates and blasts',
			mForm: 'Ticket Form Builder', mFormD: 'Custom form fields',
			quotaUsed: 'Blast quota used',
			gT: 'General Settings', gD: 'Company modules, users, channels, and PBX.',
			modulesUnit: 'modules', fMod: 'Search modules', fModPh: 'Search setting modules…',
			viewMode: 'View mode', grid: 'Card grid', list: 'List',
			manage: 'Manage', openBtn: 'Open', viewHist: 'View history',
			toastModule: 'Opening module', toastTemplate: 'Opening template', toastHist: 'Opening blast history', toastForm: 'Opening form',
			emptyModT: 'Module not found', emptyModPre: 'No module',
			dUser: 'Manage users & roles', dGroup: 'Group routing rules', dDiv: 'Manage user divisions',
			dConfig: 'Manage configuration', dChannel: 'Manage channels', dBot: 'Manage bots',
			dPbx: 'Manage PBX configuration', dKirana: 'Manual sync & batch',
			alertSmtpT: 'SMTP connected', alertRelay: 'Primary relay responding in 240ms. Autoreply',
			active: 'Active', inactive: 'Inactive',
			emailT: 'Email Settings', emailD: 'SMTP and email autoreply (partial email-setting-cards mock).',
			testBtn: 'Test',
			dSmtp: 'Manage email SMTP', dAuto: 'Autoreply outside operating hours', dEmail: 'Manage email configuration',
			ctrlT: 'Email service controls', smtpL: 'SMTP relay', smtpD: 'Enable outbound delivery.',
			autoL: 'After-hours autoreply', autoD: 'Auto-reply at night.',
			limitPre: 'Hourly send limit:', limitD: 'Slide to simulate quota.',
			schedL: 'Config deploy schedule', schedPh: 'Select deploy date',
			bT: 'Outbound Blasting', bD: 'WA HSM templates, email templates, and execution history.',
			waTab: 'WhatsApp', emailTab: 'Email', dataTab: 'Data & History',
			waT: 'WhatsApp Blasting', waD: '— HSM templates, plain text, and official blasts.',
			emailBT: 'Email Blasting', emailBD: '— templates, variables, and batch blasts.',
			dataT: 'Data & History', dataDD: '— import datasets and all-channel history.',
			dTmplCat: 'HSM template variable mapping', dHsm: 'Create, submit, sync Meta templates',
			dBlastWa: 'Send via approved HSM templates',
			dEmailCat: 'Email blast variable mapping', dEmailTmpl: 'Create email blasting templates',
			dBlastEmail: 'Send batch emails from imported data',
			dImport: 'Prepare WA & email blast datasets', dHist: 'Outbound blast execution history',
			histT: 'Blast history', histPre: 'batches · target vs sent.', audit: 'Audit',
			hID: 'ID', hChannel: 'Channel', hTemplate: 'Template', hTarget: 'Target', hSent: 'Sent', hDate: 'Date', hStatus: 'Status',
			usageT: 'Channel usage', usageD: 'Blast quota percentage.',
			formT: 'Ticket Form Builder', formD: 'Status, priority, category, type, fields, and components.',
			fStatusD: 'Manage statuses', fPrioD: 'Manage priorities', fCatD: 'Form categories',
			fJenisD: 'Types per category', fFieldD: 'Fields per type', fCompD: 'Field components',
			emptyFieldT: 'No fields yet', emptyFieldD: 'Add the first field for the complaint type.',
			apiT: 'Need a blast API key?', apiD: 'Use the 6-digit authorization PIN on the SPV page before running mass blasts.',
			keyEx: 'Example keys:',
			dlgT: 'Test email connection', dlgD: 'Send a trial email to verify the SMTP relay.',
			sendTo: 'Send to', cancel: 'Cancel', sendTest: 'Send test'
		},
		th: {
			docTitle: 'ตั้งค่าบริษัท — DK UI Kit', menuT: 'เมนูตั้งค่า',
			menuD: 'ทั่วไป · อีเมล · บลาสต์ · ตัวสร้างฟอร์ม · ข้อมูลหลัก',
			mGeneral: 'ทั่วไป', mGeneralD: 'การกำหนดค่าทั่วไป',
			mEmail: 'ตั้งค่าอีเมล', mEmailD: 'SMTP และการตอบอัตโนมัติ',
			mBlast: 'บลาสต์ขาออก', mBlastD: 'เทมเพลตและบลาสต์',
			mForm: 'ตัวสร้างฟอร์มตั๋ว', mFormD: 'ฟิลด์ฟอร์มแบบกำหนดเอง',
			quotaUsed: 'ใช้โควตาบลาสต์แล้ว',
			gT: 'ตั้งค่าทั่วไป', gD: 'โมดูลบริษัท ผู้ใช้ ช่องทาง และ PBX',
			modulesUnit: 'โมดูล', fMod: 'ค้นหาโมดูล', fModPh: 'ค้นหาโมดูลตั้งค่า…',
			viewMode: 'โหมดแสดงผล', grid: 'กริดการ์ด', list: 'รายการ',
			manage: 'จัดการ', openBtn: 'เปิด', viewHist: 'ดูประวัติ',
			toastModule: 'กำลังเปิดโมดูล', toastTemplate: 'กำลังเปิดเทมเพลต', toastHist: 'กำลังเปิดประวัติบลาสต์', toastForm: 'กำลังเปิดฟอร์ม',
			emptyModT: 'ไม่พบโมดูล', emptyModPre: 'ไม่มีโมดูล',
			dUser: 'จัดการผู้ใช้ & บทบาท', dGroup: 'กฎการกำหนดเส้นทางกลุ่ม', dDiv: 'จัดการแผนกผู้ใช้',
			dConfig: 'จัดการการกำหนดค่า', dChannel: 'จัดการช่องทาง', dBot: 'จัดการบอท',
			dPbx: 'จัดการการกำหนดค่า PBX', dKirana: 'ซิงก์ & แบทช์แบบแมนนวล',
			alertSmtpT: 'เชื่อมต่อ SMTP แล้ว', alertRelay: 'รีเลย์หลักตอบสนองใน 240ms การตอบอัตโนมัติ',
			active: 'ใช้งาน', inactive: 'ไม่ใช้งาน',
			emailT: 'ตั้งค่าอีเมล', emailD: 'SMTP และการตอบอัตโนมัติ (จำลองบางส่วน)',
			testBtn: 'ทดสอบ',
			dSmtp: 'จัดการ SMTP อีเมล', dAuto: 'ตอบอัตโนมัตินอกเวลาทำการ', dEmail: 'จัดการการกำหนดค่าอีเมล',
			ctrlT: 'ควบคุมบริการอีเมล', smtpL: 'รีเลย์ SMTP', smtpD: 'เปิดการส่งออก',
			autoL: 'ตอบอัตโนมัตินอกเวลางาน', autoD: 'ตอบอัตโนมัติตอนกลางคืน',
			limitPre: 'จำกัดการส่งต่อชั่วโมง:', limitD: 'เลื่อนเพื่อจำลองโควต้า',
			schedL: 'กำหนดการ deploy', schedPh: 'เลือกวันที่ deploy',
			bT: 'บลาสต์ขาออก', bD: 'เทมเพลต WA HSM เทมเพลตอีเมล และประวัติการดำเนินการ',
			waTab: 'WhatsApp', emailTab: 'อีเมล', dataTab: 'ข้อมูล & ประวัติ',
			waT: 'บลาสต์ WhatsApp', waD: '— เทมเพลต HSM ข้อความธรรมดา และบลาสต์ทางการ',
			emailBT: 'บลาสต์อีเมล', emailBD: '— เทมเพลต ตัวแปร และแบทช์บลาสต์',
			dataT: 'ข้อมูล & ประวัติ', dataDD: '— ชุดข้อมูลนำเข้าและประวัติทุกช่องทาง',
			dTmplCat: 'แมปตัวแปรเทมเพลต HSM', dHsm: 'สร้าง ส่ง ซิงก์เทมเพลต Meta',
			dBlastWa: 'ส่งผ่านเทมเพลต HSM ที่อนุมัติ',
			dEmailCat: 'แมปตัวแปรบลาสต์อีเมล', dEmailTmpl: 'สร้างเทมเพลตบลาสต์อีเมล',
			dBlastEmail: 'ส่งอีเมลแบทช์จากข้อมูลนำเข้า',
			dImport: 'เตรียมชุดข้อมูลบลาสต์ WA & อีเมล', dHist: 'ประวัติการบลาสต์ขาออก',
			histT: 'ประวัติบลาสต์', histPre: 'แบทช์ · เป้าหมาย vs ส่งแล้ว', audit: 'ตรวจสอบ',
			hID: 'ID', hChannel: 'ช่องทาง', hTemplate: 'เทมเพลต', hTarget: 'เป้าหมาย', hSent: 'ส่งแล้ว', hDate: 'วันที่', hStatus: 'สถานะ',
			usageT: 'การใช้ช่องทาง', usageD: 'เปอร์เซ็นต์โควตาบลาสต์',
			formT: 'ตัวสร้างฟอร์มตั๋ว', formD: 'สถานะ ลำดับความสำคัญ หมวดหมู่ ประเภท ฟิลด์ และคอมโพเนนต์',
			fStatusD: 'จัดการสถานะ', fPrioD: 'จัดการลำดับความสำคัญ', fCatD: 'หมวดหมู่ฟอร์ม',
			fJenisD: 'ประเภทต่อหมวดหมู่', fFieldD: 'ฟิลด์ต่อประเภท', fCompD: 'คอมโพเนนต์ฟิลด์',
			emptyFieldT: 'ยังไม่มีฟิลด์', emptyFieldD: 'เพิ่มฟิลด์แรกสำหรับประเภทข้อร้องเรียน',
			apiT: 'ต้องการ API key บลาสต์?', apiD: 'ใช้ PIN อนุมัติ 6 หลักที่หน้า SPV ก่อนรันบลาสต์จำนวนมาก',
			keyEx: 'ตัวอย่างคีย์:',
			dlgT: 'ทดสอบการเชื่อมต่ออีเมล', dlgD: 'ส่งอีเมลทดลองเพื่อยืนยันรีเลย์ SMTP',
			sendTo: 'ส่งถึง', cancel: 'ยกเลิก', sendTest: 'ส่งทดสอบ'
		},
		tl: {
			docTitle: 'Company Settings — DK UI Kit', menuT: 'Menu ng Settings',
			menuD: 'General · email · blasting · form builder · master data.',
			mGeneral: 'General', mGeneralD: 'Karaniwang configuration',
			mEmail: 'Email Setting', mEmailD: 'SMTP at autoreply',
			mBlast: 'Outbound Blasting', mBlastD: 'Template at blast',
			mForm: 'Form Builder ng Ticket', mFormD: 'Custom na form field',
			quotaUsed: 'Nagastos na blast quota',
			gT: 'General Settings', gD: 'Mga module ng kumpanya, user, channel, at PBX.',
			modulesUnit: 'module', fMod: 'Maghanap ng module', fModPh: 'Maghanap ng setting module…',
			viewMode: 'Mode ng display', grid: 'Card grid', list: 'Listahan',
			manage: 'Pamahalaan', openBtn: 'Buksan', viewHist: 'Tingnan ang kasaysayan',
			toastModule: 'Binubuksan ang module', toastTemplate: 'Binubuksan ang template', toastHist: 'Binubuksan ang blast history', toastForm: 'Binubuksan ang form',
			emptyModT: 'Hindi nahanap ang module', emptyModPre: 'Walang module',
			dUser: 'Pamahalaan ang user & tungkulin', dGroup: 'Mga panuntunan sa routing ng grupo', dDiv: 'Pamahalaan ang dibisyon ng user',
			dConfig: 'Pamahalaan ang configuration', dChannel: 'Pamahalaan ang channel', dBot: 'Pamahalaan ang bot',
			dPbx: 'Pamahalaan ang PBX configuration', dKirana: 'Manwal na sync & batch',
			alertSmtpT: 'Nakakonekta ang SMTP', alertRelay: 'Sumasagot ang pangunahing relay sa 240ms. Autoreply',
			active: 'Aktibo', inactive: 'Hindi aktibo',
			emailT: 'Email Setting', emailD: 'SMTP at email autoreply (partial na mock).',
			testBtn: 'Subukan',
			dSmtp: 'Pamahalaan ang email SMTP', dAuto: 'Autoreply sa labas ng oras ng operasyon', dEmail: 'Pamahalaan ang email configuration',
			ctrlT: 'Mga kontrol ng serbisyo ng email', smtpL: 'SMTP relay', smtpD: 'Paganahin ang outbound delivery.',
			autoL: 'Autoreply sa labas ng oras ng trabaho', autoD: 'Awtomatikong sumagot sa gabi.',
			limitPre: 'Limit sa pagpapadala kada oras:', limitD: 'I-slide upang gayahin ang quota.',
			schedL: 'Iskedyul ng deploy', schedPh: 'Pumili ng petsa ng deploy',
			bT: 'Outbound Blasting', bD: 'Mga WA HSM template, email template, at kasaysayan.',
			waTab: 'WhatsApp', emailTab: 'Email', dataTab: 'Data & History',
			waT: 'WhatsApp Blasting', waD: '— HSM template, plain text, at official blast.',
			emailBT: 'Email Blasting', emailBD: '— template, variable, at batch blast.',
			dataT: 'Data & History', dataDD: '— import dataset at kasaysayan ng lahat ng channel.',
			dTmplCat: 'Mapping ng HSM template variable', dHsm: 'Gumawa, mag-submit, mag-sync ng Meta template',
			dBlastWa: 'Magpadala via aprubadong HSM template',
			dEmailCat: 'Mapping ng email blast variable', dEmailTmpl: 'Gumawa ng email blasting template',
			dBlastEmail: 'Magpadala ng batch email mula sa import data',
			dImport: 'Ihanda ang WA & email blast dataset', dHist: 'Kasaysayan ng outbound blast',
			histT: 'Blast history', histPre: 'batch · target vs naipadala.', audit: 'Audit',
			hID: 'ID', hChannel: 'Channel', hTemplate: 'Template', hTarget: 'Target', hSent: 'Naipadala', hDate: 'Petsa', hStatus: 'Status',
			usageT: 'Paggamit ng channel', usageD: 'Porsyento ng blast quota.',
			formT: 'Form Builder ng Ticket', formD: 'Status, prayoridad, kategorya, uri, field, at component.',
			fStatusD: 'Pamahalaan ang status', fPrioD: 'Pamahalaan ang prayoridad', fCatD: 'Mga kategorya ng form',
			fJenisD: 'Uri bawat kategorya', fFieldD: 'Field bawat uri', fCompD: 'Mga component ng field',
			emptyFieldT: 'Wala pang field', emptyFieldD: 'Idagdag ang unang field para sa uri ng reklamo.',
			apiT: 'Kailangan ng blast API key?', apiD: 'Gamitin ang 6-digit authorization PIN sa pahina ng SPV bago mag-mass blast.',
			keyEx: 'Halimbawang key:',
			dlgT: 'Subukan ang koneksyon ng email', dlgD: 'Magpadala ng trial email upang i-verify ang SMTP relay.',
			sendTo: 'Ipadala sa', cancel: 'Kanselahin', sendTest: 'Magpadala ng pagsubok'
		}
	} as const;
	let s = $derived(STR[$locale]);

	let tab = $state('general');
	let blastView: string | undefined = $state('wa');
	let search = $state('');
	let quota = $state(65);
	let smtpOn = $state(true);
	let autoreplyOn = $state(false);
	let testOpen = $state(false);
	let page = $state(1);
	let deployDate = $state<DateValue | undefined>(new CalendarDate(2026, 10, 5));
	const perPage = 4;

	let generalCards = $derived([
		{ title: 'User Management', desc: s.dUser, tag: 'General' },
		{ title: 'Group Route', desc: s.dGroup, tag: 'General' },
		{ title: 'User Divisions', desc: s.dDiv, tag: 'General' },
		{ title: 'Config', desc: s.dConfig, tag: 'General' },
		{ title: 'Channel', desc: s.dChannel, tag: 'General' },
		{ title: 'Bot Interaction', desc: s.dBot, tag: 'General' },
		{ title: 'Config PBX', desc: s.dPbx, tag: 'General' },
		{ title: 'Kirana Execute Manual', desc: s.dKirana, tag: 'General' }
	]);
	let emailCards = $derived([
		{ title: 'Config SMTP', desc: s.dSmtp, auto: false },
		{ title: 'Config Autoreply Email', desc: s.dAuto, auto: true },
		{ title: 'Config Email', desc: s.dEmail, auto: false }
	]);
	let waCards = $derived([
		{ title: 'Template Category & Variables', desc: s.dTmplCat },
		{ title: 'HSM Message Templates', desc: s.dHsm },
		{ title: 'Blast WhatsApp', desc: s.dBlastWa }
	]);
	let emailBlastCards = $derived([
		{ title: 'Email Category & Variables', desc: s.dEmailCat },
		{ title: 'Outbound Email Templates', desc: s.dEmailTmpl },
		{ title: 'Blast Email', desc: s.dBlastEmail }
	]);
	let dataCards = $derived([
		{ title: 'Import Data', desc: s.dImport },
		{ title: 'Blast History', desc: s.dHist, hist: true }
	]);
	let formCards = $derived([
		{ title: 'Status', desc: s.fStatusD },
		{ title: 'Priority', desc: s.fPrioD },
		{ title: 'Kategori', desc: s.fCatD },
		{ title: 'Jenis Pengaduan', desc: s.fJenisD },
		{ title: 'Field', desc: s.fFieldD },
		{ title: 'Components', desc: s.fCompD }
	]);
	let menuItems = $derived([
		{ id: 'general', label: s.mGeneral, desc: s.mGeneralD, icon: Settings },
		{ id: 'email', label: s.mEmail, desc: s.mEmailD, icon: Mail },
		{ id: 'blasting', label: s.mBlast, desc: s.mBlastD, icon: Send },
		{ id: 'form', label: s.mForm, desc: s.mFormD, icon: LayoutTemplate }
	]);
	const history = [
		{ id: 'BL-2041', channel: 'WhatsApp', template: 'promo_okt', target: 1250, sent: 1218, date: '28 Sep 2026', status: 'Selesai' },
		{ id: 'BL-2040', channel: 'Email', template: 'invoice_reminder', target: 860, sent: 841, date: '27 Sep 2026', status: 'Selesai' },
		{ id: 'BL-2039', channel: 'WhatsApp', template: 'otp_notice', target: 2400, sent: 1802, date: '26 Sep 2026', status: 'Berjalan' },
		{ id: 'BL-2038', channel: 'Email', template: 'survey_csat', target: 430, sent: 96, date: '25 Sep 2026', status: 'Gagal' },
		{ id: 'BL-2037', channel: 'WhatsApp', template: 'jadwal_maintenance', target: 975, sent: 960, date: '24 Sep 2026', status: 'Selesai' }
	];
	const historyFiltered = $derived(history.filter((h) => !search.trim() || `${h.id} ${h.template} ${h.channel}`.toLowerCase().includes(search.trim().toLowerCase())));
	const pageCount = $derived(Math.max(1, Math.ceil(historyFiltered.length / perPage)));
	const safePage = $derived(Math.min(page, pageCount));
	const pageRows = $derived(historyFiltered.slice((safePage - 1) * perPage, safePage * perPage));
	const usage = [
		{ label: 'WA', value: 78 }, { label: 'Email', value: 52 }, { label: 'HSM', value: 64 }
	];


	function filteredCards(list: { title: string; desc: string }[]) {
		const q = search.trim().toLowerCase();
		if (!q) return list;
		return list.filter((c) => `${c.title} ${c.desc}`.toLowerCase().includes(q));
	}
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6 lg:flex-row">
	<Card.Root class="w-full shrink-0 lg:w-80">
		<Card.Header><Card.Title class="flex items-center gap-2"><Settings size={17} />{s.menuT}</Card.Title><p class="text-sm text-muted-foreground">{s.menuD}</p></Card.Header>
		<Card.Content class="flex flex-col gap-1">
			{#each menuItems as m}
				<button type="button" onclick={() => (tab = m.id)} class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition-colors {tab === m.id ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-foreground'}">
					<m.icon size={19} class="mt-0.5 shrink-0" /><span><span class="block text-sm font-medium">{m.label}</span><span class="block text-xs opacity-70">{m.desc}</span></span>
				</button>
			{/each}
			<Separator class="my-2" />
			<div class="rounded-xl bg-muted/40 p-3 text-xs"><div class="mb-2 flex justify-between"><span class="text-muted-foreground">{s.quotaUsed}</span><span class="font-semibold">{quota}%</span></div><Progress value={quota} /></div>
		</Card.Content>
	</Card.Root>

	<div class="flex-1">
		<Tabs.Root bind:value={tab}>

			<Tabs.Content value="general" class="mt-0">
				<Card.Root>
					<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>{s.gT}</Card.Title><p class="mt-1 text-sm text-muted-foreground">{s.gD}</p></div><Badge variant="secondary">{generalCards.length} {s.modulesUnit}</Badge></Card.Header>
					<Card.Content>
						<Field.FieldGroup class="mb-4 grid gap-3 md:grid-cols-[1fr_auto]">
							<Field.Field><Field.Label for="set-q">{s.fMod}</Field.Label><div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="set-q" bind:value={search} placeholder={s.fModPh} class="pl-8" /></div></Field.Field>
							<Field.Field><Field.Label>{s.viewMode}</Field.Label>
								<Select.Root type="single" value="grid"><Select.Trigger><Select.Value placeholder={s.grid} /></Select.Trigger><Select.Content><Select.Item value="grid">{s.grid}</Select.Item><Select.Item value="list">{s.list}</Select.Item></Select.Content></Select.Root>
							</Field.Field>
						</Field.FieldGroup>
						{#if filteredCards(generalCards).length > 0}
							<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
								{#each filteredCards(generalCards) as c}
									<Card.Root class="transition-shadow hover:shadow-md"><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success(s.toastModule)}>{s.manage}</Button></Card.Content></Card.Root>
								{/each}
							</div>
						{:else}
							<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><Search size={20} /></Empty.Media><Empty.Title>{s.emptyModT}</Empty.Title><Empty.Description>{s.emptyModPre} “{search}”.</Empty.Description></Empty.Header></Empty.Root>
						{/if}
					</Card.Content>
				</Card.Root>
			</Tabs.Content>

			<Tabs.Content value="email" class="mt-0">
				<div class="flex flex-col gap-4">
					<Alert.Root variant="success"><CircleCheck /><Alert.Title>{s.alertSmtpT}</Alert.Title><Alert.Description>{s.alertRelay} {autoreplyOn ? s.active.toLowerCase() : s.inactive.toLowerCase()}.</Alert.Description></Alert.Root>
					<Card.Root>
						<Card.Header><Card.Title>{s.emailT}</Card.Title><p class="text-sm text-muted-foreground">{s.emailD}</p></Card.Header>
						<Card.Content class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
							{#each emailCards as c}
								<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header>
								<Card.Content class="flex items-center justify-between"><Badge variant={c.auto ? (autoreplyOn ? 'success' : 'secondary') : smtpOn ? 'success' : 'secondary'}>{c.auto ? (autoreplyOn ? s.active : s.inactive) : smtpOn ? s.active : s.inactive}</Badge><Button size="sm" variant="outline" onclick={() => (testOpen = true)}>{s.testBtn}</Button></Card.Content></Card.Root>
							{/each}
						</Card.Content>
					</Card.Root>
					<Card.Root>
						<Card.Header><Card.Title>{s.ctrlT}</Card.Title></Card.Header>
						<Card.Content>
							<Field.FieldGroup class="grid gap-4 md:grid-cols-2">
								<Field.Field><div class="flex items-center justify-between rounded-xl border p-3"><div><Field.Label>{s.smtpL}</Field.Label><Field.Description>{s.smtpD}</Field.Description></div><Switch bind:checked={smtpOn} /></div></Field.Field>
								<Field.Field><div class="flex items-center justify-between rounded-xl border p-3"><div><Field.Label>{s.autoL}</Field.Label><Field.Description>{s.autoD}</Field.Description></div><Switch bind:checked={autoreplyOn} /></div></Field.Field>
								<Field.Field><Field.Label>{s.limitPre} {quota * 10}</Field.Label><Slider type="single" bind:value={quota} min={10} max={100} step={5} /><Field.Description>{s.limitD}</Field.Description></Field.Field>
								<Field.Field><Field.Label>{s.schedL}</Field.Label><DatePicker bind:value={deployDate} label={s.schedL} placeholder={s.schedPh} /></Field.Field>
							</Field.FieldGroup>
						</Card.Content>
					</Card.Root>
				</div>
			</Tabs.Content>

			<Tabs.Content value="blasting" class="mt-0">
				<div class="flex flex-col gap-4">
					<Card.Root>
						<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>{s.bT}</Card.Title><p class="mt-1 text-sm text-muted-foreground">{s.bD}</p></div>
						<ToggleGroup.Root type="single" bind:value={blastView}><ToggleGroup.Item value="wa">{s.waTab}</ToggleGroup.Item><ToggleGroup.Item value="email">{s.emailTab}</ToggleGroup.Item><ToggleGroup.Item value="data">{s.dataTab}</ToggleGroup.Item></ToggleGroup.Root></Card.Header>
						<Card.Content>
							{#if blastView === 'wa'}
								<p class="mb-3 text-sm font-medium">{s.waT} <span class="font-normal text-muted-foreground">{s.waD}</span></p>
								<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">{#each filteredCards(waCards) as c}<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success(s.toastTemplate)}>{s.openBtn}</Button></Card.Content></Card.Root>{/each}</div>
							{:else if blastView === 'email'}
								<p class="mb-3 text-sm font-medium">{s.emailBT} <span class="font-normal text-muted-foreground">{s.emailBD}</span></p>
								<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">{#each filteredCards(emailBlastCards) as c}<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success(s.toastTemplate)}>{s.openBtn}</Button></Card.Content></Card.Root>{/each}</div>
							{:else}
								<p class="mb-3 text-sm font-medium">{s.dataT} <span class="font-normal text-muted-foreground">{s.dataDD}</span></p>
								<div class="grid grid-cols-1 gap-3 sm:grid-cols-2">{#each dataCards as c}<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success(s.toastHist)}>{'hist' in c && c.hist ? s.viewHist : s.manage}</Button></Card.Content></Card.Root>{/each}</div>
							{/if}
						</Card.Content>
					</Card.Root>

					<div class="grid gap-4 lg:grid-cols-[1fr_320px]">
						<Card.Root>
							<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>{s.histT}</Card.Title><p class="mt-1 text-sm text-muted-foreground">{historyFiltered.length} {s.histPre}</p></div><Badge variant="secondary"><History size={12} />{s.audit}</Badge></Card.Header>
							<Card.Content>
								<div class="overflow-x-auto rounded-xl border">
									<Table.Root><Table.Header><Table.Row><Table.Head>{s.hID}</Table.Head><Table.Head>{s.hChannel}</Table.Head><Table.Head>{s.hTemplate}</Table.Head><Table.Head class="text-right">{s.hTarget}</Table.Head><Table.Head class="text-right">{s.hSent}</Table.Head><Table.Head>{s.hDate}</Table.Head><Table.Head>{s.hStatus}</Table.Head></Table.Row></Table.Header>
									<Table.Body>{#each pageRows as h}<Table.Row><Table.Cell class="font-mono text-xs">{h.id}</Table.Cell><Table.Cell><Badge variant="outline">{h.channel}</Badge></Table.Cell><Table.Cell class="font-mono text-xs">{h.template}</Table.Cell><Table.Cell class="text-right">{h.target.toLocaleString('id-ID')}</Table.Cell><Table.Cell class="text-right">{h.sent.toLocaleString('id-ID')}</Table.Cell><Table.Cell>{h.date}</Table.Cell><Table.Cell><Badge variant={h.status === 'Selesai' ? 'success' : h.status === 'Berjalan' ? 'warning' : 'destructive'}>{h.status}</Badge></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
								</div>
								<div class="mt-3 flex flex-col gap-2">{#each pageRows as h}<div><div class="flex justify-between text-xs"><span class="text-muted-foreground">{h.id}</span><span class="font-medium">{Math.round((h.sent / Math.max(1, h.target)) * 100)}%</span></div><Progress value={(h.sent / Math.max(1, h.target)) * 100} /></div>{/each}</div>
								<div class="mt-4 flex justify-center">
									<Pagination.Root bind:page count={historyFiltered.length} perPage={perPage} siblingCount={1}>
										{#snippet children({ pages })}
											<Pagination.Content>
												<Pagination.Item><Pagination.Previous /></Pagination.Item>
												{#each pages as p (p.key)}{#if p.type === 'ellipsis'}<Pagination.Item><Pagination.Ellipsis /></Pagination.Item>{:else}<Pagination.Item><Pagination.Link page={p.value} isActive={safePage === p.value}>{p.value}</Pagination.Link></Pagination.Item>{/if}{/each}
												<Pagination.Item><Pagination.Next /></Pagination.Item>
											</Pagination.Content>
										{/snippet}
									</Pagination.Root>
								</div>
							</Card.Content>
						</Card.Root>
						<Card.Root>
							<Card.Header><Card.Title>{s.usageT}</Card.Title><p class="text-sm text-muted-foreground">{s.usageD}</p></Card.Header>
							<Card.Content>
								<div class="flex flex-wrap gap-2">{#each usage as u}<Badge variant="outline">{u.label}: {u.value}%</Badge>{/each}</div>
								<Separator class="my-3" />
								{#each usage as u}<div class="mb-2 flex items-center justify-between text-xs"><span class="text-muted-foreground">{u.label}</span><span class="font-semibold">{u.value}%</span></div><Progress value={u.value} class="mb-3" />{/each}
							</Card.Content>
						</Card.Root>
					</div>
				</div>
			</Tabs.Content>

			<Tabs.Content value="form" class="mt-0">
				<Card.Root>
					<Card.Header><Card.Title>{s.formT}</Card.Title><p class="text-sm text-muted-foreground">{s.formD}</p></Card.Header>
					<Card.Content>
						{#if filteredCards(formCards).length > 0}
							<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
								{#each filteredCards(formCards) as c}
									<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success(s.toastForm)}>{s.manage}</Button></Card.Content></Card.Root>
								{/each}
							</div>
						{:else}
							<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><LayoutTemplate size={20} /></Empty.Media><Empty.Title>{s.emptyFieldT}</Empty.Title><Empty.Description>{s.emptyFieldD}</Empty.Description></Empty.Header></Empty.Root>
						{/if}
						<Alert.Root variant="warning" class="mt-4"><TriangleAlert /><Alert.Title>{s.apiT}</Alert.Title><Alert.Description>{s.apiD}</Alert.Description></Alert.Root>
						<div class="mt-3 flex items-center gap-2 text-xs text-muted-foreground"><KeyRound size={14} /><span>{s.keyEx} WA-HSM-****-OKT · SMTP-RELAY-****</span></div>
					</Card.Content>
				</Card.Root>
			</Tabs.Content>
		</Tabs.Root>
	</div>

	<Dialog.Root bind:open={testOpen}>
		<Dialog.Content>
			<Dialog.Header><Dialog.Title>{s.dlgT}</Dialog.Title><Dialog.Description>{s.dlgD}</Dialog.Description></Dialog.Header>
			<Field.FieldGroup class="grid gap-3">
				<Field.Field><Field.Label for="smtp-to">{s.sendTo}</Field.Label><Input id="smtp-to" placeholder="ops@example.co.id" /></Field.Field>
			</Field.FieldGroup>
			<Dialog.Footer><Button size="sm" variant="outline" onclick={() => (testOpen = false)}>{s.cancel}</Button><Button size="sm" onclick={() => (testOpen = false)}><CircleCheck data-icon="inline-start" />{s.sendTest}</Button></Dialog.Footer>
		</Dialog.Content>
	</Dialog.Root>
</div>
