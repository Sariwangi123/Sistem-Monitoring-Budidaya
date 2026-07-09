# UtiFarm

# 01_Milestone_Foundation

Version : 1.0\
Status : Draft\
Depends : 00_Project_Master.md

------------------------------------------------------------------------

# 1. Overview

Dokumen ini mendefinisikan seluruh fondasi teknis aplikasi UtiFarm.

Seluruh implementasi pada milestone berikutnya wajib mengikuti aturan
yang ditetapkan dalam dokumen ini.

Tujuan utama milestone ini adalah membangun pondasi aplikasi sehingga
seluruh modul dapat dikembangkan secara konsisten.

------------------------------------------------------------------------

# 2. Objective

Output yang harus dihasilkan:

-   Laravel Project
-   React Project
-   Authentication
-   Authorization
-   User Management
-   Global Configuration
-   API Standard
-   Logging
-   Notification
-   Testing Framework
-   CI/CD Ready

------------------------------------------------------------------------

# 3. Architecture

Project menggunakan Clean Architecture.

Presentation Layer

↓

Application Layer

↓

Domain Layer

↓

Infrastructure Layer

Setiap module wajib berdiri sendiri (Modular Architecture).

------------------------------------------------------------------------

# 4. Technology Stack

## Backend

-   Laravel 12
-   PHP 8.4

## Frontend

-   React
-   TypeScript
-   Vite
-   TailwindCSS

## Database

-   PostgreSQL

## Cache

-   Redis

## Authentication

-   Laravel Sanctum

## Storage

-   Local
-   S3 Compatible

## Deployment

-   Docker
-   Nginx
-   Linux

------------------------------------------------------------------------

# 5. Folder Structure

## Backend

    app/
    Modules/
    Shared/
    Core/
    Infrastructure/

## Frontend

    src/
    components/
    pages/
    layouts/
    hooks/
    services/
    stores/
    types/
    utils/

------------------------------------------------------------------------

# 6. Module Structure

Setiap module wajib memiliki:

-   Controller
-   Request
-   Service
-   Repository
-   DTO
-   Model
-   Policy
-   Observer
-   Routes
-   Migration
-   Seeder
-   Factory

------------------------------------------------------------------------

# 7. Database Standard

Seluruh tabel wajib memiliki:

-   id
-   uuid
-   created_at
-   updated_at
-   deleted_at
-   created_by
-   updated_by
-   deleted_by

Standar tambahan:

-   UUID
-   Soft Delete
-   Foreign Key
-   Index

------------------------------------------------------------------------

# 8. Authentication

Menggunakan Laravel Sanctum.

Fitur:

-   Login
-   Logout
-   Forgot Password
-   Reset Password
-   Change Password
-   Refresh Token

------------------------------------------------------------------------

# 9. Authorization

Role Based Access Control (RBAC).

Role:

-   Super Admin
-   Farm Owner
-   Farm Manager
-   Technician
-   Warehouse Staff
-   Finance Staff
-   Viewer

Menggunakan:

-   Policy
-   Gate
-   Middleware

------------------------------------------------------------------------

# 10. User Management

-   CRUD User
-   CRUD Role
-   CRUD Permission
-   Assign Role
-   Assign Permission
-   Farm Access

------------------------------------------------------------------------

# 11. Global Configuration

-   Timezone
-   Currency
-   Weight Unit
-   Length Unit
-   Language
-   Company Profile

------------------------------------------------------------------------

# 12. Logging

Seluruh aktivitas wajib dicatat:

-   Login
-   Logout
-   CRUD
-   Warehouse
-   Harvest
-   Finance
-   API
-   Error

------------------------------------------------------------------------

# 13. Notification

Support:

-   Email
-   Push Notification

Future:

-   WhatsApp
-   Telegram

------------------------------------------------------------------------

# 14. API Standard

Semua endpoint wajib menggunakan REST API.

## Success

``` json
{
  "success": true,
  "message": "...",
  "data": {}
}
```

## Error

``` json
{
  "success": false,
  "message": "...",
  "errors": {}
}
```

Mendukung:

-   Pagination
-   Filter
-   Sorting
-   Search

------------------------------------------------------------------------

# 15. Exception Handling

-   Validation Error
-   Authentication Error
-   Authorization Error
-   Not Found
-   Internal Server Error

------------------------------------------------------------------------

# 16. Frontend Standard

-   React
-   TypeScript
-   TailwindCSS

Komponen standar:

-   Layout
-   Sidebar
-   Navbar
-   Breadcrumb
-   Table
-   Form
-   Modal
-   Card
-   Chart

------------------------------------------------------------------------

# 17. Coding Standard

## Backend

-   PSR-12
-   SOLID
-   Repository Pattern
-   Service Layer

## Frontend

-   Functional Component
-   Hooks
-   TypeScript Strict Mode

------------------------------------------------------------------------

# 18. Git Strategy

Branch:

-   main
-   develop
-   feature/\*
-   release/\*
-   hotfix/\*

Conventional Commits:

-   feat:
-   fix:
-   refactor:
-   docs:
-   test:
-   style:

------------------------------------------------------------------------

# 19. Testing

Minimal:

-   Unit Test
-   Feature Test
-   API Test

Coverage minimum: **80%**

------------------------------------------------------------------------

# 20. Definition of Done

-   Seluruh fitur selesai.
-   Tidak terdapat error.
-   Testing berhasil.
-   Coding Standard terpenuhi.
-   Dokumentasi diperbarui.
-   API terdokumentasi.

------------------------------------------------------------------------

# 21. Deliverables

-   Laravel Foundation
-   React Foundation
-   Authentication
-   Authorization
-   User Management
-   Global Configuration
-   API Standard
-   Logging
-   Notification
-   Testing Framework
-   Docker Ready
-   CI/CD Ready

------------------------------------------------------------------------

# 22. AI Coding Instructions (Mandatory)

1.  Gunakan aturan pada `00_Project_Master.md`.
2.  Gunakan Clean Architecture.
3.  Gunakan Repository Pattern.
4.  Gunakan Service Layer.
5.  Terapkan prinsip DRY dan SOLID.
6.  Gunakan TypeScript Strict Mode.
7.  Seluruh endpoint menggunakan REST API.
8.  Seluruh migration menggunakan UUID.
9.  Semua model menggunakan Soft Delete.
10. Jangan mengimplementasikan fitur di luar ruang lingkup milestone
    ini.

------------------------------------------------------------------------

# End of Document
