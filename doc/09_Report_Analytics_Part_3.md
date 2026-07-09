# UtiFarm
# 09_Report_Analytics
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
- 09_Report_Analytics_Part_1.md
- 09_Report_Analytics_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk modul Report & Analytics.

Report menggunakan Universal Report Engine (URE).

Seluruh endpoint bersifat Read Only, kecuali endpoint Generate Report.

API mengikuti standar:

00_API_Convention.md

---

# 2. Base URL

/api/v1/reports

---

# 3. Authentication

Seluruh endpoint menggunakan:

Bearer Token

Laravel Sanctum.

---

# 4. Authorization

Role:

- Super Admin
- Farm Owner
- Farm Manager
- Warehouse Staff
- Finance Staff
- Technician
- Viewer

Hak akses ditentukan berdasarkan kategori laporan.

---

# 5. Report Registry Endpoint

GET

/report-registry

Menampilkan seluruh Report yang tersedia.

---

GET

/report-registry/{report_id}

Menampilkan metadata Report.

---

# 6. Operational Report Endpoint

GET

/operational

Support Query:

- farm_id
- pond_id
- culture_cycle_id
- date_range

Output:

- Feeding
- Treatment
- Sampling
- Maintenance
- Daily Activities

---

# 7. Production Report Endpoint

GET

/production

Output:

- Biomass
- Growth
- SR
- FCR
- ADG
- Production Summary

---

# 8. Inventory Report Endpoint

GET

/inventory

Output:

- Current Stock
- Stock Movement
- Stock Adjustment
- Inventory Valuation
- Low Stock

---

# 9. Harvest Report Endpoint

GET

/harvest

Output:

- Harvest Planning
- Harvest Summary
- Grade Distribution
- Yield
- Delivery Summary

---

# 10. Financial Report Endpoint

GET

/finance

Output:

- Expense
- Revenue
- Profit & Loss
- Cost of Production
- Cost per KG
- ROI

---

# 11. Executive Report Endpoint

GET

/executive

Output:

- Executive Summary
- KPI Summary
- Production Summary
- Inventory Summary
- Harvest Summary
- Financial Summary

---

# 12. KPI Report Endpoint

GET

/kpi

Support:

- period
- farm
- culture_cycle

Output:

- KPI List
- Trend
- Comparison

---

# 13. Audit Report Endpoint

GET

/audit

Output:

- Login Activity
- User Activity
- Approval History
- Transaction History
- Audit Trail

---

# 14. Historical Report Endpoint

GET

/historical

Support:

- daily
- weekly
- monthly
- quarterly
- yearly

---

# 15. Comparative Report Endpoint

GET

/comparative

Support:

- farm
- pond
- culture_cycle
- financial_period

Output:

Perbandingan KPI dan performa.

---

# 16. Generate Report Endpoint

POST

/generate

Body:

- report_type
- template
- export_format
- filter
- parameter

Menghasilkan Report sesuai permintaan.

---

# 17. Export Endpoint

GET

/export/{report_id}

Support:

- PDF
- Excel
- CSV

Future:

- Word

---

# 18. Analytics Endpoint

GET

/analytics

Support:

- category
- period
- farm
- culture_cycle

Output:

- Trend
- Summary
- Comparison

---

# 19. Schedule Report Endpoint

POST

/schedules

Membuat jadwal Report.

Future Ready.

---

GET

/schedules

Daftar Scheduled Report.

---

DELETE

/schedules/{uuid}

Menghapus jadwal Report.

---

# 20. Search

Support:

search=

Mencari:

- Report Name
- Report Category
- Farm
- Culture Cycle
- Financial Period

---

# 21. Filter

Support:

company_id

farm_id

pond_id

culture_cycle_id

financial_period_id

report_category

date_range

---

# 22. Standard Response

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

# 23. HTTP Status

200

201

202

204

400

401

403

404

422

500

---

# 24. Logging

Seluruh endpoint mencatat:

- User
- Report Type
- Export Format
- Execution Time
- File Size
- Generated At

---

# 25. API Resource

Gunakan:

Laravel API Resource.

Response tidak mengembalikan Model secara langsung.

---

# 26. Integration

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

# 27. Business Validation

Tidak diperbolehkan:

- Report mengubah transaksi.
- Report menghapus transaksi.
- Report mengakses database secara langsung.
- Export tanpa hak akses.
- Scheduled Report tanpa permission.

---

# 28. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan Universal Report Engine.
- Menggunakan Report Registry.
- Menggunakan Report Builder.
- Menggunakan Service Layer.
- Menggunakan API Resource.
- Menggunakan Background Job untuk Report besar.
- Menggunakan Streaming Export bila diperlukan.
- Mengikuti seluruh Business Rules.

---

# 29. Deliverables

Implementasi harus menghasilkan:

- Report Route
- Report Controller
- Report Service
- Report Builder
- Report Registry
- Export Service
- Schedule Service
- API Resource
- Feature Test

---

# End of Document