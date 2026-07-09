# UtiFarm
# 08_Dashboard
## Part 6 - Operational Intelligence & Decision Support

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
- 08_Dashboard_Part_1.md
- 08_Dashboard_Part_2.md
- 08_Dashboard_Part_3.md
- 08_Dashboard_Part_4.md
- 08_Dashboard_Part_5.md

---

# 1. Purpose

Dokumen ini mendefinisikan Operational Intelligence dan Decision Support pada Dashboard.

Dashboard menjadi pusat monitoring, analisis, dan penyajian insight dari seluruh modul UtiFarm.

Dashboard tidak melakukan transaksi operasional.

Seluruh informasi bersifat Read Only.

---

# 2. Objective

Dashboard Intelligence digunakan untuk:

- Operational Monitoring
- KPI Monitoring
- Performance Monitoring
- Trend Analysis
- Alert Management
- Decision Support
- Executive Insight

---

# 3. Data Sources

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

↓

System Administration

---

# 4. Dashboard Intelligence

Dashboard Intelligence terdiri dari:

- Operational Intelligence
- Production Intelligence
- Inventory Intelligence
- Harvest Intelligence
- Financial Intelligence
- Executive Intelligence

---

# 5. Operational Intelligence

Menampilkan:

- Active Culture Cycle
- Daily Activities
- Feeding Progress
- Treatment Progress
- Water Quality Status
- Upcoming Schedule

---

# 6. Production Intelligence

Analisis:

- Biomass
- Average Daily Gain (ADG)
- Survival Rate (SR)
- Feed Conversion Ratio (FCR)
- Growth Trend
- Production Efficiency

---

# 7. Inventory Intelligence

Analisis:

- Current Stock
- Low Stock
- Near Expired
- Inventory Turnover
- Fast Moving Item
- Slow Moving Item

---

# 8. Harvest Intelligence

Analisis:

- Harvest Schedule
- Harvest Progress
- Grade Distribution
- Yield Trend
- Delivery Status
- Harvest Performance

---

# 9. Financial Intelligence

Analisis:

- Revenue
- Expense
- Gross Profit
- Net Profit
- Cost per KG
- ROI
- Financial Health Score

---

# 10. Executive Intelligence

Menampilkan:

- Business Overview
- KPI Summary
- Financial Performance
- Production Performance
- Executive Alert
- Executive Recommendation

---

# 11. Decision Support

Dashboard membantu pengguna mengambil keputusan melalui:

- Prioritas pekerjaan.
- Ringkasan kondisi operasional.
- Perbandingan performa.
- Analisis tren.
- Ringkasan KPI.

Dashboard tidak mengambil keputusan secara otomatis.

---

# 12. Alert Intelligence

Kategori Alert:

Critical

Warning

Information

Setiap Alert memiliki:

- Severity
- Source Module
- Timestamp
- Status
- Recommended Action

---

# 13. KPI Intelligence

Pantau KPI:

- Biomass
- SR
- FCR
- ADG
- Stock Accuracy
- Harvest Yield
- Cost per KG
- Gross Profit
- Net Profit
- ROI

---

# 14. Comparative Intelligence

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

# 15. Trend Intelligence

Dashboard menampilkan tren:

- Production Trend
- Inventory Trend
- Harvest Trend
- Revenue Trend
- Profit Trend
- KPI Trend

---

# 16. Executive Summary

Executive Summary berisi:

- Kondisi operasional hari ini.
- Ringkasan produksi.
- Ringkasan panen.
- Ringkasan keuangan.
- Alert penting.
- KPI utama.

---

# 17. Drill Down

Seluruh Widget mendukung Drill Down.

Contoh:

Revenue

↓

Financial Summary

↓

Ledger

↓

Expense Detail

↓

Reference Transaction

---

# 18. Recommendation Panel

Dashboard menampilkan rekomendasi informatif seperti:

- Jadwalkan panen dalam 2 hari.
- Stok pakan di Gudang A berada di bawah batas minimum.
- Kolam B-03 memiliki FCR lebih tinggi dari target.
- Pendapatan bulan ini meningkat dibanding bulan lalu.

Rekomendasi bersifat informatif.

---

# 19. Future Ready

Dashboard harus siap mendukung:

- AI Recommendation
- AI Forecast
- AI Predictive Analytics
- AI Operational Assistant
- AI Financial Advisor

Tanpa perubahan arsitektur utama.

---

# 20. Performance Rules

Gunakan:

- Materialized View (jika diperlukan)
- Cache
- Background Job
- Aggregation Table

Dashboard tidak boleh mengganggu transaksi operasional.

---

# 21. Security Rules

Dashboard mengikuti:

- Authentication
- Authorization
- Role Based Access Control (RBAC)
- Audit Trail

Pengguna hanya melihat data sesuai hak akses.

---

# 22. Business Rules

- Dashboard bersifat Read Only.
- Dashboard tidak membuat transaksi.
- Dashboard tidak mengubah transaksi.
- Dashboard hanya membaca hasil Business Module.
- Dashboard tidak menghitung ulang KPI.

---

# 23. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Dashboard Service.
- Menggunakan Widget Engine.
- Menggunakan Composite API.
- Menggunakan Cache.
- Menggunakan Background Job.
- Menghasilkan implementasi yang scalable.
- Mengikuti seluruh Business Rules.

---

# 24. Deliverables

Backend

- Dashboard Intelligence Service
- KPI Service
- Trend Analysis Service
- Alert Service
- Recommendation Service
- Cache Service

Frontend

- Executive Dashboard
- KPI Dashboard
- Intelligence Panel
- Recommendation Panel
- Trend Dashboard
- Alert Dashboard

---

# 25. Definition of Done

Operational Intelligence dianggap selesai apabila:

✓ Executive Dashboard berjalan.

✓ KPI Dashboard berjalan.

✓ Alert Center berjalan.

✓ Trend Analysis berjalan.

✓ Comparative Analysis berjalan.

✓ Recommendation Panel berjalan.

✓ Dashboard menggunakan Composite API.

✓ Dashboard bersifat Read Only.

✓ Dokumentasi diperbarui.

---

# End of Document