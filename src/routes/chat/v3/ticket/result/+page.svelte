<script lang="ts">
	import * as Card from '$lib/components/ui/card';
	import { Badge } from '$lib/components/ui/badge';
	import { Button } from '$lib/components/ui/button';
	import * as Avatar from '$lib/components/ui/avatar';
	import * as Tabs from '$lib/components/ui/tabs';
	import * as DropdownMenu from '$lib/components/ui/dropdown-menu';
	import * as Tooltip from '$lib/components/ui/tooltip';
	import * as ScrollArea from '$lib/components/ui/scroll-area';
	import * as Dialog from '$lib/components/ui/dialog';
	import * as InputGroup from '$lib/components/ui/input-group';
	import * as Message from '$lib/components/ui/message';
	import * as Bubble from '$lib/components/ui/bubble';
	import { Separator } from '$lib/components/ui/separator';
	import * as Empty from '$lib/components/ui/empty';
	import { Skeleton } from '$lib/components/ui/skeleton';
	import EmailItem from '$lib/components/ui/email-item.svelte';
	import { toast } from 'svelte-sonner';
	import { Search, Mail, MoreVertical } from 'lucide-svelte';
	import { locale } from '$lib/i18n';

	const STR = {
		id: {
			title: 'Result Ticket — DK UI Kit',
			stages: ['Diterima', 'Diproses', 'Analisa Kirana', 'Follow-up', 'Selesai'],
			searchPh: 'Cari result ticket…',
			tabAll: 'Semua',
			tabSuccess: 'Success',
			tabPending: 'Pending',
			action: 'Aksi',
			resultH: 'Hasil',
			export: 'Export',
			sendEmail: 'Kirim Email',
			emailResult: 'Email Hasil',
			emailTip: 'Kirim hasil via email',
			listTitle: 'Daftar Result Ticket',
			emptyTitle: 'Belum ada hasil',
			emptyDesc: 'Hasil tiket akan muncul di sini.',
			detail: 'Detail',
			previewEmail: 'Preview Email',
			previewTitle: 'Preview Email Hasil —',
			send: 'Kirim',
			system: 'Sistem',
			resultPrefix: 'Hasil untuk',
			bladeDesc: 'Meniru dashboard result-ticket blade: timeline horizontal + detail + modal email body.',
			toastSent: 'Email hasil dikirim',
			stSuccess: 'success',
			stPending: 'pending'
		},
		en: {
			title: 'Result Ticket — DK UI Kit',
			stages: ['Received', 'In Progress', 'Kirana Analysis', 'Follow-up', 'Done'],
			searchPh: 'Search result tickets…',
			tabAll: 'All',
			tabSuccess: 'Success',
			tabPending: 'Pending',
			action: 'Actions',
			resultH: 'Result',
			export: 'Export',
			sendEmail: 'Send Email',
			emailResult: 'Email Result',
			emailTip: 'Send result via email',
			listTitle: 'Result Ticket List',
			emptyTitle: 'No results yet',
			emptyDesc: 'Ticket results will appear here.',
			detail: 'Details',
			previewEmail: 'Preview Email',
			previewTitle: 'Result Email Preview —',
			send: 'Send',
			system: 'System',
			resultPrefix: 'Result for',
			bladeDesc: 'Mimics the result-ticket blade dashboard: horizontal timeline + details + email body modal.',
			toastSent: 'Result email sent',
			stSuccess: 'success',
			stPending: 'pending'
		},
		th: {
			title: 'Result Ticket — DK UI Kit',
			stages: ['ได้รับแล้ว', 'กำลังดำเนินการ', 'วิเคราะห์ Kirana', 'ติดตามงาน', 'เสร็จสิ้น'],
			searchPh: 'ค้นหา result ticket…',
			tabAll: 'ทั้งหมด',
			tabSuccess: 'สำเร็จ',
			tabPending: 'รอดำเนินการ',
			action: 'การดำเนินการ',
			resultH: 'ผลลัพธ์',
			export: 'ส่งออก',
			sendEmail: 'ส่งอีเมล',
			emailResult: 'อีเมลผลลัพธ์',
			emailTip: 'ส่งผลลัพธ์ทางอีเมล',
			listTitle: 'รายการ Result Ticket',
			emptyTitle: 'ยังไม่มีผลลัพธ์',
			emptyDesc: 'ผลลัพธ์ตั๋วจะปรากฏที่นี่',
			detail: 'รายละเอียด',
			previewEmail: 'ตัวอย่างอีเมล',
			previewTitle: 'ตัวอย่างอีเมลผลลัพธ์ —',
			send: 'ส่ง',
			system: 'ระบบ',
			resultPrefix: 'ผลลัพธ์สำหรับ',
			bladeDesc: 'เลียนแบบแดชบอร์ด result-ticket blade: ไทม์ไลน์แนวนอน + รายละเอียด + โมดัลเนื้อหาอีเมล',
			toastSent: 'ส่งอีเมลผลลัพธ์แล้ว',
			stSuccess: 'สำเร็จ',
			stPending: 'รอดำเนินการ'
		},
		tl: {
			title: 'Result Ticket — DK UI Kit',
			stages: ['Natanggap', 'Pinoproseso', 'Pagsusuri ng Kirana', 'Follow-up', 'Tapos'],
			searchPh: 'Maghanap ng result ticket…',
			tabAll: 'Lahat',
			tabSuccess: 'Success',
			tabPending: 'Pending',
			action: 'Aksyon',
			resultH: 'Resulta',
			export: 'I-export',
			sendEmail: 'Ipadala ang Email',
			emailResult: 'Email ng Resulta',
			emailTip: 'Ipadala ang resulta sa email',
			listTitle: 'Listahan ng Result Ticket',
			emptyTitle: 'Wala pang resulta',
			emptyDesc: 'Ang mga resulta ng ticket ay lilitaw dito.',
			detail: 'Detalye',
			previewEmail: 'Preview ng Email',
			previewTitle: 'Preview ng Result Email —',
			send: 'Ipadala',
			system: 'System',
			resultPrefix: 'Resulta para kay',
			bladeDesc: 'Ginagaya ang result-ticket blade dashboard: pahalang na timeline + detalye + email body modal.',
			toastSent: 'Naipadala ang result email',
			stSuccess: 'success',
			stPending: 'pending'
		}
	} as const;
	let s = $derived(STR[$locale]);
	let stages = $derived(s.stages);

	const tickets = [
		{ id: 'RS-001', customer: 'Budi Santoso', result: 'Lolos verifikasi', status: 'success', time: '10:40' },
		{ id: 'RS-002', customer: 'Siti Aminah', result: 'Perlu dokumen tambahan', status: 'pending', time: '11:05' }
	];
	let sel = $state(tickets[0]);
	let q = $state('');
	let loading = $state(false);
	const initials = (n: string) => n.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase();
	const statusLabel = (st: string) => st === 'success' ? s.stSuccess : s.stPending;
