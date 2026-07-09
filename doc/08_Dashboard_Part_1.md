# UtiFarm
# 08_Dashboard
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

---

# 1. Purpose

Dashboard merupakan Operational Intelligence Dashboard (OID) yang berfungsi sebagai pusat monitoring seluruh aktivitas budidaya.

Dashboard tidak menyimpan transaksi bisnis.

Dashboard hanya membaca data dari modul lain dan menampilkan informasi dalam bentuk KPI, widget, grafik, alert, dan insight.

---

# 2. Objective

Dashboard bertujuan untuk:

- Monitoring operasional
- Monitoring produksi
- Monitoring inventory
- Monitoring panen
- Monitoring keuangan
- Monitoring KPI
- Menampilkan alert
- Menjadi pusat pengambilan keputusan

---

# 3. Scope

Dashboard mencakup:

- Executive Dashboard
- Production Dashboard
- Inventory Dashboard
- Harvest Dashboard
- Financial Dashboard
- System Dashboard
- KPI Dashboard
- Alert Dashboard

---

# 4. Dashboard Philosophy

Dashboard menggunakan prinsip:

Single Source of Truth.

Seluruh data berasal dari modul sumber.

Dashboard tidak menghitung ulang data.

Dashboard bersifat Read Only.

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

User

---

# 6. Dashboard Workspace

Dashboard terdiri dari beberapa Workspace:

- Executive
- Production
- Inventory
- Harvest
- Finance
- Administration

Setiap Workspace memiliki Widget tersendiri.

---

# 7. Executive Dashboard

Digunakan oleh:

- Farm Owner
- Director
- Super Admin

Menampilkan:

- Revenue
- Profit
- Production
- Harvest
- Stock Alert
- KPI
- Financial Health

---

# 8. Production Dashboard

Menampilkan:

- Active Culture Cycle
- Biomass
- Feeding
- Treatment
- Water Quality
- SR
- FCR
- ADG

---

# 9. Inventory Dashboard

Menampilkan:

- Current Stock
- Low Stock
- Near Expired
- Expired Item
- Stock Movement
- Warehouse Activity

---

# 10. Harvest Dashboard

Menampilkan:

- Harvest Schedule
- Harvest Today
- Yield
- Grade Distribution
- Pending Delivery
- Harvest Trend

---

# 11. Financial Dashboard

Menampilkan:

- Revenue
- Expense
- Cost per KG
- Gross Profit
- Net Profit
- ROI
- Financial Health Score

---

# 12. System Dashboard

Menampilkan:

- Active User
- Login Activity
- Background Job
- Queue Status
- API Health
- Storage Usage

---

# 13. KPI Monitoring

Dashboard memonitor KPI utama:

- Biomass
- Survival Rate (SR)
- Feed Conversion Ratio (FCR)
- Average Daily Gain (ADG)
- Cost per KG
- Gross Profit
- Net Profit
- ROI

---

# 14. Alert Center

Dashboard menampilkan Alert:

- Low Stock
- Expired Inventory
- Water Quality Warning
- Harvest Due
- Financial Warning
- Failed Background Job

Alert hanya bersifat informatif.

---

# 15. Timeline

Dashboard menampilkan Activity Timeline.

Contoh:

08:00

↓

Feeding

↓

10:00

↓

Treatment

↓

14:00

↓

Harvest

↓

16:00

↓

Stock In

↓

18:00

↓

Revenue Posted

---

# 16. Role Based Dashboard

Dashboard mengikuti Role.

Super Admin

↓

System Dashboard

Farm Owner

↓

Executive Dashboard

Farm Manager

↓

Operational Dashboard

Warehouse Staff

↓

Inventory Dashboard

Finance Staff

↓

Financial Dashboard

Technician

↓

Production Dashboard

---

# 17. Business Rules

- Dashboard tidak membuat transaksi.
- Dashboard tidak mengubah transaksi.
- Dashboard hanya membaca data.
- Dashboard menggunakan Widget.
- Dashboard mengikuti Role.

---

# 18. Integration

Dashboard membaca data dari:

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

Notification

---

# 19. Acceptance Criteria

Dashboard dianggap memenuhi spesifikasi apabila:

✓ Executive Dashboard berjalan.

✓ Production Dashboard berjalan.

✓ Inventory Dashboard berjalan.

✓ Harvest Dashboard berjalan.

✓ Financial Dashboard berjalan.

✓ KPI ditampilkan.

✓ Alert ditampilkan.

✓ Timeline ditampilkan.

✓ Role Dashboard berjalan.

---

# 20. AI Coding Instructions

AI Coding Assistant wajib:

- Menganggap Dashboard sebagai Operational Intelligence Dashboard.
- Menggunakan Widget sebagai komponen utama.
- Menggunakan Read Only Architecture.
- Tidak melakukan Business Logic.
- Mengikuti seluruh Business Rules.
- Menghasilkan implementasi production-ready.

---

# 21. Deliverables

Dokumen berikutnya:

08_Dashboard_Part_2.md

Membahas:

- Dashboard Architecture
- Widget Engine
- Widget Registry
- Dashboard Layout
- Refresh Strategy
- Cache Strategy
- Responsive Workspace

---

# End of Document