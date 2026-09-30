<script lang="ts">
  import * as Alert from '$lib/components/ui/alert';
  import * as Card from '$lib/components/ui/card';
  import { Badge } from '$lib/components/ui/badge';
  import { Button } from '$lib/components/ui/button';
  import { Field } from '$lib/components/ui/field';
  import { Input } from '$lib/components/ui/input';
  import { Progress } from '$lib/components/ui/progress';
  import * as Table from '$lib/components/ui/table';
  import {
    Activity,
    ArrowUpRight,
    CheckCircle2,
    Clock3,
    Mail,
    MessageCircle,
    Phone,
    Star,
    Users,
    Zap
  } from 'lucide-svelte';

  const channelStats = [
    { label: 'Phone Calls', value: '248', detail: '212 terjawab · 85%', response: '3m 24s', satisfaction: '4.6/5', icon: Phone },
    { label: 'Live Chat', value: '186', detail: '174 direspon · 94%', response: '42 detik', satisfaction: '4.8/5', icon: MessageCircle },
    { label: 'Email', value: '124', detail: '96 dibalas · 77%', response: '2j 18m', satisfaction: '4.5/5', icon: Mail },
    { label: 'Social Media', value: '92', detail: '81 direspon · 88%', response: '18 menit', satisfaction: '4.4/5', icon: Activity },
    { label: 'WhatsApp Business', value: '316', detail: '294 direspon · 93%', response: '1m 06s', satisfaction: '4.9/5', icon: MessageCircle },
    { label: 'Comment & More', value: '74', detail: '61 direspon · 82%', response: '26 menit', satisfaction: '4.3/5', icon: Zap }
  ];

  const alerts = [
    { variant: 'warning' as const, icon: Clock3, text: '4 chat menunggu balasan lebih dari 5 menit' },
    { variant: 'destructive' as const, icon: Activity, text: 'Tiket T-2026-001 membutuhkan perhatian segera' },
    { variant: 'success' as const, icon: CheckCircle2, text: 'Semua channel aktif dan terhubung' }
  ];

  const recentTickets = [
    { id: 'T-2026-001', subject: 'Keterlambatan pengiriman', channel: 'WhatsApp', owner: 'Rina', status: 'Urgent', variant: 'destructive' as const },
    { id: 'T-2026-002', subject: 'Reset password akun', channel: 'Live Chat', owner: 'Budi', status: 'Open', variant: 'warning' as const },
    { id: 'T-2026-003', subject: 'Permintaan invoice bulanan', channel: 'Email', owner: 'Sari', status: 'In progress', variant: 'secondary' as const }
  ];

  const channels = [
    { label: 'WhatsApp', value: 82 },
    { label: 'Live Chat', value: 68 },
    { label: 'Email', value: 46 },
    { label: 'Voice', value: 32 }
  ];
</script>

<svelte:head><title>Home — DK UI Kit</title></svelte:head>

