# UtiFarm
# CHANGELOG

Version : 1.0

Status : Active

Format : Keep a Changelog
Versioning : Semantic Versioning (SemVer)

---

# Project Timeline

Dokumen ini mencatat seluruh perubahan penting selama pengembangan UtiFarm.

Seluruh perubahan arsitektur, fitur, dokumentasi, dan implementasi wajib dicatat pada dokumen ini.

---

# [Unreleased]

## Added

- Added Activities API route registration.
- Added Activities category and type controllers, services, requests, routes, and feature API tests.
- Added Laravel base test case for project feature and unit tests.
- Added Warehouse database migrations for warehouses, locations, inventory items, batches, movements, current stocks, stock opnames, and stock opname details.
- Added Warehouse Eloquent models and relationships for inventory management.
- Added Warehouse model factory support, factories, and seeder for inventory seed/test data.
- Added Warehouse repositories for warehouse, inventory, stock, and stock opname models.
- Added Warehouse services for warehouse, inventory, stock, and stock opname workflows.
- Added Warehouse API requests, resources, controllers, routes, and policies.
- Added Warehouse feature API tests for warehouse CRUD, inventory movement, stock, and stock opname flows.
- Added Harvest database migrations for harvests, harvest batches, quality controls, grades, packings, and deliveries.
- Added Harvest Eloquent models with fillable fields, casts, relationships, and query scopes.
- Added Harvest factories and seeder for harvest, batch, QC, grade, packing, and delivery seed/test data.
- Added Harvest repository interfaces and container bindings for harvest, batch, QC, grade, packing, and delivery repositories.
- Added Harvest service layer with transactional create/update operations and workflow status helpers.
- Added Harvest API requests, resources, controllers, routes, and policies for harvest operational endpoints.
- Added Harvest feature and unit tests for CRUD, operational sub-resource creation, validation, authentication, and service workflow transitions.
- Added Master Data schema alignment migration for region code columns used by the current API contract.
- Added Finance database migrations for cost centers, expenses, revenues, journals, ledgers, journal entries, cost allocations, profit calculations, and financial summaries.
- Added Finance Eloquent models with fillable fields, casts, relationships, UUID, soft deletes, audit support, and query scopes.
- Added Finance factories and seeder for cost center, expense, revenue, journal, ledger, journal entry, cost allocation, profit calculation, and financial summary seed/test data.
- Added Finance repository interfaces, repositories, and service container bindings.
- Added Finance service layer with transactional create/update operations, financial workflow status transitions (Draft→Validated→Posted→Completed→Closed→Locked), ledger posting engine (Expense and Revenue auto-generate Journal, Ledger, and Journal Entries on posting), journal balance validation, ledger immutability guard, cost center and financial period validation, profit calculation engine (Cost of Production, Gross Profit, Net Profit, Cost per KG), and financial summary aggregation.
- Added Finance API layer with form requests, API resources, thin service-backed controllers, route registration, and policies for cost centers, expenses, revenues, journals, ledgers, journal entries, cost allocations, profit calculations, and financial summaries.
- Added Finance feature and unit tests for API CRUD, operational resource creation, validation, authentication, posting workflows, journal balance validation, ledger immutability, profit calculation, and financial summary workflows.
- Added Dashboard Part 1 read-only backend foundation with a service-backed operational snapshot endpoint, repository contract and binding, API resource, controller, and route registration.
- Added Dashboard Part 2 modular architecture with Dashboard Engine, Widget Engine, Widget Registry, Widget Container, role-based workspace resolver, and read-only workspace endpoint.
- Added Dashboard Part 3 REST API layer with role-based workspace endpoints, KPI, widget, alert, timeline, analytics, refresh, cache, export, statistics endpoints, request validation, API resources, cache integration, execution logging, and feature tests.
- Added Dashboard Part 4 frontend Command Center workspace with role-based workspace selector, KPI bar, responsive widget grid, reusable widget container, timeline, alert center, notification panel, filter bar, manual refresh, loading, error, empty, and last-updated states.
- Added Dashboard Part 5 engine hardening with configurable cache service, cache hit/miss metadata, user-scoped cache keys, widget permission filtering, independent widget refresh lifecycle metadata, error isolation, workspace validation, custom Dashboard exceptions, and feature tests for cache, role, permission, and refresh behavior.
- Added Dashboard Part 6 Operational Intelligence with rule-based operational summary, KPI intelligence, trend indicators, comparative indicators, insight cards, recommendation panel, farm/pond/financial/inventory/production health summaries, Dashboard intelligence API, and frontend intelligence panel.
- Marked Dashboard Module as completed after final verification of Dashboard Part 1-6 deliverables.
- Added Report Analytics Part 1 read-only backend foundation with Generate Never Store overview, category/workspace definitions, service foundation, API resource, controller, routes, authorization policy, and feature tests.
- Added Report Analytics Part 2 architecture foundation with Universal Report Engine, Report Registry, Report Definition metadata, Template Engine, Template Resolver, Report Builder, Report Section abstraction, service-layer Data Collector abstraction, Data Formatter, Rendering Engine abstraction, Export Engine abstraction, Report Layout abstraction, file naming convention service, locale-aware formatting foundation, service container bindings, and unit tests.
- Added Report Analytics Part 3 REST API layer with report registry endpoints, category report endpoints, historical/comparative/analytics endpoints, generate preview endpoint, export metadata adapter endpoint, scheduled report foundation endpoints, Form Request validation, RBAC per report category, Universal Report Engine integration, execution logging, and feature tests.
- Added Report Analytics Part 4 frontend Report Workspace with hash-based route integration, report navigation sidebar, category workspaces, report registry list, global search, sorting/filtering, reusable filter panel, preview panel, export metadata panel, generate preview action, export progress state, loading/error/empty states, last generated metadata, scheduled report UI foundation, and responsive three/two/one-panel layout.
- Added Report Analytics Part 5 report engine hardening with permission validation, parameter validation, template validation, data aggregation foundation, scoped report cache service, queue/background job metadata foundation, chunk-processing metadata, streaming-export metadata, scheduled report service foundation, audit metadata, execution logging, retry metadata, and custom report exceptions.
- Added Report Analytics Part 6 Business Intelligence and Executive Analytics with BI service, executive analytics service, operational/production/inventory/harvest/financial intelligence summaries, trend analysis, comparative analysis, KPI analytics, executive summary, executive scorecard, benchmark analysis, decision support insights, BI cache service, aggregation job foundation, REST API endpoints, frontend BI panel, and unit/feature tests.
- Marked Report Analytics Module as completed after final verification of Report Analytics Part 1-6 deliverables.
- Added Notification Part 1 backend foundation with Notification Center overview endpoint, repository contract and implementation, service foundation, controller, API resource, policy, route, category/priority/status/channel definitions, MVP In-App channel metadata, service container binding, and feature tests.
- Added Notification Part 2 event-driven architecture foundation with immutable Domain Event contract and implementation, sample events, Event Bus abstraction, Notification Registry, Notification Definition metadata, Recipient Resolver, Channel Resolver, In-App channel adapter, Delivery Engine, queue/job foundation, Retry Policy, delivery status workflow, notification record/history foundation, template abstraction, service container bindings, custom exceptions, and unit/feature tests.
- Added Notification Part 3 REST API layer with Notification Center list, detail, read/read-all, archive/archive-all, delete, preferences, history, search, statistics, retry, registry, templates, export metadata endpoints, Form Request validation, API Resources, user-scoped repository queries, status transition validation, RBAC policies, action logging, preference storage, and feature tests.
- Added Notification Part 4 frontend Notification Center with lazy-loaded hash route, sidebar and navbar unread badge integration, user-scoped three-panel workspace, navigation, search, filters, sorting, pagination, statistics, detail actions, history, preferences, responsive states, and React Query service-backed mutations.
- Added Notification Part 5 engine hardening with policy validation, queue retry backoff, pending-to-processing delivery lifecycle, delivery/retry/dead-letter/retention metadata, notification audit logging, engine health metrics, scoped cache strategy, custom policy and queue exceptions, and Notification unit/feature coverage.
- Added System Administration Part 1 backend foundation with a read-only platform overview endpoint, Administration repository contract and implementation, service layer, Configuration Registry metadata, API resource, controller, route, RBAC policy and gate, service bindings, and feature tests.
- Added System Administration Part 2 Administration Engine architecture with Configuration, Security, Monitoring, Audit, Backup, Restore, Integration, and Health Check engine foundations; Configuration Cache and Validator; Module and System Capability registries; Feature Toggle and Environment Resolver foundations; engine service provider; custom exceptions; and unit/feature coverage.
- Added System Administration Part 3 REST API with configuration, module registry, feature toggle, health, security, monitoring, audit, backup, and integration endpoints; request validation, API Resource responses, administrator-only policy enforcement, and feature coverage.
- Added System Administration Part 4 frontend workspace with lazy hash route, three-panel responsive Administration Control Center, React Query services/hooks, RBAC-aware navigation, metadata dashboard, configuration and feature-toggle actions, monitoring/health polling, and accessible loading, error, and empty states.
- Added System Administration Part 5 engine hardening with centralized configuration cache TTL, configuration synchronization metadata, feature toggle evaluation cache, module registry cache, user-scoped role and permission cache, engine metrics, performance metadata, audit metadata for configuration changes, Administration exception hierarchy, and unit/feature coverage for cache, security metadata, and platform metadata update workflows.
- Added System Administration Part 6 Configuration, Monitoring & Audit with configuration lifecycle/version/history/publish/rollback/cache-refresh metadata, immutable masked configuration history, monitoring summary, application/database/queue/worker/scheduler/cache/storage/API/integration monitoring metadata, performance monitoring, capacity monitoring, rule-based system health score, operational dashboard metadata, audit center classifications, alert monitoring with existing Notification Event Engine metadata integration, background metrics collection job foundation, REST API endpoints, frontend workspace panels, and unit/feature coverage.
- Added System Administration Part 7 Security, Backup & Disaster Recovery with security governance metadata, access/session/password/account review metadata, security health score, incident classification and lifecycle foundation, security alert Notification Event Engine metadata integration, backup policy/plan/history/execution/verification foundations, restore request/validation/dry-run metadata, disaster recovery plan/readiness/checklist, non-destructive backup/restore/DR background job foundations, REST API endpoints, frontend workspace panels, and unit/feature coverage.

