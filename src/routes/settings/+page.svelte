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
	import { Calendar } from '$lib/components/ui/calendar';
	import { CalendarDate } from '@internationalized/date';

	import { toast } from 'svelte-sonner';
	import { Settings, Mail, Send, LayoutTemplate, Search, CircleCheck, TriangleAlert, KeyRound, History } from 'lucide-svelte';

	let tab = $state('general');
	let blastView: string | undefined = $state('wa');
	let search = $state('');
	let quota = $state(65);
	let smtpOn = $state(true);
	let autoreplyOn = $state(false);
	let testOpen = $state(false);
	let page = $state(1);
	let deployDate = $state<CalendarDate | undefined>(new CalendarDate(2026, 10, 5));
	const perPage = 4;

	const generalCards = [
		{ title: 'User Management', desc: 'Kelola user & peran', tag: 'General' },
		{ title: 'Group Route', desc: 'Aturan routing grup', tag: 'General' },
		{ title: 'User Divisions', desc: 'Kelola divisi user', tag: 'General' },
		{ title: 'Config', desc: 'Kelola konfigurasi', tag: 'General' },
		{ title: 'Channel', desc: 'Kelola channel', tag: 'General' },
		{ title: 'Bot Interaction', desc: 'Kelola bot', tag: 'General' },
		{ title: 'Config PBX', desc: 'Kelola konfigurasi PBX', tag: 'General' },
		{ title: 'Kirana Execute Manual', desc: 'Sync & batch manual', tag: 'General' }
	];
	const emailCards = [
		{ title: 'Config SMTP', desc: 'Kelola SMTP email', status: 'Aktif' },
		{ title: 'Config Autoreply Email', desc: 'Autoreply di luar jam operasional', status: 'Nonaktif' },
		{ title: 'Config Email', desc: 'Kelola konfigurasi email', status: 'Aktif' }
	];
	const waCards = [
		{ title: 'Template Category & Variables', desc: 'Mapping variabel template HSM' },
		{ title: 'HSM Message Templates', desc: 'Buat, submit, sinkron template Meta' },
		{ title: 'Blast WhatsApp', desc: 'Kirim via template HSM disetujui' }
	];
	const emailBlastCards = [
		{ title: 'Email Category & Variables', desc: 'Mapping variabel blast email' },
		{ title: 'Outbound Email Templates', desc: 'Buat template email blasting' },
		{ title: 'Blast Email', desc: 'Kirim batch email dari data import' }
	];
	const dataCards = [
		{ title: 'Import Data', desc: 'Siapkan dataset blast WA & email' },
		{ title: 'Blast History', desc: 'Riwayat eksekusi blast outbound' }
	];
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

