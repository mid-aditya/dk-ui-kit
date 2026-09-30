<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as Select from '$lib/components/ui/select';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as Alert from '$lib/components/ui/alert';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Chart from '$lib/components/ui/chart';
	import * as ToggleGroup from '$lib/components/ui/toggle-group';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import * as Empty from '$lib/components/ui/empty';
	import DatePicker from "$lib/components/ui/date-picker.svelte";
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Phone, MessageCircle, Mail, Share2, Star, TriangleAlert, CircleCheck, Info, CalendarDays, Inbox } from 'lucide-svelte';
	import { CalendarDate, type DateValue } from '@internationalized/date';

	const channels = [
		{ key: 'phone', label: 'Phone Calls', icon: Phone, total: '248 panggilan', answered: '212 terjawab (85%)', avg: '3m 24s', score: '4.6/5' },
		{ key: 'chat', label: 'Live Chat', icon: MessageCircle, total: '186 chat', answered: '174 direspon (94%)', avg: '42 detik', score: '4.8/5' },
		{ key: 'email', label: 'Email', icon: Mail, total: '124 email', answered: '96 dibalas (77%)', avg: '2j 18m', score: '4.5/5' },
		{ key: 'wa', label: 'WhatsApp Business', icon: MessageCircle, total: '316 chat', answered: '294 direspon (93%)', avg: '1m 06s', score: '4.9/5' },
		{ key: 'soc', label: 'Social Media', icon: Share2, total: '92 interaksi', answered: '81 direspon (88%)', avg: '18 menit', score: '4.4/5' },
		{ key: 'cmt', label: 'Comment & More', icon: Star, total: '74 interaksi', answered: '61 direspon (82%)', avg: '26 menit', score: '4.3/5' }
	];
	const tickets = [
		{ id: 'T-2026-001', subject: 'Keterlambatan pengiriman', channel: 'WhatsApp', owner: 'Rina', status: 'Urgent' },
		{ id: 'T-2026-002', subject: 'Reset password akun', channel: 'Live Chat', owner: 'Budi', status: 'Open' },
		{ id: 'T-2026-003', subject: 'Permintaan invoice bulanan', channel: 'Email', owner: 'Sari', status: 'In Progress' }
	];
	const dist = [
		{ label: 'WhatsApp', value: 82 }, { label: 'Live Chat', value: 68 },
		{ label: 'Email', value: 46 }, { label: 'Voice', value: 32 }
	];
	let tab = $state('harian');
	let range = $state('30h');
	let loading = $state(false);
	let date = $state<DateValue | undefined>(new CalendarDate(2026, 9, 30));
	let period = $state('2026-09');
	function apply() { loading = true; setTimeout(() => (loading = false), 600); }
	const ApplyIcon = $derived(loading ? Spinner : CalendarDays);
	const chartConfig = { volume: { label: 'Volume', color: 'var(--primary)' } };
	const bars = [42, 68, 55, 80, 62, 90, 74];
</script>

