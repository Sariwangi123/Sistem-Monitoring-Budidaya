# UtiFarm
# 09_Report_Analytics
## Part 1 - Overview & Business Process

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
- 02_Master_Data
- 03_Culture_Cycle
- 04_Activities
- 05_Warehouse
- 06_Harvest
- 07_Finance
- 08_Dashboard

---

# 1. Purpose

Report & Analytics merupakan modul Business Intelligence (BI) yang menghasilkan laporan operasional, analisis historis, serta ringkasan eksekutif berdasarkan data dari seluruh modul UtiFarm.

Modul ini tidak membuat ataupun mengubah transaksi.

Seluruh laporan bersifat Read Only.

---

# 2. Objective

Modul Report & Analytics bertujuan untuk:

- Menghasilkan laporan operasional.
- Menghasilkan laporan produksi.
- Menghasilkan laporan inventori.
- Menghasilkan laporan panen.
- Menghasilkan laporan keuangan.
- Menyediakan analisis historis.
- Menjadi sumber laporan manajemen.
- Mendukung audit operasional.

---

# 3. Scope

Modul mencakup:

- Operational Report
- Production Report
- Inventory Report
- Harvest Report
- Financial Report
- Executive Report
- KPI Report
- Audit Report
- Comparative Report
- Historical Report

---

# 4. Report Philosophy

Report menggunakan prinsip:

Generate, Never Store.

Report selalu dibuat berdasarkan data terbaru dari Business Module.

Report tidak menyimpan salinan transaksi.

---

# 5. Data Flow

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

Report Engine

↓

User

---

# 6. Report Workspace

Workspace terdiri dari:

- Executive Report
- Production Report
- Inventory Report
- Harvest Report
- Financial Report
- Audit Report

Setiap Workspace memiliki kategori laporan masing-masing.

---

# 7. Operational Report

Laporan operasional meliputi:

- Daily Activities
- Feeding Report
- Treatment Report
- Sampling Report
- Maintenance Report

---

# 8. Production Report

Laporan produksi meliputi:

- Active Culture Cycle
- Biomass Report
- Growth Report
- Survival Rate (SR)
- Feed Conversion Ratio (FCR)
- Average Daily Gain (ADG)

---

# 9. Inventory Report

Laporan inventori meliputi:

- Current Stock
- Stock Movement
- Stock Adjustment
- Low Stock
- Near Expired
- Inventory Valuation

---

# 10. Harvest Report

Laporan panen meliputi:

- Harvest Planning
- Harvest Summary
- Harvest Yield
- Grade Distribution
- Packing Report
- Delivery Report

---

# 11. Financial Report

Laporan keuangan meliputi:

- Expense Report
- Revenue Report
- Profit & Loss
- Cost of Production
- Cost per Kilogram
- ROI Report

---

# 12. Executive Report

Executive Report menampilkan:

- Executive Summary
- KPI Summary
- Financial Performance
- Production Performance
- Harvest Performance
- Operational Performance

---

# 13. KPI Report

Laporan KPI mencakup:

- Biomass
- SR
- FCR
- ADG
- Cost per KG
- Gross Profit
- Net Profit
- ROI

---

# 14. Audit Report

Audit Report menampilkan:

- User Activity
- Login History
- Transaction History
- Approval History
- System Activity
- Audit Trail

---

# 15. Historical Report

Historical Report mendukung:

- Daily
- Weekly
- Monthly
- Quarterly
- Yearly

Perbandingan dapat dilakukan antar periode.

---

# 16. Comparative Report

Perbandingan berdasarkan:

- Company
- Farm
- Pond
- Culture Cycle
- Financial Period
- Customer

---

# 17. Report Categories

Kategori laporan:

- Operational
- Production
- Inventory
- Harvest
- Financial
- Executive
- KPI
- Audit

---

# 18. Business Rules

- Report bersifat Read Only.
- Report tidak membuat transaksi.
- Report tidak mengubah transaksi.
- Report membaca data dari Business Module.
- Report selalu menggunakan data terbaru.

---

# 19. Integration

Report membaca data dari:

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

Notification

---

# 20. Acceptance Criteria

Modul dianggap memenuhi spesifikasi apabila:

✓ Operational Report tersedia.

✓ Production Report tersedia.

✓ Inventory Report tersedia.

✓ Harvest Report tersedia.

✓ Financial Report tersedia.

✓ Executive Report tersedia.

✓ KPI Report tersedia.

✓ Audit Report tersedia.

✓ Historical Report tersedia.

---

# 21. AI Coding Instructions

AI Coding Assistant wajib:

- Menganggap Report sebagai Business Intelligence Module.
- Menggunakan Read Only Architecture.
- Menggunakan Report Engine.
- Menggunakan Template Engine.
- Menggunakan Service Layer.
- Tidak melakukan Business Logic.
- Menghasilkan implementasi production-ready.

---

# 22. Deliverables

Dokumen berikutnya:

09_Report_Analytics_Part_2.md

Membahas:

- Report Engine
- Template Engine
- Export Engine
- Report Registry
- Report Builder
- Report Layout
- Report Rendering

---

# End of Document