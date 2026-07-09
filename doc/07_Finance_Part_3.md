# UtiFarm
# 07_Finance
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
- 07_Finance_Part_1.md
- 07_Finance_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk modul Finance.

Finance menggunakan pendekatan Aquaculture Financial Management System (AFMS).

Seluruh transaksi keuangan diproses melalui Financial Workflow API.

API mengikuti standar pada:

00_API_Convention.md

---

# 2. Base URL

/api/v1

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
- Finance Staff
- Accountant

Viewer hanya memiliki akses GET.

---

# 5. Financial Period Endpoint

GET

/financial-periods

---

GET

/financial-periods/{uuid}

---

POST

/financial-periods

---

PUT

/financial-periods/{uuid}

---

POST

/financial-periods/{uuid}/close

Menutup periode keuangan.

---

POST

/financial-periods/{uuid}/reopen

Membuka kembali periode (Super Admin).

---

# 6. Cost Center Endpoint

GET

/cost-centers

---

GET

/cost-centers/{uuid}

---

POST

/cost-centers

---

PUT

/cost-centers/{uuid}

---

DELETE

/cost-centers/{uuid}

---

# 7. Cost Object Endpoint

GET

/cost-objects

---

GET

/cost-objects/{uuid}

---

POST

/cost-objects

---

PUT

/cost-objects/{uuid}

---

DELETE

/cost-objects/{uuid}

---

# 8. Expense Endpoint

GET

/expenses

---

GET

/expenses/{uuid}

---

POST

/expenses

Input manual hanya untuk biaya yang tidak berasal dari modul lain.

---

PUT

/expenses/{uuid}

---

POST

/expenses/{uuid}/post

Posting ke Financial Ledger.

---

# 9. Revenue Endpoint

GET

/revenues

---

GET

/revenues/{uuid}

---

POST

/revenues

Input manual hanya jika tidak berasal dari Harvest.

---

PUT

/revenues/{uuid}

---

POST

/revenues/{uuid}/post

Posting Revenue.

---

# 10. Journal Endpoint

GET

/journals

---

GET

/journals/{uuid}

---

POST

/journals

---

POST

/journals/{uuid}/post

Posting Journal.

---

GET

/journals/{uuid}/details

---

# 11. Financial Ledger Endpoint

GET

/financial-ledgers

---

GET

/financial-ledgers/{uuid}

---

GET

/financial-ledgers/cost-center/{uuid}

---

GET

/financial-ledgers/culture-cycle/{uuid}

Ledger bersifat Read Only.

---

# 12. Profit Summary Endpoint

GET

/profit-summaries

---

GET

/profit-summaries/{culture_cycle_uuid}

---

GET

/profit-summaries/farm/{farm_uuid}

---

GET

/profit-summaries/company

---

# 13. Financial Workflow Endpoint

POST

/finance/post-expense

---

POST

/finance/post-revenue

---

POST

/finance/post-journal

---

POST

/finance/calculate-profit

---

POST

/finance/close-period

---

# 14. Dashboard Endpoint

GET

/finance/dashboard

Output:

- Total Expense
- Total Revenue
- Gross Profit
- Net Profit
- Cost per KG
- Pending Journal

---

# 15. Search

Support:

search=

Pencarian berdasarkan:

- Expense Number
- Revenue Number
- Ledger Number
- Journal Number
- Cost Center

---

# 16. Filter

Support:

company_id

farm_id

culture_cycle_id

financial_period_id

cost_center_id

cost_object_id

transaction_type

status

date_range

---

# 17. Sorting

Support:

transaction_date

ledger_number

expense_number

revenue_number

created_at

Default:

transaction_date DESC

---

# 18. Pagination

Default:

20 data.

Pilihan:

10

20

50

100

---

# 19. Include

Support:

include=

Contoh:

cost_center

cost_object

supplier

customer

journal

ledger

culture_cycle

harvest

warehouse

---

# 20. Export Endpoint

GET

/finance/export

Support:

- PDF
- Excel
- CSV

---

# 21. Statistics Endpoint

GET

/finance/statistics

Output:

- Total Expense
- Total Revenue
- Gross Profit
- Net Profit
- Expense by Category
- Revenue by Category
- Cost per KG

---

# 22. Business Validation

Tidak diperbolehkan:

- Posting pada Financial Period yang Closed.
- Expense tanpa Cost Center.
- Revenue tanpa referensi transaksi.
- Journal tanpa Detail.
- Ledger diedit secara manual.
- Profit dihitung sebelum Revenue tersedia.

---

# 23. Standard Response

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

# 24. HTTP Status

200

201

204

400

401

403

404

409

422

500

---

# 25. Logging

Seluruh endpoint mencatat:

- User
- Endpoint
- Method
- Document Number
- Reference Number
- Execution Time
- Cost Center

---

# 26. API Resource

Gunakan:

Laravel API Resource.

Tidak mengembalikan Model secara langsung.

---

# 27. Integration

Finance berkomunikasi dengan:

Warehouse

↓

Activities

↓

Culture Cycle

↓

Harvest

↓

Dashboard

↓

Report Analytics

---

# 28. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan UUID.
- Menggunakan Form Request.
- Menggunakan API Resource.
- Menggunakan Repository Pattern.
- Menggunakan Service Layer.
- Menggunakan Database Transaction.
- Menggunakan Financial Workflow.
- Menggunakan Financial Ledger sebagai Source of Truth.
- Mengikuti seluruh Business Rules.

---

# 29. Deliverables

Implementasi harus menghasilkan:

- API Route
- Controller
- Form Request
- API Resource
- Repository
- Service
- Policy
- Feature Test

---

# End of Document