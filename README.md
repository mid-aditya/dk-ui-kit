# DK UI Kit

UI kit omnichannel CRM (SvelteKit + Svelte 5 runes + Tailwind + lucide-svelte)
dengan komponen gaya **shadcn** (`src/lib/components/ui`: button, card,
badge, input, label, textarea, select, dialog, tabs, table, avatar,
progress) dan tema **biru** + dark mode.

Referensi fitur: `C:\WORK\Galih\crm-ahu` (Laravel). Data saat ini mock
(`src/lib/mock.ts`) — ganti dengan fetch API saat integrasi backend.

## Jalankan

```powershell
npm install
npm run dev      # http://localhost:5173
npm run build
npm run preview
```

## Rute

home, agent/performance, agent-productivity-dashboard, threads,
chat/v3, chat/v3/ticket/result, chat/v3/ticket/kirana-monitoring,
ticketing, email (+ compose, send, history, templates, ?status=draft),
spv, recordings, recording-archive, report (+ csat, csat-interaction),
settings, agent-schedule, work-calendar.

Sidebar bisa minimize (persisten), drawer di mobile, toggle dark/light
di topbar. Layout: `src/routes/+layout.svelte`.
