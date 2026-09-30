# Implementation Plan: CRM AHU UI Alignment

## Overview
Menyelaraskan UI kit DK CRM dengan pola CRM AHU: struktur navigasi/sidebar, hierarchy topbar dan page header, token layout visual, summary cards, data table, state UI, serta pilihan skor CSAT berbasis emoticon. Perubahan dilakukan bertahap melalui komponen bersama agar seluruh route konsisten tanpa duplikasi styling.

## Architecture Decisions
- **Shared primitives first:** standardisasi `PageHeader`, `SummaryCard`, `DataTable`, `TableToolbar`, `Pagination`, `EmptyState`, `ErrorState`, `LoadingState`, `Alert`, dan `ConfirmDialog` di `src/lib/components/ui`.
- **Tailwind token classes:** mempertahankan primary blue dan dark mode yang sudah ada; ukuran container, radius, border, shadow, dan spacing diturunkan dari token/class bersama, bukan nilai acak per halaman.
- **Route behavior stays local:** filter, search, pagination, dan dialog tetap menggunakan state route masing-masing; komponen bersama hanya menangani presentasi dan event callback.
- **Dark mode default:** tidak mengubah kontrak theme yang ada; light mode tetap melalui toggle topbar.
- **CSAT semantics:** gunakan label dan emoticon `😊 Sangat baik`, `😐 Cukup`, `😞 Buruk`; jangan memakai simbol bintang sebagai indikator skor.
- **Progressive migration:** migrasikan route berdasarkan kelompok agar setiap fase dapat dicek dan tidak menghasilkan perubahan lintas halaman yang tidak terukur.

## Task List

### Phase 1: Foundation and shell
- [ ] Audit route content and existing mock data against CRM AHU navigation.
- [ ] Standardize `+layout.svelte` sidebar grouping, active state, user footer, topbar, and page content container.
- [ ] Add shared visual tokens/utilities for surfaces, borders, radii, shadows, spacing, and page headers.
- [ ] Add reusable `PageHeader`, `SummaryCard`, and status/state primitives.

### Checkpoint: Shell
- [ ] Sidebar works on desktop/mobile and preserves current routes.
- [ ] Topbar hierarchy and page container are consistent at mobile, tablet, and desktop widths.
- [ ] Dark mode remains default; light mode toggle remains functional.

### Phase 2: Data-heavy CRM patterns
- [ ] Add reusable `DataTable` with responsive horizontal scrolling.
- [ ] Add `TableToolbar` with search, status filter, and action area.
- [ ] Add reusable pagination and row action menu primitives.
- [ ] Migrate Ticketing, Result Ticket, Threads, Email, SPV, Recordings, and Reporting tables.
- [ ] Add consistent loading, empty, error, success alert, and confirmation dialog states to migrated flows.

### Checkpoint: Data patterns
- [ ] Every migrated table has search/filter behavior where applicable.
- [ ] Tables remain usable at narrow widths and expose row actions accessibly.
- [ ] Empty/loading/error states do not leave blank content areas.

### Phase 3: Dashboard and reporting pages
- [ ] Migrate Home summary cards and dashboard sections.
- [ ] Migrate Agent Performance and Agent Productivity.
- [ ] Migrate CSAT and CSAT Interaction with emoticon score presentation.
- [ ] Migrate Chat, Agent Schedule, and Work Calendar page headers, cards, and state patterns.

### Checkpoint: Dashboard/report
- [ ] Summary cards share identical dimensions, spacing, borders, radius, and shadow.
- [ ] CSAT pages contain no star-based score indicators.
- [ ] Dashboard/report pages use the same page header and container rhythm.

### Phase 4: Remaining operational pages and polish
- [ ] Migrate Settings and remaining Email subroutes.
- [ ] Add confirmation dialogs for destructive or consequential actions.
- [ ] Add success alerts for completed create/update actions.
- [ ] Verify keyboard focus, labels, responsive behavior, and reduced-motion-safe transitions.
- [ ] Remove deprecated Svelte syntax and resolve diagnostics introduced by the migration.

### Checkpoint: Complete
- [ ] All requested pages use the shared shell and visual primitives.
- [ ] All requested states are represented consistently.
- [ ] `npm run check` has no errors caused by this migration.
- [ ] `npm run build` succeeds.

## Risks and Mitigations
| Risk | Impact | Mitigation |
|---|---|---|
| Large number of routes changed at once | High | Migrate in phases and validate after each checkpoint. |
| Existing Svelte runes/type diagnostics | Medium | Keep unrelated diagnostics separate; fix only diagnostics touched by each phase. |
| CRM AHU visual reference not present in repository | Medium | Use current CRM-like shell and explicit requirements as source of truth; flag any missing exact dimensions. |
| Shared component prop changes break routes | High | Preserve existing props where possible and migrate one route group at a time. |
| Mock data lacks pagination/error scenarios | Medium | Add deterministic local UI states without introducing backend assumptions. |

## Open Questions
- Apakah ada screenshot/design file CRM AHU yang harus dijadikan pixel-level reference?
- Apakah pagination harus memakai ukuran halaman tetap (mis. 10/25/50) atau cukup kontrol previous/next untuk mock data?
- Action menu per tabel apa saja yang wajib tersedia (view, edit, assign, archive, delete)?
- Apakah label sidebar harus seluruhnya Bahasa Indonesia atau mempertahankan istilah operasional Inggris seperti sekarang?