<svelte:head><title>Home — Statistik Kanal</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header><Card.Title>Statistik Kanal | Real-time Performance Monitoring</Card.Title><Card.Description>Filter rentang tanggal dan periode untuk memperbarui metrik kanal.</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_1fr_auto]">
				<Field.Field><Field.Label for="start">Start Date</Field.Label><DatePicker bind:value={date} label="Pilih start date" placeholder="Pilih tanggal" /></Field.Field>
				<Field.Field>
					<Field.Label for="period">Periode</Field.Label>
					<Select.Root type="single" bind:value={period}>
						<Select.Trigger id="period" class="w-full">{period}</Select.Trigger>
						<Select.Content><Select.Group><Select.GroupHeading>Periode</Select.GroupHeading><Select.Item value="2026-08">Agustus 2026</Select.Item><Select.Item value="2026-09">September 2026</Select.Item><Select.Item value="2026-10">Oktober 2026</Select.Item></Select.Group></Select.Content>
					</Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button onclick={apply} disabled={loading}><ApplyIcon data-icon="inline-start" /><span>{loading ? 'Memuat' : 'Apply Filter'}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={range} class="w-fit" aria-label="Rentang">
				<ToggleGroup.Item value="7h">7 hari</ToggleGroup.Item><ToggleGroup.Item value="30h">30 hari</ToggleGroup.Item><ToggleGroup.Item value="90h">90 hari</ToggleGroup.Item>
			</ToggleGroup.Root>
			<Tabs.Root bind:value={tab}>
				<Tabs.List><Tabs.Trigger value="harian">Harian</Tabs.Trigger><Tabs.Trigger value="mingguan">Mingguan</Tabs.Trigger><Tabs.Trigger value="bulanan">Bulanan</Tabs.Trigger></Tabs.List>
			</Tabs.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">Scope data: semua kanal · diperbarui real-time</Card.Footer>
	</Card.Root>

	{#if loading}
		<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">{#each [1, 2, 3] as _}<Skeleton class="h-44 w-full" />{/each}</div>
	{:else}
		<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3" aria-label="Statistik kanal">
			{#each channels as c}
				<Card.Root class={cn('transition-shadow hover:shadow-md', c.key === 'wa' && 'border-primary/40')}>
					<Card.Header class="flex flex-row items-center gap-3">
						<div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary"><c.icon data-icon="card" /></div>
						<div class="min-w-0 flex-1"><Card.Title class="truncate text-base">{c.label}</Card.Title><Card.Description class="truncate">Total: {c.total}</Card.Description></div>
						<Tooltip.Root><Tooltip.Trigger class="shrink-0"><Badge variant="secondary" class="shrink-0 whitespace-nowrap">Aktif</Badge></Tooltip.Trigger><Tooltip.Content>Kanal terhubung</Tooltip.Content></Tooltip.Root>
					</Card.Header>
					<Card.Content class="flex flex-col gap-2 text-sm">
						<div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">Respons</span><span class="font-medium">{c.answered}</span></div>
						<div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">Rata-rata</span><span class="font-medium">{c.avg}</span></div>
						<div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">Kepuasan</span><span class="font-medium">{c.score}</span></div>
					</Card.Content>
					<Card.Footer><Progress value={85} class="w-full" /></Card.Footer>
				</Card.Root>
			{/each}
		</section>
	{/if}

	<Alert.Root variant="warning"><TriangleAlert data-icon="alert" /><Alert.Description>4 chat menunggu balasan lebih dari 5 menit.</Alert.Description></Alert.Root>
	<Alert.Root variant="success"><CircleCheck data-icon="alert" /><Alert.Description>Semua channel aktif dan terhubung.</Alert.Description></Alert.Root>

	<div class="grid gap-4 lg:grid-cols-2">
		<Card.Root>
			<Card.Header><Card.Title>Volume kanal</Card.Title><Card.Description>Distribusi 7 hari terakhir.</Card.Description></Card.Header>
			<Card.Content>
				<Chart.Container config={chartConfig} class="min-h-40">
					<div class="flex h-36 w-full items-end gap-2">{#each bars as b}<div class="flex-1 rounded bg-primary/80" style="height:{b}%"></div>{/each}</div>
				</Chart.Container>
			</Card.Content>
			<Card.Footer class="flex flex-col gap-3">
				{#each dist as d}<div class="flex flex-col gap-1.5"><div class="flex justify-between text-sm"><span>{d.label}</span><span class="text-muted-foreground">{d.value}%</span></div><Progress value={d.value} /></div>{/each}
			</Card.Footer>
		</Card.Root>
		<Card.Root>
			<Card.Header><Card.Title>Tiket terbaru</Card.Title><Card.Description>Aktivitas tiket terakhir.</Card.Description></Card.Header>
			<Card.Content>
				{#if tickets.length === 0}
					<Empty.Root><Empty.Header><Empty.Media><Inbox data-icon="empty" /></Empty.Media><Empty.Title>Belum ada tiket</Empty.Title><Empty.Description>Tiket baru akan muncul di sini.</Empty.Description></Empty.Header></Empty.Root>
				{:else}
					<Table.Root><Table.Header><Table.Row><Table.Head>ID</Table.Head><Table.Head>Subjek</Table.Head><Table.Head>Owner</Table.Head><Table.Head class="text-right">Status</Table.Head></Table.Row></Table.Header>
					<Table.Body>{#each tickets as t}<Table.Row><Table.Cell class="font-mono text-xs">{t.id}</Table.Cell><Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-6"><Avatar.Fallback>{t.owner.slice(0, 1)}</Avatar.Fallback></Avatar.Root><span class="font-medium">{t.subject}</span></div></Table.Cell><Table.Cell>{t.owner}</Table.Cell><Table.Cell class="text-right"><Badge variant={t.status === 'Urgent' ? 'destructive' : 'secondary'}>{t.status}</Badge></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
				{/if}
			</Card.Content>
			<Card.Footer><Separator class="my-1" /><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> Menampilkan 3 tiket terbaru</p></Card.Footer>
		</Card.Root>
	</div>
</div>

