<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Select from '$lib/components/ui/select';
	import * as Field from '$lib/components/ui/field';
	import * as ToggleGroup from '$lib/components/ui/toggle-group';
	import * as Pagination from '$lib/components/ui/pagination';
	import * as Empty from '$lib/components/ui/empty';
	import * as Alert from '$lib/components/ui/alert';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as Sheet from '$lib/components/ui/sheet';
	import * as InputOTP from '$lib/components/ui/input-otp';
	import * as Chart from '$lib/components/ui/chart';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Switch } from '$lib/components/ui/switch';
	import { Calendar } from '$lib/components/ui/calendar';
	import { CalendarDate } from '@internationalized/date';
	import { Chart as LCChart, Svg, Axis, Grid, Bars } from 'layerchart';
	import { RefreshCw, Users, Hourglass, MessagesSquare, CircleCheck, Search, UserPlus, ShieldCheck, TriangleAlert } from 'lucide-svelte';

	let statusFilter: string | undefined = $state('all');
	let channelFilter = $state('all');
	let search = $state('');
	let page = $state(1);
	const perPage = 5;
	let autoRefresh = $state(true);
	let assignOpen = $state(false);
	let sheetOpen = $state(false);
	let selectedChat = $state('');
	let otp = $state('');
	let shiftDate = $state<CalendarDate | undefined>(new CalendarDate(2026, 9, 30));

	type Chat = { customer: string; channel: string; account: string; agent: string | null; status: 'open' | 'queue' | 'close'; started: string };
	const chats: Chat[] = [
		{ customer: 'NINA', channel: 'WhatsApp', account: 'CS AHU 1', agent: 'Ayu Lestari', status: 'open', started: '10:02' },
		{ customer: 'EVA SITI', channel: 'Live Chat', account: 'Web AHU', agent: null, status: 'queue', started: '10:05' },
		{ customer: 'BUDI SANTOSO', channel: 'Voice', account: 'PBX 101', agent: 'Rizky Pratama', status: 'open', started: '10:11' },
		{ customer: 'SITI AMINAH', channel: 'Email', account: 'info@ahu', agent: 'Dewi Anggraini', status: 'open', started: '10:18' },
		{ customer: 'ANDI WIJAYA', channel: 'WhatsApp', account: 'CS AHU 2', agent: null, status: 'queue', started: '10:22' },
		{ customer: 'RINA MARLINA', channel: 'Live Chat', account: 'Web AHU', agent: 'Fajar Nugraha', status: 'close', started: '09:47' },
		{ customer: 'HENDRA G', channel: 'WhatsApp', account: 'CS AHU 1', agent: 'Sari Wulandari', status: 'close', started: '09:31' }
	];
	const readyAgents = [
		{ username: 'ayu.lestari', name: 'Ayu Lestari' },
		{ username: 'rizky.p', name: 'Rizky Pratama' },
		{ username: 'dewi.a', name: 'Dewi Anggraini' }
	];

	const filtered = $derived(chats.filter((c) => {
		if (statusFilter !== 'all' && c.status !== statusFilter) return false;
		if (channelFilter !== 'all' && c.channel !== channelFilter) return false;
		const q = search.trim().toLowerCase();
		if (q && !`${c.customer} ${c.agent ?? ''} ${c.account}`.toLowerCase().includes(q)) return false;
		return true;
	}));
	const inQueue = chats.filter((c) => c.status === 'queue').length;
	const onHandled = chats.filter((c) => c.status === 'open').length;
	const totalOpen = inQueue + onHandled;
	const totalClosed = chats.filter((c) => c.status === 'close').length;
	const pageCount = $derived(Math.max(1, Math.ceil(filtered.length / perPage)));
	const safePage = $derived(Math.min(page, pageCount));
	const pageRows = $derived(filtered.slice((safePage - 1) * perPage, safePage * perPage));
	const loadData = [
		{ label: 'Queue', value: inQueue }, { label: 'Handled', value: onHandled }, { label: 'Closed', value: totalClosed }
	];
	const chartConfig = { value: { label: 'Chat' } } satisfies import('$lib/components/ui/chart').ChartConfig;

	function statusVariant(s: Chat['status']) { return s === 'open' ? 'success' as const : s === 'queue' ? 'warning' as const : 'secondary' as const; }
	function openAssign(customer: string) { selectedChat = customer; assignOpen = true; }
	let refreshedAt = $state('10:24:00');
	function refresh() { refreshedAt = new Date().toLocaleTimeString('id-ID'); }
</script>

