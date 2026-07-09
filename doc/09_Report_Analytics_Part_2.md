# UtiFarm
# 09_Report_Analytics
## Part 2 - Report Architecture & Template Engine

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Business_Rules.md
- 00_Database_Convention.md
- 00_API_Convention.md
- 00_UI_Convention.md
- 00_Coding_Convention.md
- 00_Project_Structure.md
- 09_Report_Analytics_Part_1.md

---

# 1. Purpose

Dokumen ini mendefinisikan arsitektur Report Engine, Template Engine, Report Registry, Export Engine, dan Report Builder.

Report menggunakan arsitektur modular sehingga setiap laporan dapat dikembangkan tanpa mengubah Engine utama.

---

# 2. Report Architecture

Report menggunakan arsitektur:

Report Workspace

↓

Report Engine

↓

Report Registry

↓

Template Resolver

↓

Report Builder

↓

Data Collector

↓

Business Module Service

↓

Export Engine

↓

User

Report tidak mengakses database secara langsung.

---

# 3. Report Philosophy

Report menggunakan prinsip:

- Generate Never Store
- Read Only
- Service Oriented
- Template Based
- Reusable
- Modular

---

# 4. Universal Report Engine

Report Engine bertugas:

- Menerima Report Request
- Menentukan Template
- Mengumpulkan Data
- Menyusun Report
- Menghasilkan Output

Report Engine tidak memiliki Business Logic.

---

# 5. Report Registry

Seluruh laporan harus terdaftar.

Setiap Report memiliki:

- Report ID
- Report Name
- Category
- Module
- Template
- Permission
- Export Format
- Schedule Support

---

# 6. Report Categories

Kategori Report:

- Operational
- Production
- Inventory
- Harvest
- Financial
- Executive
- KPI
- Audit

---

# 7. Template Engine

Template Engine bertugas:

- Memilih Template
- Menyusun Layout
- Menentukan Header
- Menentukan Footer
- Menentukan Format

Template dipisahkan dari Business Logic.

---

# 8. Report Builder

Report Builder menyusun laporan berdasarkan Section.

Contoh Executive Report:

- Cover
- Executive Summary
- Production Summary
- Inventory Summary
- Harvest Summary
- Financial Summary
- KPI Summary
- Closing

---

# 9. Data Collector

Data Collector membaca data dari:

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

Collector hanya memanggil Service Layer.

---

# 10. Data Formatter

Formatter bertugas:

- Format Tanggal
- Format Angka
- Format Mata Uang
- Format Persentase
- Format Tabel
- Format Grafik

---

# 11. Export Engine

Export mendukung:

- PDF
- Excel
- CSV

Future Ready:

- Word
- JSON

---

# 12. Rendering Engine

Rendering menghasilkan:

- Printable Report
- Digital Report
- Export File

Rendering dipisahkan dari Template.

---

# 13. Report Layout

Layout terdiri dari:

- Cover
- Header
- Body
- Summary
- Footer

Layout mengikuti Template.

---

# 14. Report Section

Section dapat digunakan ulang.

Contoh:

Financial Summary

Production Summary

Harvest Summary

Inventory Summary

KPI Summary

Section bersifat reusable.

---

# 15. Chart Rendering

Report mendukung:

- Line Chart
- Bar Chart
- Pie Chart
- Donut Chart

Chart mengikuti Theme UtiFarm.

---

# 16. Table Rendering

Table mendukung:

- Grouping
- Sorting
- Pagination (Preview)
- Totals
- Sub Totals

---

# 17. File Naming Convention

Format:

REPORTTYPE-YYYYMMDD-HHMMSS

Contoh:

FINANCE-20260710-093000.pdf

---

# 18. Localization

Report mendukung:

- Bahasa Indonesia
- English

Format mengikuti Locale pengguna.

---

# 19. Performance Rules

Gunakan:

- Background Job
- Cache
- Streaming Export
- Lazy Data Loading

Report besar tidak diproses pada HTTP Request utama.

---

# 20. Security Rules

Report mengikuti:

- Authentication
- Authorization
- RBAC

Pengguna hanya dapat membuat Report sesuai hak akses.

---

# 21. Business Rules

- Report bersifat Read Only.
- Report tidak mengubah data.
- Report membaca Service Layer.
- Template dipisahkan dari Engine.
- Builder dipisahkan dari Template.

---

# 22. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Universal Report Engine.
- Menggunakan Report Registry.
- Menggunakan Template Engine.
- Menggunakan Report Builder.
- Menggunakan Service Layer.
- Menggunakan Background Job untuk laporan besar.
- Menghasilkan implementasi production-ready.

---

# 23. Deliverables

Implementasi harus menghasilkan:

- Universal Report Engine
- Report Registry
- Template Engine
- Report Builder
- Data Collector
- Export Engine
- Rendering Engine
- Feature Test

---

# End of Document