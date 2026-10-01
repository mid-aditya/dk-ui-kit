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
	import * as Chart from '$lib/components/ui/chart';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import { Slider } from '$lib/components/ui/slider';
	import { Switch } from '$lib/components/ui/switch';
	import { Chart as LCChart, Svg, Axis, Grid, Bars } from 'layerchart';
	import { Search, Star, Download, RotateCcw, TriangleAlert, MessagesSquare, SlidersHorizontal } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			docTitle: 'CSAT Interaction — DK UI Kit', heading: 'CSAT Interaction',
			sub: 'Rating per interaksi & agent: distribusi bintang 1–5, rata-rata skor, dan komentar.',
			reset: 'Reset', export: 'Ekspor',
			kTotal: 'Total interaksi ternilai', kAvg: 'Rata-rata skor',
			kAbove: 'Agent di atas target (≥ 4.0)', kTarget: 'Target CSAT interaksi: 4.0/5.0',
			coachT: 'Perlu coaching', coachMid: 'agent di bawah 3.8 — jadwalkan review interaksi minggu ini.',
			filterT: 'Filter interaksi', fChannel: 'Channel', fAllChannel: 'Semua channel',
			fAgent: 'Agent', fAllAgent: 'Semua agent', fMin: 'Skor minimum:',
			fSearch: 'Pencarian', fSearchPh: 'Cari agent / channel',
			onlyComment: 'Hanya yang ada komentar', viewTable: 'Tabel', viewChart: 'Grafik',
			chartT: 'Rata-rata skor per agent', chartPre: 'Visualisasi', chartEnd: 'agent yang lolos filter.',
			cfgAvg: 'Rata-rata skor',
			tblT: 'Rating per agent', tblAgents: 'agent', tblInteractions: 'interaksi.',
			badgeTarget: 'Target ≥ 4.0',
			hAgent: 'Agent', hChannel: 'Channel', hInter: 'Interaksi', hAvg: 'Rata-rata', hDist: 'Distribusi 5→1', hComment: 'Komentar', hAction: 'Aksi',
			commentYes: 'Ada', commentNo: 'Tidak', detailBtn: 'Detail',
			emptyT: 'Tidak ada interaksi', emptyD: 'Tidak ada agent yang cocok — longgarkan skor minimum atau matikan filter komentar.',
			dlgT: 'Detail interaksi —', dlgD: 'Ringkasan rating, tren mingguan, dan contoh komentar pelanggan.',
			dlgAvg: 'Rata-rata 4 minggu', dlgQuote: '“Agent sigap dan solutif.” — contoh komentar CSAT 5 bintang.',
			close: 'Tutup'
		},
		en: {
			docTitle: 'CSAT Interaction — DK UI Kit', heading: 'CSAT Interaction',
			sub: 'Per-interaction & agent ratings: 1–5 star distribution, average score, and comments.',
			reset: 'Reset', export: 'Export',
			kTotal: 'Total rated interactions', kAvg: 'Average score',
			kAbove: 'Agents above target (≥ 4.0)', kTarget: 'Interaction CSAT target: 4.0/5.0',
			coachT: 'Coaching needed', coachMid: 'agents below 3.8 — schedule an interaction review this week.',
			filterT: 'Interaction filters', fChannel: 'Channel', fAllChannel: 'All channels',
			fAgent: 'Agent', fAllAgent: 'All agents', fMin: 'Minimum score:',
			fSearch: 'Search', fSearchPh: 'Search agent / channel',
			onlyComment: 'Only with comments', viewTable: 'Table', viewChart: 'Chart',
			chartT: 'Average score per agent', chartPre: 'Visualizing', chartEnd: 'agents passing the filter.',
			cfgAvg: 'Average score',
			tblT: 'Rating per agent', tblAgents: 'agents', tblInteractions: 'interactions.',
			badgeTarget: 'Target ≥ 4.0',
			hAgent: 'Agent', hChannel: 'Channel', hInter: 'Interactions', hAvg: 'Average', hDist: 'Distribution 5→1', hComment: 'Comments', hAction: 'Actions',
			commentYes: 'Yes', commentNo: 'No', detailBtn: 'Details',
			emptyT: 'No interactions', emptyD: 'No matching agents — lower the minimum score or turn off the comment filter.',
			dlgT: 'Interaction details —', dlgD: 'Rating summary, weekly trend, and sample customer comments.',
			dlgAvg: '4-week average', dlgQuote: '"Fast and helpful agent." — sample 5-star CSAT comment.',
			close: 'Close'
		},
		th: {
			docTitle: 'ปฏิสัมพันธ์ CSAT — DK UI Kit', heading: 'ปฏิสัมพันธ์ CSAT',
			sub: 'คะแนนรายปฏิสัมพันธ์ & เอเจนต์: การกระจายดาว 1–5 คะแนนเฉลี่ย และความคิดเห็น',
			reset: 'รีเซ็ต', export: 'ส่งออก',
			kTotal: 'ปฏิสัมพันธ์ที่ได้คะแนนทั้งหมด', kAvg: 'คะแนนเฉลี่ย',
			kAbove: 'เอเจนต์ที่เกินเป้า (≥ 4.0)', kTarget: 'เป้า CSAT ปฏิสัมพันธ์: 4.0/5.0',
			coachT: 'ต้องโค้ชชิ่ง', coachMid: 'เอเจนต์ต่ำกว่า 3.8 — นัดทบทวนปฏิสัมพันธ์สัปดาห์นี้',
			filterT: 'ตัวกรองปฏิสัมพันธ์', fChannel: 'ช่องทาง', fAllChannel: 'ทุกช่องทาง',
			fAgent: 'เอเจนต์', fAllAgent: 'เอเจนต์ทั้งหมด', fMin: 'คะแนนขั้นต่ำ:',
			fSearch: 'ค้นหา', fSearchPh: 'ค้นหาเอเจนต์ / ช่องทาง',
			onlyComment: 'เฉพาะที่มีความคิดเห็น', viewTable: 'ตาราง', viewChart: 'กราฟ',
			chartT: 'คะแนนเฉลี่ยต่อเอเจนต์', chartPre: 'แสดงภาพ', chartEnd: 'เอเจนต์ที่ผ่านตัวกรอง',
			cfgAvg: 'คะแนนเฉลี่ย',
			tblT: 'คะแนนต่อเอเจนต์', tblAgents: 'เอเจนต์', tblInteractions: 'ปฏิสัมพันธ์',
			badgeTarget: 'เป้า ≥ 4.0',
			hAgent: 'เอเจนต์', hChannel: 'ช่องทาง', hInter: 'ปฏิสัมพันธ์', hAvg: 'เฉลี่ย', hDist: 'กระจาย 5→1', hComment: 'ความคิดเห็น', hAction: 'จัดการ',
			commentYes: 'มี', commentNo: 'ไม่มี', detailBtn: 'รายละเอียด',
			emptyT: 'ไม่มีปฏิสัมพันธ์', emptyD: 'ไม่มีเอเจนต์ที่ตรง — ลดคะแนนขั้นต่ำหรือปิดตัวกรองความคิดเห็น',
			dlgT: 'รายละเอียดปฏิสัมพันธ์ —', dlgD: 'สรุปคะแนน แนวโน้มรายสัปดาห์ และตัวอย่างความคิดเห็นลูกค้า',
			dlgAvg: 'เฉลี่ย 4 สัปดาห์', dlgQuote: '“เอเจนต์รวดเร็วและช่วยเหลือดี” — ตัวอย่างความคิดเห็น CSAT 5 ดาว',
			close: 'ปิด'
		},
		tl: {
			docTitle: 'CSAT Interaction — DK UI Kit', heading: 'CSAT Interaction',
			sub: 'Rating bawat interaksyon & agent: distribusyon ng 1–5 bituin, average na iskor, at komento.',
			reset: 'I-reset', export: 'I-export',
			kTotal: 'Kabuuang interaksyong na-rate', kAvg: 'Average na iskor',
			kAbove: 'Mga agent na lampas sa target (≥ 4.0)', kTarget: 'Target ng interaction CSAT: 4.0/5.0',
			coachT: 'Kailangan ng coaching', coachMid: 'agent na below 3.8 — mag-iskedyul ng review ngayong linggo.',
			filterT: 'Mga filter ng interaksyon', fChannel: 'Channel', fAllChannel: 'Lahat ng channel',
			fAgent: 'Agent', fAllAgent: 'Lahat ng agent', fMin: 'Minimum na iskor:',
			fSearch: 'Paghahanap', fSearchPh: 'Maghanap ng agent / channel',
			onlyComment: 'May komento lamang', viewTable: 'Talahanayan', viewChart: 'Grap',
			chartT: 'Average na iskor bawat agent', chartPre: 'Ipinapakita ang', chartEnd: 'agent na pumasa sa filter.',
			cfgAvg: 'Average na iskor',
			tblT: 'Rating bawat agent', tblAgents: 'agent', tblInteractions: 'interaksyon.',
			badgeTarget: 'Target ≥ 4.0',
			hAgent: 'Agent', hChannel: 'Channel', hInter: 'Interaksyon', hAvg: 'Average', hDist: 'Distribusyon 5→1', hComment: 'Komento', hAction: 'Aksyon',
			commentYes: 'Mayroon', commentNo: 'Wala', detailBtn: 'Detalye',
			emptyT: 'Walang interaksyon', emptyD: 'Walang tumutugmang agent — babaan ang minimum na iskor o i-off ang comment filter.',
			dlgT: 'Detalye ng interaksyon —', dlgD: 'Buod ng rating, lingguhang trend, at halimbawang komento ng customer.',
			dlgAvg: 'Average ng 4 na linggo', dlgQuote: '"Mabilis at matulungin ang agent." — halimbawang 5-star CSAT comment.',
			close: 'Isara'
		}
	} as const;
	let s = $derived(STR[$locale]);

	let channel = $state('all');
	let agent = $state('all');
	let view: string | undefined = $state('table');
	let minScore = $state(1);
	let onlyComment = $state(false);
	let search = $state('');
	let page = $state(1);
	const perPage = 5;
	let detailOpen = $state(false);
	let detailName = $state('');

	type Row = { agent: string; channel: string; interactions: number; avg: number; s5: number; s4: number; s3: number; s2: number; s1: number; comment: boolean };
	const rows: Row[] = [
		{ agent: 'Ayu Lestari', channel: 'WhatsApp', interactions: 86, avg: 4.7, s5: 64, s4: 14, s3: 5, s2: 2, s1: 1, comment: true },
		{ agent: 'Rizky Pratama', channel: 'Voice', interactions: 74, avg: 4.4, s5: 48, s4: 16, s3: 6, s2: 3, s1: 1, comment: true },
		{ agent: 'Dewi Anggraini', channel: 'Live Chat', interactions: 69, avg: 4.2, s5: 40, s4: 17, s3: 8, s2: 2, s1: 2, comment: false },
		{ agent: 'Fajar Nugraha', channel: 'Email', interactions: 52, avg: 4.0, s5: 28, s4: 12, s3: 7, s2: 3, s1: 2, comment: true },
		{ agent: 'Sari Wulandari', channel: 'WhatsApp', interactions: 47, avg: 3.8, s5: 22, s4: 12, s3: 8, s2: 3, s1: 2, comment: false },
		{ agent: 'Budi Hartono', channel: 'Voice', interactions: 41, avg: 3.6, s5: 16, s4: 11, s3: 8, s2: 4, s1: 2, comment: false }
	];

	const filtered = $derived(rows.filter((r) => {
		if (channel !== 'all' && r.channel !== channel) return false;
		if (agent !== 'all' && r.agent !== agent) return false;
		if (r.avg < minScore) return false;
		if (onlyComment && !r.comment) return false;
		const q = search.trim().toLowerCase();
		if (q && !`${r.agent} ${r.channel}`.toLowerCase().includes(q)) return false;
		return true;
	}));
	const totalInteractions = $derived(filtered.reduce((n, r) => n + r.interactions, 0));
	const avgAll = $derived(filtered.length ? filtered.reduce((n, r) => n + r.avg * r.interactions, 0) / Math.max(1, totalInteractions) : 0);
	const pageCount = $derived(Math.max(1, Math.ceil(filtered.length / perPage)));
	const safePage = $derived(Math.min(page, pageCount));
	const pageRows = $derived(filtered.slice((safePage - 1) * perPage, safePage * perPage));
	const barData = $derived(filtered.map((r) => ({ label: r.agent.split(' ')[0], value: Number(r.avg.toFixed(1)) })));
	let chartConfig = $derived({ value: { label: s.cfgAvg } });

	function openDetail(name: string) { detailName = name; detailOpen = true; }
	function reset() { channel = 'all'; agent = 'all'; minScore = 1; onlyComment = false; search = ''; page = 1; }
	function stars(v: number) { return Array.from({ length: 5 }, (_, i) => i < Math.round(v)); }
