<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as Select from '$lib/components/ui/select';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as Alert from '$lib/components/ui/alert';
	import * as Empty from '$lib/components/ui/empty';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Switch } from '$lib/components/ui/switch';
	import { Separator } from '$lib/components/ui/separator';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import TimePicker from '$lib/components/ui/time-picker.svelte';
	import { toast } from 'svelte-sonner';
	import { cn } from '$lib/utils.js';
	import { Clock, Plus, Pencil, Trash2, Info, CalendarOff, TriangleAlert, CircleCheck } from 'lucide-svelte';

	type DayRow = { day: string; active: boolean; open: string; close: string; brk: string };

	let tab = $state('jadwal');
	let channel = $state('omnichat');
	let timezone = $state('Asia/Jakarta');
	let loading = $state(false);
	let editOpen = $state(false);
	let editingDay = $state<DayRow | null>(null);
	let editOpen2 = $state('');
	let editClose = $state('');
	let editBrk = $state('');

	let schedule = $state<DayRow[]>([
		{ day: 'Senin', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ day: 'Selasa', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ day: 'Rabu', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ day: 'Kamis', active: true, open: '08:00', close: '17:00', brk: '12:00–13:00' },
		{ day: 'Jumat', active: true, open: '08:00', close: '16:30', brk: '11:30–13:00' },
		{ day: 'Sabtu', active: false, open: '09:00', close: '14:00', brk: '-' },
		{ day: 'Minggu', active: false, open: '09:00', close: '14:00', brk: '-' }
	]);

	let exceptions = $state([
		{ id: 1, date: '25 Des 2026', label: 'Hari Raya Natal', closed: true },
		{ id: 2, date: '01 Jan 2027', label: 'Tahun Baru', closed: true },
		{ id: 3, date: '17 Agu 2026', label: 'Hari Kemerdekaan — layanan terbatas', closed: false }
	]);
	let excDate = $state('');
	let excLabel = $state('');
	let excClosed = $state(true);

	function openEdit(d: DayRow) {
		editingDay = d;
		editOpen2 = d.open;
		editClose = d.close;
		editBrk = d.brk;
		editOpen = true;
	}

	function saveEdit() {
		if (!editingDay) return;
		editingDay.open = editOpen2;
		editingDay.close = editClose;
		editingDay.brk = editBrk;
		editOpen = false;
		toast.success(`Jam ${editingDay.day} disimpan`);
	}

	function toggleDay(d: DayRow, v: boolean) {
		d.active = v;
		toast.success(`${d.day}: ${v ? 'buka' : 'tutup'}`);
	}

	function addException() {
		if (!excDate.trim() || !excLabel.trim()) {
			toast.error('Tanggal dan keterangan wajib diisi');
			return;
		}
		exceptions = [...exceptions, { id: Date.now(), date: excDate.trim(), label: excLabel.trim(), closed: excClosed }];
		excDate = '';
		excLabel = '';
		toast.success('Pengecualian ditambahkan');
	}

	function applyChannel() {
		loading = true;
		setTimeout(() => {
			loading = false;
			toast.success(`Jadwal ${channel} diterapkan`);
		}, 500);
	}
</script>

