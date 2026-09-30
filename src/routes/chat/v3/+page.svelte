<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Resizable from '$lib/components/ui/resizable';
	import * as Sheet from '$lib/components/ui/sheet';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Message from '$lib/components/ui/message';
	import * as Bubble from '$lib/components/ui/bubble';
	import ChatBubble from '$lib/components/ui/chat-bubble.svelte';
	import ChatInput from '$lib/components/ui/chat-input.svelte';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import { toast } from 'svelte-sonner';
	import { cn } from '$lib/utils';
	import { Search, Send, Paperclip, Smile, Phone, MoreVertical, Inbox, CheckCheck } from 'lucide-svelte';

	let openChatTab = $state('served');
	const tabStatus: Record<string, number> = { served: 3, chatbot: 5, resolved: 4 };
	const queues = [
		{ id: 1, customer: 'Budi Santoso', channel: 'WhatsApp', last: 'Halo, paket saya belum sampai?', time: '10:20', unread: 3, status: 'open' },
		{ id: 2, customer: 'Siti Aminah', channel: 'Email', last: 'Mohon info pengajuan KTP…', time: '09:45', unread: 1, status: 'pending' },
		{ id: 3, customer: 'Bot Assistant', channel: 'Live Chat', last: 'Baik, saya bantu cek resi…', time: '09:00', unread: 0, status: 'bot' },
		{ id: 4, customer: 'Dewi Lestari', channel: 'Live Chat', last: 'Oke, ditunggu kabar bot…', time: '08:30', unread: 0, status: 'bot' },
		{ id: 5, customer: 'Andi Wijaya', channel: 'Live Chat', last: 'Terima kasih atas bantuannya', time: '08:15', unread: 0, status: 'resolved' }
	];
	const filteredQueues = $derived(
		openChatTab === 'served' ? queues.filter((q) => q.status === 'open' || q.status === 'pending')
		: openChatTab === 'chatbot' ? queues.filter((q) => q.status === 'bot')
		: queues.filter((q) => q.status === 'resolved')
	);
	let selected = $state(queues[0]);
	let draft = $state('');
	let loading = $state(false);
	let messages = $state([
		{ id: 1, from: 'customer' as const, body: 'Halo, paket saya belum sampai?', time: '10:20' },
		{ id: 2, from: 'agent' as const, body: 'Halo kak, boleh info nomor resinya?', time: '10:22' },
		{ id: 3, from: 'customer' as const, body: 'Resi JNE123456789', time: '10:23' }
	]);
	const initials = (n: string) => n.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
	function send() {
		if (!draft.trim()) return;
		messages = [...messages, { id: Date.now(), from: 'agent' as const, body: draft, time: 'now' }];
		draft = '';
		toast.success('Pesan terkirim');
	}
	function simulateLoad() { loading = true; setTimeout(() => (loading = false), 900); }
</script>

<svelte:head><title>Omnichat</title></svelte:head>