<svelte:head><title>Company Settings — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6 lg:flex-row">
	<Card.Root class="w-full shrink-0 lg:w-80">
		<Card.Header><Card.Title class="flex items-center gap-2"><Settings size={17} />Settings Menu</Card.Title><p class="text-sm text-muted-foreground">General · email · blasting · form builder · master data.</p></Card.Header>
		<Card.Content class="flex flex-col gap-1">
			{#each [
				{ id: 'general', label: 'General', desc: 'Common configuration', icon: Settings },
				{ id: 'email', label: 'Email Setting', desc: 'SMTP dan autoreply', icon: Mail },
				{ id: 'blasting', label: 'Outbound Blasting', desc: 'Template dan blast', icon: Send },
				{ id: 'form', label: 'Form Builder Ticket', desc: 'Custom field form', icon: LayoutTemplate }
			] as m}
				<button type="button" onclick={() => (tab = m.id)} class="flex w-full items-start gap-3 rounded-xl p-3 text-left transition-colors {tab === m.id ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-foreground'}">
					<m.icon size={19} class="mt-0.5 shrink-0" /><span><span class="block text-sm font-medium">{m.label}</span><span class="block text-xs opacity-70">{m.desc}</span></span>
				</button>
			{/each}
			<Separator class="my-2" />
			<div class="rounded-xl bg-muted/40 p-3 text-xs"><div class="mb-2 flex justify-between"><span class="text-muted-foreground">Kuota blast terpakai</span><span class="font-semibold">{quota}%</span></div><Progress value={quota} /></div>
		</Card.Content>
	</Card.Root>

	<div class="flex-1">
		<Tabs.Root bind:value={tab}>
			<Tabs.List class="flex-wrap"><Tabs.Trigger value="general">General</Tabs.Trigger><Tabs.Trigger value="email">Email Setting</Tabs.Trigger><Tabs.Trigger value="blasting">Outbound Blasting</Tabs.Trigger><Tabs.Trigger value="form">Form Builder</Tabs.Trigger></Tabs.List>

			<Tabs.Content value="general" class="mt-4">
				<Card.Root>
					<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>General Settings</Card.Title><p class="mt-1 text-sm text-muted-foreground">Modul perusahaan, user, channel, dan PBX.</p></div><Badge variant="secondary">{generalCards.length} modul</Badge></Card.Header>
					<Card.Content>
						<Field.FieldGroup class="mb-4 grid gap-3 md:grid-cols-[1fr_auto]">
							<Field.Field><Field.Label for="set-q">Cari modul</Field.Label><div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="set-q" bind:value={search} placeholder="Cari modul setting…" class="pl-8" /></div></Field.Field>
							<Field.Field><Field.Label>Mode tampilan</Field.Label>
								<Select.Root type="single" value="grid"><Select.Trigger><Select.Value placeholder="Grid" /></Select.Trigger><Select.Content><Select.Item value="grid">Grid kartu</Select.Item><Select.Item value="list">Daftar</Select.Item></Select.Content></Select.Root>
							</Field.Field>
						</Field.FieldGroup>
						{#if filteredCards(generalCards).length > 0}
							<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
								{#each filteredCards(generalCards) as c}
									<Card.Root class="transition-shadow hover:shadow-md"><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success('Membuka modul')}>Kelola</Button></Card.Content></Card.Root>
								{/each}
							</div>
						{:else}
							<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><Search size={20} /></Empty.Media><Empty.Title>Modul tidak ditemukan</Empty.Title><Empty.Description>Tidak ada modul “{search}”.</Empty.Description></Empty.Header></Empty.Root>
						{/if}
					</Card.Content>
				</Card.Root>
			</Tabs.Content>

			<Tabs.Content value="email" class="mt-4">
				<div class="flex flex-col gap-4">
					<Alert.Root variant="success"><CircleCheck /><Alert.Title>SMTP terhubung</Alert.Title><Alert.Description>Relay utama merespons dalam 240ms. Autoreply {autoreplyOn ? 'aktif' : 'nonaktif'}.</Alert.Description></Alert.Root>
					<Card.Root>
						<Card.Header><Card.Title>Email Setting</Card.Title><p class="text-sm text-muted-foreground">SMTP dan autoreply email (tiruan partial email-setting-cards).</p></Card.Header>
						<Card.Content class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
							{#each emailCards as c}
								<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header>
								<Card.Content class="flex items-center justify-between"><Badge variant={c.title.includes('Autoreply') ? (autoreplyOn ? 'success' : 'secondary') : smtpOn ? 'success' : 'secondary'}>{c.title.includes('Autoreply') ? (autoreplyOn ? 'Aktif' : 'Nonaktif') : smtpOn ? 'Aktif' : 'Nonaktif'}</Badge><Button size="sm" variant="outline" onclick={() => (testOpen = true)}>Uji</Button></Card.Content></Card.Root>
							{/each}
						</Card.Content>
					</Card.Root>
					<Card.Root>
						<Card.Header><Card.Title>Kontrol layanan email</Card.Title></Card.Header>
						<Card.Content>
							<Field.FieldGroup class="grid gap-4 md:grid-cols-2">
								<Field.Field><div class="flex items-center justify-between rounded-xl border p-3"><div><Field.Label>Relay SMTP</Field.Label><Field.Description>Aktifkan pengiriman keluar.</Field.Description></div><Switch bind:checked={smtpOn} /></div></Field.Field>
								<Field.Field><div class="flex items-center justify-between rounded-xl border p-3"><div><Field.Label>Autoreply luar jam kerja</Field.Label><Field.Description>Balas otomatis malam hari.</Field.Description></div><Switch bind:checked={autoreplyOn} /></div></Field.Field>
								<Field.Field><Field.Label>Batas kirim per jam: {quota * 10}</Field.Label><Slider type="single" bind:value={quota} min={10} max={100} step={5} /><Field.Description>Geser untuk simulasi kuota.</Field.Description></Field.Field>
								<Field.Field><Field.Label>Jadwal deploy config</Field.Label><Calendar type="single" bind:value={deployDate} /></Field.Field>
							</Field.FieldGroup>
						</Card.Content>
					</Card.Root>
				</div>
			</Tabs.Content>

			<Tabs.Content value="blasting" class="mt-4">
				<div class="flex flex-col gap-4">
					<Card.Root>
						<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>Outbound Blasting</Card.Title><p class="mt-1 text-sm text-muted-foreground">Template WA HSM, template email, dan riwayat eksekusi.</p></div>
						<ToggleGroup.Root type="single" bind:value={blastView}><ToggleGroup.Item value="wa">WhatsApp</ToggleGroup.Item><ToggleGroup.Item value="email">Email</ToggleGroup.Item><ToggleGroup.Item value="data">Data & History</ToggleGroup.Item></ToggleGroup.Root></Card.Header>
						<Card.Content>
							{#if blastView === 'wa'}
								<p class="mb-3 text-sm font-medium">WhatsApp Blasting <span class="font-normal text-muted-foreground">— template HSM, plain text, dan blast official.</span></p>
								<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">{#each filteredCards(waCards) as c}<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success('Membuka template')}>Buka</Button></Card.Content></Card.Root>{/each}</div>
							{:else if blastView === 'email'}
								<p class="mb-3 text-sm font-medium">Email Blasting <span class="font-normal text-muted-foreground">— template, variabel, dan batch blast.</span></p>
								<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">{#each filteredCards(emailBlastCards) as c}<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success('Membuka template')}>Buka</Button></Card.Content></Card.Root>{/each}</div>
							{:else}
								<p class="mb-3 text-sm font-medium">Data & History <span class="font-normal text-muted-foreground">— dataset import dan riwayat semua channel.</span></p>
								<div class="grid grid-cols-1 gap-3 sm:grid-cols-2">{#each dataCards as c}<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success('Membuka riwayat blast')}>{c.title === 'Blast History' ? 'Lihat riwayat' : 'Kelola'}</Button></Card.Content></Card.Root>{/each}</div>
							{/if}
						</Card.Content>
					</Card.Root>

					<div class="grid gap-4 lg:grid-cols-[1fr_320px]">
						<Card.Root>
							<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>Blast history</Card.Title><p class="mt-1 text-sm text-muted-foreground">{historyFiltered.length} batch · target vs terkirim.</p></div><Badge variant="secondary"><History size={12} />Audit</Badge></Card.Header>
							<Card.Content>
								<div class="overflow-x-auto rounded-xl border">
									<Table.Root><Table.Header><Table.Row><Table.Head>ID</Table.Head><Table.Head>Channel</Table.Head><Table.Head>Template</Table.Head><Table.Head class="text-right">Target</Table.Head><Table.Head class="text-right">Terkirim</Table.Head><Table.Head>Tanggal</Table.Head><Table.Head>Status</Table.Head></Table.Row></Table.Header>
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
							<Card.Header><Card.Title>Pemakaian channel</Card.Title><p class="text-sm text-muted-foreground">Persentase kuota blast.</p></Card.Header>
							<Card.Content>
								<div class="flex flex-wrap gap-2">{#each usage as u}<Badge variant="outline">{u.label}: {u.value}%</Badge>{/each}</div>
								<Separator class="my-3" />
								{#each usage as u}<div class="mb-2 flex items-center justify-between text-xs"><span class="text-muted-foreground">{u.label}</span><span class="font-semibold">{u.value}%</span></div><Progress value={u.value} class="mb-3" />{/each}
							</Card.Content>
						</Card.Root>
					</div>
				</div>
			</Tabs.Content>

			<Tabs.Content value="form" class="mt-4">
				<Card.Root>
					<Card.Header><Card.Title>Form Builder Ticket</Card.Title><p class="text-sm text-muted-foreground">Status, prioritas, kategori, jenis, field, dan komponen.</p></Card.Header>
					<Card.Content>
						{#if filteredCards([{ title: 'Status', desc: 'Kelola status' }, { title: 'Priority', desc: 'Kelola prioritas' }, { title: 'Kategori', desc: 'Kategori form' }, { title: 'Jenis Pengaduan', desc: 'Jenis per kategori' }, { title: 'Field', desc: 'Field setiap jenis' }, { title: 'Components', desc: 'Komponen field' }]).length > 0}
							<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
								{#each filteredCards([{ title: 'Status', desc: 'Kelola status' }, { title: 'Priority', desc: 'Kelola prioritas' }, { title: 'Kategori', desc: 'Kategori form' }, { title: 'Jenis Pengaduan', desc: 'Jenis per kategori' }, { title: 'Field', desc: 'Field setiap jenis' }, { title: 'Components', desc: 'Komponen field' }]) as c}
									<Card.Root><Card.Header><Card.Title class="text-base">{c.title}</Card.Title><p class="text-xs text-muted-foreground">{c.desc}</p></Card.Header><Card.Content><Button size="sm" variant="secondary" class="w-full" onclick={() => toast.success('Membuka form')}>Kelola</Button></Card.Content></Card.Root>
								{/each}
							</div>
						{:else}
							<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><LayoutTemplate size={20} /></Empty.Media><Empty.Title>Belum ada field</Empty.Title><Empty.Description>Tambahkan field pertama untuk jenis pengaduan.</Empty.Description></Empty.Header></Empty.Root>
						{/if}
						<Alert.Root variant="warning" class="mt-4"><TriangleAlert /><Alert.Title>Butuh API key blast?</Alert.Title><Alert.Description>Gunakan PIN otorisasi 6 digit di halaman SPV sebelum menjalankan blast massal.</Alert.Description></Alert.Root>
						<div class="mt-3 flex items-center gap-2 text-xs text-muted-foreground"><KeyRound size={14} /><span>Contoh kunci: WA-HSM-****-OKT · SMTP-RELAY-****</span></div>
					</Card.Content>
				</Card.Root>
			</Tabs.Content>
		</Tabs.Root>
	</div>

	<Dialog.Root bind:open={testOpen}>
		<Dialog.Content>
			<Dialog.Header><Dialog.Title>Uji koneksi email</Dialog.Title><Dialog.Description>Kirim email percobaan untuk memverifikasi relay SMTP.</Dialog.Description></Dialog.Header>
			<Field.FieldGroup class="grid gap-3">
				<Field.Field><Field.Label for="smtp-to">Kirim ke</Field.Label><Input id="smtp-to" placeholder="ops@example.co.id" /></Field.Field>
			</Field.FieldGroup>
			<Dialog.Footer><Button size="sm" variant="outline" onclick={() => (testOpen = false)}>Batal</Button><Button size="sm" onclick={() => (testOpen = false)}><CircleCheck data-icon="inline-start" />Kirim uji</Button></Dialog.Footer>
		</Dialog.Content>
	</Dialog.Root>
</div>
