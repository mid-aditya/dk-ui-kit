# CRM AHU UI Alignment — Task Checklist

## Phase 1 — Foundation and shell
- [ ] Confirm CRM AHU sidebar labels/order and active-state behavior.
- [ ] Refine `src/routes/+layout.svelte` shell: sidebar, mobile drawer, topbar hierarchy, page container.
- [ ] Define shared CRM surface/layout classes in `src/app.css`.
- [ ] Create `PageHeader` component.
- [ ] Create `SummaryCard` component.
- [ ] Create shared loading, empty, error, success-alert, and confirmation-dialog patterns.

## Phase 2 — Tables and operational routes
- [ ] Create reusable `DataTable` wrapper with responsive scroll.
- [ ] Create `TableToolbar` with search and status filter slots/props.
- [ ] Create pagination component.
- [ ] Create accessible row action menu component.
- [ ] Migrate Ticketing and Result Ticket.
- [ ] Migrate Threads and Email.
- [ ] Migrate SPV and Recordings.
- [ ] Migrate Reporting tables.

## Phase 3 — Dashboards and reports
- [ ] Migrate Home summary/dashboard sections.
- [ ] Migrate Agent Performance.
- [ ] Migrate Agent Productivity.
- [ ] Migrate CSAT and CSAT Interaction.
- [ ] Replace star-based CSAT scores with emoticons and labels.
- [ ] Migrate Chat, Agent Schedule, and Work Calendar.

## Phase 4 — Remaining pages and verification
- [ ] Migrate Settings and Email subroutes.
- [ ] Add confirmation flows to consequential actions.
- [ ] Add success alerts to create/update actions.
- [ ] Check loading, empty, error, and success states on all requested pages.
- [ ] Check keyboard accessibility and responsive widths.
- [ ] Run targeted diagnostics, `npm run check`, and `npm run build`.
