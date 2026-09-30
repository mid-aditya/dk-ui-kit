<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import * as Table from '$lib/components/ui/table';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Field from '$lib/components/ui/field';
	import * as Select from '$lib/components/ui/select';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as Alert from '$lib/components/ui/alert';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as ToggleGroup from '$lib/components/ui/toggle-group';
	import * as Dialog from '$lib/components/ui/dialog';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import * as Empty from '$lib/components/ui/empty';
	import * as Popover from '$lib/components/ui/popover';
	import { RangeCalendar } from '$lib/components/ui/range-calendar';
	import { Spinner } from '$lib/components/ui/spinner';
	import { cn } from '$lib/utils.js';
	import { Handshake, Ticket, TriangleAlert, CircleCheck, Info, Gauge } from 'lucide-svelte';
	import { CalendarDate, DateFormatter, getLocalTimeZone } from '@internationalized/date';
	import { CalendarIcon } from 'lucide-svelte';
	import { goto } from '$app/navigation';
	import { toast } from 'svelte-sonner';

	const df = new DateFormatter('id-ID', { dateStyle: 'medium' });
	import type { DateRange } from 'bits-ui';

	let tab = $state('ringkasan'); let channel = $state('semua'); let loading = $state(false); let open = $state(false);
	let period = $state<DateRange | undefined>({ start: new CalendarDate(2026, 9, 1), end: new CalendarDate(2026, 9, 30) });
	const kpi = [
		{ icon: Handshake, label: 'Total Interaksi', value: '248', target: 'Target: 200', ok: true },
		{ icon: Ticket, label: 'Tiket Diproses', value: '96', target: 'Target: 90', ok: true },
		{ icon: TriangleAlert, label: 'Tiket Near SLA', value: '7', target: 'Perlu perhatian', ok: false },
		{ icon: CircleCheck, label: 'Tiket Over SLA', value: '2', target: 'Eskalasi', ok: false }
	];
	const rows = [
		{ name: 'Rina Amelia', interaksi: 64, tiket: 28, near: 2, over: 0, util: 88 },
		{ name: 'Budi Santoso', interaksi: 58, tiket: 24, near: 3, over: 1, util: 81 },
		{ name: 'Sari Dewi', interaksi: 47, tiket: 19, near: 1, over: 1, util: 72 }
	];
	function refresh() { loading = true; setTimeout(() => (loading = false), 500); }
	const BtnIcon = $derived(loading ? Spinner : Gauge);

</script>

<svelte:head><title>Agent Productivity</title></svelte:head>