## Verification

- System Administration Part 1 (2026-07-16): `composer dump-autoload` succeeded; 1 Administration route is registered; 82 tests passed with 655 assertions; Laravel 12.63.0 runs on PHP 8.4.23 with PostgreSQL, Redis, and database queue; all 66 migrations are `Ran`.
- System Administration Part 2 (2026-07-16): `composer dump-autoload` succeeded; 1 Administration route is registered; 85 tests passed with 668 assertions; Laravel 12.63.0 runs on PHP 8.4.23 with PostgreSQL, Redis, and database queue; all 66 migrations are `Ran`.
- System Administration Part 3 (2026-07-16): `composer dump-autoload` succeeded; 19 Administration route definitions are registered; 86 tests passed with 718 assertions; Laravel 12.63.0 runs on PHP 8.4.23 with PostgreSQL, Redis, and database queue; all 66 migrations are `Ran`.
- System Administration Part 4 (2026-07-16): `npm run build` and `npm run lint` succeeded; TypeScript verification runs through the production build.
- System Administration Part 5 (2026-07-16): `composer dump-autoload` succeeded with 6781 classes; 19 Administration route definitions are registered; 90 tests passed with 737 assertions; Laravel 12.63.0 runs on PHP 8.4.23 with PostgreSQL, Redis cache, and database queue; all 66 migrations are `Ran`; `npm run build` and `npm run lint` succeeded; TypeScript verification runs through the production build.
- System Administration Part 6 (2026-07-16): `composer dump-autoload` succeeded with 6782 classes; 31 Administration route definitions are registered; 91 tests passed with 793 assertions; Laravel 12.63.0 runs on PHP 8.4.23 with PostgreSQL, Redis cache, and database queue; all 66 migrations are `Ran`; `npm run build` and `npm run lint` succeeded; no separate `type-check` script is configured because TypeScript verification runs through `npm run build`.
- System Administration Part 7 (2026-07-16): `composer dump-autoload` succeeded with 6786 classes; 46 Administration route definitions are registered; 92 tests passed with 846 assertions; Laravel 12.63.0 runs on PHP 8.4.23 with PostgreSQL, Redis cache, and database queue; all 66 migrations are `Ran`; `npm run build` and `npm run lint` succeeded; no separate `type-check` script is configured because TypeScript verification runs through `npm run build`.

