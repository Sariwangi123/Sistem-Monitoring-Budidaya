# UtiFarm
# 08_Dashboard
## Part 4 - Frontend & UI Workspace

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 08_Dashboard_Part_1.md
- 08_Dashboard_Part_2.md
- 08_Dashboard_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan User Interface (UI) dan User Experience (UX) untuk Operational Intelligence Dashboard (OID).

Dashboard menjadi pusat monitoring seluruh modul UtiFarm.

Dashboard menggunakan konsep Command Center Workspace.

---

# 2. Dashboard Philosophy

Dashboard harus:

- Cepat
- Bersih
- Informatif
- Responsif
- Read Only
- Berbasis Widget

Dashboard bukan halaman CRUD.

---

# 3. Workspace

Dashboard memiliki Workspace:

- Executive
- Production
- Inventory
- Harvest
- Finance
- Administration

Workspace ditampilkan sesuai Role.

---

# 4. Layout

Desktop

KPI Bar

↓

Workspace Grid

↓

Timeline

↓

Alert Center

↓

Footer Status

Tablet

↓

Responsive Grid

Mobile

↓

Vertical Card

---

# 5. KPI Bar

Bagian paling atas.

Menampilkan:

- Revenue
- Profit
- Biomass
- Stock
- Harvest
- SR
- FCR
- ROI

Seluruh KPI menggunakan Summary Card.

---

# 6. Workspace Grid

Grid menggunakan:

12 Column Layout

Widget dapat memiliki ukuran:

- XS
- Small
- Medium
- Large
- Full Width

---

# 7. Executive Workspace

Widget:

- Financial Summary
- Revenue Trend
- Profit Trend
- Production Summary
- Harvest Summary
- Financial Health Score
- Alert Center

---

# 8. Production Workspace

Widget:

- Active Culture Cycle
- Feeding Today
- Water Quality
- Biomass
- SR
- FCR
- ADG
- Daily Activities

---

# 9. Inventory Workspace

Widget:

- Current Stock
- Low Stock
- Expired Inventory
- Inventory Movement
- Warehouse Utilization
- Stock Trend

---

# 10. Harvest Workspace

Widget:

- Harvest Schedule
- Harvest Progress
- Grade Distribution
- Yield Analysis
- Pending Delivery
- Harvest Trend

---

# 11. Finance Workspace

Widget:

- Revenue
- Expense
- Financial Ledger
- Profit Summary
- Cost per KG
- ROI
- Financial Trend

---

# 12. Administration Workspace

Widget:

- Active User
- Queue Status
- API Status
- Storage
- Job Monitor
- Audit Activity

---

# 13. Timeline

Timeline menampilkan:

- Feeding
- Treatment
- Sampling
- Harvest
- Delivery
- Stock In
- Stock Out
- Revenue Posted

Urutan:

Terbaru di atas.

---

# 14. Alert Center

Alert dibagi menjadi:

Critical

Warning

Information

Alert menggunakan warna sesuai tingkat prioritas.

---

# 15. Widget Interaction

Widget dapat:

- Refresh
- Expand
- Collapse
- Export
- Drill Down

Widget tidak boleh mengubah data.

---

# 16. Dashboard Theme

Support:

- Light Mode
- Dark Mode

Mengikuti Theme Global.

---

# 17. Search

Global Search.

Mendukung pencarian:

- Farm
- Pond
- Culture Cycle
- Harvest Batch
- Customer
- Cost Center

---

# 18. Filter

Dashboard mendukung:

- Farm
- Pond
- Culture Cycle
- Financial Period
- Date Range

Filter diterapkan ke seluruh Widget yang relevan.

---

# 19. Notification Panel

Panel kanan menampilkan:

- Notification
- Alert
- Reminder
- System Message

---

# 20. Loading State

Gunakan:

- Skeleton
- Spinner
- Progressive Loading

Dashboard tetap dapat digunakan walaupun sebagian Widget masih dimuat.

---

# 21. Empty State

Apabila Widget belum memiliki data.

Tampilkan:

Icon

↓

"No Data Available"

↓

Button

Refresh

---

# 22. Responsive Design

Desktop

12 Column Grid

Tablet

6 Column Grid

Mobile

1 Column Grid

---

# 23. Accessibility

Gunakan:

- Keyboard Navigation
- Screen Reader Support
- ARIA Label
- Focus Indicator
- High Contrast

---

# 24. State Management

Gunakan:

React Query

Untuk:

- Dashboard
- Widget
- KPI
- Timeline
- Alert

Gunakan Context API atau Zustand untuk state lokal.

---

# 25. API Integration

Flow:

Workspace

↓

Widget

↓

Hook

↓

Dashboard Service

↓

REST API

Component tidak boleh memanggil API secara langsung.

---

# 26. User Experience Rules

- Dashboard menjadi halaman pertama setelah login.
- Maksimal tiga detik untuk menampilkan KPI utama.
- Widget dapat diperbarui secara independen.
- Toast Notification digunakan untuk aksi Refresh dan Export.
- Dashboard tidak melakukan Full Reload.

---

# 27. Widget Refresh Indicator

Widget yang sedang diperbarui menampilkan:

- Spinner kecil
- Timestamp Last Updated
- Refresh Status

---

# 28. Dashboard Personalization

Future Ready:

- Menyusun ulang Widget
- Menyembunyikan Widget
- Dashboard favorit
- Widget pinning

---

# 29. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Command Center Layout.
- Menggunakan Widget Engine.
- Menggunakan Responsive Grid.
- Menggunakan React Query.
- Menggunakan Lazy Loading.
- Menggunakan Tailwind CSS.
- Menggunakan Reusable Component.
- Tidak menggunakan inline style.
- Mengikuti UI Convention.
- Menghasilkan UI production-ready.

---

# 30. Deliverables

Frontend harus menghasilkan:

- Dashboard Workspace
- KPI Bar
- Widget Grid
- Timeline
- Alert Center
- Notification Panel
- Responsive Layout
- Theme Support
- Dashboard Personalization Ready

---

# End of Document