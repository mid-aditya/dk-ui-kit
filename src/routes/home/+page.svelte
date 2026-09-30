<script lang="ts">
  import Card from '$lib/components/ui/card.svelte';
  import CardHeader from '$lib/components/ui/card-header.svelte';
  import CardTitle from '$lib/components/ui/card-title.svelte';
  import CardContent from '$lib/components/ui/card-content.svelte';
  import Badge from '$lib/components/ui/badge.svelte';
  import Button from '$lib/components/ui/button.svelte';
  import Progress from '$lib/components/ui/progress.svelte';
  import Alert from '$lib/components/ui/alert.svelte';
  import { MessagesSquare, Ticket, Star, Users } from 'lucide-svelte';

  const stats = [
    { label: 'Antrian chat', value: '18', icon: MessagesSquare, hint: '4 menunggu > 5 mnt', urgent: true },
    { label: 'Tiket open', value: '23', icon: Ticket, hint: '3 urgent', urgent: true },
    { label: 'CSAT hari ini', value: '4.7', icon: Star, hint: 'dari 132 survei', urgent: false },
    { label: 'Agent online', value: '14/18', icon: Users, hint: '4 istirahat', urgent: false }
  ];

  const alerts = [
    { type: 'warning' as const, text: '4 chat menunggu balasan lebih dari 5 menit', urgent: true },
    { type: 'destructive' as const, text: 'Tiket T-2026-001 prioritas urgent', urgent: true },
    { type: 'info' as const, text: '2 agent mendekati batas shift', urgent: false }
  ];
</script>

<svelte:head><title>Home — DK UI Kit</title></svelte:head>

<div class="flex items-center justify-between">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Home</h1>
    <p class="mt-0.5 text-sm text-muted-foreground">Ringkasan operasional omnichannel hari ini.</p>
  </div>
  <Button href="/threads" size="sm">Buka threads</Button>
</div>

<!-- Stats Cards -->
<div class="mt-3 grid grid-cols-2 gap-3 lg:grid-cols-4">
  {#each stats as s}
    <Card class="hover:shadow-md transition-shadow cursor-pointer">
      <CardContent class="p-4">
        <div class="flex items-center gap-2 text-xs font-medium text-muted-foreground">
          <s.icon size={15} class="text-primary" />{s.label}
        </div>
        <div class="mt-1 text-2xl font-extrabold tracking-tight">{s.value}</div>
        <div class="text-[11px] text-muted-foreground">{s.hint}</div>
      </CardContent>
    </Card>
  {/each}
</div>

<!-- Content Grid -->
<div class="mt-3 grid gap-3 lg:grid-cols-2">
  <!-- Channel Stats -->
  <Card>
    <CardHeader><CardTitle>Kanal paling ramai</CardTitle></CardHeader>
    <CardContent class="space-y-3">
      {#each [{ c: 'WhatsApp', v: 82 }, { c: 'Email', v: 46 }, { c: 'Telegram', v: 24 }, { c: 'Voice', v: 12 }] as k}
        <div>
          <div class="mb-1 flex justify-between text-sm"><span class="font-medium">{k.c}</span><span class="text-muted-foreground">{k.v}</span></div>
          <Progress value={k.v} />
        </div>
      {/each}
    </CardContent>
  </Card>

  <!-- Alerts Section -->
  <Card>
    <CardHeader><CardTitle>Perlu perhatian</CardTitle></CardHeader>
    <CardContent class="space-y-2">
      {#each alerts as alert}
        <Alert variant={alert.type} dismissible>
          {alert.text}
        </Alert>
      {/each}
      <div class="mt-3 flex gap-2">
        <Button href="/chat/v3" size="sm">Buka chat</Button>
        <Button href="/ticketing" size="sm" variant="secondary">Lihat tiket</Button>
      </div>
    </CardContent>
  </Card>
</div>

<!-- Recent Tickets -->
<div class="mt-3">
  <Card>
    <CardHeader>
      <div class="flex items-center justify-between">
        <CardTitle>Tiket terbaru</CardTitle>
        <Badge>3 open</Badge>
      </div>
    </CardHeader>
    <CardContent>
      <div class="overflow-auto rounded-lg border">
        <table class="w-full text-sm">
          <tbody>
            {#each [{ n: 'T-2026-001', s: 'Keterlambatan pengiriman', p: 'urgent' }, { n: 'T-2026-002', s: 'Reset password akun', p: 'medium' }] as t}
              <tr class="border-b border-border last:border-0 hover:bg-muted/50">
                <td class="px-4 py-3 font-mono font-semibold">{t.n}</td>
                <td class="px-4 py-3">{t.s}</td>
                <td class="px-4 py-3 text-right"><Badge variant={t.p === 'urgent' ? 'destructive' : 'warning'}>{t.p}</Badge></td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </CardContent>
  </Card>
</div>
