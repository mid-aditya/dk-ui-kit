# CRM AHU UI Route Samples

Folder ini berisi salinan file Blade UI dari project `crm-ahu` untuk dijadikan referensi saat mengembangkan halaman Svelte di `dk-ui-kit`.

## Mapping route dan file view

| Route | Sample view |
|---|---|
| `/home` | `resources/views/pages/home.blade.php` |
| `/agent/performance` | `resources/views/pages/agent.blade.php` |
| `/agent-productivity-dashboard` | `resources/views/pages/agent-productivity.blade.php` |
| `/chat/v3/ticket/result` | `resources/views/pages/result-ticket/index.blade.php` |
| `/threads` | `resources/views/pages/threads/index.blade.php` |
| `/report/csat-interaction` | Tidak ada Blade terpisah di source; gunakan `resources/views/report/csat.blade.php` sebagai referensi CSAT terdekat |
| `/report/csat` | `resources/views/report/csat.blade.php` |
| `/chat/v3` | `resources/views/pages/chat/v3/index.blade.php` |
| `/ticketing` | `resources/views/pages/chat/ticketing/index.blade.php` |
| `/email` | `resources/views/pages/email/index.blade.php` |
| `/email/compose` | `resources/views/pages/email/compose.blade.php` |
| `/email?status=draft` | `resources/views/pages/email/index.blade.php` dengan state/filter draft |
| `/email/send` | `resources/views/pages/email/send.blade.php` |
| `/email/history` | `resources/views/pages/email/history-email.blade.php` |
| `/email/templates` | `resources/views/pages/email/templates.blade.php` |
| `/spv` | `resources/views/pages/report/spv/index.blade.php` |
| `/recordings` | `resources/views/pages/recordings/index.blade.php` |
| `/recording-archive` | `resources/views/pages/recording_archive/index.blade.php` |
| `/chat/v3/ticket/kirana-monitoring` | `resources/views/pages/kirana-monitoring/index.blade.php` |
| `/report` | `resources/views/report/index.blade.php` |
| `/settings` | `resources/views/pages/company/setting/index.blade.php` |
| `/agent-schedule` | `resources/views/pages/agent-schedule/index.blade.php` |
| `/work-calendar` | `resources/views/pages/work-calendar/index.blade.php` |

## Shared UI shell

`resources/views/components/dashonic/` berisi komponen layout bersama dari CRM AHU:

- `header.blade.php`
- `sidebar.blade.php`
- `sidebar-conflict.blade.php`
- `footer.blade.php`
- `iframe.blade.php`
- `modal-sign-as-chat.blade.php`

## Catatan penggunaan

- File-file ini hanya sample/reference UI; tidak dipakai sebagai runtime Svelte.
- Jangan menyalin data produksi, credential, atau koneksi backend dari Blade ke UI kit.
- Gunakan mock data pada Svelte.
- Struktur visual, hierarchy, spacing, table, filter, modal, sidebar, dan topbar dapat dijadikan acuan.
- Warna primary tetap dikontrol dari satu file konfigurasi UI kit, bukan dari warna hardcoded per halaman.
