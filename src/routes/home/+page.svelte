<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import { MessagesSquare, Ticket, Star, Users } from 'lucide-svelte';

  const stats = [
    { label: 'Antrian chat', value: '18', icon: MessagesSquare, hint: '4 menunggu > 5 mnt' },
    { label: 'Tiket open', value: '23', icon: Ticket, hint: '3 urgent' },
    { label: 'CSAT hari ini', value: '4.7', icon: Star, hint: 'dari 132 survei' },
    { label: 'Agent online', value: '14/18', icon: Users, hint: '4 istirahat' }
  ];
</script>

<svelte:head><title>Home — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Home</h1>
    <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Ringkasan operasional omnichannel hari ini.</p>
  </div>
  <Button href="/threads" size="sm">Buka threads</Button>
</div>

<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each stats as s}
    <Card>
      <CardContent class="p-4">
        <div class="flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400">
          <s.icon size={15} class="text-brand-500" />{s.label}
        </div>
        <div class="mt-1 text-2xl font-extrabold tracking-tight">{s.value}</div>
        <div class="text-[11px] text-slate-400">{s.hint}</div>
      </CardContent>
    </Card>
  {/each}
</div>

<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <Card>
    <CardHeader><CardTitle>Kanal paling ramai</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each [{ c: 'WhatsApp', v: 82 }, { c: 'Email', v: 46 }, { c: 'Telegram', v: 24 }, { c: 'Voice', v: 12 }] as k}
        <div>
          <div class="mb-1 flex justify-between text-sm"><span class="font-medium">{k.c}</span><span class="text-slate-500">{k.v}</span></div>
          <Progress value={k.v} />
        </div>
      {/each}
    </CardContent>
  </Card>
  <Card>
    <CardHeader><CardTitle>Perlu perhatian</CardTitle></CardHeader>
    <CardContent>
      <ul class="space-y-2 text-sm">
        <li class="rounded-xl border border-amber-100 bg-amber-50 px-3 py-2 dark:border-amber-900 dark:bg-amber-950/40">4 chat menunggu balasan &gt; 5 menit</li>
        <li class="rounded-xl border border-amber-100 bg-amber-50 px-3 py-2 dark:border-amber-900 dark:bg-amber-950/40">Tiket T-2026-001 prioritas urgent</li>
        <li class="rounded-xl border border-amber-100 bg-amber-50 px-3 py-2 dark:border-amber-900 dark:bg-amber-950/40">2 agent mendekati batas shift</li>
      </ul>
      <div class="mt-3 flex gap-2">
        <Button href="/chat/v3" size="sm">Buka chat</Button>
        <Button href="/ticketing" size="sm" variant="secondary">Lihat tiket</Button>
      </div>
    </CardContent>
  </Card>
</div>

<div class="mt-3">
  <Card>
    <CardHeader>
      <div class="flex items-center justify-between">
        <CardTitle>Tiket terbaru</CardTitle>
        <Badge>3 open</Badge>
      </div>
    </CardHeader>
    <CardContent>
      <div class="overflow-auto">
        <table class="w-full text-sm">
          <tbody>
            {#each [{ n: 'T-2026-001', s: 'Keterlambatan pengiriman', p: 'urgent' }, { n: 'T-2026-002', s: 'Reset password akun', p: 'medium' }] as t}
              <tr class="border-t border-slate-100 dark:border-slate-800">
                <td class="py-2 font-mono font-semibold">{t.n}</td>
                <td class="py-2">{t.s}</td>
                <td class="py-2 text-right"><Badge variant={t.p === 'urgent' ? 'destructive' : 'warning'}>{t.p}</Badge></td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </CardContent>
  </Card>
</div>
