<script lang="ts">
	import { onMount } from 'svelte';

	type Skill = { name: string; que: number; notReady: number; ready: number; abn: number; scr: number; answered: number };

	let now = $state(new Date());
	let lastUpdated = $state(new Date());
	let incoming = $state(753);
	let queue = $state(7);
	let answered = $state(624);
	let abandoned = $state(129);
	let incomingCall = $state(345);
	let answeredCall = $state(222);
	let waitQueue = $state(1);

	const skills = $state<Skill[]>([
		{ name: 'NOTARIAT', que: 0, notReady: 9, ready: 24, abn: 5.2, scr: 94.8, answered: 128 },
		{ name: 'WASIAT', que: 0, notReady: 9, ready: 24, abn: 0.9, scr: 99.1, answered: 115 },
		{ name: 'FIDUSIA', que: 0, notReady: 9, ready: 24, abn: 0.0, scr: 100.0, answered: 22 },
		{ name: 'YAYASAN', que: 0, notReady: 9, ready: 24, abn: 4.8, scr: 95.2, answered: 20 },
		{ name: 'PERKUMPULAN', que: 0, notReady: 9, ready: 24, abn: 0.0, scr: 100.0, answered: 2 },
		{ name: 'LEGALISASI', que: 0, notReady: 9, ready: 24, abn: 0.0, scr: 100.0, answered: 1 },
		{ name: 'APOSTILE', que: 0, notReady: 9, ready: 24, abn: 11.1, scr: 88.9, answered: 8 },
		{ name: 'KEWARGANEGARAAN', que: 0, notReady: 9, ready: 24, abn: 50.0, scr: 50.0, answered: 1 }
	]);

	const konsultasi = [
		{ no: 1, sub: 'NOTARIAT', total: 125 },
		{ no: 2, sub: 'PERSEKUTUAN KOMANDITER CV', total: 95 },
		{ no: 3, sub: 'PERSEROAN TERBATAS', total: 82 },
		{ no: 4, sub: 'WASIAT', total: 80 }
	];
	const aduan = [
		{ no: 1, sub: 'SYSTEM TI', total: 195 },
		{ no: 2, sub: 'NOTARIAT', total: 77 },
		{ no: 3, sub: 'PERSEKUTUAN KOMANDITER CV', total: 59 },
		{ no: 4, sub: 'WASIAT', total: 58 }
	];
	const mpps = [
		{ name: 'MPP KOTA TANGGERANG', kon: 0, adu: 0, cet: 0 },
		{ name: 'MPP JAKARTA', kon: 9, adu: 2, cet: 4 },
		{ name: 'MPP JAKARTA BARAT', kon: 0, adu: 0, cet: 0 },
		{ name: 'MPP KAB BOGOR', kon: 1, adu: 0, cet: 2 },
		{ name: 'GPP KAB TANGGERANG', kon: 0, adu: 0, cet: 1 },
		{ name: 'MPP KOTA BOGOR', kon: 1, adu: 0, cet: 2 }
	];

	const dayFmt = new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
	const timeFmt = new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

	onMount(() => {
		const clock = setInterval(() => (now = new Date()), 1000);
		const tick = setInterval(() => {
			const d = Math.random() > 0.4 ? 1 : -1;
			queue = Math.max(0, queue + d);
			incoming += Math.max(0, d);
			if (d > 0) answered += 1;
			else abandoned += 1;
			lastUpdated = new Date();
		}, 15000);
		return () => {
			clearInterval(clock);
			clearInterval(tick);
		};
	});
</script>

<svelte:head><title>Wallboard AHU — DK UI Kit</title></svelte:head>