</script>

<svelte:head><title>{s.docTitle}</title></svelte:head>

<div class="flex flex-col gap-6">
	<div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-end">
		<div><h1 class="flex items-center gap-2 text-xl font-bold"><MessagesSquare size={20} class="text-primary" />{s.heading}</h1><p class="mt-1 text-sm text-muted-foreground">{s.sub}</p></div>
		<div class="flex gap-2"><Button size="sm" variant="outline" onclick={reset}><RotateCcw data-icon="inline-start" />{s.reset}</Button><Button size="sm"><Download data-icon="inline-start" />{s.export}</Button></div>
	</div>

	<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
		<Card.Root><Card.Content class="p-4"><p class="text-xs text-muted-foreground">{s.kTotal}</p><p class="mt-1 text-2xl font-bold">{totalInteractions}</p><Progress value={Math.min(100, totalInteractions / 4)} class="mt-3" /></Card.Content></Card.Root>
		<Card.Root><Card.Content class="p-4"><p class="text-xs text-muted-foreground">{s.kAvg}</p><p class="mt-1 flex items-center gap-1 text-2xl font-bold"><Star size={20} class="fill-amber-400 text-amber-400" />{avgAll.toFixed(1)}</p><div class="mt-2 flex gap-0.5">{#each stars(avgAll) as on}<Star size={14} class={on ? 'fill-amber-400 text-amber-400' : 'text-muted-foreground'} />{/each}</div></Card.Content></Card.Root>
		<Card.Root><Card.Content class="p-4"><p class="text-xs text-muted-foreground">{s.kAbove}</p><p class="mt-1 text-2xl font-bold">{filtered.filter((r) => r.avg >= 4).length}/{filtered.length}</p><p class="mt-2 text-xs text-muted-foreground">{s.kTarget}</p></Card.Content></Card.Root>
	</div>

	{#if filtered.some((r) => r.avg < 3.8)}
		<Alert.Root variant="destructive"><TriangleAlert /><Alert.Title>{s.coachT}</Alert.Title><Alert.Description>{filtered.filter((r) => r.avg < 3.8).length} {s.coachMid}</Alert.Description></Alert.Root>
	{/if}

	<Card.Root>
		<Card.Header><Card.Title class="flex items-center gap-2"><SlidersHorizontal size={16} />{s.filterT}</Card.Title></Card.Header>
		<Card.Content>
			<Field.FieldGroup class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
				<Field.Field><Field.Label for="ci-channel">{s.fChannel}</Field.Label>
					<Select.Root type="single" bind:value={channel}><Select.Trigger id="ci-channel"><Select.Value placeholder={s.fAllChannel} /></Select.Trigger><Select.Content><Select.Item value="all">{s.fAllChannel}</Select.Item><Select.Item value="WhatsApp">WhatsApp</Select.Item><Select.Item value="Voice">Voice</Select.Item><Select.Item value="Live Chat">Live Chat</Select.Item><Select.Item value="Email">Email</Select.Item></Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label for="ci-agent">{s.fAgent}</Field.Label>
					<Select.Root type="single" bind:value={agent}><Select.Trigger id="ci-agent"><Select.Value placeholder={s.fAllAgent} /></Select.Trigger><Select.Content><Select.Item value="all">{s.fAllAgent}</Select.Item>{#each rows as r}<Select.Item value={r.agent}>{r.agent}</Select.Item>{/each}</Select.Content></Select.Root>
				</Field.Field>
				<Field.Field><Field.Label for="ci-min">{s.fMin} {minScore.toFixed(1)}</Field.Label><Slider id="ci-min" type="single" bind:value={minScore} min={1} max={5} step={0.5} /></Field.Field>
				<Field.Field><Field.Label for="ci-q">{s.fSearch}</Field.Label><div class="relative"><Search size={15} class="absolute top-1/2 left-2.5 -translate-y-1/2 text-muted-foreground" /><Input id="ci-q" bind:value={search} placeholder={s.fSearchPh} class="pl-8" /></div></Field.Field>
			</Field.FieldGroup>
			<div class="mt-4 flex flex-wrap items-center justify-between gap-3">
				<label class="flex items-center gap-2 text-sm"><Switch bind:checked={onlyComment} />{s.onlyComment}</label>
				<ToggleGroup.Root type="single" bind:value={view} class="justify-start"><ToggleGroup.Item value="table">{s.viewTable}</ToggleGroup.Item><ToggleGroup.Item value="chart">{s.viewChart}</ToggleGroup.Item></ToggleGroup.Root>
			</div>
		</Card.Content>
	</Card.Root>

	{#if view === 'chart'}
		<Card.Root>
			<Card.Header><Card.Title>{s.chartT}</Card.Title><p class="text-sm text-muted-foreground">{s.chartPre} {filtered.length} {s.chartEnd}</p></Card.Header>
			<Card.Content>
				<Chart.Container config={chartConfig} class="aspect-auto h-72">
					<LCChart data={barData} x="label" y="value" padding={{ left: 8, right: 8 }}>
						<Svg><Grid vertical={false} /><Axis placement="bottom" /><Axis placement="left" grid rule domain={[0, 5]} /><Bars radius={6} /></Svg>
					</LCChart>
				</Chart.Container>
			</Card.Content>
		</Card.Root>
	{/if}

	<Card.Root>
		<Card.Header class="flex-row items-center justify-between space-y-0"><div><Card.Title>{s.tblT}</Card.Title><p class="mt-1 text-sm text-muted-foreground">{filtered.length} {s.tblAgents} · {totalInteractions} {s.tblInteractions}</p></div><Badge variant="secondary">{s.badgeTarget}</Badge></Card.Header>
		<Card.Content>
			{#if filtered.length > 0}
				<div class="overflow-x-auto rounded-xl border">
					<Table.Root>
						<Table.Header><Table.Row><Table.Head>{s.hAgent}</Table.Head><Table.Head>{s.hChannel}</Table.Head><Table.Head class="text-right">{s.hInter}</Table.Head><Table.Head>{s.hAvg}</Table.Head><Table.Head>{s.hDist}</Table.Head><Table.Head>{s.hComment}</Table.Head><Table.Head class="text-right">{s.hAction}</Table.Head></Table.Row></Table.Header>
						<Table.Body>
							{#each pageRows as r}
								<Table.Row>
									<Table.Cell class="font-medium">{r.agent}</Table.Cell>
									<Table.Cell><Badge variant="outline">{r.channel}</Badge></Table.Cell>
									<Table.Cell class="text-right">{r.interactions}</Table.Cell>
									<Table.Cell><span class="flex items-center gap-1 font-semibold"><Star size={13} class="fill-amber-400 text-amber-400" />{r.avg.toFixed(1)}</span><Progress value={(r.avg / 5) * 100} class="mt-1 w-24" /></Table.Cell>
									<Table.Cell class="text-xs text-muted-foreground">{r.s5} · {r.s4} · {r.s3} · {r.s2} · {r.s1}</Table.Cell>
									<Table.Cell>{#if r.comment}<Badge variant="success">{s.commentYes}</Badge>{:else}<Badge variant="secondary">{s.commentNo}</Badge>{/if}</Table.Cell>
									<Table.Cell class="text-right"><Button size="sm" variant="outline" onclick={() => openDetail(r.agent)}>{s.detailBtn}</Button></Table.Cell>
								</Table.Row>
							{/each}
						</Table.Body>
					</Table.Root>
				</div>
				<Separator class="my-4" />
				<div class="flex justify-center">
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
				<Empty.Root class="border border-dashed"><Empty.Header><Empty.Media><Search size={20} /></Empty.Media><Empty.Title>{s.emptyT}</Empty.Title><Empty.Description>{s.emptyD}</Empty.Description></Empty.Header><Empty.Content><Button size="sm" variant="outline" onclick={reset}>{s.reset}</Button></Empty.Content></Empty.Root>
			{/if}
		</Card.Content>
	</Card.Root>

	<Dialog.Root bind:open={detailOpen}>
		<Dialog.Content>
			<Dialog.Header><Dialog.Title>{s.dlgT} {detailName}</Dialog.Title><Dialog.Description>{s.dlgD}</Dialog.Description></Dialog.Header>
			<div class="flex flex-col gap-3 text-sm">
				<div class="flex items-center justify-between rounded-lg bg-muted/50 p-3"><span class="text-muted-foreground">{s.dlgAvg}</span><span class="font-semibold">4.3 / 5.0</span></div>
				<Progress value={86} />
				<p class="text-muted-foreground">{s.dlgQuote}</p>
			</div>
			<Dialog.Footer><Button size="sm" variant="outline" onclick={() => (detailOpen = false)}>{s.close}</Button></Dialog.Footer>
		</Dialog.Content>
	</Dialog.Root>
</div>
