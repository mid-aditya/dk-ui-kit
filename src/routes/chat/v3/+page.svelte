<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import { Input } from '$lib/components/ui/input';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Resizable from '$lib/components/ui/resizable';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Message from '$lib/components/ui/message';
	import * as Bubble from '$lib/components/ui/bubble';
	import * as Field from '$lib/components/ui/field';
	import * as Select from '$lib/components/ui/select';
	import { Checkbox } from '$lib/components/ui/checkbox';
	import { Progress } from '$lib/components/ui/progress';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import { toast } from 'svelte-sonner';
	import { cn } from '$lib/utils';
	import {
		Search,
		Send,
		Paperclip,
		Smile,
		Phone,
		Inbox,
		CheckCheck,
		Save,
		PhoneOff,
		History
	} from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			title: 'Omnichat Sosmed',
			inbox: 'Inbox',
			searchPh: 'Cari…',
			normal: 'Normal',
			adminLoad: 'Beban admin',
			tabMyOpen: 'My Open',
			tabServed: 'Served',
			tabResolved: 'Resolved',
			userInteraction: 'User Interaction',
			callTip: 'Mulai panggilan',
			connected: 'Chat telah terhubung. Balas pesan pelanggan dengan ramah.',
			today: 'Hari ini',
			typePh: 'Type Message…',
			send: 'Kirim',
			toastSent: 'Pesan terkirim',
			overview: 'Overview',
			endChatTab: 'End Chat Ticket',
			historyTab: 'History',
			historyTitle: 'Riwayat interaksi',
			agentName: 'Agent Name',
			agentNamePh: 'Nama agen…',
			branch: 'Select a Branch',
			branchPh: 'Pilih cabang…',
			branchGroup: 'Cabang',
			path: 'Select Complaint Path',
			pathPh: 'Pilih jalur komplain…',
			pathGroup: 'Jalur komplain',
			category: 'Category',
			categoryPh: 'Pilih kategori…',
			categoryGroup: 'Kategori',
			rtype: 'Type',
			rtypePh: 'Pilih tipe…',
			rtypeGroup: 'Tipe',
			escalation: 'Eskalasi (Layer 2)',
			escalationDesc: 'Teruskan tiket ke tim Layer 2 untuk penanganan lanjut.',
			save: 'Simpan',
			update: 'Update',
			toastSaved: 'Tiket disimpan',
			endChatBtn: 'End Chat Ticket',
			endChatDesc: 'Akhiri sesi chat dan tutup tiket? Chat akan dipindah ke Resolved.',
			endTitle: 'Akhiri chat & tutup tiket?',
			endDesc: 'Sesi chat akan ditutup dan tiket ditandai resolved.',
			endYes: 'Ya, akhiri',
			endCancel: 'Batal',
			toastEnded: 'Sesi chat diakhiri, tiket resolved',
			emptyTitle: 'Belum ada pesan',
			emptyDesc: 'Mulai percakapan dengan pelanggan.',
			hist1: 'Tiket dibuat via Live Chat',
			hist2: 'Agen membalas pelanggan',
			hist3: 'Pelanggan mengirim nomor resi'
		},
		en: {
			title: 'Omnichat Social',
			inbox: 'Inbox',
			searchPh: 'Search…',
			normal: 'Normal',
			adminLoad: 'Admin load',
			tabMyOpen: 'My Open',
			tabServed: 'Served',
			tabResolved: 'Resolved',
			userInteraction: 'User Interaction',
			callTip: 'Start call',
			connected: 'Chat is connected. Reply to the customer politely.',
			today: 'Today',
			typePh: 'Type Message…',
			send: 'Send',
			toastSent: 'Message sent',
			overview: 'Overview',
			endChatTab: 'End Chat Ticket',
			historyTab: 'History',
			historyTitle: 'Interaction history',
			agentName: 'Agent Name',
			agentNamePh: 'Agent name…',
			branch: 'Select a Branch',
			branchPh: 'Choose a branch…',
			branchGroup: 'Branches',
			path: 'Select Complaint Path',
			pathPh: 'Choose a complaint path…',
			pathGroup: 'Complaint paths',
			category: 'Category',
			categoryPh: 'Choose a category…',
			categoryGroup: 'Categories',
			rtype: 'Type',
			rtypePh: 'Choose a type…',
			rtypeGroup: 'Types',
			escalation: 'Escalation (Layer 2)',
			escalationDesc: 'Forward the ticket to the Layer 2 team for further handling.',
			save: 'Save',
			update: 'Update',
			toastSaved: 'Ticket saved',
			endChatBtn: 'End Chat Ticket',
			endChatDesc: 'End the chat session and close the ticket? The chat will move to Resolved.',
			endTitle: 'End chat & close ticket?',
			endDesc: 'The chat session will be closed and the ticket marked as resolved.',
			endYes: 'Yes, end it',
			endCancel: 'Cancel',
			toastEnded: 'Chat session ended, ticket resolved',
			emptyTitle: 'No messages yet',
			emptyDesc: 'Start a conversation with the customer.',
			hist1: 'Ticket created via Live Chat',
			hist2: 'Agent replied to customer',
			hist3: 'Customer sent the tracking number'
		},
		th: {
			title: 'Omnichat โซเชียล',
			inbox: 'กล่องข้อความ',
			searchPh: 'ค้นหา…',
			normal: 'ปกติ',
			adminLoad: 'ภาระงานแอดมิน',
			tabMyOpen: 'งานของฉัน',
			tabServed: 'ให้บริการแล้ว',
			tabResolved: 'แก้ไขแล้ว',
			userInteraction: 'การโต้ตอบผู้ใช้',
			callTip: 'เริ่มการโทร',
			connected: 'เชื่อมต่อแชทแล้ว ตอบลูกค้าอย่างสุภาพ',
			today: 'วันนี้',
			typePh: 'พิมพ์ข้อความ…',
			send: 'ส่ง',
			toastSent: 'ส่งข้อความแล้ว',
			overview: 'ภาพรวม',
			endChatTab: 'จบแชท',
			historyTab: 'ประวัติ',
			historyTitle: 'ประวัติการโต้ตอบ',
			agentName: 'ชื่อเจ้าหน้าที่',
			agentNamePh: 'ชื่อเจ้าหน้าที่…',
			branch: 'เลือกสาขา',
			branchPh: 'เลือกสาขา…',
			branchGroup: 'สาขา',
			path: 'เลือกช่องทางร้องเรียน',
			pathPh: 'เลือกช่องทางร้องเรียน…',
			pathGroup: 'ช่องทางร้องเรียน',
			category: 'หมวดหมู่',
			categoryPh: 'เลือกหมวดหมู่…',
			categoryGroup: 'หมวดหมู่',
			rtype: 'ประเภท',
			rtypePh: 'เลือกประเภท…',
			rtypeGroup: 'ประเภท',
			escalation: 'ส่งต่อ (เลเยอร์ 2)',
			escalationDesc: 'ส่งต่อตั๋วให้ทีมเลเยอร์ 2 ดำเนินการต่อ',
			save: 'บันทึก',
			update: 'อัปเดต',
			toastSaved: 'บันทึกตั๋วแล้ว',
			endChatBtn: 'จบแชท',
			endChatDesc: 'จบเซสชันแชทและปิดตั๋ว? แชทจะย้ายไปยัง Resolved',
			endTitle: 'จบแชทและปิดตั๋ว?',
			endDesc: 'เซสชันแชทจะถูกปิดและตั๋วจะถูกทำเครื่องหมายว่าแก้ไขแล้ว',
			endYes: 'ใช่ จบเลย',
			endCancel: 'ยกเลิก',
			toastEnded: 'จบเซสชันแชทแล้ว ตั๋วได้รับการแก้ไข',
			emptyTitle: 'ยังไม่มีข้อความ',
			emptyDesc: 'เริ่มการสนทนากับลูกค้า',
			hist1: 'สร้างตั๋วผ่าน Live Chat',
			hist2: 'เจ้าหน้าที่ตอบลูกค้า',
			hist3: 'ลูกค้าส่งหมายเลขพัสดุ'
		},
		tl: {
			title: 'Omnichat Social',
			inbox: 'Inbox',
			searchPh: 'Maghanap…',
			normal: 'Normal',
			adminLoad: 'Load ng admin',
			tabMyOpen: 'My Open',
			tabServed: 'Naseserbisyuhan',
			tabResolved: 'Nalutas',
			userInteraction: 'User Interaction',
			callTip: 'Simulan ang tawag',
			connected: 'Nakakonekta na ang chat. Sagutin ang customer nang magalang.',
			today: 'Ngayon',
			typePh: 'Type Message…',
			send: 'Ipadala',
			toastSent: 'Naipadala ang mensahe',
			overview: 'Overview',
			endChatTab: 'End Chat Ticket',
			historyTab: 'History',
			historyTitle: 'History ng interaksyon',
			agentName: 'Pangalan ng Agent',
			agentNamePh: 'Pangalan ng agent…',
			branch: 'Pumili ng Branch',
			branchPh: 'Pumili ng branch…',
			branchGroup: 'Branch',
			path: 'Pumili ng Complaint Path',
			pathPh: 'Pumili ng complaint path…',
			pathGroup: 'Complaint path',
			category: 'Kategorya',
			categoryPh: 'Pumili ng kategorya…',
			categoryGroup: 'Kategorya',
			rtype: 'Uri',
			rtypePh: 'Pumili ng uri…',
			rtypeGroup: 'Uri',
			escalation: 'Escalation (Layer 2)',
			escalationDesc: 'Ipasa ang ticket sa Layer 2 team para sa karagdagang aksyon.',
			save: 'I-save',
			update: 'I-update',
			toastSaved: 'Na-save ang ticket',
			endChatBtn: 'End Chat Ticket',
			endChatDesc: 'Tapusin ang chat session at isara ang ticket? Lilipat ang chat sa Resolved.',
			endTitle: 'Tapusin ang chat at isara ang ticket?',
			endDesc: 'Isasara ang chat session at mamarkahang resolved ang ticket.',
			endYes: 'Oo, tapusin',
			endCancel: 'Kanselahin',
			toastEnded: 'Natapos ang chat session, resolved ang ticket',
			emptyTitle: 'Wala pang mensahe',
			emptyDesc: 'Simulan ang pakikipag-usap sa customer.',
			hist1: 'Nalikha ang ticket via Live Chat',
			hist2: 'Sumagot ang agent sa customer',
			hist3: 'Ipinadala ng customer ang tracking number'
		}
	} as const;
	let s = $derived(STR[$locale]);

	type Queue = 'myopen' | 'served' | 'resolved';
	let inboxTab: Queue = $state('myopen');
	let ticketTab = $state('overview');

	let queues = $state([
		{ id: 1, name: 'Budi Santoso', handle: '@budi.s', snippet: 'Halo, paket saya belum sampai?', time: '10:20', unread: 3, online: true, read: false, queue: 'myopen' as Queue },
		{ id: 2, name: 'Siti Aminah', handle: '@siti.a', snippet: 'Mohon info pengajuan KTP…', time: '09:45', unread: 1, online: true, read: false, queue: 'myopen' as Queue },
		{ id: 3, name: 'Rina Marlina', handle: '@rina.m', snippet: 'Baik, saya bantu cek resi…', time: '09:00', unread: 0, online: false, read: true, queue: 'served' as Queue },
		{ id: 4, name: 'Dewi Lestari', handle: '@dewi.l', snippet: 'Oke, ditunggu kabar bot…', time: '08:30', unread: 0, online: false, read: true, queue: 'served' as Queue },
		{ id: 5, name: 'Andi Wijaya', handle: '@andi.w', snippet: 'Terima kasih atas bantuannya', time: '08:15', unread: 0, online: false, read: true, queue: 'resolved' as Queue }
	]);
	const filteredQueues = $derived(queues.filter((q) => q.queue === inboxTab));
	let selectedId = $state(1);
	const selected = $derived(queues.find((q) => q.id === selectedId) ?? queues[0]);

	const TICKET_ID = '#JKT-9374-3U128';

	let draft = $state('');
	let loading = $state(false);
	let messages = $state([
		{ id: 1, from: 'customer' as const, body: 'Halo, paket saya belum sampai?', time: '10:20' },
		{ id: 2, from: 'agent' as const, body: 'Halo kak, boleh info nomor resinya?', time: '10:22' },
		{ id: 3, from: 'customer' as const, body: 'Resi JNE123456789', time: '10:23' }
	]);

	let agentName = $state('');
	let branch = $state('');
	let complaintPath = $state('');
	let category = $state('');
	let rtype = $state('');
	let escalation = $state(false);
	let endOpen = $state(false);

	const history = $derived([
		{ id: 1, text: s.hist1, time: '10:18' },
		{ id: 2, text: s.hist2, time: '10:22' },
		{ id: 3, text: s.hist3, time: '10:23' }
	]);

	const initials = (n: string) =>
		n
			.split(' ')
			.map((w) => w[0])
			.slice(0, 2)
			.join('')
			.toUpperCase();

	function pick(id: number) {
		selectedId = id;
		loading = true;
		setTimeout(() => (loading = false), 700);
	}

	function send() {
		if (!draft.trim()) return;
		messages = [...messages, { id: Date.now(), from: 'agent' as const, body: draft.trim(), time: 'now' }];
		draft = '';
		toast.success(s.toastSent);
	}

	function saveTicket() {
		toast.success(s.toastSaved);
	}

	function confirmEnd() {
		queues = queues.map((q) => (q.id === selected.id ? { ...q, queue: 'resolved' as Queue, unread: 0 } : q));
		endOpen = false;
		inboxTab = 'resolved';
		ticketTab = 'overview';
		toast.success(s.toastEnded);
	}
