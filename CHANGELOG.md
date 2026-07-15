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