## Fixed

- Fixed module PSR-4 autoload mapping for `MasterData`, `CultureCycle`, and `Activities`.
- Fixed base repository methods required by modular services.
- Fixed Activities request/resource field alignment with Activities migrations.
- Fixed restore and force delete flow for soft-deleted modular resources.
- Fixed `HasFactory` trait collision in module models by creating `Shared/Support/HasModuleFactory.php` trait for proper factory resolution.
- Updated all MasterData (22 models), CultureCycle (5 models), and Activities (5 models) to use `HasModuleFactory`.
- Fixed `Role` model explicit table name for `role_permission` pivot.
- Fixed `HasFactory` + `HasModuleFactory` collision in `CultureCycle/Models/CultureCycle.php`.
- Fixed `use HasFactory;` import missing in Activities models (ActivityCategory, ActivityType, Activity, ActivityAttachment, ActivityComment).
- Fixed `_code` column naming in MasterData migrations (`province_code`, `city_code`, etc.) for proper API resource prefix.
- Fixed Master Data API request, factory, and test alignment with current migration fields and UUID-based resource endpoints.

## Verification

- Ran checklist verifikasi milestone (2026-07-10):
  - ✅ `composer install` — passed
  - ✅ `php artisan route:list` — passed
   - ✅ `php artisan test` — 2 passed (sebelum Docker; setelah Docker: seluruh 6 WarehouseApiTest + test lainnya lulus)
   - ✅ `php artisan about` — Laravel 12.63.0, PHP 8.4.23
   - ✅ `php artisan migrate:status` — 47 migrations di batch [1] Ran
   - ✅ WarehouseApiTest: 6 passed (34 assertions) — CRUD, inventory batch→stock→movement, stock opname, validasi, restore/force delete, unauthenticated
   - ✅ `composer install` — nothing to install, optimized autoload
   - ✅ Seluruh 47 migrations telah dijalankan (foundation, master data, culture cycle, activities, warehouse)
   - 🏁 **Warehouse module — ✅ Completed**