<div class="flex min-h-svh flex-col gap-3 bg-slate-950 p-3 text-slate-100">
	<header class="flex flex-wrap items-center gap-3">
		<div class="flex items-center gap-2">
			<img src="/favicon.svg" alt="Logo" class="size-8 rounded-md" />
			<h1 class="text-xl font-bold tracking-tight">Wallboard AHU</h1>
		</div>
		<div class="ms-auto rounded-lg border border-slate-800 bg-slate-900/70 px-3 py-1.5 text-right">
			<p class="text-xs font-semibold tracking-wide uppercase">{dayFmt.format(now)} pukul {timeFmt.format(now)}</p>
			<p class="text-[10px] tracking-wide text-slate-400 uppercase">Last updated at {timeFmt.format(lastUpdated)}</p>
		</div>
	</header>

	<div class="grid flex-1 gap-3 xl:grid-cols-[250px_minmax(0,1fr)_250px]">
		<!-- Kolom kiri -->
		<div class="grid grid-cols-2 content-start gap-3">
			<section class="rounded-xl border border-slate-800 bg-blue-600 p-3" aria-label="SCR">
				<p class="inline-block rounded bg-blue-800/60 px-1.5 py-0.5 text-[10px] font-bold tracking-wider">SCR</p>
				<p class="mt-1 text-4xl font-bold tabular-nums">82<span class="text-lg">.9</span><span class="text-sm font-medium"> %</span></p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-amber-500 p-3 text-slate-950" aria-label="ABN">
				<p class="inline-block rounded bg-amber-700/40 px-1.5 py-0.5 text-[10px] font-bold tracking-wider">ABN</p>
				<p class="mt-1 text-4xl font-bold tabular-nums">17<span class="text-lg">.1</span><span class="text-sm font-medium"> %</span></p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Incoming">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">INCOMING</p>
				<p class="text-4xl font-bold tabular-nums">{incoming}</p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Queue">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">QUEUE</p>
				<p class="text-4xl font-bold tabular-nums text-amber-400">{queue}</p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Answered">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">ANSWERED</p>
				<p class="text-4xl font-bold tabular-nums text-green-400">{answered}</p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Abandoned">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">ABANDONED</p>
				<p class="text-4xl font-bold tabular-nums text-red-400">{abandoned}</p>
			</section>
			<section class="col-span-2 rounded-xl border border-slate-800 bg-blue-600 p-3" aria-label="SCR Email">
				<p class="inline-block rounded bg-blue-800/60 px-1.5 py-0.5 text-[10px] font-bold tracking-wider">SCR EMAIL</p>
				<p class="mt-1 text-4xl font-bold tabular-nums">74<span class="text-lg">.5</span><span class="text-sm font-medium"> %</span></p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Total Email">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">TOTAL EMAIL</p>
				<p class="text-4xl font-bold tabular-nums">470</p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Distributed">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">DISTRIBUTED</p>
				<p class="text-4xl font-bold tabular-nums text-amber-400">161</p>
			</section>
			<section class="col-span-2 flex items-center justify-between rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Email Answered">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">ANSWERED</p>
				<p class="text-4xl font-bold tabular-nums text-green-400">120</p>
			</section>
		</div>

		<!-- Tengah -->
		<div class="flex min-w-0 flex-col gap-3">
			<section class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900/70" aria-label="Skill">
				<div class="overflow-x-auto">
					<table class="w-full min-w-[640px] text-sm">
						<thead>
							<tr class="text-left text-[11px] tracking-wider text-slate-400">
								<th class="px-4 py-2.5 font-semibold">SKILL</th>
								<th class="px-4 py-2.5 text-center font-semibold">QUE</th>
								<th class="px-4 py-2.5 text-center font-semibold">NOT READY</th>
								<th class="px-4 py-2.5 text-center font-semibold">READY</th>
								<th class="px-4 py-2.5 text-center font-semibold">ABN %</th>
								<th class="px-4 py-2.5 text-center font-semibold">SCR %</th>
								<th class="px-4 py-2.5 text-center font-semibold">ANSWERED</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-800/70">
							{#each skills as s (s.name)}
								<tr class="tabular-nums">
									<td class="px-4 py-2 font-semibold">{s.name}</td>
									<td class="px-4 py-2 text-center text-amber-400">{s.que}</td>
									<td class="px-4 py-2 text-center text-red-400">{s.notReady}</td>
									<td class="px-4 py-2 text-center text-green-400">{s.ready}</td>
									<td class="px-4 py-2 text-center text-red-400">{s.abn.toFixed(1)}%</td>
									<td class="px-4 py-2 text-center text-green-400">{s.scr.toFixed(1)}%</td>
									<td class="px-4 py-2 text-center">{s.answered}</td>
								</tr>
							{/each}
						</tbody>
					</table>
				</div>
			</section>
			<div class="grid gap-3 lg:grid-cols-2">
				<section class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900/70" aria-label="Konsultasi">
					<table class="w-full text-sm">
						<thead>
							<tr class="text-left text-[11px] tracking-wider text-slate-400">
								<th class="px-4 py-2.5 font-semibold">KONSULTASI</th>
								<th class="px-4 py-2.5 font-semibold">SUBCATEGORY</th>
								<th class="px-4 py-2.5 text-right font-semibold">TOTAL</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-800/70 tabular-nums">
							{#each konsultasi as k (k.no)}
								<tr><td class="px-4 py-2 text-slate-400">{k.no}</td><td class="px-4 py-2">{k.sub}</td><td class="px-4 py-2 text-right">{k.total}</td></tr>
							{/each}
						</tbody>
					</table>
				</section>
				<section class="overflow-hidden rounded-xl border border-slate-800 bg-slate-900/70" aria-label="Aduan">
					<table class="w-full text-sm">
						<thead>
							<tr class="text-left text-[11px] tracking-wider text-slate-400">
								<th class="px-4 py-2.5 font-semibold">ADUAN</th>
								<th class="px-4 py-2.5 font-semibold">SUBCATEGORY</th>
								<th class="px-4 py-2.5 text-right font-semibold">TOTAL</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-800/70 tabular-nums">
							{#each aduan as a (a.no)}
								<tr><td class="px-4 py-2 text-slate-400">{a.no}</td><td class="px-4 py-2">{a.sub}</td><td class="px-4 py-2 text-right">{a.total}</td></tr>
							{/each}
						</tbody>
					</table>
				</section>
			</div>
		</div>

		<!-- Kolom kanan -->
		<div class="grid grid-cols-2 content-start gap-3">
			<section class="col-span-2 rounded-xl border border-slate-800 bg-green-600 p-3" aria-label="SCR WA Chat">
				<p class="inline-block rounded bg-green-800/60 px-1.5 py-0.5 text-[10px] font-bold tracking-wider">SCR WA CHAT</p>
				<p class="mt-1 text-4xl font-bold tabular-nums">0<span class="text-sm font-medium"> %</span></p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Wait in Queue">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">WAIT IN QUEUE</p>
				<p class="text-3xl font-bold tabular-nums text-amber-400">0</p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Incoming Chat">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">INCOMING CHAT</p>
				<p class="text-3xl font-bold tabular-nums text-purple-400">0</p>
			</section>
			<section class="col-span-2 flex items-center justify-between rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Chat Answered">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">ANSWERED</p>
				<p class="text-3xl font-bold tabular-nums text-blue-400">0</p>
			</section>
			<section class="col-span-2 rounded-xl border border-slate-800 bg-green-600 p-3" aria-label="SCR WA Call">
				<p class="inline-block rounded bg-green-800/60 px-1.5 py-0.5 text-[10px] font-bold tracking-wider">SCR WA CALL</p>
				<p class="mt-1 text-4xl font-bold tabular-nums">64<span class="text-lg">.3</span><span class="text-sm font-medium"> %</span></p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Wait in Queue Call">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">WAIT IN QUEUE</p>
				<p class="text-3xl font-bold tabular-nums text-amber-400">{waitQueue}</p>
			</section>
			<section class="rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Incoming Call">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">INCOMING CALL</p>
				<p class="text-3xl font-bold tabular-nums text-purple-400">{incomingCall}</p>
			</section>
			<section class="col-span-2 flex items-center justify-between rounded-xl border border-slate-800 bg-slate-900/70 p-3" aria-label="Call Answered">
				<p class="text-[11px] font-semibold tracking-wider text-slate-400">ANSWERED</p>
				<p class="text-3xl font-bold tabular-nums text-blue-400">{answeredCall}</p>
			</section>
		</div>
	</div>

	<footer class="flex gap-3 overflow-x-auto pb-1" aria-label="MPP">
		{#each mpps as m (m.name)}
			<section class="min-w-[190px] flex-1 rounded-xl border border-slate-800 bg-slate-900/70 p-3">
				<p class="truncate text-[11px] font-semibold tracking-wider text-slate-300">{m.name}</p>
				<div class="mt-2 grid grid-cols-3 text-center tabular-nums">
					<div><p class="text-[10px] tracking-wider text-slate-500">KON</p><p class="text-lg font-bold text-blue-400">{m.kon}</p></div>
					<div><p class="text-[10px] tracking-wider text-slate-500">ADU</p><p class="text-lg font-bold text-amber-400">{m.adu}</p></div>
					<div><p class="text-[10px] tracking-wider text-slate-500">CET</p><p class="text-lg font-bold text-green-400">{m.cet}</p></div>
				</div>
			</section>
		{/each}
	</footer>
</div>
