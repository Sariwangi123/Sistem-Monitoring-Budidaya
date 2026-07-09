# UtiFarm
# 09_Report_Analytics
## Part 5 - Report Engine & Business Rules

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
- 09_Report_Analytics_Part_2.md
- 09_Report_Analytics_Part_3.md
- 09_Report_Analytics_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan aturan implementasi Report Engine dan Business Rules untuk modul Report & Analytics.

Report Engine bertanggung jawab menghasilkan laporan secara konsisten, aman, dan efisien menggunakan Universal Report Engine (URE).

Report tidak memiliki Business Logic operasional.

---

# 2. Report Engine

Flow implementasi:

REST API

↓

Report Controller

↓

Report Service

↓

Universal Report Engine

↓

Template Resolver

↓

Data Collector

↓

Data Aggregator

↓

Report Builder

↓

Rendering Engine

↓

Export Engine

↓

Response

Controller tidak boleh memiliki Business Logic.

---

# 3. Report Principles

Report menggunakan prinsip:

- Read Only
- Generate Never Store
- Template Based
- Service Oriented
- Modular
- Reusable
- Scalable

---

# 4. Report Workflow

Report Request

↓

Permission Validation

↓

Parameter Validation

↓

Template Selection

↓

Data Collection

↓

Data Aggregation

↓

Report Composition

↓

Rendering

↓

Export

↓

Response

---

# 5. Universal Report Engine

Universal Report Engine bertugas:

- Validasi Request
- Memilih Template
- Mengumpulkan Data
- Menyusun Report
- Merender Output
- Mengirim hasil Export

Engine tidak menghitung Business KPI.

---

# 6. Report Registry

Setiap Report harus memiliki metadata:

- Report ID
- Report Name
- Category
- Template
- Export Format
- Required Permission
- Schedule Support
- Version

Report wajib terdaftar sebelum dapat digunakan.

---

# 7. Template Resolver

Template Resolver bertugas:

- Menentukan Template
- Menentukan Layout
- Menentukan Bahasa
- Menentukan Format Output

Template dipisahkan dari Engine.

---

# 8. Data Collector

Collector membaca data dari:

- Master Data
- Culture Cycle
- Activities
- Warehouse
- Harvest
- Finance
- Dashboard

Collector hanya menggunakan Service Layer.

---

# 9. Data Aggregator

Aggregator bertugas:

- Menggabungkan Data
- Menghitung Ringkasan
- Mengelompokkan Data
- Menyusun Struktur Report

Aggregator tidak mengubah data sumber.

---

# 10. Report Builder

Builder menyusun laporan berdasarkan Section.

Contoh Executive Report:

- Cover
- Executive Summary
- KPI Summary
- Production Summary
- Inventory Summary
- Harvest Summary
- Financial Summary
- Closing

---

# 11. Rendering Engine

Rendering menghasilkan:

- Preview
- Printable Report
- Export File

Rendering dipisahkan dari Builder.

---

# 12. Export Engine

Format yang didukung:

- PDF
- Excel
- CSV

Future Ready:

- Word
- JSON

---

# 13. Background Processing

Report besar diproses menggunakan:

- Queue
- Background Job
- Worker

Pengguna menerima notifikasi ketika laporan selesai dibuat.

---

# 14. Schedule Engine

Schedule mendukung:

- Daily
- Weekly
- Monthly
- Quarterly
- Yearly

Future Ready untuk otomatisasi distribusi laporan.

---

# 15. Cache Engine

Gunakan Cache untuk:

- Metadata Report
- Report Registry
- Template
- Ringkasan Data

Cache tidak digunakan untuk file hasil Export.

---

# 16. Exception Handling

Gunakan Custom Exception.

Contoh:

- ReportNotFoundException
- InvalidReportTemplateException
- ExportFailedException
- ReportPermissionException
- ReportGenerationException

---

# 17. Logging

Catat:

- User
- Report Type
- Export Format
- Execution Time
- File Size
- Queue ID
- Generated At

---

# 18. Performance Rules

Gunakan:

- Queue
- Cache
- Streaming Export
- Chunk Processing
- Lazy Data Loading

Report besar tidak boleh memblokir request utama.

---

# 19. Security Rules

Report menerapkan:

- Authentication
- Authorization
- RBAC
- Audit Trail

Seluruh proses Generate Report dicatat.

---

# 20. Business Rules

- Report bersifat Read Only.
- Report tidak membuat transaksi.
- Report tidak mengubah transaksi.
- Report hanya membaca melalui Service Layer.
- Report mengikuti hak akses pengguna.
- Template dipisahkan dari Business Logic.
- Report menggunakan Universal Report Engine.

---

# 21. Quality Assurance

Setiap Report wajib memiliki:

- Unit Test
- Feature Test
- Export Validation
- Permission Validation
- Performance Test

---

# 22. Acceptance Criteria

Report Engine dianggap selesai apabila:

✓ Universal Report Engine berjalan.

✓ Report Registry berjalan.

✓ Template Resolver berjalan.

✓ Report Builder berjalan.

✓ Rendering Engine berjalan.

✓ Export Engine berjalan.

✓ Queue Processing berjalan.

✓ Scheduled Report berjalan.

✓ Seluruh Feature Test lulus.

---

# 23. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Universal Report Engine.
- Menggunakan Report Registry.
- Menggunakan Report Builder.
- Menggunakan Template Resolver.
- Menggunakan Queue.
- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan Background Job.
- Menghasilkan implementasi production-ready.

---

# 24. Deliverables

Backend

- Report Controller
- Report Service
- Universal Report Engine
- Report Registry
- Template Resolver
- Data Collector
- Data Aggregator
- Report Builder
- Rendering Engine
- Export Engine
- Queue Job
- Feature Test

Frontend

- Report Preview
- Export Progress
- Report History
- Scheduled Report

---

# 25. Definition of Done

Report Engine dinyatakan selesai apabila:

- Seluruh Report dapat dihasilkan melalui Universal Report Engine.
- Preview berjalan.
- Export PDF, Excel, dan CSV berjalan.
- Queue Processing berjalan.
- Scheduled Report berjalan.
- Permission Validation berjalan.
- Logging lengkap.
- Dokumentasi diperbarui.

---

# End of Document