- Ran checklist verifikasi milestone (2026-07-12):
  - ✅ `composer install` — nothing to install, optimized autoload
  - ✅ `php artisan route:list` — 224 routes registered
  - ✅ `php artisan test` — 28 passed, 0 failures (all modules: MasterData, CultureCycle, Activities, Warehouse)
  - ✅ `php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL
  - ✅ `php artisan migrate:status` — 48 migrations in batch [1] Ran (foundation, master data, culture cycle, activities, warehouse)
  - ✅ All Docker containers running, all tests pass
  - 🏁 **Verifikasi milestone — ✅ Passed**
- Ran Harvest Part 1 migration verification (2026-07-12):
  - ✅ `docker compose exec app php artisan migrate` — Harvest migrations completed.
  - ✅ `docker compose exec app php artisan migrate:status` — 6 Harvest migrations in batch [2] Ran.
- Ran Harvest Part 7 verification (2026-07-14):
  - ✅ `docker compose exec app composer install` — nothing to install, optimized autoload
  - ✅ `docker compose exec app php artisan route:list` — 266 routes registered
  - ✅ `docker compose exec app php artisan test` — 34 passed, 193 assertions
  - ✅ `docker compose exec app php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL
  - ✅ `docker compose exec app php artisan migrate:status` — 54 migrations in batch [1] Ran
  - 🏁 **Harvest Part 7 Testing — ✅ Completed**
