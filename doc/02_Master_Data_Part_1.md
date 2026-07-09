# UtiFarm
# 02_Master_Data
## Part 1 — Overview & Business Rules

Version : 1.0

Depends :

- 00_Project_Master.md
- 01_Milestone_Foundation.md

---

# 1. Overview

Master Data merupakan pondasi utama seluruh sistem UtiFarm.

Seluruh modul lain wajib menggunakan data yang berasal dari Master Data.

Modul lain tidak diperbolehkan membuat data referensi sendiri.

Master Data menjadi Single Source of Truth (SSOT) bagi seluruh aplikasi.

---

# 2. Objective

Tujuan modul ini adalah menyediakan seluruh data referensi yang diperlukan oleh sistem.

Seluruh data harus dapat digunakan kembali oleh:

- Dashboard
- Culture Cycle
- Activities
- Warehouse
- Harvest
- Finance
- Reports

---

# 3. Business Rules

Seluruh Master Data memiliki aturan berikut.

- Mendukung CRUD.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Memiliki Audit Trail.
- Memiliki Created By.
- Memiliki Updated By.
- Memiliki Deleted By.
- Mendukung Search.
- Mendukung Filter.
- Mendukung Pagination.
- Mendukung Export.
- Mendukung Import.

---

# 4. List of Master Data

Master Data terdiri dari:

## Organization

- Company
- Farm
- Pond Area
- Pond
- Building
- Warehouse

---

## Human Resource

- Employee
- User
- Role
- Permission

---

## Aquaculture

- Fish Species
- Fish Strain
- Seed Supplier
- Seed Batch
- Feed Brand
- Feed Type
- Feed Size
- Feed Category
- Medicine
- Probiotic
- Vitamin
- Chemical

---

## Warehouse

- Item Category
- Item Unit
- Item
- Supplier

---

## Sales

- Customer
- Customer Category

---

## Finance

- Expense Category
- Income Category
- Payment Method
- Tax

---

## General

- Unit
- Currency
- Province
- City
- District
- Village

---

# 5. Dependency Diagram

Company

↓

Farm

↓

Pond Area

↓

Pond

↓

Culture Cycle

↓

Activities

↓

Harvest

↓

Finance

↓

Dashboard

---

# 6. Business Flow

User Login

↓

Select Farm

↓

Select Pond

↓

Input Activity

↓

Update Warehouse

↓

Calculate Biomass

↓

Harvest

↓

Finance

↓

Dashboard

---

# 7. Master Data Principles

Seluruh Master Data wajib:

- Reusable.
- Tidak saling menduplikasi.
- Memiliki relasi yang jelas.
- Tidak boleh menyimpan data transaksi.
- Digunakan sebagai referensi oleh modul lain.

---

# 8. Naming Convention

Nama tabel menggunakan snake_case.

Nama Model menggunakan PascalCase.

Nama API menggunakan kebab-case.

Nama Route mengikuti REST Standard.

---

# 9. Validation Rules

Setiap Master Data minimal memiliki validasi:

- Required
- Unique
- Max Length
- Min Length
- Exists
- Foreign Key Validation

---

# 10. Performance Rules

Semua list wajib:

- Pagination.
- Lazy Loading.
- Server Side Search.
- Server Side Filter.
- Server Side Sort.

---

# 11. Security Rules

Seluruh endpoint:

- Authentication Required.
- Authorization Required.
- Activity Logging.
- Input Validation.
- SQL Injection Protection.
- XSS Protection.

---

# 12. Deliverables

Dokumen berikutnya akan mendefinisikan:

02_Master_Data_Part_2

yang berisi:

- Database Schema
- Table Design
- Relationship
- Foreign Key
- Index
- Constraint

---

# AI Coding Instructions

Implementasikan seluruh struktur Master Data sesuai spesifikasi.

Jangan membuat tabel transaksi.

Jangan membuat Dashboard.

Jangan membuat Culture Cycle.

Fokus hanya pada Master Data.

Seluruh CRUD harus production-ready.

---

# End of Document