<div class="flex flex-col gap-6">
  <section class="flex flex-col gap-1 md:flex-row md:items-end md:justify-between">
    <div>
      <div class="flex items-center gap-2 text-sm font-medium text-primary">
        <Activity size={16} /> Real-time Performance Monitoring
      </div>
      <p class="mt-1 text-sm text-muted-foreground">Ringkasan performa seluruh kanal customer service.</p>
    </div>
    <div class="rounded-lg border border-border bg-card px-3 py-2 text-left md:text-right">
      <div class="text-xs text-muted-foreground">Scope data</div>
      <div class="text-sm font-semibold">Hari ini · Semua channel</div>
    </div>
  </section>

  <Card.Root>
    <Card.Header class="pb-3">
      <Card.Title class="text-base">Filter periode</Card.Title>
      <p class="text-sm text-muted-foreground">Pilih rentang tanggal untuk memperbarui metrik.</p>
    </Card.Header>
    <Card.Content>
      <div class="grid gap-4 md:grid-cols-[1fr_1fr_auto] md:items-end">
        <Field.Field>
          <Field.Label for="start-date">Start date</Field.Label>
          <Input id="start-date" type="date" value="2026-09-30" />
        </Field.Field>
        <Field.Field>
          <Field.Label for="end-date">End date</Field.Label>
          <Input id="end-date" type="date" value="2026-09-30" />
        </Field.Field>
        <Button class="w-full md:w-auto"><Activity data-icon="inline-start" />Apply filter</Button>
      </div>
    </Card.Content>
  </Card.Root>

  <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3" aria-label="Statistik kanal">
    {#each channelStats as stat}
      <Card.Root class="transition-shadow hover:shadow-md">
        <Card.Header class="flex-row items-center gap-3 space-y-0 pb-3">
          <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
            <stat.icon size={19} />
          </div>
          <div class="min-w-0">
            <Card.Title class="truncate text-base">{stat.label}</Card.Title>
            <p class="text-xs text-muted-foreground">Volume interaksi</p>
          </div>
        </Card.Header>
        <Card.Content class="flex flex-col gap-3">
          <div class="flex items-baseline justify-between gap-2">
            <span class="text-2xl font-bold tracking-tight">{stat.value}</span>
            <Badge variant="secondary">Aktif</Badge>
          </div>
          <div class="flex flex-col gap-2 text-xs">
            <div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">Respons</span><span class="font-medium">{stat.detail}</span></div>
            <div class="flex items-center justify-between gap-2"><span class="text-muted-foreground">Rata-rata response</span><span class="font-medium">{stat.response}</span></div>
            <div class="flex items-center justify-between gap-2"><span class="flex items-center gap-1 text-muted-foreground"><Star size={13} /> Kepuasan</span><span class="font-medium">{stat.satisfaction}</span></div>
          </div>
        </Card.Content>
      </Card.Root>
    {/each}
  </section>

  <div class="grid gap-4 lg:grid-cols-[1fr_1.2fr]">
    <Card.Root>
      <Card.Header>
        <Card.Title>Kanal paling ramai</Card.Title>
        <p class="text-sm text-muted-foreground">Distribusi volume interaksi hari ini.</p>
      </Card.Header>
      <Card.Content class="flex flex-col gap-4">
        {#each channels as channel}
          <div class="flex flex-col gap-2">
            <div class="flex justify-between text-sm"><span class="font-medium">{channel.label}</span><span class="text-muted-foreground">{channel.value}%</span></div>
            <Progress value={channel.value} />
          </div>
        {/each}
      </Card.Content>
    </Card.Root>

    <Card.Root>
      <Card.Header>
        <Card.Title>Perlu perhatian</Card.Title>
        <p class="text-sm text-muted-foreground">Sinyal operasional yang perlu ditindaklanjuti.</p>
      </Card.Header>
      <Card.Content class="flex flex-col gap-2">
        {#each alerts as alert}
          <Alert.Root variant={alert.variant}>
            <alert.icon />
            <Alert.Description>{alert.text}</Alert.Description>
          </Alert.Root>
        {/each}
        <div class="mt-2 flex flex-wrap gap-2">
          <Button href="/chat/v3" size="sm">Buka chat</Button>
          <Button href="/ticketing" size="sm" variant="outline">Lihat tiket</Button>
        </div>
      </Card.Content>
    </Card.Root>
  </div>

  <Card.Root>
    <Card.Header class="flex-row items-center justify-between space-y-0">
      <div><Card.Title>Tiket terbaru</Card.Title><p class="mt-1 text-sm text-muted-foreground">Aktivitas tiket yang terakhir diperbarui.</p></div>
      <Button href="/ticketing" variant="ghost" size="sm">Lihat semua <ArrowUpRight data-icon="inline-end" /></Button>
    </Card.Header>
    <Card.Content>
      <div class="overflow-x-auto">
        <Table.Root>
          <Table.Header>
            <Table.Row>
              <Table.Head>ID tiket</Table.Head><Table.Head>Subjek</Table.Head><Table.Head class="hidden md:table-cell">Channel</Table.Head><Table.Head class="hidden md:table-cell">Owner</Table.Head><Table.Head class="text-right">Status</Table.Head>
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {#each recentTickets as ticket}
              <Table.Row>
                <Table.Cell class="font-mono text-xs font-semibold">{ticket.id}</Table.Cell>
                <Table.Cell class="min-w-48 font-medium">{ticket.subject}</Table.Cell>
                <Table.Cell class="hidden md:table-cell">{ticket.channel}</Table.Cell>
                <Table.Cell class="hidden md:table-cell">{ticket.owner}</Table.Cell>
                <Table.Cell class="text-right"><Badge variant={ticket.variant}>{ticket.status}</Badge></Table.Cell>
              </Table.Row>
            {/each}
          </Table.Body>
        </Table.Root>
      </div>
    </Card.Content>
  </Card.Root>
</div>