- Ran Finance Part 1 migration verification (2026-07-14):
  - ✅ `docker compose exec app php artisan migrate` — 9 Finance migrations completed.
  - ✅ `docker compose exec app php artisan migrate:status` — Finance migrations in batch [2] Ran.
- Ran Finance Part 2 model verification (2026-07-14):
  - ✅ `composer dump-autoload` — optimized autoload regenerated.
  - ✅ Finance model class resolution — 9 models OK.
- Ran Finance Part 3 seeder verification (2026-07-14):
  - ✅ `docker compose exec app composer dump-autoload` — optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan db:seed "--class=Database\\Seeders\\Finance\\FinanceSeeder"` — passed.
- Ran Finance Part 4 repository verification (2026-07-14):
  - ✅ PHP lint for Finance repositories and interfaces — passed.
  - ✅ Laravel container binding resolution — 9 Finance repository interfaces resolved.
- Ran Finance Part 5 service layer verification (2026-07-14):
  - ✅ `docker compose exec app composer dump-autoload` — 6568 classes, optimized autoload regenerated.
  - ✅ `php artisan config:clear`, `route:clear`, `view:clear` — passed.
  - ✅ `docker compose exec app php artisan test` — 34 passed, 193 assertions, 0 failures.
  - ✅ 9 Finance services implemented: CostCenter, Expense, Revenue, Journal, JournalEntry, Ledger, CostAllocation, ProfitCalculation, FinancialSummary.
  - ✅ Ledger Posting Engine berjalan — postExpense dan postRevenue auto-generate Journal + Ledger + Journal Entries.
  - ✅ Journal Balance Validation — Debit harus sama dengan Credit sebelum posting.
  - ✅ Ledger Immutability Guard — Posted ledger tidak dapat diubah atau dihapus.
  - ✅ Profit Calculation Engine — Cost of Production, Gross Profit, Net Profit, Cost per KG dihitung dari Ledger Posted.
  - ✅ Financial Summary Engine — total_expense, total_revenue, gross_profit, net_profit, profit_margin dihitung otomatis.
- Ran Finance Part 6 API layer verification (2026-07-15):
  - ✅ `docker compose up -d` — app, postgres, redis, and nginx containers started.
  - ✅ `docker compose exec app composer dump-autoload` — 6605 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list` — 329 routes registered, including Finance API resources and restore/force-delete routes.
  - ✅ PHP lint for Finance API requests, resources, controllers, routes, and policies — passed.
- Ran Finance Part 7 testing and module completion verification (2026-07-15):
  - ✅ Finance-only test run — 9 passed, 64 assertions.
  - ✅ `docker compose exec app composer install` — nothing to install, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list` — 329 routes registered.
  - ✅ `docker compose exec app php artisan test` — 43 passed, 257 assertions.
  - ✅ `docker compose exec app php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL.
  - ✅ `docker compose exec app php artisan migrate:status` — all 63 migrations Ran.
  - 🏁 **Finance module — ✅ Completed**
- Ran Dashboard Part 1 foundation verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6613 classes, optimized autoload regenerated.
  - ✅ PHP lint for Dashboard contract, repository, service, resource, controller, and routes — passed.
  - ✅ Dashboard service container binding — resolved after Laravel bootstrap.
  - ✅ `docker compose exec app php artisan route:list` — 330 routes registered, including `GET api/v1/dashboard`.
- Ran Dashboard Part 2 architecture verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6624 classes, optimized autoload regenerated.
  - ✅ PHP lint for the complete Dashboard module — passed.
  - ✅ Role-based workspace engine resolved the Executive workspace for the `farm-owner` role with an empty widget registry.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/dashboard` — 2 Dashboard routes registered.
- Ran Dashboard Part 3 REST API verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6631 classes, optimized autoload regenerated.
  - ✅ PHP lint for the complete Dashboard module — passed.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/dashboard` — 21 Dashboard routes registered.
  - ✅ `docker compose exec app php artisan test` — 46 passed, 298 assertions.
