# UtiFarm
# 08_Dashboard
## Part 2 - Dashboard Architecture & Widget Design

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

---

# 1. Purpose

Dokumen ini mendefinisikan arsitektur Dashboard, Widget Engine, Widget Registry, Dashboard Layout, dan strategi refresh data.

Dashboard menggunakan arsitektur modular sehingga setiap Widget dapat dikembangkan secara independen.

---

# 2. Dashboard Architecture

Dashboard menggunakan arsitektur:

Dashboard

↓

Workspace

↓

Widget Container

↓

Widget

↓

Widget Service

↓

REST API

↓

Business Module

Dashboard tidak mengakses database secara langsung.

---

# 3. Dashboard Philosophy

Dashboard menggunakan prinsip:

- Read Only
- Widget Based
- Modular
- Reusable
- Role Based
- Cache Friendly

---

# 4. Dashboard Workspace

Workspace utama:

- Executive
- Production
- Inventory
- Harvest
- Finance
- Administration

Setiap Workspace memiliki kumpulan Widget tersendiri.

---

# 5. Widget Engine

Widget Engine bertugas:

- Memuat Widget
- Menyusun Layout
- Mengatur Refresh
- Mengelola Error Widget
- Mengelola Loading Widget

Widget Engine tidak memiliki Business Logic.

---

# 6. Widget Registry

Seluruh Widget harus didaftarkan.

Contoh:

Executive KPI

Production KPI

Inventory KPI

Harvest KPI

Financial KPI

Alert Center

Timeline

Chart

Weather (Future)

AI Recommendation (Future)

---

# 7. Widget Categories

Kategori Widget:

- KPI Widget
- Summary Widget
- Chart Widget
- Table Widget
- Timeline Widget
- Alert Widget
- Analytics Widget

---

# 8. Widget Lifecycle

Widget dibuat melalui proses:

Register

↓

Initialize

↓

Load Data

↓

Render

↓

Refresh

↓

Destroy

---

# 9. Widget Layout

Layout menggunakan Grid.

Widget dapat memiliki ukuran:

- Small
- Medium
- Large
- Full Width

Ukuran ditentukan oleh Widget Registry.

---

# 10. KPI Widget

Menampilkan:

- Value
- Trend
- Percentage
- Status

Contoh:

Revenue

Profit

SR

FCR

Stock

Harvest

---

# 11. Chart Widget

Jenis Chart:

- Line
- Bar
- Area
- Pie
- Donut

Chart harus bersifat interaktif.

---

# 12. Table Widget

Digunakan untuk:

- Low Stock
- Harvest Schedule
- Recent Activity
- Financial Ledger
- Notification

Support:

- Pagination
- Sorting
- Search

---

# 13. Alert Widget

Menampilkan:

- Low Stock
- Expired Batch
- Water Quality Warning
- Harvest Reminder
- Financial Alert
- System Alert

Alert bersifat Read Only.

---

# 14. Timeline Widget

Menampilkan aktivitas terbaru.

Contoh:

Feeding

Treatment

Harvest

Packing

Delivery

Revenue Posted

---

# 15. Refresh Strategy

Widget mendukung:

- Manual Refresh
- Auto Refresh
- Background Refresh

Refresh hanya dilakukan pada Widget terkait.

Dashboard tidak melakukan Full Reload.

---

# 16. Cache Strategy

Widget menggunakan Cache.

Prioritas:

- KPI
- Chart
- Analytics

Data operasional penting dapat menggunakan cache dengan masa berlaku yang singkat.

---

# 17. Error Handling

Apabila Widget gagal dimuat:

- Tampilkan Error Card.
- Sediakan tombol Retry.
- Widget lain tetap berjalan.

---

# 18. Responsive Layout

Desktop

Multi Column Grid

Tablet

Two Column Grid

Mobile

Single Column

Card View

---

# 19. Personalization Ready

Arsitektur harus mendukung pengembangan:

- Menyembunyikan Widget
- Mengubah urutan Widget
- Dashboard favorit pengguna

Fitur ini bersifat Future Ready.

---

# 20. Performance Rules

Gunakan:

- Lazy Loading
- Code Splitting
- React Query Cache
- Memoization
- Virtualization (untuk data besar)

---

# 21. Security Rules

Widget mengikuti Role Based Access Control.

Widget hanya dapat membaca data yang menjadi hak akses pengguna.

---

# 22. Business Rules

- Widget tidak mengubah data.
- Widget hanya membaca API.
- Widget tidak menghitung Business Logic.
- Widget menggunakan Service Layer.
- Dashboard tetap dapat digunakan meskipun salah satu Widget gagal dimuat.

---

# 23. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Widget Engine.
- Menggunakan Widget Registry.
- Menggunakan Reusable Component.
- Menggunakan React Query.
- Menggunakan Lazy Loading.
- Menggunakan Tailwind CSS.
- Menggunakan Responsive Grid Layout.
- Mengikuti UI Convention.
- Menghasilkan implementasi production-ready.

---

# 24. Deliverables

Implementasi harus menghasilkan:

- Dashboard Engine
- Widget Engine
- Widget Registry
- KPI Widget
- Summary Widget
- Chart Widget
- Table Widget
- Timeline Widget
- Alert Widget
- Responsive Dashboard Layout

---

# End of Document