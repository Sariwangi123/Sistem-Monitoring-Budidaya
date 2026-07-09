# UtiFarm
# 09_Report_Analytics
## Part 4 - Frontend & Report Workspace

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 09_Report_Analytics_Part_1.md
- 09_Report_Analytics_Part_2.md
- 09_Report_Analytics_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan User Interface (UI) dan User Experience (UX) untuk modul Report & Analytics.

Report menggunakan konsep Report Workspace yang memungkinkan pengguna mencari, memfilter, melihat pratinjau, dan mengekspor laporan secara efisien.

---

# 2. Report Philosophy

Report harus:

- Read Only
- Cepat
- Mudah dipahami
- Konsisten
- Siap dicetak
- Mendukung Preview

Report bukan halaman transaksi.

---

# 3. Workspace

Workspace terdiri dari:

- Executive Report
- Production Report
- Inventory Report
- Harvest Report
- Financial Report
- KPI Report
- Audit Report

Workspace mengikuti Role pengguna.

---

# 4. Layout

Desktop

Report Navigation

↓

Filter Panel

↓

Preview Panel

↓

Export Panel

Tablet

↓

Responsive Layout

Mobile

↓

Card View

---

# 5. Report Navigation

Panel kiri menampilkan:

- Favorite Report
- Recent Report
- Executive
- Production
- Inventory
- Harvest
- Finance
- KPI
- Audit

---

# 6. Report List

Setiap kategori menampilkan:

- Report Name
- Description
- Last Generated
- Export Format
- Favorite

Support:

- Search
- Sort
- Filter

---

# 7. Filter Panel

Filter mendukung:

- Company
- Farm
- Pond
- Culture Cycle
- Financial Period
- Customer
- Date Range

Filter diterapkan sebelum Generate Report.

---

# 8. Preview Panel

Preview menampilkan:

- Cover
- Summary
- Table
- Chart
- Footer

Preview bersifat Read Only.

---

# 9. Export Panel

Format Export:

- PDF
- Excel
- CSV

Future Ready:

- Word

---

# 10. Executive Report Workspace

Widget:

- Executive Summary
- KPI Summary
- Production Summary
- Harvest Summary
- Financial Summary

---

# 11. Production Report Workspace

Widget:

- Biomass
- SR
- FCR
- ADG
- Growth Trend
- Production Summary

---

# 12. Inventory Report Workspace

Widget:

- Current Stock
- Stock Movement
- Inventory Valuation
- Low Stock
- Near Expired

---

# 13. Harvest Report Workspace

Widget:

- Harvest Summary
- Grade Distribution
- Yield
- Packing
- Delivery

---

# 14. Financial Report Workspace

Widget:

- Revenue
- Expense
- Profit
- Cost per KG
- ROI
- Financial Health

---

# 15. KPI Report Workspace

Widget:

- KPI Summary
- KPI Trend
- KPI Comparison

---

# 16. Audit Report Workspace

Widget:

- User Activity
- Login History
- Approval History
- Audit Trail

---

# 17. Chart Component

Gunakan:

- Line Chart
- Bar Chart
- Pie Chart
- Donut Chart

Chart mengikuti Theme UtiFarm.

---

# 18. Table Component

Table mendukung:

- Sorting
- Filtering
- Sticky Header
- Total
- Sub Total

---

# 19. Search

Global Search.

Mencari:

- Report
- Farm
- Pond
- Culture Cycle
- Financial Period

---

# 20. Responsive Design

Desktop

Three Panel Layout

Tablet

Two Panel Layout

Mobile

Single Panel

---

# 21. Loading State

Gunakan:

- Skeleton
- Spinner
- Progressive Loading

Report besar menampilkan Progress Indicator.

---

# 22. Empty State

Apabila Report belum tersedia.

Tampilkan:

Icon

↓

"No Report Available"

↓

Button

Generate Report

---

# 23. Accessibility

Gunakan:

- Keyboard Navigation
- Screen Reader
- ARIA Label
- High Contrast

---

# 24. State Management

Gunakan:

React Query

Untuk:

- Report List
- Preview
- Export
- Schedule

Gunakan Context API atau Zustand untuk state lokal.

---

# 25. API Integration

Flow:

Workspace

↓

Report Hook

↓

Report Service

↓

REST API

↓

Universal Report Engine

Component tidak boleh mengakses API secara langsung.

---

# 26. User Experience Rules

- Preview sebelum Export.
- Filter disimpan selama sesi aktif.
- Export tidak melakukan reload halaman.
- Progress Generate Report ditampilkan.
- Report dapat diunduh setelah proses selesai.

---

# 27. Scheduled Report UI

Halaman Scheduled Report menampilkan:

- Report Name
- Frequency
- Next Execution
- Last Execution
- Status

Pengguna dapat:

- Membuat jadwal
- Mengubah jadwal
- Menonaktifkan jadwal

---

# 28. Personalization

Future Ready:

- Favorite Report
- Recent Report
- Report History
- Saved Filter

---

# 29. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Report Workspace.
- Menggunakan Reusable Component.
- Menggunakan React Query.
- Menggunakan Tailwind CSS.
- Menggunakan Responsive Layout.
- Menggunakan Report Preview.
- Menggunakan Progress Indicator.
- Tidak menggunakan inline style.
- Mengikuti UI Convention.
- Menghasilkan UI production-ready.

---

# 30. Deliverables

Frontend harus menghasilkan:

- Report Workspace
- Report Navigation
- Report List
- Filter Panel
- Preview Panel
- Export Panel
- Scheduled Report UI
- Responsive Layout

---

# End of Document