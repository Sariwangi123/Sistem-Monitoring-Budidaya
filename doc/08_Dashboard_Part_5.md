# UtiFarm
# 08_Dashboard
## Part 5 - Dashboard Engine & Business Rules

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
- 08_Dashboard_Part_1.md
- 08_Dashboard_Part_2.md
- 08_Dashboard_Part_3.md
- 08_Dashboard_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan aturan implementasi Dashboard Engine dan Business Rules untuk Operational Intelligence Dashboard (OID).

Dashboard menggunakan Dashboard Engine sebagai orkestrator seluruh Widget.

Dashboard tidak memiliki Business Logic maupun transaksi operasional.

---

# 2. Dashboard Engine

Flow implementasi:

REST API

↓

Dashboard Controller

↓

Dashboard Service

↓

Widget Engine

↓

Widget Service

↓

Business Module Service

↓

Response Builder

↓

Frontend

Dashboard tidak mengakses Repository maupun Database secara langsung.

---

# 3. Dashboard Principles

Dashboard menggunakan prinsip:

- Read Only
- Widget Based
- Role Based
- Service Oriented
- Cache First
- Single Source of Truth

---

# 4. Dashboard Workflow

User Login

↓

Role Detection

↓

Workspace Selection

↓

Widget Loading

↓

Data Aggregation

↓

Widget Rendering

↓

Auto Refresh

↓

User Interaction

---

# 5. Widget Engine

Widget Engine bertugas:

- Register Widget
- Load Widget
- Refresh Widget
- Destroy Widget
- Handle Error Widget
- Handle Loading Widget

Widget Engine tidak memiliki Business Logic.

---

# 6. Widget Registry

Seluruh Widget harus memiliki:

- Widget ID
- Widget Name
- Workspace
- Component
- Refresh Interval
- Required Permission
- Data Source

Widget wajib didaftarkan sebelum dapat digunakan.

---

# 7. Dashboard Service

Dashboard Service bertugas:

- Mengambil data dari Business Module.
- Menggabungkan data.
- Menyusun Response.
- Mengelola Cache.
- Mengelola Refresh.

Dashboard Service tidak menghitung KPI bisnis.

---

# 8. KPI Engine

Dashboard hanya membaca KPI dari modul terkait.

Contoh:

Production KPI

↓

Culture Cycle

Inventory KPI

↓

Warehouse

Harvest KPI

↓

Harvest

Financial KPI

↓

Finance

---

# 9. Widget Refresh Engine

Widget mendukung:

- Manual Refresh
- Auto Refresh
- Scheduled Refresh

Refresh hanya dilakukan pada Widget yang diminta.

---

# 10. Cache Engine

Gunakan Cache untuk:

- KPI
- Chart
- Analytics
- Summary

Cache memiliki TTL sesuai jenis data.

Data operasional kritis menggunakan TTL lebih singkat.

---

# 11. Aggregation Engine

Dashboard menggabungkan data dari:

- Master Data
- Culture Cycle
- Activities
- Warehouse
- Harvest
- Finance

Aggregation dilakukan pada Service Layer.

---

# 12. Alert Engine

Alert berasal dari modul lain.

Dashboard hanya membaca Alert.

Kategori:

- Critical
- Warning
- Information

---

# 13. Timeline Engine

Timeline membaca Activity Module.

Menampilkan:

- Feeding
- Treatment
- Sampling
- Harvest
- Delivery
- Revenue Posting

Urutan berdasarkan waktu terbaru.

---

# 14. Role Engine

Dashboard menentukan Workspace berdasarkan Role.

Role:

- Super Admin
- Farm Owner
- Farm Manager
- Warehouse Staff
- Finance Staff
- Technician
- Viewer

Role menentukan Widget yang ditampilkan.

---

# 15. Permission Engine

Widget hanya ditampilkan apabila:

- Role memiliki akses.
- Permission sesuai.
- Modul aktif.

Widget tanpa izin tidak dirender.

---

# 16. Personalization Engine

Future Ready.

Mendukung:

- Widget Favorite
- Widget Order
- Hidden Widget
- Custom Workspace

Tidak mengubah Widget bawaan sistem.

---

# 17. Exception Handling

Gunakan Custom Exception.

Contoh:

- WidgetNotFoundException
- WidgetPermissionException
- DashboardCacheException
- DashboardServiceException
- WorkspaceNotFoundException

---

# 18. Performance Rules

Gunakan:

- Lazy Loading
- React Query Cache
- Composite API
- Background Refresh
- Memoization

Hindari Full Dashboard Reload.

---

# 19. Security Rules

Dashboard menerapkan:

- Authentication
- Authorization
- RBAC
- Audit Trail

Dashboard tidak boleh menampilkan data di luar hak akses pengguna.

---

# 20. Business Rules

- Dashboard bersifat Read Only.
- Dashboard tidak membuat transaksi.
- Dashboard tidak mengubah transaksi.
- Dashboard tidak menghapus transaksi.
- Dashboard membaca data melalui Service Layer.
- Dashboard tidak mengakses database secara langsung.

---

# 21. Dashboard Lifecycle

Dashboard mengikuti siklus:

Initialize

↓

Load Workspace

↓

Load Widget

↓

Fetch Data

↓

Render

↓

Refresh

↓

Destroy

---

# 22. Logging

Dashboard mencatat:

- User
- Workspace
- Widget Loaded
- Refresh Time
- Cache Hit / Miss
- Error Widget

---

# 23. Acceptance Criteria

Dashboard Engine dianggap selesai apabila:

✓ Widget Engine berjalan.

✓ Widget Registry berjalan.

✓ Dashboard Service berjalan.

✓ KPI ditampilkan.

✓ Timeline berjalan.

✓ Alert berjalan.

✓ Cache berjalan.

✓ Composite API berjalan.

✓ Role Dashboard berjalan.

---

# 24. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Dashboard Engine.
- Menggunakan Widget Engine.
- Menggunakan Widget Registry.
- Menggunakan Composite API.
- Menggunakan Service Layer.
- Menggunakan React Query.
- Menggunakan Cache.
- Menggunakan Lazy Loading.
- Menghasilkan implementasi production-ready.

---

# 25. Deliverables

Backend

- Dashboard Service
- Widget Engine
- Widget Registry
- Cache Service
- Composite API
- Dashboard Controller
- Feature Test

Frontend

- Dashboard Workspace
- Widget Renderer
- Widget Loader
- Timeline Component
- Alert Component
- KPI Component

---

# 26. Definition of Done

Dashboard Engine dianggap selesai apabila:

- Dashboard hanya membaca data.
- Widget berjalan independen.
- Composite API berjalan.
- Cache berjalan.
- Refresh berjalan tanpa Full Reload.
- Dashboard mengikuti Role.
- Dashboard responsif.
- Seluruh Feature Test lulus.
- Dokumentasi diperbarui.

---

# End of Document