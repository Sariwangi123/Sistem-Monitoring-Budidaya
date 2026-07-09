# UtiFarm
# 00_Development_Convention

Version : 1.0

Status : Active

Depends :

- 00_Project_Master.md
- 01_Milestone_Foundation.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar pengembangan yang wajib diikuti selama proses pembangunan aplikasi UtiFarm.

Dokumen ini berlaku untuk seluruh developer dan AI Coding Assistant yang berkontribusi pada proyek.

Apabila terdapat konflik dengan dokumen lain, maka prioritas mengikuti urutan berikut:

1. 00_Project_Master.md
2. 00_Development_Convention.md
3. Dokumen Milestone
4. Dokumen Modul

---

# 2. Development Philosophy

Pengembangan UtiFarm menggunakan prinsip:

- Simplicity First
- Modular Architecture
- Maintainability
- Readability
- Scalability
- Reusability

Hindari over-engineering.

Implementasikan hanya fitur yang benar-benar dibutuhkan.

---

# 3. Technology Stack

Backend

- Laravel 12

Frontend

- React
- TypeScript
- Vite
- Tailwind CSS

Database

- PostgreSQL

Authentication

- Laravel Sanctum

Deployment

- Docker

---

# 4. Backend Architecture

Setiap modul memiliki struktur:

Module/

├── Controllers/

├── Models/

├── Requests/

├── Resources/

├── Services/

├── Repositories/

├── Policies/

├── Routes/

Tidak menggunakan DTO kecuali benar-benar diperlukan.

Observer hanya digunakan jika ada kebutuhan otomatisasi proses.

---

# 5. Frontend Architecture

Gunakan Component Based Architecture.

Struktur:

src/

components/

pages/

hooks/

services/

types/

utils/

layouts/

Komponen harus reusable.

---

# 6. Database Convention

Gunakan PostgreSQL.

Semua tabel menggunakan:

- UUID
- created_at
- updated_at
- deleted_at
- created_by
- updated_by
- deleted_by

Gunakan Soft Delete untuk seluruh Master Data.

---

# 7. API Convention

Semua endpoint menggunakan REST API.

Versi endpoint:

/api/v1

Format response:

```json
{
  "success": true,
  "message": "",
  "data": {}
}
```

---

# 8. Repository Pattern

Seluruh akses database dilakukan melalui Repository.

Controller tidak boleh mengakses Model secara langsung.

Alur:

Controller

↓

Service

↓

Repository

↓

Model

---

# 9. Service Layer

Seluruh business logic berada pada Service.

Controller hanya:

- menerima request
- memanggil service
- mengembalikan response

---

# 10. Validation

Gunakan Form Request.

Semua input harus divalidasi.

Tidak melakukan validasi manual di Controller.

---

# 11. Authentication

Gunakan Laravel Sanctum.

Semua endpoint menggunakan Bearer Token.

---

# 12. Authorization

Gunakan Policy apabila diperlukan.

Role utama:

- Super Admin
- Farm Owner
- Farm Manager
- Technician
- Warehouse Staff
- Finance Staff
- Viewer

---

# 13. Frontend Standard

Gunakan:

- React Query
- React Hook Form
- Zod
- Axios

Tidak melakukan request API langsung di Component.

---

# 14. Code Style

Backend:

- PSR-12

Frontend:

- ESLint
- Prettier

Gunakan TypeScript Strict Mode.

---

# 15. Naming Convention

Controller

CompanyController

Service

CompanyService

Repository

CompanyRepository

Model

Company

Table

companies

Column

company_name

---

# 16. Git Convention

Branch:

main

develop

feature/*

bugfix/*

hotfix/*

Commit:

feat:

fix:

docs:

refactor:

style:

test:

chore:

---

# 17. Error Handling

Semua exception dicatat pada log.

Jangan menampilkan stack trace kepada pengguna.

Gunakan response standar.

---

# 18. Performance

Gunakan:

- Pagination
- Eager Loading
- Server Side Search
- Server Side Filter

Hindari Query N+1.

---

# 19. Documentation

Setiap modul minimal memiliki:

- Database Design
- API Specification
- UI Specification
- Business Rules

---

# 20. Testing

Minimal:

- Unit Test
- Feature Test

Testing dilakukan pada fitur utama.

Coverage ditingkatkan secara bertahap sesuai perkembangan proyek.

---

# 21. Development Workflow

Urutan implementasi modul:

00_Project_Master

↓

00_Development_Convention

↓

01_Milestone_Foundation

↓

02_Master_Data

↓

03_Culture_Cycle

↓

04_Activities

↓

05_Warehouse

↓

06_Harvest

↓

07_Finance

↓

08_Dashboard

↓

09_Report_Analytics

---

# 22. AI Coding Rules

AI Coding Assistant wajib:

- Mengikuti seluruh dokumen spesifikasi.
- Tidak membuat fitur di luar ruang lingkup modul yang sedang dikerjakan.
- Menghasilkan kode yang production-ready.
- Menghindari duplikasi kode.
- Mengutamakan keterbacaan dibanding kompleksitas.
- Menggunakan pola implementasi yang konsisten antar modul.
- Tidak mengubah struktur folder atau teknologi tanpa instruksi.

---

# 23. Definition of Done

Sebuah modul dinyatakan selesai apabila:

- Fitur sesuai spesifikasi.
- Migration berhasil dijalankan.
- CRUD berjalan dengan baik (jika relevan).
- Validasi berfungsi.
- Hak akses sesuai role.
- Dokumentasi diperbarui.
- Tidak terdapat error yang diketahui.

---

# End of Document