<div class="flex flex-col gap-6">
	<Card.Root>
		<Card.Header><div class="flex items-center gap-3"><Avatar.Root class="size-12"><Avatar.Fallback>AG</Avatar.Fallback></Avatar.Root><div><Card.Title>Agent Productivity</Card.Title><Card.Description>Monitor performa dan produktivitas agent secara real-time.</Card.Description></div></div></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<Field.FieldGroup class="grid gap-4 md:grid-cols-[1fr_200px_auto]">
				<Field.Field><Field.Label>Periode</Field.Label><Popover.Root><Popover.Trigger aria-label="Pilih periode">{#snippet child({ props })}<Button {...props} variant="outline" class="w-full justify-start px-2.5 font-normal"><CalendarIcon data-icon="inline-start" />{#if period?.start}{#if period.end}{df.format(period.start.toDate(getLocalTimeZone()))} - {df.format(period.end.toDate(getLocalTimeZone()))}{:else}{df.format(period.start.toDate(getLocalTimeZone()))}{/if}{:else}<span>Pilih periode</span>{/if}</Button>{/snippet}</Popover.Trigger><Popover.Content class="w-auto p-0" align="start"><Popover.Title class="sr-only">Pilih periode</Popover.Title><Popover.Description class="sr-only">Kalender periode</Popover.Description><RangeCalendar bind:value={period} numberOfMonths={1} locale="id-ID" /></Popover.Content></Popover.Root></Field.Field>
				<Field.Field>
					<Field.Label for="ch">Channel</Field.Label>
					<Select.Root type="single" bind:value={channel}><Select.Trigger id="ch" class="w-full">{channel}</Select.Trigger><Select.Content><Select.Group><Select.GroupHeading>Channel</Select.GroupHeading><Select.Item value="semua">Semua</Select.Item><Select.Item value="chat">Live Chat</Select.Item><Select.Item value="call">Inbound Call</Select.Item></Select.Group></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label>&nbsp;</Field.Label><Button onclick={refresh} disabled={loading}><BtnIcon data-icon="inline-start" /><span>{loading ? 'Memuat' : 'Refresh'}</span></Button></Field.Field>
			</Field.FieldGroup>
			<ToggleGroup.Root type="single" bind:value={tab} aria-label="Tampilan"><ToggleGroup.Item value="ringkasan">Ringkasan</ToggleGroup.Item><ToggleGroup.Item value="sla">SLA</ToggleGroup.Item><ToggleGroup.Item value="tren">Tren</ToggleGroup.Item></ToggleGroup.Root>
			<Tabs.Root bind:value={tab}><Tabs.List><Tabs.Trigger value="ringkasan">Ringkasan</Tabs.Trigger><Tabs.Trigger value="sla">SLA</Tabs.Trigger><Tabs.Trigger value="tren">Tren</Tabs.Trigger></Tabs.List></Tabs.Root>
		</Card.Content>
		<Card.Footer class="text-muted-foreground text-xs">Welcome back, Agent · Online</Card.Footer>
	</Card.Root>

	{#if loading}
		<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">{#each [1, 2, 3, 4] as _}<Skeleton class="h-32 w-full" />{/each}</div>
	{:else}
		<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
			{#each kpi as k}
				<Card.Root class={cn(!k.ok && 'border-amber-500/40')}>
					<Card.Header class="flex-row items-center gap-3"><div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary"><k.icon data-icon="card" /></div><Card.Title class="text-sm">{k.label}</Card.Title></Card.Header>
					<Card.Content><div class="text-2xl font-bold">{k.value}</div><p class="text-muted-foreground text-xs">{k.target}</p></Card.Content>
					<Card.Footer><Badge variant={k.ok ? 'success' : 'warning'}>{k.ok ? 'Above target' : 'Watch'}</Badge></Card.Footer>
				</Card.Root>
			{/each}
		</section>
	{/if}

	<Card.Root>
		<Card.Header><Card.Title>Utilisasi agent</Card.Title><Card.Description>Interaksi vs tiket diproses.</Card.Description></Card.Header>
		<Card.Content class="flex flex-col gap-4">
			<div class="flex flex-col gap-2">{#each rows as r}<div class="flex items-center gap-3"><Badge variant="outline" class="min-w-24 justify-center">{r.name.split(' ')[0]}</Badge><Progress value={r.util} class="flex-1" /><span class="text-xs font-medium">{r.util}%</span></div>{/each}</div>
			{#if rows.length === 0}
				<Empty.Root><Empty.Header><Empty.Title>Belum ada data</Empty.Title><Empty.Description>Data produktivitas akan muncul di sini.</Empty.Description></Empty.Header></Empty.Root>
			{:else}
				<Table.Root><Table.Header><Table.Row><Table.Head>Agent</Table.Head><Table.Head>Total Interaksi</Table.Head><Table.Head>Tiket</Table.Head><Table.Head>Near SLA</Table.Head><Table.Head>Over SLA</Table.Head><Table.Head>Utilisasi</Table.Head></Table.Row></Table.Header>
				<Table.Body>{#each rows as r}<Table.Row><Table.Cell><div class="flex items-center gap-2"><Avatar.Root class="size-7"><Avatar.Fallback>{r.name.slice(0, 1)}</Avatar.Fallback></Avatar.Root><span class="font-medium">{r.name}</span></div></Table.Cell><Table.Cell>{r.interaksi}</Table.Cell><Table.Cell>{r.tiket}</Table.Cell><Table.Cell><Tooltip.Root><Tooltip.Trigger><Badge variant="warning">{r.near}</Badge></Tooltip.Trigger><Tooltip.Content>Mendekati SLA</Tooltip.Content></Tooltip.Root></Table.Cell><Table.Cell><Badge variant="destructive">{r.over}</Badge></Table.Cell><Table.Cell><div class="flex items-center gap-2"><Progress value={r.util} class="w-24" /><span class="text-xs">{r.util}%</span></div></Table.Cell></Table.Row>{/each}</Table.Body></Table.Root>
			{/if}
		</Card.Content>
		<Card.Footer><Separator class="my-1" /><div class="flex items-center justify-between gap-2"><p class="text-muted-foreground flex items-center gap-1 text-xs"><Info data-icon="inline" /> Klik Near/Over SLA untuk daftar tiket.</p><Button size="sm" variant="outline" onclick={() => (open = true)}>Lihat SLA</Button></div></Card.Footer>
	</Card.Root>

	<Alert.Root variant="warning"><TriangleAlert data-icon="alert" /><Alert.Description>7 tiket mendekati SLA — prioritaskan antrean.</Alert.Description></Alert.Root>
</div>

<Dialog.Root bind:open><Dialog.Content class="sm:max-w-md"><Dialog.Header><Dialog.Title>Tiket Near SLA</Dialog.Title><Dialog.Description>7 tiket membutuhkan perhatian dalam 2 jam.</Dialog.Description></Dialog.Header><Dialog.Footer><Button variant="outline" onclick={() => (open = false)}>Tutup</Button><Button onclick={() => { open = false; toast.success('Membuka daftar tiket'); goto('/ticketing'); }}>Buka tiket</Button></Dialog.Footer></Dialog.Content></Dialog.Root>

