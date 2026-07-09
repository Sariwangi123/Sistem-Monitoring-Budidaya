# UtiFarm
# 07_Finance
## Part 7 - Costing, Profitability & Financial Reporting

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
- 07_Finance_Part_5.md
- 07_Finance_Part_6.md

---

# 1. Purpose

Dokumen ini mendefinisikan Costing Engine, Profitability Analysis, dan Financial Reporting.

Seluruh analisis biaya dan keuntungan menggunakan Financial Ledger sebagai sumber data utama.

Dokumen ini menjadi dasar seluruh laporan bisnis UtiFarm.

---

# 2. Objective

Costing Engine digunakan untuk:

- Menghitung Cost of Production
- Menghitung Cost per Kilogram
- Menghitung Gross Profit
- Menghitung Net Profit
- Menghitung ROI
- Menghasilkan laporan keuangan operasional
- Mendukung pengambilan keputusan bisnis

---

# 3. Costing Sources

Perhitungan biaya berasal dari:

Warehouse

↓

Activities

↓

Harvest

↓

Financial Ledger

↓

Costing Engine

---

# 4. Cost Components

Komponen biaya:

- Feed Cost
- Medicine Cost
- Vitamin Cost
- Chemical Cost
- Labor Cost
- Electricity Cost
- Fuel Cost
- Maintenance Cost
- Equipment Cost
- Operational Cost
- Other Cost

---

# 5. Revenue Components

Pendapatan berasal dari:

- Harvest Revenue
- Other Revenue

Revenue hanya dihitung dari transaksi Posted.

---

# 6. Cost of Production

Formula:

Total Feed Cost

+

Medicine Cost

+

Labor Cost

+

Operational Cost

+

Other Cost

=

Cost of Production

---

# 7. Cost per Kilogram

Cost per KG dihitung:

Total Cost of Production

/

Total Harvest Weight

Output:

Cost per KG

---

# 8. Gross Profit

Formula:

Revenue

-

Cost of Production

=

Gross Profit

---

# 9. Net Profit

Formula:

Gross Profit

-

Additional Expense

=

Net Profit

---

# 10. Profit Margin

Formula:

(Net Profit / Revenue)

× 100%

Output:

Profit Margin (%)

---

# 11. ROI

Formula:

(Net Profit / Total Investment)

× 100%

Output:

Return on Investment (%)

---

# 12. Profitability Analysis

Hitung:

- Profit per Farm
- Profit per Pond
- Profit per Culture Cycle
- Profit per Customer

---

# 13. Cost Analysis

Analisis:

- Feed Cost Ratio
- Medicine Cost Ratio
- Labor Cost Ratio
- Operational Cost Ratio

Bandingkan kontribusi setiap komponen terhadap total biaya.

---

# 14. Comparative Analysis

Bandingkan:

Farm

vs

Farm

Pond

vs

Pond

Culture Cycle

vs

Culture Cycle

Financial Period

vs

Financial Period

---

# 15. Break Even Analysis

Hitung:

- Total Cost
- Revenue
- Margin
- Break Even Point

Break Even digunakan sebagai indikator evaluasi bisnis.

---

# 16. Financial Reporting

Laporan yang tersedia:

- Profit & Loss
- Cost of Production
- Cost per Kilogram
- Revenue Summary
- Expense Summary
- ROI Report
- Profitability Report

---

# 17. Reporting Scope

Laporan dapat dibuat berdasarkan:

- Company
- Farm
- Pond
- Culture Cycle
- Financial Period
- Customer

---

# 18. Export

Support:

- PDF
- Excel
- CSV

---

# 19. Dashboard Integration

Dashboard membaca:

- Cost per KG
- Gross Profit
- Net Profit
- Profit Margin
- ROI
- Financial Health Score

Dashboard tidak melakukan perhitungan ulang.

---

# 20. AI Recommendation Ready

Costing Engine menyediakan data untuk:

- AI Cost Optimization
- AI Feed Efficiency
- AI Revenue Recommendation
- AI Profit Forecast
- AI Investment Recommendation

Seluruh rekomendasi bersifat informatif.

---

# 21. Performance Rules

Gunakan:

- Materialized View (jika diperlukan)
- Cache
- Background Job
- Aggregation Table

Laporan tidak boleh mengganggu transaksi operasional.

---

# 22. Security Rules

Financial Report mengikuti Role Based Access Control.

Pengguna hanya dapat melihat laporan sesuai hak akses:

- Company
- Farm
- Pond
- Financial Period

---

# 23. Business Rules

- Financial Report bersifat Read Only.
- Profit hanya dihitung dari transaksi Posted.
- Cost of Production tidak boleh dihitung dari transaksi Draft.
- ROI menggunakan nilai investasi yang telah disetujui.
- Dashboard menggunakan hasil Costing Engine.

---

# 24. Financial Decision Support

Sistem menghasilkan insight seperti:

- Farm paling menguntungkan.
- Pond paling efisien.
- Culture Cycle terbaik.
- Komponen biaya terbesar.
- Peluang efisiensi biaya.
- Tren profit.
- ROI tertinggi.
- Cost per KG terendah.

Insight bersifat informatif.

---

# 25. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Financial Calculation Service.
- Menggunakan Costing Engine.
- Menggunakan Financial Ledger sebagai Source of Truth.
- Menggunakan Cache untuk Dashboard.
- Menggunakan Background Job untuk agregasi.
- Menghasilkan implementasi yang scalable.
- Mengikuti seluruh Business Rules.

---

# 26. Deliverables

Backend

- Costing Service
- Profitability Service
- Financial Report Service
- ROI Service
- Aggregation Job
- Cache Service

Frontend

- Cost Dashboard
- Profit Dashboard
- ROI Dashboard
- Profitability Dashboard
- Financial Reporting
- Export Report

---

# 27. Definition of Done

Costing & Financial Reporting dianggap selesai apabila:

✓ Cost of Production dihitung.

✓ Cost per KG dihitung.

✓ Gross Profit dihitung.

✓ Net Profit dihitung.

✓ Profit Margin dihitung.

✓ ROI dihitung.

✓ Profitability Analysis berjalan.

✓ Financial Report dapat di-export.

✓ Dashboard membaca seluruh hasil Costing Engine.

✓ Dokumentasi diperbarui.

---

# End of Document