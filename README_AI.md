# UtiFarm
# README_AI

Version : 1.0

Status : Active

---

# AI Project Context

Dokumen ini merupakan titik awal (Entry Point) bagi AI Coding Assistant.

Sebelum melakukan analisis, pembuatan, atau perubahan source code, AI wajib membaca dokumen ini dan seluruh dokumentasi yang direferensikan.

Dokumen ini berlaku untuk:

- OpenAI Codex
- ChatGPT
- GitHub Copilot
- AI Coding Assistant lainnya

---

# Project Overview

Nama Project

UtiFarm

Deskripsi

UtiFarm adalah aplikasi manajemen budidaya perikanan berbasis web yang dibangun menggunakan arsitektur Modern Modular.

Target aplikasi:

- Mudah digunakan
- Mudah dipelihara
- Mudah dikembangkan
- Production Ready

---

# Technology Stack

Backend

- Laravel 12
- PHP 8.4

Frontend

- React
- TypeScript
- Vite
- Tailwind CSS

Database

- PostgreSQL

Authentication

- Laravel Sanctum

Cache

- Redis

Deployment

- Docker
- Nginx
- Linux

---

# Architecture

Project menggunakan:

- Modular Architecture
- Service Layer
- Repository Pattern
- REST API
- Component Based Frontend

Project bukan Microservice.

Project bukan Domain Driven Design penuh.

---

# Documentation Priority

Apabila terdapat konflik dokumentasi, gunakan urutan berikut.

1. 00_Project_Master.md
2. 00_Development_Convention.md
3. 00_Business_Rules.md
4. 00_Database_Convention.md
5. 00_API_Convention.md
6. 00_UI_Convention.md
7. 00_Coding_Convention.md
8. 00_Project_Structure.md
9. 01_Milestone_Foundation.md
10. Dokumen Modul

---

# Documentation Structure

Seluruh dokumentasi berada pada folder:

docs/

Dokumen utama:

00_Project_Master.md

00_Development_Convention.md

00_Business_Rules.md

00_Database_Convention.md

00_API_Convention.md

00_UI_Convention.md

00_Coding_Convention.md

00_Project_Structure.md

01_Milestone_Foundation.md

02_Master_Data/

03_Culture_Cycle/

04_Activities/

05_Warehouse/

06_Harvest/

07_Finance/

08_Dashboard/

09_Report_Analytics/

---

# Development Workflow

Urutan implementasi modul:

Foundation

↓

Master Data

↓

Culture Cycle

↓

Activities

↓

Warehouse

↓

Harvest

↓

Finance

↓

Dashboard

↓

Report Analytics

Jangan mengimplementasikan modul berikutnya sebelum dependency selesai.

---

# Backend Rules

Gunakan:

- Controller
- Service
- Repository
- Model
- Resource
- Request

Controller tidak boleh memiliki Business Logic.

Repository hanya mengakses Database.

Business Logic berada pada Service.

---

# Frontend Rules

Gunakan:

- React Query
- React Hook Form
- Zod
- Axios

Component tidak boleh mengakses API secara langsung.

Seluruh komunikasi API dilakukan melalui Service.

---

# Database Rules

Gunakan:

- UUID
- Soft Delete
- Foreign Key
- Audit Trail

Seluruh Migration mengikuti standar pada 00_Database_Convention.md

---

# API Rules

Gunakan:

REST API

Base URL

/api/v1

Response wajib mengikuti:

00_API_Convention.md

---

# UI Rules

Seluruh halaman wajib mengikuti:

00_UI_Convention.md

Gunakan reusable component.

---

# Coding Rules

Ikuti:

00_Coding_Convention.md

Gunakan:

- PSR-12
- TypeScript Strict Mode
- SOLID
- DRY
- KISS

---

# Project Status

Sebelum melakukan implementasi, AI wajib membaca:

PROJECT_STATUS.md

Untuk mengetahui:

- Progress proyek
- Modul aktif
- Next Task
- Prioritas implementasi

---

# Changelog

Sebelum melakukan perubahan besar, AI wajib membaca:

CHANGELOG.md

Untuk memahami riwayat perubahan proyek.

---

# Implementation Rules

AI wajib:

- Membaca seluruh dokumentasi yang relevan sebelum membuat kode.
- Tidak mengubah arsitektur tanpa instruksi.
- Tidak mengubah struktur folder tanpa instruksi.
- Tidak membuat fitur di luar ruang lingkup modul.
- Menghasilkan kode production-ready.
- Menghindari duplikasi kode.
- Mengikuti Business Rules.

---

# Standard Workflow

Setiap memulai sesi baru, lakukan langkah berikut:

1. Baca README_AI.md.
2. Baca PROJECT_STATUS.md.
3. Baca CHANGELOG.md.
4. Baca dokumen pada folder docs yang relevan.
5. Analisis source code yang sudah ada.
6. Lanjutkan implementasi sesuai Next Task.
7. Jangan mengubah modul yang sudah selesai kecuali diminta.

---

# Current Repository Structure

utifarm/

├── backend/

├── frontend/

├── docs/

├── docker/

├── README.md

├── README_AI.md

├── PROJECT_STATUS.md

└── CHANGELOG.md

---

# AI Reminder

Sebelum membuat kode, selalu tanyakan pada diri sendiri:

- Apakah implementasi ini sesuai Business Rules?
- Apakah mengikuti Coding Convention?
- Apakah sesuai struktur project?
- Apakah tidak melanggar dependency modul?
- Apakah implementasi ini production-ready?

Jika jawaban salah satu pertanyaan di atas adalah "Tidak", hentikan implementasi dan lakukan penyesuaian terlebih dahulu.

---

# End of Document