- Ran Dashboard Part 4 frontend verification (2026-07-15):
  - ✅ `npm install` — frontend dependencies installed, 0 vulnerabilities.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
  - ✅ Vite foreground dev server started successfully at `http://127.0.0.1:5174/`; background server launch was not retained by the shell tool environment.
- Ran Dashboard Part 5 engine verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6637 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/dashboard` — 21 Dashboard routes registered.
  - ✅ PHP lint for the complete Dashboard module — passed.
  - ✅ `docker compose exec app php artisan test` — 49 passed, 318 assertions.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
- Ran Dashboard Part 6 Operational Intelligence verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6638 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/dashboard` — 22 Dashboard routes registered.
  - ✅ PHP lint for the complete Dashboard module — passed.
  - ✅ `docker compose exec app php artisan test` — 50 passed, 343 assertions.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
- Ran Dashboard final module completion verification (2026-07-15):
  - ✅ `docker compose exec app composer install` — nothing to install, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/dashboard` — 22 Dashboard routes registered.
  - ✅ `docker compose exec app php artisan test` — 50 passed, 343 assertions.
  - ✅ `docker compose exec app php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL, Redis cache, Asia/Jakarta.
  - ✅ `docker compose exec app php artisan migrate:status` — all 63 migrations Ran.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
  - 🏁 **Dashboard module — ✅ Completed**
- Ran Report Analytics Part 1 foundation verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6644 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/reports` — 3 Report Analytics routes registered.
  - ✅ `docker compose exec app php artisan test` — 53 passed, 374 assertions.
  - ✅ Report Analytics Part 1 read-only foundation completed; Report Analytics remains in progress for Part 2.
- Ran Report Analytics Part 2 architecture verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6665 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/reports` — 3 Report Analytics routes registered.
  - ✅ `docker compose exec app php artisan test` — 58 passed, 393 assertions.
  - ✅ Report Analytics Part 2 architecture foundation completed; Report Analytics remains in progress for Part 3.
- Ran Report Analytics Part 3 REST API verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6669 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/reports` — 21 Report Analytics routes registered.
  - ✅ `docker compose exec app php artisan test` — 61 passed, 475 assertions.
  - ✅ Report Analytics Part 3 REST API completed; Report Analytics remains in progress for Part 4.
- Ran Report Analytics Part 4 frontend workspace verification (2026-07-15):
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/reports` — 21 Report Analytics routes registered.
  - ✅ `docker compose exec app php artisan test` — 61 passed, 475 assertions.
  - ✅ Report Analytics Part 4 frontend workspace completed; Report Analytics remains in progress for Part 5.
- Ran Report Analytics Part 5 engine hardening verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6685 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/reports` — 21 Report Analytics routes registered.
  - ✅ `docker compose exec app php artisan test` — 62 passed, 485 assertions.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
  - ✅ `npm run type-check` — not available as a separate script; TypeScript check runs through `npm run build`.
  - ✅ Report Analytics Part 5 engine hardening completed; Report Analytics remains in progress for Part 6.
- Ran Report Analytics Part 6 Business Intelligence verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6692 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/reports` — 29 Report Analytics routes registered.
  - ✅ `docker compose exec app php artisan test` — 64 passed, 557 assertions.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
  - ✅ `npm run type-check` — not available as a separate script; TypeScript check runs through `npm run build`.
  - ✅ Report Analytics Part 6 Business Intelligence completed; Report Analytics remains in progress for final verification and module completion.