</script>

<svelte:head><title>{s.title}</title></svelte:head>

<Card.Root class="h-[80vh]">
	<Card.Content class="h-full p-0">
		<Resizable.PaneGroup direction="horizontal" class="h-full">
			<!-- KOLOM KIRI — INBOX -->
			<Resizable.Pane defaultSize={24} minSize={18}>
				<div class="flex h-full flex-col gap-0">
					<div class="flex flex-col gap-2 p-3">
						<div class="flex items-center gap-2">
							<Inbox data-icon="inline-start" class="size-4 text-muted-foreground" />
							<strong class="flex-1 text-sm">{s.inbox}</strong>
							<Badge variant="secondary">{s.normal}</Badge>
						</div>
						<InputGroup.Root>
							<InputGroup.Addon><Search data-icon="inline" class="size-4" /></InputGroup.Addon>
							<InputGroup.Input placeholder={s.searchPh} />
						</InputGroup.Root>
						<div class="flex flex-col gap-1">
							<div class="flex items-center justify-between text-xs text-muted-foreground">
								<span>{s.adminLoad}</span><span>65%</span>
							</div>
							<Progress value={65} class="h-1.5" />
						</div>
					</div>
					<Separator />
					<Tabs.Root bind:value={inboxTab} class="flex min-h-0 flex-1 flex-col">
						<Tabs.List class="mx-3 mt-2 grid w-auto grid-cols-3">
							<Tabs.Trigger value="myopen">{s.tabMyOpen}</Tabs.Trigger>
							<Tabs.Trigger value="served">{s.tabServed}</Tabs.Trigger>
							<Tabs.Trigger value="resolved">{s.tabResolved}</Tabs.Trigger>
						</Tabs.List>
						<ScrollArea.Root class="min-h-0 flex-1">
							<div class="flex flex-col gap-1.5 p-3">
								{#each filteredQueues as q (q.id)}
									<button
										onclick={() => pick(q.id)}
										class={cn(
											'flex items-center gap-3 rounded-lg p-2.5 text-left hover:bg-muted/60',
											selected.id === q.id && 'bg-muted'
										)}
									>
										<span class="relative shrink-0">
											<Avatar.Root class="size-9">
												<Avatar.Fallback>{initials(q.name)}</Avatar.Fallback>
											</Avatar.Root>
											<span
												class={cn(
													'absolute -right-0.5 -bottom-0.5 size-2.5 rounded-full ring-2 ring-card',
													q.online ? 'bg-emerald-500' : 'bg-muted-foreground/40'
												)}
											></span>
										</span>
										<span class="flex min-w-0 flex-1 flex-col gap-0.5">
											<span class="flex items-center justify-between gap-2">
												<strong class="truncate text-sm">{q.name}</strong>
												<span class="shrink-0 text-[11px] text-muted-foreground">{q.time}</span>
											</span>
											<span class="flex items-center justify-between gap-2">
												<span class="flex min-w-0 flex-1 items-center gap-1 text-xs text-muted-foreground">
													{#if q.read}<CheckCheck data-icon="inline" class="size-3.5 shrink-0 text-sky-500" />{/if}
													<span class="truncate">{q.snippet}</span>
												</span>
												{#if q.unread > 0}
													<Badge variant="destructive" class="h-5 min-w-5 justify-center px-1 text-[10px]">{q.unread}</Badge>
												{/if}
											</span>
										</span>
									</button>
								{/each}
							</div>
						</ScrollArea.Root>
					</Tabs.Root>
				</div>
			</Resizable.Pane>
			<Resizable.Handle />
			<!-- KOLOM TENGAH — PERCAKAPAN -->
			<Resizable.Pane defaultSize={46} minSize={30}>
				<div class="flex h-full flex-col gap-0 border-x">
					<div class="flex flex-col gap-2 p-3">
						<div class="flex items-center gap-3">
							<Avatar.Root class="size-9">
								<Avatar.Fallback>{initials(selected.name)}</Avatar.Fallback>
							</Avatar.Root>
							<div class="flex min-w-0 flex-1 flex-col gap-0.5">
								<strong class="truncate text-sm">{selected.name}</strong>
								<span class="truncate text-xs text-muted-foreground">{selected.handle}</span>
							</div>
							<Tooltip.Provider>
								<Tooltip.Root>
									<Tooltip.Trigger>
										{#snippet child({ props })}
											<Button size="icon" variant="outline" {...props}>
												<Phone data-icon="inline" class="size-4" />
											</Button>
										{/snippet}
									</Tooltip.Trigger>
									<Tooltip.Content>{s.callTip}</Tooltip.Content>
								</Tooltip.Root>
							</Tooltip.Provider>
						</div>
						<div class="flex items-center gap-2">
							<span class="text-xs font-medium text-muted-foreground">{s.userInteraction}</span>
							<Badge variant="secondary" class="text-[11px]">{TICKET_ID}</Badge>
						</div>
					</div>
					<Separator />
					<div class="flex flex-col gap-1.5 px-3 pt-3">
						<div
							class="rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-700 dark:text-emerald-300"
						>
							{s.connected}
						</div>
						<p class="text-center text-[11px] text-muted-foreground">{s.today}</p>
					</div>
					<ScrollArea.Root class="min-h-0 flex-1">
						<div class="p-3">
							{#if loading}
								<div class="flex flex-col gap-2">
									<Skeleton class="h-10 w-2/3" />
									<Skeleton class="h-10 w-1/2 self-end" />
									<Skeleton class="h-10 w-2/3" />
								</div>
							{:else if messages.length === 0}
								<Empty.Root>
									<Empty.Header>
										<Empty.Title>{s.emptyTitle}</Empty.Title>
										<Empty.Description>{s.emptyDesc}</Empty.Description>
									</Empty.Header>
								</Empty.Root>
							{:else}
								<Message.Group>
									{#each messages as m (m.id)}
										<Message.Root class={cn('flex', m.from === 'agent' && 'justify-end')}>
											{#if m.from === 'customer'}
												<Message.Avatar>
													<Avatar.Root class="size-7">
														<Avatar.Fallback>{initials(selected.name)}</Avatar.Fallback>
													</Avatar.Root>
												</Message.Avatar>
											{/if}
											<div class="flex max-w-[75%] flex-col gap-1">
												<Bubble.Root variant={m.from === 'agent' ? 'sent' : 'received'}>
													<Bubble.Content>{m.body}</Bubble.Content>
												</Bubble.Root>
												<Message.Footer>
													{m.time}
													{#if m.from === 'agent'}<CheckCheck data-icon="inline" class="size-3" />{/if}
												</Message.Footer>
											</div>
										</Message.Root>
									{/each}
								</Message.Group>
							{/if}
						</div>
					</ScrollArea.Root>
					<div class="p-3 pt-2">
						<InputGroup.Root>
							<InputGroup.Addon>
								<Paperclip data-icon="inline" class="size-4" />
								<Smile data-icon="inline" class="size-4" />
							</InputGroup.Addon>
							<InputGroup.Input
								bind:value={draft}
								placeholder={s.typePh}
								onkeydown={(e) => {
									if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) send();
								}}
							/>
							<InputGroup.Button onclick={send}>
								<Send data-icon="inline-start" class="size-4" /> {s.send}
							</InputGroup.Button>
						</InputGroup.Root>
					</div>
				</div>
			</Resizable.Pane>
			<Resizable.Handle />
			<!-- KOLOM KANAN — PANEL TIKET -->
			<Resizable.Pane defaultSize={30} minSize={22}>
				<div class="flex h-full flex-col gap-0">
					<Tabs.Root bind:value={ticketTab} class="flex min-h-0 flex-1 flex-col">
						<Tabs.List class="mx-3 mt-3 grid w-auto grid-cols-3">
							<Tabs.Trigger value="overview">{s.overview}</Tabs.Trigger>
							<Tabs.Trigger value="endchat">{s.endChatTab}</Tabs.Trigger>
							<Tabs.Trigger value="history">{s.historyTab}</Tabs.Trigger>
						</Tabs.List>
						<ScrollArea.Root class="min-h-0 flex-1">
							<div class="p-3">
								{#if ticketTab === 'overview'}
									<Field.FieldGroup class="flex flex-col gap-3">
										<Field.Field>
											<Field.Label>{s.agentName} <span class="text-destructive">*</span></Field.Label>
											<Input bind:value={agentName} placeholder={s.agentNamePh} />
										</Field.Field>
										<Field.Field>
											<Field.Label>{s.branch} <span class="text-destructive">*</span></Field.Label>
											<Select.Root type="single" bind:value={branch}>
												<Select.Trigger class="w-full">{branch || s.branchPh}</Select.Trigger>
												<Select.Content>
													<Select.Group>
														<Select.GroupHeading>{s.branchGroup}</Select.GroupHeading>
														<Select.Item value="Jakarta">Jakarta</Select.Item>
														<Select.Item value="Bandung">Bandung</Select.Item>
														<Select.Item value="Surabaya">Surabaya</Select.Item>
													</Select.Group>
												</Select.Content>
											</Select.Root>
										</Field.Field>
										<Field.Field>
											<Field.Label>{s.path} <span class="text-destructive">*</span></Field.Label>
											<Select.Root type="single" bind:value={complaintPath}>
												<Select.Trigger class="w-full">{complaintPath || s.pathPh}</Select.Trigger>
												<Select.Content>
													<Select.Group>
														<Select.GroupHeading>{s.pathGroup}</Select.GroupHeading>
														<Select.Item value="Walk-in">Walk-in</Select.Item>
														<Select.Item value="Call Center">Call Center</Select.Item>
														<Select.Item value="Social Media">Social Media</Select.Item>
													</Select.Group>
												</Select.Content>
											</Select.Root>
										</Field.Field>
										<Field.Field>
											<Field.Label>{s.category} <span class="text-destructive">*</span></Field.Label>
											<Select.Root type="single" bind:value={category}>
												<Select.Trigger class="w-full">{category || s.categoryPh}</Select.Trigger>
												<Select.Content>
													<Select.Group>
														<Select.GroupHeading>{s.categoryGroup}</Select.GroupHeading>
														<Select.Item value="Billing">Billing</Select.Item>
														<Select.Item value="Network">Network</Select.Item>
														<Select.Item value="Device">Device</Select.Item>
													</Select.Group>
												</Select.Content>
											</Select.Root>
										</Field.Field>
										<Field.Field>
											<Field.Label>{s.rtype} <span class="text-destructive">*</span></Field.Label>
											<Select.Root type="single" bind:value={rtype}>
												<Select.Trigger class="w-full">{rtype || s.rtypePh}</Select.Trigger>
												<Select.Content>
													<Select.Group>
														<Select.GroupHeading>{s.rtypeGroup}</Select.GroupHeading>
														<Select.Item value="Complaint">Complaint</Select.Item>
														<Select.Item value="Request">Request</Select.Item>
														<Select.Item value="Inquiry">Inquiry</Select.Item>
													</Select.Group>
												</Select.Content>
											</Select.Root>
										</Field.Field>
										<Field.Field>
											<div class="flex items-start gap-2 rounded-lg border p-3">
												<Checkbox id="escalation" bind:checked={escalation} />
												<div class="flex flex-col gap-1">
													<Field.Label for="escalation">{s.escalation}</Field.Label>
													<Field.Description>{s.escalationDesc}</Field.Description>
												</div>
											</div>
										</Field.Field>
										<Button onclick={saveTicket}>
											<Save data-icon="inline-start" class="size-4" />{escalation ? s.update : s.save}
										</Button>
									</Field.FieldGroup>
								{:else if ticketTab === 'endchat'}
									<div class="flex flex-col gap-3">
										<div class="flex items-center gap-2 rounded-lg border border-destructive/30 bg-destructive/10 p-3 text-sm">
											<PhoneOff data-icon="inline" class="size-4 shrink-0 text-destructive" />
											<p class="text-xs">{s.endChatDesc}</p>
										</div>
										<Dialog.Root bind:open={endOpen}>
											<Button variant="destructive" onclick={() => (endOpen = true)}>
												<PhoneOff data-icon="inline-start" class="size-4" />{s.endChatBtn}
											</Button>
											<Dialog.Content>
												<Dialog.Header>
													<Dialog.Title>{s.endTitle}</Dialog.Title>
													<Dialog.Description>{s.endDesc}</Dialog.Description>
												</Dialog.Header>
												<Dialog.Footer>
													<Button variant="outline" onclick={() => (endOpen = false)}>{s.endCancel}</Button>
													<Button variant="destructive" onclick={confirmEnd}>{s.endYes}</Button>
												</Dialog.Footer>
											</Dialog.Content>
										</Dialog.Root>
									</div>
								{:else}
									<div class="flex flex-col gap-2">
										<p class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
											<History data-icon="inline" class="size-3.5" />{s.historyTitle}
										</p>
										<Separator />
										{#each history as h (h.id)}
											<div class="flex items-start gap-2.5 rounded-lg border p-2.5">
												<span class="mt-1.5 size-2 shrink-0 rounded-full bg-primary"></span>
												<div class="flex min-w-0 flex-1 flex-col gap-0.5">
													<p class="text-xs font-medium">{h.text}</p>
													<span class="text-[11px] text-muted-foreground">{h.time}</span>
												</div>
											</div>
										{/each}
									</div>
								{/if}
							</div>
						</ScrollArea.Root>
					</Tabs.Root>
				</div>
			</Resizable.Pane>
		</Resizable.PaneGroup>
	</Card.Content>
</Card.Root>