<div class="flex flex-col gap-3">
	<Tabs.Root bind:value={openChatTab}>
		<Tabs.List>
			<Tabs.Trigger value="served">Served</Tabs.Trigger>
			<Tabs.Trigger value="chatbot">Chatbot</Tabs.Trigger>
			<Tabs.Trigger value="resolved">Resolved</Tabs.Trigger>
		</Tabs.List>
	</Tabs.Root>

	<Resizable.PaneGroup direction="horizontal" class="min-h-[70vh] gap-3">
		<Resizable.Pane defaultSize={30}>
			<Card.Root class="flex h-full flex-col">
				<Card.Header class="flex flex-row items-center gap-2">
					<InputGroup.Root>
						<InputGroup.Addon><Search class="size-4" /></InputGroup.Addon>
						<InputGroup.Input placeholder="Cari antrian…" />
					</InputGroup.Root>
					<DropdownMenu.Root>
						<DropdownMenu.Trigger>
							{#snippet child({ props })}
								<Button size="icon" variant="outline" {...props}><MoreVertical class="size-4" /></Button>
							{/snippet}
						</DropdownMenu.Trigger>
						<DropdownMenu.Content>
							<DropdownMenu.Group>
								<DropdownMenu.GroupHeading>Filter kanal</DropdownMenu.GroupHeading>
								<DropdownMenu.Item>Semua</DropdownMenu.Item>
								<DropdownMenu.Item>WhatsApp</DropdownMenu.Item>
								<DropdownMenu.Item>Email</DropdownMenu.Item>
							</DropdownMenu.Group>
							<DropdownMenu.Separator />
							<DropdownMenu.Group>
								<DropdownMenu.Item>Belum dibaca</DropdownMenu.Item>
								<DropdownMenu.Item>Assigned ke saya</DropdownMenu.Item>
							</DropdownMenu.Group>
						</DropdownMenu.Content>
					</DropdownMenu.Root>
				</Card.Header>
				<Separator />
				<ScrollArea.Root class="h-[55vh]">
					<div class="flex flex-col gap-2 p-3">
						{#each filteredQueues as q (q.id)}
							<button onclick={() => { selected = q; simulateLoad(); }} class={cn('flex items-center gap-3 rounded-lg p-3 text-left hover:bg-muted/50', selected.id === q.id && 'bg-muted')}>
								<Avatar.Root><Avatar.Fallback>{initials(q.customer)}</Avatar.Fallback></Avatar.Root>
								<span class="min-w-0 flex-1">
									<span class="flex items-center gap-2"><strong class="truncate text-sm">{q.customer}</strong><Badge variant="outline" class="text-[10px]">{q.channel}</Badge></span>
									<span class="truncate text-xs text-muted-foreground">{q.last}</span>
								</span>
								{#if q.unread}<span class="flex h-5 w-5 items-center justify-center rounded-full bg-primary text-[10px] text-primary-foreground">{q.unread}</span>{/if}
							</button>
						{/each}
					</div>
				</ScrollArea.Root>
			</Card.Root>
		</Resizable.Pane>
		<Resizable.Handle />
		<Resizable.Pane defaultSize={70}>
			<Card.Root class="flex h-full flex-col">
				<Card.Header class="flex flex-row items-center gap-3">
					<Avatar.Root><Avatar.Fallback>{initials(selected.customer)}</Avatar.Fallback></Avatar.Root>
					<div class="flex flex-1 flex-col gap-0.5">
						<strong class="text-sm">{selected.customer}</strong>
						<span class="text-xs text-muted-foreground">{selected.channel} • {selected.time}</span>
					</div>
					<Badge variant="secondary">{selected.status}</Badge>
					<Tooltip.Provider>
						<Tooltip.Root>
							<Tooltip.Trigger>
								{#snippet child({ props })}
									<Button size="icon" variant="outline" {...props}><Phone class="size-4" /></Button>
								{/snippet}
							</Tooltip.Trigger>
							<Tooltip.Content>Mulai panggilan</Tooltip.Content>
						</Tooltip.Root>
					</Tooltip.Provider>
					<Sheet.Root>
						<Sheet.Trigger>
							{#snippet child({ props })}
								<Button size="sm" variant="outline" {...props}>Detail</Button>
							{/snippet}
						</Sheet.Trigger>
						<Sheet.Content>
							<Sheet.Header><Sheet.Title>Detail Tiket</Sheet.Title></Sheet.Header>
							<div class="flex flex-col gap-2 p-4 text-sm">
								<p><strong>ID:</strong> TCK-2026-001</p><p><strong>Pelanggan:</strong> {selected.customer}</p><p><strong>Kanal:</strong> {selected.channel}</p>
								<Separator />
								<p class="text-muted-foreground">Riwayat tiket, SLA, dan assignee ditampilkan di sini meniru panel blade.</p>
							</div>
						</Sheet.Content>
					</Sheet.Root>
					<Dialog.Root>
						<Dialog.Trigger>
							{#snippet child({ props })}
								<Button size="sm" {...props}>Resolve</Button>
							{/snippet}
						</Dialog.Trigger>
						<Dialog.Content>
							<Dialog.Header><Dialog.Title>Selesaikan tiket?</Dialog.Title></Dialog.Header>
							<p class="text-sm text-muted-foreground">Tiket akan ditandai selesai dan masuk ke Result Ticket.</p>
							<Dialog.Footer><Button onclick={() => toast.success('Tiket diselesaikan')}>Ya, selesaikan</Button></Dialog.Footer>
						</Dialog.Content>
					</Dialog.Root>
				</Card.Header>
				<Separator />
				<ScrollArea.Root class="h-[45vh] p-4">
					{#if loading}
						<div class="flex flex-col gap-2"><Skeleton class="h-10 w-2/3" /><Skeleton class="h-10 w-1/2 self-end" /><Skeleton class="h-10 w-2/3" /></div>
					{:else if messages.length === 0}
						<Empty.Root><Empty.Header><Empty.Title>Belum ada pesan</Empty.Title><Empty.Description>Mulai percakapan dengan pelanggan.</Empty.Description></Empty.Header></Empty.Root>
					{:else}
						<Message.Group>
							{#each messages as m (m.id)}
								<Message.Root class={cn('flex', m.from === 'agent' && 'justify-end')}>
									{#if m.from === 'customer'}<Message.Avatar><Avatar.Root><Avatar.Fallback>{initials(selected.customer)}</Avatar.Fallback></Avatar.Root></Message.Avatar>{/if}
									<div class="flex flex-col gap-1">
										<Bubble.Root variant={m.from === 'agent' ? 'sent' : 'received'}><Bubble.Content>{m.body}</Bubble.Content></Bubble.Root>
										<Message.Footer>{m.time} {#if m.from === 'agent'}<CheckCheck class="size-3" />{/if}</Message.Footer>
									</div>
								</Message.Root>
							{/each}
						</Message.Group>
						<div class="mt-2 flex flex-col gap-1"><ChatBubble from="agent" body="Contoh chat-bubble legacy: paket Anda sedang dalam pengiriman." time="10:24" /></div>
					{/if}
				</ScrollArea.Root>
				<Card.Footer class="flex-col gap-2">
					<ChatInput bind:value={draft} onSend={send} />
					<InputGroup.Root>
						<InputGroup.Addon><Paperclip class="size-4" /><Smile class="size-4" /></InputGroup.Addon>
						<InputGroup.Input bind:value={draft} placeholder="Ketik pesan… (Ctrl+Enter kirim)" onkeydown={(e) => { if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) send(); }} />
						<InputGroup.Button onclick={send}><Send class="size-4" /> Kirim</InputGroup.Button>
					</InputGroup.Root>
				</Card.Footer>
			</Card.Root>
		</Resizable.Pane>
	</Resizable.PaneGroup>
</div>