<svelte:head><title>Operational Hours — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
			<div>
				<Card.Title class="flex items-center gap-2"><Clock data-icon="inline-start" /> Operational Hours</Card.Title>
				<Card.Description>Atur jam layanan per kanal, zona waktu, dan pengecualian hari libur.</Card.Description>
			</div>
			<Badge variant="secondary" class="w-fit">{timezone}</Badge>
		</Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_1fr_auto]">
				<Field.Field>
					<Field.Label for="oh-channel">Kanal</Field.Label>
					<Select.Root type="single" bind:value={channel}>
						<Select.Trigger id="oh-channel" class="w-full">{channel}</Select.Trigger>
						<Select.Content>
							<Select.Group>
								<Select.GroupHeading>Kanal</Select.GroupHeading>
								<Select.Item value="omnichat">Omnichat</Select.Item>
								<Select.Item value="ticketing">Ticketing</Select.Item>
								<Select.Item value="email">Email</Select.Item>
								<Select.Item value="voice">Voice / Call</Select.Item>
							</Select.Group>
						</Select.Content>
					</Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label for="oh-tz">Zona waktu</Field.Label>
					<Select.Root type="single" bind:value={timezone}>
						<Select.Trigger id="oh-tz" class="w-full">{timezone}</Select.Trigger>
						<Select.Content>
							<Select.Group>
								<Select.GroupHeading>Zona waktu</Select.GroupHeading>
								<Select.Item value="Asia/Jakarta">Asia/Jakarta (WIB)</Select.Item>
								<Select.Item value="Asia/Makassar">Asia/Makassar (WITA)</Select.Item>
								<Select.Item value="Asia/Jayapura">Asia/Jayapura (WIT)</Select.Item>
							</Select.Group>
						</Select.Content>
					</Select.Root>
				</Field.Field>
				<Field.Field>
					<Field.Label>&nbsp;</Field.Label>
					<Button onclick={applyChannel} disabled={loading}>{loading ? 'Menerapkan…' : 'Terapkan'}</Button>
				</Field.Field>
			</Field.FieldGroup>
			<Tabs.Root bind:value={tab}>
				<Tabs.List>
					<Tabs.Trigger value="jadwal">Jadwal mingguan</Tabs.Trigger>
					<Tabs.Trigger value="pengecualian">Pengecualian ({exceptions.length})</Tabs.Trigger>
				</Tabs.List>
			</Tabs.Root>
		</Card.Content>
	</Card.Root>

	{#if loading}
		<Skeleton class="h-64 w-full" />
	{:else if tab === 'jadwal'}
		<Card.Root>
			<Card.Header>
				<Card.Title>Jadwal mingguan — {channel}</Card.Title>
				<Card.Description>Aktifkan hari layanan dan atur jam buka, tutup, serta istirahat.</Card.Description>
			</Card.Header>
			<Card.Content class="p-0">
				<Table.Root>
					<Table.Header>
						<Table.Row>
							<Table.Head>Hari</Table.Head>
							<Table.Head>Status</Table.Head>
							<Table.Head>Buka</Table.Head>
							<Table.Head>Tutup</Table.Head>
							<Table.Head>Istirahat</Table.Head>
							<Table.Head class="text-right">Aksi</Table.Head>
						</Table.Row>
					</Table.Header>
					<Table.Body>
						{#each schedule as d (d.day)}
							<Table.Row class={cn(!d.active && 'opacity-60')}>
								<Table.Cell class="font-medium">{d.day}</Table.Cell>
								<Table.Cell>
									<div class="flex items-center gap-2">
										<Switch checked={d.active} onCheckedChange={(v) => toggleDay(d, v === true)} aria-label={`Aktifkan ${d.day}`} />
										<Badge variant={d.active ? 'success' : 'secondary'}>{d.active ? 'Buka' : 'Tutup'}</Badge>
									</div>
								</Table.Cell>
								<Table.Cell class="tabular-nums">{d.open}</Table.Cell>
								<Table.Cell class="tabular-nums">{d.close}</Table.Cell>
								<Table.Cell class="text-muted-foreground tabular-nums">{d.brk}</Table.Cell>
								<Table.Cell class="text-right">
									<Tooltip.Root>
										<Tooltip.Trigger>
											{#snippet child({ props })}
												<Button {...props} size="icon" variant="ghost" onclick={() => openEdit(d)} aria-label={`Ubah ${d.day}`}>
													<Pencil data-icon="true" />
												</Button>
											{/snippet}
										</Tooltip.Trigger>
										<Tooltip.Content>Ubah jam</Tooltip.Content>
									</Tooltip.Root>
								</Table.Cell>
							</Table.Row>
						{/each}
					</Table.Body>
				</Table.Root>
			</Card.Content>
			<Card.Footer>
				<Separator class="my-1" />
				<p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> Di luar jam operasional, chat dialihkan ke chatbot &amp; tiket otomatis.</p>
			</Card.Footer>
		</Card.Root>
	{:else}
		<div class="grid gap-4 lg:grid-cols-[1fr_1.4fr]">
			<Card.Root>
				<Card.Header>
					<Card.Title class="flex items-center gap-2"><Plus data-icon="inline-start" /> Tambah pengecualian</Card.Title>
					<Card.Description>Hari libur atau layanan terbatas di luar jadwal mingguan.</Card.Description>
				</Card.Header>
				<Card.Content>
					<Field.FieldGroup class="flex flex-col gap-4">
						<Field.Field>
							<Field.Label for="exc-date">Tanggal</Field.Label>
							<Input id="exc-date" placeholder="cth. 25 Des 2026" bind:value={excDate} />
						</Field.Field>
						<Field.Field>
							<Field.Label for="exc-label">Keterangan</Field.Label>
							<Input id="exc-label" placeholder="cth. Hari Raya Natal" bind:value={excLabel} />
						</Field.Field>
						<Field.Field>
							<Field.Label for="exc-closed">Tutup penuh</Field.Label>
							<div class="flex items-center gap-2">
								<Switch id="exc-closed" bind:checked={excClosed} />
								<span class="text-xs text-muted-foreground">{excClosed ? 'Tutup — dialihkan ke chatbot' : 'Buka terbatas'}</span>
							</div>
						</Field.Field>
						<Button onclick={addException}><Plus data-icon="inline-start" />Tambah</Button>
					</Field.FieldGroup>
				</Card.Content>
			</Card.Root>
			<Card.Root>
				<Card.Header>
					<Card.Title>Daftar pengecualian</Card.Title>
					<Card.Description>{exceptions.length} tanggal khusus terdaftar.</Card.Description>
				</Card.Header>
				<Card.Content class="flex flex-col gap-2">
					{#if exceptions.length === 0}
						<Empty.Root class="py-8">
							<Empty.Header>
								<Empty.Media><CalendarOff data-icon="empty" /></Empty.Media>
								<Empty.Title>Belum ada pengecualian</Empty.Title>
								<Empty.Description>Tambahkan hari libur atau layanan terbatas.</Empty.Description>
							</Empty.Header>
						</Empty.Root>
					{:else}
						{#each exceptions as e (e.id)}
							<div class="flex items-center gap-3 rounded-lg border px-3 py-2.5">
								<div class="min-w-0 flex-1">
									<p class="truncate text-sm font-medium">{e.label}</p>
									<p class="text-xs text-muted-foreground tabular-nums">{e.date}</p>
								</div>
								<Badge variant={e.closed ? 'destructive' : 'warning'} class="shrink-0">{e.closed ? 'Tutup' : 'Terbatas'}</Badge>
								<Button
									size="icon"
									variant="ghost"
									class="shrink-0"
									aria-label={`Hapus ${e.label}`}
									onclick={() => {
										exceptions = exceptions.filter((x) => x.id !== e.id);
										toast.success('Pengecualian dihapus');
									}}
								>
									<Trash2 data-icon="true" />
								</Button>
							</div>
						{/each}
					{/if}
				</Card.Content>
			</Card.Root>
		</div>
	{/if}

	<Alert.Root variant="warning"><TriangleAlert data-icon="alert" /><Alert.Description>Jadwal berlaku per kanal — perubahan membutuhkan apply agar aktif di routing.</Alert.Description></Alert.Root>
	<Alert.Root variant="success"><CircleCheck data-icon="alert" /><Alert.Description>Sinkron dengan Work Calendar untuk hari libur nasional.</Alert.Description></Alert.Root>
</div>

<Dialog.Root bind:open={editOpen}>
	<Dialog.Content>
		<Dialog.Header>
			<Dialog.Title>Ubah jam — {editingDay?.day}</Dialog.Title>
			<Dialog.Description>Format 24 jam (JJ:MM).</Dialog.Description>
		</Dialog.Header>
		<Field.FieldGroup class="flex flex-col gap-4">
			<Field.Field>
				<Field.Label>Jam buka</Field.Label>
				<TimePicker bind:value={editOpen2} label="Jam buka" />
			</Field.Field>
			<Field.Field>
				<Field.Label>Jam tutup</Field.Label>
				<TimePicker bind:value={editClose} label="Jam tutup" />
			</Field.Field>
			<Field.Field>
				<Field.Label for="edit-brk">Istirahat</Field.Label>
				<Input id="edit-brk" placeholder="12:00–13:00" bind:value={editBrk} />
			</Field.Field>
		</Field.FieldGroup>
		<Dialog.Footer>
			<Button variant="outline" onclick={() => (editOpen = false)}>Batal</Button>
			<Button onclick={saveEdit}>Simpan</Button>
		</Dialog.Footer>
	</Dialog.Content>
</Dialog.Root>
