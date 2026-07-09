# UtiFarm
# 00_Coding_Convention

Version : 1.0

Status : Active

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Database_Convention.md
- 00_API_Convention.md
- 00_UI_Convention.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar penulisan source code yang digunakan pada seluruh aplikasi UtiFarm.

Seluruh Backend Developer, Frontend Developer, dan AI Coding Assistant wajib mengikuti konvensi ini.

Tujuan utama:

- Konsisten
- Mudah Dibaca
- Mudah Dipelihara
- Mudah Dikembangkan

---

# 2. Coding Principles

Seluruh kode mengikuti prinsip berikut.

- KISS (Keep It Simple)
- DRY (Don't Repeat Yourself)
- SOLID
- Clean Code
- Readability First
- Maintainability
- Modular

Jangan melakukan over-engineering.

---

# 3. Backend Standard

Backend menggunakan:

- Laravel 12
- PHP 8.4

Mengikuti standar:

- PSR-12
- Laravel Best Practice

---

# 4. Frontend Standard

Frontend menggunakan:

- React
- TypeScript
- Vite
- Tailwind CSS

Mengikuti:

- ESLint
- Prettier
- TypeScript Strict Mode

---

# 5. Folder Convention

Backend

Module/

Controllers/

Models/

Requests/

Resources/

Repositories/

Services/

Policies/

Routes/

Frontend

components/

pages/

hooks/

services/

types/

utils/

layouts/

---

# 6. Naming Convention

Gunakan PascalCase

- CompanyController
- FarmService
- PondRepository

Gunakan camelCase

- getFarm()
- createCompany()

Gunakan snake_case

- company_name
- farm_code

---

# 7. Controller Convention

Controller hanya bertugas:

- menerima request
- memanggil service
- mengembalikan response

Controller tidak boleh:

- query database
- business logic
- validasi manual

---

# 8. Service Convention

Semua Business Logic berada pada Service.

Service bertugas:

- validasi bisnis
- transaksi
- memanggil repository
- logging

---

# 9. Repository Convention

Repository hanya bertugas mengakses database.

Repository tidak boleh memiliki business logic.

---

# 10. Model Convention

Model hanya berisi:

- Relationship
- Scope
- Accessor
- Mutator

Model tidak boleh berisi business process.

---

# 11. Request Convention

Semua validasi menggunakan Form Request.

Controller tidak boleh menggunakan Validator secara manual.

---

# 12. API Resource Convention

Semua response menggunakan Resource.

Tidak mengembalikan Model secara langsung.

---

# 13. Route Convention

Gunakan REST API.

Contoh

GET

POST

PUT

PATCH

DELETE

Gunakan Route API Resource apabila memungkinkan.

---

# 14. Query Convention

Gunakan:

Eloquent

atau

Query Builder

Hindari Raw SQL.

---

# 15. Database Transaction

Gunakan DB::transaction() pada:

- Create
- Update
- Delete
- Import
- Batch Process

---

# 16. Logging Convention

Log hanya untuk:

- Login
- Logout
- Create
- Update
- Delete
- Error

Jangan melakukan logging berlebihan.

---

# 17. Error Handling

Gunakan:

Exception

Custom Exception

Handler

Jangan menggunakan try-catch di semua tempat.

---

# 18. Frontend Component

Gunakan Functional Component.

Gunakan Hooks.

Hindari Class Component.

---

# 19. State Management

Server State

React Query

Client State

Context API

atau

Zustand

---

# 20. API Communication

Gunakan:

Axios

↓

Service

↓

React Query

↓

Component

Component tidak boleh memanggil API secara langsung.

---

# 21. Form Convention

Gunakan:

React Hook Form

+

Zod

---

# 22. Reusable Component

Seluruh komponen umum harus reusable.

Contoh:

Button

Input

Table

Modal

Dialog

Badge

Toast

Card

---

# 23. Comment Convention

Tambahkan komentar hanya apabila diperlukan.

Hindari komentar yang menjelaskan hal yang sudah jelas dari kode.

---

# 24. Import Convention

Gunakan urutan import:

1. Library
2. Framework
3. Internal Module
4. Relative Import

---

# 25. Constant Convention

Gunakan file Constant.

Jangan melakukan hardcode berulang.

---

# 26. Environment Variable

Semua konfigurasi berada pada:

.env

Jangan melakukan hardcode:

- URL
- Password
- API Key
- Secret

---

# 27. Git Convention

Branch

main

develop

feature/*

bugfix/*

hotfix/*

Commit

feat:

fix:

refactor:

docs:

style:

test:

chore:

---

# 28. Testing Convention

Minimal:

- Unit Test
- Feature Test

Testing dilakukan pada fitur utama.

---

# 29. Performance Convention

Gunakan:

- Pagination
- Eager Loading
- Memoization
- Lazy Loading

Hindari:

- Query N+1
- Duplicate Query

---

# 30. Security Convention

Gunakan:

- Authentication
- Authorization
- Validation
- CSRF Protection
- HTTPS
- Rate Limiting

---

# 31. Code Review Checklist

Sebelum kode dianggap selesai, pastikan:

- Mengikuti Coding Convention.
- Tidak ada duplicate code.
- Tidak ada warning.
- Tidak ada error.
- Menggunakan Service.
- Menggunakan Repository.
- Menggunakan Resource.
- Menggunakan Form Request.
- Menggunakan Policy jika diperlukan.

---

# 32. AI Coding Rules

AI Coding Assistant wajib:

- Membaca seluruh dokumentasi sebelum implementasi.
- Tidak membuat business logic di Controller.
- Tidak mengakses Model langsung dari Controller.
- Tidak membuat kode di luar ruang lingkup modul.
- Menghasilkan kode production-ready.
- Mengikuti seluruh konvensi proyek.

---

# 33. Definition of Done

Kode dianggap selesai apabila:

- Berhasil dijalankan.
- Tidak terdapat syntax error.
- Tidak terdapat warning.
- Mengikuti Coding Convention.
- Mudah dibaca.
- Mudah dipelihara.
- Lulus testing yang relevan.

---

# End of Document