- Ran Report Analytics final module completion verification (2026-07-15):
  - ✅ `docker compose exec app composer install` — nothing to install, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/reports` — 29 Report Analytics routes registered.
  - ✅ `docker compose exec app php artisan test` — 64 passed, 557 assertions.
  - ✅ `docker compose exec app php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL, Redis cache, Queue database, Asia/Jakarta.
  - ✅ `docker compose exec app php artisan migrate:status` — all 63 migrations Ran.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed.
  - ✅ `npm run type-check` — not available as a separate script; TypeScript check runs through `npm run build`.
  - 🏁 **Report Analytics module — ✅ Completed**
- Ran Notification Part 1 foundation verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6699 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/notifications` — 1 Notification route registered: `GET api/v1/notifications/overview`.
  - ✅ `docker compose exec app php artisan test` — 66 passed, 577 assertions.
  - ✅ Notification Part 1 foundation completed; Notification remains in progress for Part 2.
- Ran Notification Part 2 event engine verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6730 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/notifications` — 1 Notification route registered: `GET api/v1/notifications/overview`.
  - ✅ `docker compose exec app php artisan test` — 73 passed, 603 assertions.
  - ✅ Notification Part 2 architecture and event engine foundation completed; Notification remains in progress for Part 3.
- Ran Notification Part 3 REST API verification (2026-07-15):
  - ✅ `docker compose exec app composer dump-autoload` — 6737 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/notifications` — 17 Notification routes registered.
  - ✅ `docker compose exec app php artisan migrate` — no pending migrations.
  - ✅ `docker compose exec app php artisan test` — 78 passed, 638 assertions.
  - ✅ Notification Part 3 REST API completed; Notification remains in progress for Part 4.
- Ran Notification Part 4 frontend verification (2026-07-16):
  - ✅ `docker compose up -d` — PostgreSQL, Redis, app, and Nginx containers started.
  - ✅ `docker compose exec app composer dump-autoload` — 6737 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/notifications` — 17 Notification routes registered.
  - ✅ `docker compose exec app php artisan test` — 78 passed, 638 assertions, 93.17 seconds.
  - ✅ `docker compose exec app php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL, Redis cache, database queue, Asia/Jakarta.
  - ✅ `docker compose exec app php artisan migrate:status` — 66 migrations Ran.
  - ✅ `npm run build` — TypeScript and Vite production build passed; Notification Center is emitted as a lazy-loaded chunk.
  - ✅ `npm run lint` — ESLint passed with no errors.
  - ✅ Notification Part 4 frontend completed and is ready for review and manual Git commit; Notification remains in progress for Part 5.
- Ran Notification Part 5 engine hardening verification (2026-07-16):
  - ✅ `docker compose exec app composer dump-autoload` — 6744 classes, optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/notifications` — 17 Notification routes registered.
  - ✅ Notification-focused tests — 15 passed, 88 assertions.
  - ✅ `docker compose exec app php artisan test` — 79 passed, 645 assertions, 97.63 seconds.
  - ✅ `docker compose exec app php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL, Redis cache, database queue, Asia/Jakarta.
  - ✅ `docker compose exec app php artisan migrate:status` — 66 migrations Ran; no new migration required.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed; TypeScript validation runs through `npm run build` because no separate type-check script is configured.
  - ✅ Notification Part 5 engine hardening completed and is ready for review and manual Git commit; Notification remains in progress for final verification.
- Ran Notification final module completion verification (2026-07-16):
  - ✅ `docker compose exec app composer install` — lock file valid; nothing to install, update, or remove; optimized autoload regenerated.
  - ✅ `docker compose exec app php artisan route:list --path=api/v1/notifications` — 17 Notification routes registered.
  - ✅ `docker compose exec app php artisan test` — 79 passed, 645 assertions, 98.32 seconds.
  - ✅ `docker compose exec app php artisan about` — Laravel 12.63.0, PHP 8.4.23, PostgreSQL, Redis cache, database queue, Asia/Jakarta.
  - ✅ `docker compose exec app php artisan migrate:status` — 66 migrations Ran.
  - ✅ `npm run build` — TypeScript and Vite production build passed.
  - ✅ `npm run lint` — ESLint passed; TypeScript validation runs through `npm run build` because no separate type-check script is configured.
  - 🏁 **Notification Module — ✅ Completed** and ready for manual Git commit.

## Planned

- Dokumentasi 05_Warehouse
- Dokumentasi 06_Harvest
- Dokumentasi 07_Finance
- Dokumentasi 08_Dashboard
- Dokumentasi 09_Report_Analytics

---

# [0.1.0] - Blueprint Phase

## Added

### Global Documentation

- Added `00_Project_Master.md`
- Added `00_Development_Convention.md`
- Added `00_Business_Rules.md`
- Added `00_Database_Convention.md`
- Added `00_API_Convention.md`
- Added `00_UI_Convention.md`
- Added `00_Coding_Convention.md`
- Added `00_Project_Structure.md`

### Foundation

- Added `01_Milestone_Foundation.md`

### Master Data Documentation

- Added `02_Master_Data_Part_1.md`
- Added `02_Master_Data_Part_2.md`
- Added `02_Master_Data_Part_3.md`
- Added `02_Master_Data_Part_4.md`
- Added `02_Master_Data_Part_5.md`

### Repository Documentation

- Added `README_AI.md`
- Added `PROJECT_STATUS.md`
- Added `CHANGELOG.md`

---

## Architecture

Implemented:

- Modern Modular Architecture
- Service Layer
- Repository Pattern
- REST API
- Component Based Frontend

Technology Stack

- Laravel 12
- PHP 8.4
- React
- TypeScript
- Vite
- Tailwind CSS
- PostgreSQL
- Docker
- Redis
- Laravel Sanctum

---

## Business Rules

Established global business rules covering:

- Company
- Farm
- Pond
- Culture Cycle
- Warehouse
- Harvest
- Finance
- Dashboard

---

## Database

Defined:

- UUID Standard
- Soft Delete
- Audit Trail
- Foreign Key Convention
- Index Convention
- Migration Convention

---

## API

Defined:

- REST API Standard
- Response Format
- Error Response
- Pagination
- Search
- Sorting
- Filtering
- Authentication
- Authorization

---

## UI

Defined:

- Layout Standard
- Data Table Standard
- Form Standard
- Modal Standard
- Responsive Design
- Component Standard

---

## Coding

Defined:

- Backend Coding Standard
- Frontend Coding Standard
- Repository Pattern
- Service Layer
- Naming Convention
- Git Convention

---

## Notes

Blueprint project telah selesai.

Tahap berikutnya adalah implementasi source code menggunakan Codex berdasarkan seluruh dokumentasi yang telah dibuat.

---

# Version History

| Version | Status | Description |
|----------|--------|-------------|
| 0.1.0 | Active | Blueprint Project Completed |

---

# Release Roadmap

## Version 0.2.0

Target:

Master Data Implementation

---

## Version 0.3.0

Target:

Culture Cycle

---

## Version 0.4.0

Target:

Activities

---

## Version 0.5.0

Target:

Warehouse

---

## Version 0.6.0

Target:

Harvest

---

## Version 0.7.0

Target:

Finance

---

## Version 0.8.0

Target:

Dashboard

---

## Version 0.9.0

Target:

Report & Analytics

---

## Version 1.0.0

Target:

Minimum Viable Product (MVP)

---

# Update Rules

Setiap selesai melakukan perubahan berikut, wajib memperbarui CHANGELOG.md:

- Penambahan fitur baru.
- Perubahan arsitektur.
- Perubahan struktur database.
- Perubahan API.
- Penambahan dokumentasi.
- Perubahan Business Rules.
- Penyelesaian milestone.
- Perubahan versi.

---

# AI Instructions

AI Coding Assistant wajib:

1. Membaca CHANGELOG.md sebelum melakukan implementasi.
2. Memahami perubahan terakhir yang telah dilakukan.
3. Tidak mengimplementasikan fitur yang sudah tercatat sebagai selesai.
4. Memperbarui CHANGELOG.md setelah menyelesaikan milestone atau fitur besar.

---

# End of Document
