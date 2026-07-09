# UtiFarm
# 07_Finance
## Part 2 - Database Design

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

---

# 1. Purpose

Dokumen ini mendefinisikan struktur database untuk modul Finance.

Finance menggunakan konsep Aquaculture Financial Management System (AFMS) berbasis Financial Ledger.

Seluruh transaksi keuangan harus dapat ditelusuri melalui Financial Ledger.

---

# 2. Database Principles

Seluruh tabel wajib menggunakan:

- UUID
- Soft Delete
- Audit Trail
- Timestamp
- Foreign Key
- Index

---

# 3. Financial Philosophy

Finance menggunakan prinsip:

Financial Transaction

↓

Financial Ledger

↓

Financial Summary

↓

Profit Calculation

↓

Dashboard

Financial Ledger menjadi sumber data utama.

Seluruh laporan membaca Financial Ledger.

---

# 4. Main Entities

Entity utama:

Financial Period

↓

Cost Center

↓

Cost Object

↓

Expense

↓

Revenue

↓

Journal

↓

Financial Ledger

↓

Profit Summary

---

# 5. Entity Relationship

Company

↓

Farm

↓

Culture Cycle

↓

Cost Center

↓

Cost Object

↓

Expense

↓

Revenue

↓

Journal

↓

Financial Ledger

↓

Profit Summary

---

# 6. Table : financial_periods

Deskripsi

Periode pembukuan.

Field

period_code

period_name

start_date

end_date

status

closed_at

---

# 7. Table : cost_centers

Deskripsi

Pusat biaya.

Relationship

company_id

farm_id

culture_cycle_id

Field

cost_center_code

cost_center_name

description

status

---

# 8. Table : cost_objects

Deskripsi

Objek biaya.

Field

object_code

object_name

category

description

status

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

# 9. Table : expenses

Relationship

financial_period_id

cost_center_id

cost_object_id

supplier_id

activity_id

user_id

Field

expense_number

expense_date

expense_category

amount

reference_type

reference_uuid

notes

status

---

# 10. Table : revenues

Relationship

financial_period_id

cost_center_id

customer_id

harvest_batch_id

user_id

Field

revenue_number

revenue_date

revenue_category

quantity

unit_price

total_amount

reference_type

reference_uuid

status

---

# 11. Table : journals

Deskripsi

Ringkasan transaksi keuangan.

Field

journal_number

journal_date

description

status

---

# 12. Table : journal_details

Relationship

journal_id

expense_id

revenue_id

Field

transaction_type

amount

reference_type

reference_uuid

---

# 13. Table : financial_ledgers

Deskripsi

Ledger seluruh transaksi keuangan.

Relationship

financial_period_id

journal_id

cost_center_id

cost_object_id

Field

ledger_number

transaction_date

transaction_type

debit

credit

balance

reference_type

reference_uuid

notes

---

# 14. Table : profit_summaries

Relationship

financial_period_id

cost_center_id

culture_cycle_id

Field

feed_cost

medicine_cost

labor_cost

operational_cost

revenue

gross_profit

net_profit

status

---

# 15. Financial Categories

Expense:

- Feed
- Medicine
- Labor
- Electricity
- Fuel
- Maintenance
- Operational
- Other

Revenue:

- Harvest
- Service
- Other

---

# 16. Financial Status

Draft

↓

Validated

↓

Posted

↓

Completed

↓

Closed

---

# 17. Reference Rules

reference_type

Contoh:

Warehouse

Harvest

Activities

Culture Cycle

Supplier

Customer

reference_uuid

UUID transaksi asal.

---

# 18. Constraint Rules

- Expense wajib memiliki Cost Center.
- Revenue wajib memiliki Cost Center.
- Ledger wajib memiliki Journal.
- Financial Period yang telah Closed tidak dapat menerima transaksi baru.
- Journal Posted tidak dapat diubah.

---

# 19. Index Strategy

Index wajib dibuat pada:

uuid

expense_number

revenue_number

journal_number

ledger_number

transaction_date

financial_period_id

cost_center_id

created_at

deleted_at

---

# 20. Performance Strategy

Gunakan:

- Composite Index
- Server Side Search
- Server Side Pagination
- Eager Loading
- Optimized Query

Financial Summary dapat menggunakan cache apabila diperlukan.

---

# 21. Migration Order

financial_periods

↓

cost_centers

↓

cost_objects

↓

expenses

↓

revenues

↓

journals

↓

journal_details

↓

financial_ledgers

↓

profit_summaries

---

# 22. Seeder

Minimal Seeder:

Financial Category

Cost Object

Financial Status

Financial Period

---

# 23. Factory

Factory digunakan untuk:

- Testing
- Dummy Expense
- Dummy Revenue
- Dummy Journal
- Performance Testing

---

# 24. Business Constraint

- Financial Ledger tidak boleh dihapus.
- Profit Summary bersifat hasil perhitungan.
- Journal Posted tidak boleh diedit.
- Financial Period Closed tidak menerima transaksi baru.
- Seluruh transaksi wajib memiliki Reference.

---

# 25. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Financial Ledger sebagai Source of Truth.
- Menggunakan Cost Center pada seluruh transaksi.
- Menggunakan Cost Object pada seluruh transaksi.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Menggunakan DB Transaction.
- Menggunakan Eloquent Relationship.
- Menghasilkan implementasi production-ready.

---

# 26. Deliverables

Implementasi harus menghasilkan:

✔ Migration

✔ Model

✔ Relationship

✔ Factory

✔ Seeder

✔ Repository

✔ Service

✔ Policy

---

# End of Document