</script>

<svelte:head><title>{s.title}</title></svelte:head>

<div class="flex flex-col gap-3">
	<Card.Root>
		<Card.Content class="flex items-center gap-3 overflow-x-auto p-4">
			{#each stages as st, i}<div class="flex items-center gap-2"><span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-sm font-bold text-primary">{i + 1}</span><span class="whitespace-nowrap text-xs font-medium">{st}</span>{#if i < stages.length - 1}<span class="h-0.5 w-8 bg-border"></span>{/if}</div>{/each}
		</Card.Content>
	</Card.Root>

	<div class="flex flex-wrap items-center gap-2">
		<InputGroup.Root class="max-w-sm"><InputGroup.Addon><Search class="size-4" /></InputGroup.Addon><InputGroup.Input bind:value={q} placeholder={s.searchPh} /></InputGroup.Root>
		<Tabs.Root value="all"><Tabs.List><Tabs.Trigger value="all">{s.tabAll}</Tabs.Trigger><Tabs.Trigger value="success">{s.tabSuccess}</Tabs.Trigger><Tabs.Trigger value="pending">{s.tabPending}</Tabs.Trigger></Tabs.List></Tabs.Root>
		<DropdownMenu.Root>
			<DropdownMenu.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><MoreVertical class="size-4" /> {s.action}</Button>{/snippet}</DropdownMenu.Trigger>
			<DropdownMenu.Content><DropdownMenu.Group><DropdownMenu.GroupHeading>{s.resultH}</DropdownMenu.GroupHeading><DropdownMenu.Item>{s.export}</DropdownMenu.Item><DropdownMenu.Item>{s.sendEmail}</DropdownMenu.Item></DropdownMenu.Group></DropdownMenu.Content>
		</DropdownMenu.Root>
		<Tooltip.Provider><Tooltip.Root><Tooltip.Trigger>{#snippet child({ props })}<Button size="sm" variant="outline" {...props}><Mail class="size-4" /> {s.emailResult}</Button>{/snippet}</Tooltip.Trigger><Tooltip.Content>{s.emailTip}</Tooltip.Content></Tooltip.Root></Tooltip.Provider>
	</div>

	<div class="grid grid-cols-1 gap-3 xl:grid-cols-2">
		<Card.Root>
			<Card.Header><strong class="text-sm">{s.listTitle}</strong></Card.Header><Separator />
			<ScrollArea.Root class="h-[50vh]">
				{#if loading}<div class="flex flex-col gap-2 p-4"><Skeleton class="h-14 w-full" /><Skeleton class="h-14 w-full" /></div>
				{:else if tickets.length === 0}<Empty.Root><Empty.Header><Empty.Title>{s.emptyTitle}</Empty.Title><Empty.Description>{s.emptyDesc}</Empty.Description></Empty.Header></Empty.Root>
				{:else}
					<div class="flex flex-col gap-2 p-3">
						{#each tickets as t (t.id)}
							<button onclick={() => (sel = t)} class="flex items-center gap-3 rounded-lg border p-3 text-left hover:bg-muted/50">
								<Avatar.Root><Avatar.Fallback>{initials(t.customer)}</Avatar.Fallback></Avatar.Root>
								<span class="flex-1"><strong class="text-sm">{t.id} — {t.customer}</strong><span class="block text-xs text-muted-foreground">{t.result}</span></span>
								<Badge variant={t.status === 'success' ? 'default' : 'secondary'}>{statusLabel(t.status)}</Badge>
							</button>
						{/each}
					</div>
				{/if}
			</ScrollArea.Root>
		</Card.Root>
		<Card.Root>
			<Card.Header class="flex flex-row items-center gap-2"><strong class="flex-1 text-sm">{s.detail} {sel.id}</strong><Badge variant="outline">{statusLabel(sel.status)}</Badge>
				<Dialog.Root>
						<Dialog.Trigger>{#snippet child({ props })}<Button size="sm" {...props}>{s.previewEmail}</Button>{/snippet}</Dialog.Trigger>
					<Dialog.Content><Dialog.Header><Dialog.Title>{s.previewTitle} {sel.id}</Dialog.Title></Dialog.Header><EmailItem from="noreply@ahu.go.id" subject={`${s.resultH} ${sel.id}`} preview={sel.result} time={sel.time} /><Dialog.Footer><Button onclick={() => toast.success(s.toastSent)}>{s.send}</Button></Dialog.Footer></Dialog.Content>
				</Dialog.Root>
			</Card.Header><Separator />
			<Card.Content class="flex flex-col gap-2 p-4">
				<Message.Group>
					<Message.Root><Message.Avatar><Avatar.Root><Avatar.Fallback>SY</Avatar.Fallback></Avatar.Root></Message.Avatar><div class="flex flex-col gap-1"><Message.Header>{s.system}</Message.Header><Bubble.Root variant="received"><Bubble.Content>{s.resultPrefix} {sel.customer}: {sel.result}.</Bubble.Content></Bubble.Root><Message.Footer>{sel.time}</Message.Footer></div></Message.Root>
				</Message.Group>
				<Separator />
				<p class="text-xs text-muted-foreground">{s.bladeDesc}</p>
			</Card.Content>
		</Card.Root>
	</div>
</div>
