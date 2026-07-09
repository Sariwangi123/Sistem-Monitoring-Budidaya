# UtiFarm
# 08_Dashboard
## Part 3 - REST API Specification

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Business_Rules.md
- 00_Database_Convention.md
- 00_API_Convention.md
- 00_Coding_Convention.md
- 00_Project_Structure.md
- 08_Dashboard_Part_1.md
- 08_Dashboard_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk Operational Intelligence Dashboard (OID).

Dashboard hanya membaca data dari Business Module.

Dashboard tidak membuat maupun mengubah transaksi.

API mengikuti standar:

00_API_Convention.md

---

# 2. Base URL

/api/v1/dashboard

---

# 3. Authentication

Seluruh endpoint menggunakan:

Bearer Token

Laravel Sanctum.

---

# 4. Authorization

Dashboard mengikuti Role Based Access Control.

Role:

- Super Admin
- Farm Owner
- Farm Manager
- Warehouse Staff
- Finance Staff
- Technician
- Viewer

Setiap Role hanya dapat mengakses Dashboard sesuai hak aksesnya.

---

# 5. Dashboard Home Endpoint

GET

/

Menampilkan Dashboard sesuai Role.

Output:

- Workspace
- Widget
- KPI
- Alert

---

# 6. Executive Dashboard

GET

/executive

Output:

- Revenue
- Profit
- ROI
- Financial Health
- Production Summary

---

# 7. Production Dashboard

GET

/production

Output:

- Active Culture Cycle
- Biomass
- Feeding
- Treatment
- SR
- FCR
- ADG

---

# 8. Inventory Dashboard

GET

/inventory

Output:

- Current Stock
- Low Stock
- Expired Item
- Stock Movement
- Warehouse Activity

---

# 9. Harvest Dashboard

GET

/harvest

Output:

- Harvest Schedule
- Harvest Today
- Yield
- Grade Distribution
- Delivery Status

---

# 10. Financial Dashboard

GET

/finance

Output:

- Revenue
- Expense
- Gross Profit
- Net Profit
- Cost per KG
- ROI

---

# 11. System Dashboard

GET

/system

Output:

- Active User
- Login Activity
- Queue Status
- API Health
- Storage Usage

---

# 12. KPI Endpoint

GET

/kpi

Support Query:

workspace

period

farm

culture_cycle

Output:

- KPI List
- Trend
- Comparison

---

# 13. Widget Endpoint

GET

/widgets

Daftar Widget sesuai Workspace.

---

GET

/widgets/{widget_id}

Detail Widget.

---

POST

/widgets/{widget_id}/refresh

Refresh Widget tertentu.

Tidak melakukan Full Dashboard Refresh.

---

# 14. Alert Endpoint

GET

/alerts

Support:

- unread_only
- severity
- category

Output:

- Alert List
- Priority
- Status

---

# 15. Timeline Endpoint

GET

/timeline

Output:

- Recent Activities
- Harvest Event
- Inventory Event
- Financial Event

---

# 16. Analytics Endpoint

GET

/analytics

Support:

workspace

period

farm

culture_cycle

Output:

- Summary
- Trend
- Comparison

---

# 17. Search

Support:

search=

Mencari:

- Culture Cycle
- Pond
- Farm
- Harvest Batch
- Cost Center

---

# 18. Filter

Support:

company_id

farm_id

pond_id

culture_cycle_id

financial_period_id

date_range

---

# 19. Refresh Endpoint

POST

/refresh

Refresh seluruh Dashboard.

Digunakan secara manual.

---

POST

/widgets/{widget_id}/refresh

Refresh satu Widget.

---

# 20. Cache Endpoint

GET

/cache/status

Status Cache Dashboard.

---

DELETE

/cache

Membersihkan cache Dashboard.

Super Admin only.

---

# 21. Export Endpoint

GET

/export

Support:

- PDF
- Excel
- CSV

---

# 22. Statistics Endpoint

GET

/statistics

Output:

- Total Widget
- Active Widget
- Dashboard Load Time
- Cache Hit Ratio

---

# 23. Business Validation

Tidak diperbolehkan:

- Dashboard mengubah transaksi.
- Dashboard membuat transaksi.
- Dashboard menghitung ulang KPI.
- Dashboard mengakses database secara langsung.

Dashboard hanya membaca Service Layer.

---

# 24. Standard Response

Success

{
    "success": true,
    "message": "Success",
    "data": {},
    "meta": {}
}

---

Validation Error

{
    "success": false,
    "message": "Validation Error",
    "errors": {}
}

---

# 25. HTTP Status

200

204

400

401

403

404

429

500

---

# 26. Logging

Seluruh endpoint mencatat:

- User
- Role
- Workspace
- Widget
- Execution Time
- Cache Status

---

# 27. API Resource

Gunakan:

Laravel API Resource.

Dashboard tidak mengembalikan Model secara langsung.

---

# 28. Integration

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

# 29. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan Dashboard Service.
- Menggunakan API Resource.
- Menggunakan Service Layer.
- Menggunakan Cache.
- Menggunakan Widget Engine.
- Menggunakan Repository Pattern.
- Tidak melakukan Business Logic.
- Tidak mengakses database secara langsung.
- Mengikuti seluruh Business Rules.

---

# 30. Deliverables

Implementasi harus menghasilkan:

- Dashboard Route
- Dashboard Controller
- Dashboard Service
- Widget Service
- API Resource
- Feature Test
- Cache Integration
- KPI Endpoint
- Analytics Endpoint

---

# End of Document