# AI IMPLEMENTATION INSTRUCTION

Anda adalah Senior Software Engineer, Solution Architect, Technical Lead, dan Laravel + React Fullstack Developer.

Gunakan seluruh dokumen berikut sebagai satu kesatuan spesifikasi.

1. 00_Project_Master.md
2. 01_Milestone_Foundation.md
3. 02_Master_Data_Part_1.md
4. 02_Master_Data_Part_2.md
5. 02_Master_Data_Part_3.md
6. 02_Master_Data_Part_4.md

Seluruh implementasi harus mengikuti seluruh spesifikasi.

Apabila terdapat konflik, gunakan prioritas dokumen berdasarkan nomor terkecil.

Dilarang membuat implementasi di luar ruang lingkup Master Data.

Seluruh kode harus production-ready.

---

# UtiFarm

# 02_Master_Data

## Part 5 — Implementation Rules & Development Checklist

Version : 1.0

---

# 1. Objective

Dokumen ini mendefinisikan aturan implementasi Master Data.

Dokumen ini menjadi acuan utama selama proses development.

Seluruh source code harus mengikuti aturan berikut.

---

# 2. Development Scope

Yang diperbolehkan

✔ CRUD Master Data

✔ Migration

✔ Model

✔ Seeder

✔ Factory

✔ Repository

✔ Service

✔ Controller

✔ Form Request

✔ API Resource

✔ Policy

✔ Route

✔ React CRUD

✔ Unit Test

✔ Feature Test

Yang tidak diperbolehkan

✖ Dashboard

✖ Culture Cycle

✖ Activities

✖ Warehouse

✖ Harvest

✖ Finance

✖ Report

---

# 3. CRUD Standard

Setiap Master Data wajib memiliki:

Create

Read

Update

Delete

Restore

Force Delete (Super Admin)

---

# 4. Repository Standard

Semua akses database harus melalui Repository.

Controller

↓

Service

↓

Repository

↓

Model

Controller tidak boleh mengakses Model secara langsung.

---

# 5. Service Standard

Seluruh Business Logic berada pada Service Layer.

Service bertanggung jawab terhadap:

- Validasi bisnis
- Transaksi database
- Integrasi antar repository
- Logging
- Event dispatching

---

# 6. Controller Standard

Controller hanya bertugas:

- Menerima Request
- Memanggil Service
- Mengembalikan API Resource

Tidak boleh berisi business logic.

---

# 7. Validation Standard

Semua POST dan PUT wajib menggunakan Form Request.

Validasi minimal:

- required
- string
- numeric
- integer
- email
- uuid
- unique
- exists
- boolean
- date

---

# 8. API Resource Standard

Semua response wajib menggunakan API Resource.

Tidak boleh mengembalikan Model secara langsung.

---

# 9. Transaction Standard

Operasi berikut wajib menggunakan Database Transaction:

- Create
- Update
- Delete
- Restore
- Import

Rollback jika terjadi error.

---

# 10. Audit Trail

Seluruh perubahan wajib mencatat:

- created_by
- updated_by
- deleted_by
- created_at
- updated_at
- deleted_at

---

# 11. Activity Log

Catat aktivitas berikut:

Login

Logout

Create

Update

Delete

Restore

Export

Import

---

# 12. Permission Matrix

Role:

Super Admin

- Full Access

Farm Owner

- CRUD Farm
- View Report

Farm Manager

- CRUD Master Farm

Technician

- View Only

Warehouse Staff

- Warehouse Master

Finance Staff

- Finance Master

Viewer

- Read Only

---

# 13. UI Checklist

Setiap halaman wajib memiliki:

✔ Breadcrumb

✔ Search

✔ Filter

✔ Sort

✔ Pagination

✔ Export

✔ Refresh

✔ Responsive

✔ Loading State

✔ Empty State

✔ Error State

---

# 14. Performance Rules

List data wajib:

Server Side Pagination

Server Side Search

Server Side Sort

Server Side Filter

Gunakan eager loading untuk relationship yang diperlukan.

Hindari query N+1.

---

# 15. Security Rules

Semua endpoint wajib:

Authentication

Authorization

CSRF Protection (jika menggunakan session)

Input Validation

Rate Limiting

Audit Logging

---

# 16. Error Handling

Gunakan format response standar.

Jangan menampilkan stack trace kepada pengguna.

Semua exception dicatat ke log.

---

# 17. Testing Standard

Minimal:

Unit Test

Feature Test

API Test

Coverage minimum:

80%

---

# 18. Documentation Standard

Setiap Master Data wajib memiliki:

- Migration
- Model
- Seeder
- Factory
- Repository
- Service
- Controller
- Form Request
- API Resource
- Policy
- Route
- API Documentation

---

# 19. Acceptance Criteria

Implementasi dianggap selesai apabila:

✔ Migration berhasil dijalankan.

✔ Seeder berhasil dijalankan.

✔ CRUD berjalan.

✔ Validation berjalan.

✔ Authorization berjalan.

✔ Search berjalan.

✔ Filter berjalan.

✔ Pagination berjalan.

✔ Soft Delete berjalan.

✔ Restore berjalan.

✔ Unit Test berhasil.

✔ Feature Test berhasil.

✔ API Documentation tersedia.

---

# 20. Deliverables

Codex wajib menghasilkan struktur berikut.

Backend

app/

Modules/

MasterData/

Company/

Farm/

Pond/

Fish/

Feed/

Supplier/

Customer/

Employee/

Frontend

src/

pages/

master-data/

components/

services/

hooks/

types/

---

# 21. Folder Structure Standard

Setiap Master Data memiliki struktur:

Company/

Controller/

Request/

Service/

Repository/

DTO/

Model/

Policy/

Resource/

Route/

Migration/

Seeder/

Factory/

Tests/

---

# 22. Naming Convention

Controller

CompanyController

Service

CompanyService

Repository

CompanyRepository

Model

Company

Request

StoreCompanyRequest

UpdateCompanyRequest

Policy

CompanyPolicy

Resource

CompanyResource

---

# 23. Code Quality

Gunakan:

PSR-12

SOLID

DRY

KISS

Clean Code

Tidak boleh ada duplicated code.

---

# 24. AI Development Rules

Apabila membuat CRUD:

1. Migration
2. Model
3. Factory
4. Seeder
5. Repository
6. Service
7. Request
8. Resource
9. Controller
10. Policy
11. Route
12. Unit Test
13. Feature Test

Urutan tersebut tidak boleh diubah.

---

# 25. Definition of Done

Master Data dianggap selesai apabila:

Semua tabel selesai.

Semua CRUD selesai.

Semua endpoint selesai.

Semua halaman React selesai.

Semua testing berhasil.

Tidak ada error migration.

Tidak ada warning TypeScript.

Tidak ada error ESLint.

Semua dokumentasi diperbarui.

---

# 26. Final Deliverables

Setelah seluruh Part 1–5 selesai, Codex harus mampu menghasilkan:

✔ Database Master Data lengkap

✔ Backend Laravel Production Ready

✔ Frontend React Production Ready

✔ REST API

✔ Authentication

✔ Authorization

✔ Documentation

✔ Testing

✔ Docker Ready

✔ CI/CD Ready

Tanpa melakukan implementasi modul lain.

---

# End of Document