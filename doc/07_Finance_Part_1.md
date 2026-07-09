# UtiFarm
# 07_Finance
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

---

# 1. Purpose

Finance merupakan Aquaculture Financial Management System (AFMS) yang mengelola seluruh transaksi keuangan operasional budidaya.

Finance menjadi pusat pencatatan biaya, pendapatan, profitabilitas, dan analisis keuangan.

Seluruh transaksi keuangan harus dapat ditelusuri (traceable).

---

# 2. Objective

Tujuan modul Finance:

- Mengelola biaya operasional.
- Mengelola pendapatan panen.
- Mengelola Cost Center.
- Menghitung Cost of Production.
- Menghitung Cost per Kilogram.
- Menghitung Profit & Loss.
- Menjadi sumber Dashboard.
- Menjadi sumber Financial Analytics.

---

# 3. Scope

Finance mencakup:

- Expense
- Revenue
- Cost Center
- Financial Ledger
- Journal
- Cost Allocation
- Profit Calculation
- Profit & Loss
- Financial Summary
- Financial Analytics

---

# 4. Business Process

Warehouse

↓

Operational Cost

↓

Culture Cycle

↓

Harvest

↓

Revenue

↓

Finance

↓

Profit Calculation

↓

Dashboard

↓

Analytics

---

# 5. Financial Lifecycle

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

# 6. Actors

- Super Admin
- Farm Owner
- Farm Manager
- Finance Staff
- Accountant
- Viewer

---

# 7. Dependency

Finance membutuhkan data dari:

Company

↓

Farm

↓

Culture Cycle

↓

Warehouse

↓

Activities

↓

Harvest

↓

Customer

↓

Supplier

---

# 8. Financial Categories

Kategori transaksi:

- Operational Expense
- Feed Cost
- Medicine Cost
- Labor Cost
- Utility Cost
- Maintenance Cost
- Harvest Revenue
- Other Income
- Other Expense

Kategori dapat dikembangkan tanpa mengubah struktur database.

---

# 9. Cost Center

Seluruh biaya harus memiliki Cost Center.

Contoh:

Farm

↓

Pond

↓

Culture Cycle

↓

Cost Center

Cost Center menjadi dasar seluruh analisis profitabilitas.

---

# 10. Financial Ledger

Finance menggunakan konsep Financial Ledger.

Setiap transaksi menghasilkan Ledger.

Ledger menjadi sumber data utama.

Seluruh laporan keuangan membaca Financial Ledger.

---

# 11. Business Event Matrix

| Event | Trigger | Source | Target |
|--------|----------|---------|----------|
| Feed Used | Warehouse | Finance | Ledger |
| Medicine Used | Warehouse | Finance | Ledger |
| Operational Expense | Finance | Ledger | Dashboard |
| Harvest Completed | Harvest | Finance | Revenue |
| Revenue Posted | Finance | Dashboard | Analytics |
| Profit Calculated | Finance | Dashboard | Report |

---

# 12. Revenue Sources

Revenue berasal dari:

- Harvest
- Penjualan
- Pendapatan Lain

Seluruh Revenue harus memiliki referensi transaksi.

---

# 13. Expense Sources

Expense berasal dari:

- Feed
- Medicine
- Vitamin
- Chemical
- Labor
- Electricity
- Fuel
- Maintenance
- Operational

---

# 14. Integration

Finance terintegrasi dengan:

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

# 15. Business Rules

- Seluruh transaksi wajib memiliki Cost Center.
- Seluruh transaksi wajib memiliki Document Number.
- Seluruh transaksi wajib menghasilkan Financial Ledger.
- Revenue hanya berasal dari transaksi yang valid.
- Expense harus memiliki kategori.
- Ledger yang telah Posted tidak dapat diubah.

---

# 16. Cost of Production

Finance menghitung:

- Feed Cost
- Medicine Cost
- Labor Cost
- Utility Cost
- Maintenance Cost
- Operational Cost

Total seluruh biaya menjadi Cost of Production.

---

# 17. Profit Calculation

Profit dihitung dari:

Revenue

-

Cost of Production

=

Gross Profit

-

Operational Cost

=

Net Profit

---

# 18. Traceability

Seluruh transaksi harus dapat ditelusuri.

Contoh:

Feed

↓

Warehouse

↓

Culture Cycle

↓

Harvest

↓

Revenue

↓

Financial Ledger

↓

Profit Report

---

# 19. Acceptance Criteria

Finance dianggap memenuhi spesifikasi apabila:

✓ Expense tercatat.

✓ Revenue tercatat.

✓ Financial Ledger berjalan.

✓ Cost Center berjalan.

✓ Cost of Production dihitung.

✓ Profit dihitung.

✓ Dashboard menerima data.

✓ Analytics menerima data.

---

# 20. AI Coding Instructions

AI Coding Assistant wajib:

- Menganggap Finance sebagai Aquaculture Financial Management System.
- Menggunakan Financial Ledger sebagai sumber data utama.
- Menggunakan Cost Center pada seluruh transaksi.
- Tidak melakukan perhitungan profit di Controller.
- Mengikuti seluruh Business Rules.
- Menghasilkan implementasi production-ready.

---

# 21. Deliverables

Dokumen berikutnya:

07_Finance_Part_2.md

Membahas:

- Database Design
- Financial Ledger
- Cost Center
- Expense
- Revenue
- Journal
- Cost Allocation
- Migration Rules

---

# End of Document