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

## Fixed

- Fixed module PSR-4 autoload mapping for `MasterData`, `CultureCycle`, and `Activities`.
- Fixed base repository methods required by modular services.
- Fixed Activities request/resource field alignment with Activities migrations.
- Fixed restore and force delete flow for soft-deleted modular resources.

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