<svelte:head><title>SPV Dashboard — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
	<div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-center">
		<div><h1 class="flex items-center gap-2 text-xl font-bold"><ShieldCheck size={20} class="text-primary" />SPV Dashboard</h1><p class="mt-1 text-sm text-muted-foreground">Supervisi chat berjalan: queue, handled, open/close, dan assign ulang agent.</p></div>
		<div class="flex items-center gap-3">
			<label class="flex items-center gap-2 text-sm"><Switch bind:checked={autoRefresh} />Auto refresh</label>
			<Button size="sm" onclick={refresh}><RefreshCw data-icon="inline-start" />Refresh data</Button>
		</div>
	</div>

	{#if inQueue > 0}
		<Alert.Root variant="warning"><TriangleAlert /><Alert.Title>{inQueue} chat menunggu di queue</Alert.Title><Alert.Description>Terakhir diperbarui {refreshedAt}. Segera assign ke agent ready.</Alert.Description></Alert.Root>
	{/if}

	<div class="grid gap-4 lg:grid-cols-[1.6fr_1fr]">
		<Card.Root>
			<Card.Header class="flex-row items-center justify-between space-y-0">
				<div><Card.Title>Chat terbuka</Card.Title><p class="mt-1 text-sm text-muted-foreground">Customer · channel · account · agent · status · mulai.</p></div>
				<Badge variant="secondary">{filtered.length} sesi</Badge>
			</Card.Header>
			<Card.Content>
				<Field.FieldGroup class="mb-4 grid gap-3 md:grid-cols-[1fr_auto_auto]">
					<Field.Field><Field.Label for="spv-q">Cari sesi</Field.Label><div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="spv-q" bind:value={search} placeholder="Customer / agent / account" class="pl-8" /></div></Field.Field>
					<Field.Field><Field.Label>Channel</Field.Label>
						<Select.Root type="single" bind:value={channelFilter}><Select.Trigger><Select.Value placeholder="Semua" /></Select.Trigger><Select.Content><Select.Item value="all">Semua</Select.Item><Select.Item value="WhatsApp">WhatsApp</Select.Item><Select.Item value="Live Chat">Live Chat</Select.Item><Select.Item value="Voice">Voice</Select.Item><Select.Item value="Email">Email</Select.Item></Select.Content></Select.Root>
					</Field.Field>
					<Field.Field><Field.Label>Status</Field.Label>
						<ToggleGroup.Root type="single" bind:value={statusFilter}><ToggleGroup.Item value="all">Semua</ToggleGroup.Item><ToggleGroup.Item value="open">Open</ToggleGroup.Item><ToggleGroup.Item value="queue">Queue</ToggleGroup.Item><ToggleGroup.Item value="close">Close</ToggleGroup.Item></ToggleGroup.Root>
					</Field.Field>
				</Field.FieldGroup>
				{#if filtered.length > 0}
					<div class="overflow-x-auto rounded-xl border">
						<Table.Root>
							<Table.Header><Table.Row><Table.Head>Customer</Table.Head><Table.Head>Channel</Table.Head><Table.Head>Account</Table.Head><Table.Head>Agent</Table.Head><Table.Head>Status</Table.Head><Table.Head>Mulai</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header>
							<Table.Body>
								{#each pageRows as c}
									<Table.Row>
										<Table.Cell class="font-medium">{c.customer}</Table.Cell><Table.Cell>{c.channel}</Table.Cell><Table.Cell class="text-muted-foreground">{c.account}</Table.Cell>
										<Table.Cell>{c.agent ?? '—'}</Table.Cell><Table.Cell><Badge variant={statusVariant(c.status)}>{c.status}</Badge></Table.Cell><Table.Cell>{c.started}</Table.Cell>
										<Table.Cell class="text-right"><div class="flex justify-end gap-1">{#if c.agent}<Button size="sm" variant="outline">Release</Button><Button size="sm" variant="destructive" onclick={() => openAssign(c.customer)}>Re-assign</Button>{:else}<Button size="sm" onclick={() => openAssign(c.customer)}><UserPlus data-icon="inline-start" />Assign</Button>{/if}</div></Table.Cell>
									</Table.Row>
								{/each}
							</Table.Body>
						</Table.Root>
					</div>
					<div class="mt-4 flex justify-center">
						<Pagination.Root bind:page count={filtered.length} perPage={perPage} siblingCount={1}>
							{#snippet children({ pages })}
								<Pagination.Content>
									<Pagination.Item><Pagination.Previous /></Pagination.Item>
									{#each pages as p (p.key)}{#if p.type === 'ellipsis'}<Pagination.Item><Pagination.Ellipsis /></Pagination.Item>{:else}<Pagination.Item><Pagination.Link page={p.value} isActive={safePage === p.value}>{p.value}</Pagination.Link></Pagination.Item>{/if}{/each}
									<Pagination.Item><Pagination.Next /></Pagination.Item>
								</Pagination.Content>
							{/snippet}
						</Pagination.Root>
					</div>
				{:else}
					<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><MessagesSquare size={20} /></Empty.Media><Empty.Title>Tidak ada sesi</Empty.Title><Empty.Description>Tidak ada chat {statusFilter} yang cocok dengan filter.</Empty.Description></Empty.Header></Empty.Root>
				{/if}
			</Card.Content>
		</Card.Root>

		<div class="flex flex-col gap-4">
			<Card.Root>
				<Card.Header><Card.Title>Ringkasan chat</Card.Title></Card.Header>
				<Card.Content class="flex flex-col gap-3">
					{#each [
						{ icon: Users, label: 'Chat in Queue', value: String(inQueue) },
						{ icon: Hourglass, label: 'Chat on Handled', value: String(onHandled) },
						{ icon: MessagesSquare, label: 'Total Chat Open', value: String(totalOpen) },
						{ icon: CircleCheck, label: 'Total Chat Closed', value: String(totalClosed) }
					] as s}
						<div class="flex items-center gap-3 rounded-xl border p-3"><div class="flex size-9 items-center justify-center rounded-full bg-primary/10 text-primary"><s.icon size={16} /></div><div class="flex-1"><p class="text-xs text-muted-foreground">{s.label}</p><p class="text-base font-bold">{s.value}</p></div></div>
					{/each}
					<Separator />
					<div class="flex items-center justify-between text-xs"><span class="text-muted-foreground">Beban handled</span><span class="font-semibold">{Math.round((onHandled / Math.max(1, totalOpen + totalClosed)) * 100)}%</span></div>
					<Progress value={(onHandled / Math.max(1, totalOpen + totalClosed)) * 100} />
				</Card.Content>
			</Card.Root>
			<Card.Root>
				<Card.Header><Card.Title>Beban sesi</Card.Title><p class="text-sm text-muted-foreground">Queue vs handled vs closed.</p></Card.Header>
				<Card.Content>
					<Chart.Container config={chartConfig} class="aspect-auto h-48">
						<LCChart data={loadData} x="label" y="value" padding={{ left: 8, right: 8 }}>
							<Svg><Grid vertical={false} /><Axis placement="bottom" /><Axis placement="left" grid rule /><Bars radius={6} /></Svg>
						</LCChart>
					</Chart.Container>
					<Button size="sm" variant="outline" class="mt-3 w-full" onclick={() => (sheetOpen = true)}>Jadwal shift & PIN SPV</Button>
				</Card.Content>
			</Card.Root>
		</div>
	</div>

	<Dialog.Root bind:open={assignOpen}>
		<Dialog.Content>
			<Dialog.Header><Dialog.Title>List agent ready</Dialog.Title><Dialog.Description>Pilih agent untuk sesi milik {selectedChat || '—'}.</Dialog.Description></Dialog.Header>
			<div class="overflow-x-auto rounded-xl border">
				<Table.Root><Table.Header><Table.Row><Table.Head>Username</Table.Head><Table.Head>Nama</Table.Head><Table.Head class="text-right">Aksi</Table.Head></Table.Row></Table.Header>
				<Table.Body>{#each readyAgents as a}<Table.Row><Table.Cell class="font-mono text-xs">{a.username}</Table.Cell><Table.Cell>{a.name}</Table.Cell><Table.Cell class="text-right"><Button size="sm" onclick={() => (assignOpen = false)}>Assign</Button></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
			</div>
			<Dialog.Footer><Button size="sm" variant="outline" onclick={() => (assignOpen = false)}>Tutup</Button></Dialog.Footer>
		</Dialog.Content>
	</Dialog.Root>

	<Sheet.Root bind:open={sheetOpen}>
		<Sheet.Content side="right">
			<Sheet.Header><Sheet.Title>Jadwal shift SPV</Sheet.Title><Sheet.Description>Pilih tanggal shift dan verifikasi PIN sebelum release massal.</Sheet.Description></Sheet.Header>
			<div class="flex flex-col gap-4 px-4 pb-4">
				<Calendar type="single" bind:value={shiftDate} />
				<Field.Field><Field.Label>PIN otorisasi (6 digit)</Field.Label>
					<InputOTP.Root maxlength={6} bind:value={otp}>
						<InputOTP.Group>
							<InputOTP.Slot index={0} /><InputOTP.Slot index={1} /><InputOTP.Slot index={2} /><InputOTP.Slot index={3} /><InputOTP.Slot index={4} /><InputOTP.Slot index={5} />
						</InputOTP.Group>
					</InputOTP.Root>
					<Field.Description>PIN diminta saat release semua sesi.</Field.Description>
				</Field.Field>
				<Button size="sm" onclick={() => (sheetOpen = false)}>Simpan jadwal</Button>
			</div>
		</Sheet.Content>
	</Sheet.Root>
</div>
