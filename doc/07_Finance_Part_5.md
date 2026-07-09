# UtiFarm
# 07_Finance
## Part 5 - Implementation Rules & Business Engine

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
- 07_Finance_Part_1.md
- 07_Finance_Part_2.md
- 07_Finance_Part_3.md
- 07_Finance_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan aturan implementasi dan Business Engine untuk modul Finance.

Finance menggunakan pendekatan Aquaculture Financial Management System (AFMS) berbasis Financial Workflow dan Financial Ledger.

Seluruh transaksi keuangan diproses melalui Business Engine.

---

# 2. Business Engine

Flow implementasi:

REST API

↓

Controller

↓

Service

↓

Repository

↓

Business Validation

↓

Financial Workflow

↓

Financial Ledger

↓

Profit Engine

↓

Dashboard

↓

Analytics

↓

Audit Trail

Controller tidak diperbolehkan memiliki Business Logic.

---

# 3. Finance Principles

Prinsip utama:

- Financial Ledger adalah Source of Truth.
- Profit berasal dari transaksi yang telah diposting.
- Cost Center wajib pada setiap transaksi.
- Cost Object wajib pada setiap transaksi.
- Seluruh transaksi dapat ditelusuri.

---

# 4. Financial Workflow

Draft

↓

Validated

↓

Posted

↓

Completed

↓

Closed

↓

Locked

Transaksi yang telah Locked tidak dapat diubah.

---

# 5. Expense Process

Flow:

Validation

↓

Expense Created

↓

Business Validation

↓

Journal

↓

Financial Ledger

↓

Dashboard

↓

Analytics

---

# 6. Revenue Process

Flow:

Harvest Completed

↓

Revenue Created

↓

Validation

↓

Financial Ledger

↓

Profit Calculation

↓

Dashboard

---

# 7. Journal Process

Flow:

Expense

↓

Revenue

↓

Journal

↓

Journal Validation

↓

Posting

↓

Ledger

Journal menjadi ringkasan transaksi.

---

# 8. Financial Ledger Engine

Ledger mencatat:

- Debit
- Credit
- Balance
- Cost Center
- Cost Object
- Reference

Ledger bersifat immutable setelah Posted.

---

# 9. Cost Center Engine

Setiap transaksi wajib memiliki Cost Center.

Contoh:

Farm

↓

Pond

↓

Culture Cycle

↓

Cost Center

Seluruh laporan profit membaca Cost Center.

---

# 10. Cost Object Engine

Cost Object digunakan untuk mengelompokkan biaya.

Contoh:

Feed

Medicine

Labor

Electricity

Fuel

Maintenance

Harvest

Administration

---

# 11. Profit Engine

Profit dihitung:

Revenue

↓

Cost of Production

↓

Gross Profit

↓

Operational Cost

↓

Net Profit

Profit dihitung otomatis oleh Service Layer.

---

# 12. Cost of Production Engine

Komponen biaya:

- Feed
- Medicine
- Vitamin
- Chemical
- Labor
- Electricity
- Fuel
- Maintenance
- Operational

Total menjadi Cost of Production.

---

# 13. Cost per Kilogram Engine

Formula:

Cost of Production

/

Total Harvest Weight

Output:

Cost per KG

Nilai diperbarui setelah Harvest Completed.

---

# 14. Profit Margin Engine

Hitung:

Gross Margin

Net Margin

Profit Margin

Margin dihitung otomatis berdasarkan Revenue dan Cost.

---

# 15. Financial Period Engine

Flow:

Open

↓

Transaction

↓

Posting

↓

Closing

↓

Locked

Periode yang Locked tidak menerima transaksi baru.

---

# 16. Warehouse Integration

Warehouse mengirim:

- Feed Cost
- Medicine Cost
- Material Cost

Seluruh data diposting ke Financial Ledger.

---

# 17. Harvest Integration

Harvest mengirim:

- Revenue
- Quantity
- Yield
- Customer

Data digunakan untuk Profit Engine.

---

# 18. Activities Integration

Activities mengirim:

- Operational Cost
- Labor
- Maintenance
- Utility

Data digunakan sebagai Expense.

---

# 19. Dashboard Integration

Dashboard membaca:

- Financial Ledger
- Profit Summary
- Revenue Summary
- Expense Summary

Dashboard tidak menghitung ulang transaksi.

---

# 20. Report Integration

Report membaca:

- Financial Ledger
- Profit Summary
- Cost Center
- Cost Object

Report bersifat Read Only.

---

# 21. Exception Handling

Gunakan Custom Exception.

Contoh:

- InvalidFinancialPeriodException
- InvalidCostCenterException
- InvalidCostObjectException
- LedgerAlreadyPostedException
- FinancialPeriodClosedException
- ProfitCalculationException

---

# 22. Database Transaction

Gunakan DB::transaction() untuk:

- Expense Posting
- Revenue Posting
- Journal Posting
- Profit Calculation
- Financial Period Closing

Rollback apabila salah satu proses gagal.

---

# 23. Performance Rules

Gunakan:

- Eager Loading
- Composite Index
- Cache Dashboard
- Background Job
- Optimized Query

Hindari Query N+1.

---

# 24. Security Rules

Finance menerapkan:

- Authentication
- Authorization
- RBAC
- Audit Trail

Ledger Posted hanya dapat dilihat.

Tidak dapat diubah.

---

# 25. Business Rules

- Ledger adalah Source of Truth.
- Journal wajib sebelum Posting.
- Cost Center wajib.
- Cost Object wajib.
- Financial Period Closed tidak menerima transaksi.
- Profit hanya dihitung dari transaksi Posted.
- Revenue Harvest tidak boleh diedit manual setelah Posted.

---

# 26. Acceptance Criteria

Business Engine dianggap selesai apabila:

✓ Expense berjalan.

✓ Revenue berjalan.

✓ Journal berjalan.

✓ Financial Ledger berjalan.

✓ Cost Center berjalan.

✓ Cost Object berjalan.

✓ Cost per KG dihitung.

✓ Profit dihitung.

✓ Dashboard diperbarui.

✓ Report membaca Financial Ledger.

---

# 27. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan Financial Workflow.
- Menggunakan Financial Ledger sebagai Source of Truth.
- Menggunakan DB Transaction.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Menghasilkan implementasi production-ready.

---

# 28. Deliverables

Backend

- Migration
- Model
- Repository
- Service
- Controller
- Form Request
- Resource
- Policy
- Feature Test

Frontend

- Financial Workspace
- Ledger
- Expense
- Revenue
- Profit Summary
- Dashboard
- Financial Analytics

---

# 29. Definition of Done

Finance dinyatakan selesai apabila:

- Expense berjalan.
- Revenue berjalan.
- Journal berjalan.
- Financial Ledger berjalan.
- Cost Center berjalan.
- Cost Object berjalan.
- Cost of Production dihitung.
- Cost per KG dihitung.
- Profit dihitung otomatis.
- Dashboard membaca Financial Ledger.
- Report berjalan.
- Seluruh Feature Test lulus.
- Dokumentasi diperbarui.

---

# End of Document