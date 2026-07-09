# UtiFarm
# 05_Warehouse
## Part 6 - Inventory Intelligence & Analytics

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
- 05_Warehouse_Part_1.md
- 05_Warehouse_Part_2.md
- 05_Warehouse_Part_3.md
- 05_Warehouse_Part_4.md
- 05_Warehouse_Part_5.md

---

# 1. Purpose

Dokumen ini mendefinisikan Inventory Intelligence dan Analytics pada modul Warehouse.

Analytics digunakan untuk mengubah data inventory menjadi informasi yang mendukung pengambilan keputusan.

Analytics bersifat Read Only dan tidak mengubah data transaksi.

---

# 2. Objective

Inventory Intelligence digunakan untuk:

- Monitoring Inventory
- Stock Analysis
- Inventory Optimization
- Cost Analysis
- Consumption Analysis
- Decision Support

---

# 3. Data Sources

Analytics membaca data dari:

Warehouse

↓

Inventory Movement

↓

Current Stock

↓

Activities

↓

Culture Cycle

↓

Harvest

↓

Finance

↓

Master Data

---

# 4. Analytics Categories

Analytics dibagi menjadi:

- Inventory
- Stock Movement
- Consumption
- Warehouse Performance
- Batch
- Expired Inventory
- Cost
- Operational

---

# 5. Inventory Dashboard

Dashboard menampilkan:

- Total Inventory Item
- Total Warehouse
- Current Stock Value
- Low Stock
- Out of Stock
- Near Expired
- Expired Item
- Pending Stock Opname

---

# 6. Inventory Analytics

Hitung:

- Total Item
- Total Stock
- Available Stock
- Reserved Stock
- Stock Value
- Average Daily Usage

---

# 7. Stock Movement Analytics

Analisis:

- Stock In
- Stock Out
- Transfer
- Adjustment
- Opname

Tampilkan tren harian, mingguan, dan bulanan.

---

# 8. Consumption Analytics

Analisis penggunaan:

- Feed
- Medicine
- Vitamin
- Chemical
- Equipment

Hitung:

- Total Consumption
- Average Consumption
- Consumption Trend

---

# 9. Warehouse Performance

Hitung:

- Movement per Warehouse
- Stock Accuracy
- Stock Turnover
- Opname Accuracy
- Warehouse Utilization

---

# 10. Batch Analytics

Tampilkan:

- Active Batch
- Consumed Batch
- Near Expired Batch
- Expired Batch

---

# 11. Expired Analytics

Analisis:

- Expired Item
- Near Expired
- Disposal Recommendation
- Estimated Loss

---

# 12. Reorder Analytics

Pantau:

- Minimum Stock
- Reorder Level
- Safety Stock

Rekomendasikan item yang perlu segera dipesan.

---

# 13. Cost Analytics

Hitung:

- Inventory Value
- Average Unit Cost
- Total Inventory Cost
- Inventory Cost Trend

Data biaya berasal dari Inventory Movement.

---

# 14. Inventory Ledger

Ledger menampilkan:

- Date
- Document Number
- Movement Type
- Stock In
- Stock Out
- Balance
- Unit Cost
- Total Cost

Ledger bersifat Read Only.

---

# 15. Stock Card Analytics

Stock Card mendukung analisis berdasarkan:

- Item
- Warehouse
- Batch
- Periode

---

# 16. Comparative Analytics

Perbandingan:

Warehouse

vs

Warehouse

Farm

vs

Farm

Item

vs

Item

---

# 17. KPI Monitoring

Pantau KPI:

- Inventory Turnover
- Stock Accuracy
- Low Stock Percentage
- Expired Percentage
- Inventory Availability

---

# 18. Report Generation

Support:

- Daily Inventory Report
- Weekly Inventory Report
- Monthly Inventory Report
- Inventory Valuation Report
- Stock Movement Report
- Stock Opname Report
- Expired Inventory Report

Export:

- PDF
- Excel
- CSV

---

# 19. Drill Down

Seluruh widget dapat dibuka menjadi detail.

Contoh:

Low Stock

↓

Item List

↓

Movement History

↓

Stock Card

↓

Inventory Detail

---

# 20. Future Ready

Analytics harus mendukung:

- AI Inventory Forecast
- Demand Prediction
- Automatic Reorder Recommendation
- Consumption Prediction
- Inventory Optimization

Tanpa perubahan arsitektur utama.

---

# 21. Performance Rules

Gunakan:

- Materialized View (jika diperlukan)
- Cache
- Background Job
- Aggregation Table

Analytics tidak boleh mengganggu transaksi operasional.

---

# 22. Security Rules

Analytics mengikuti hak akses pengguna.

Pengguna hanya dapat melihat data Warehouse yang menjadi hak aksesnya.

---

# 23. Business Rules

Analytics bersifat Read Only.

Tidak boleh:

- Mengubah transaksi.
- Mengubah Current Stock.
- Mengubah Inventory Movement.
- Mengubah KPI.

Analytics hanya membaca data.

---

# 24. Inventory Intelligence

Sistem memberikan insight seperti:

- Item paling sering digunakan.
- Item paling jarang digunakan.
- Warehouse dengan aktivitas tertinggi.
- Batch yang mendekati kedaluwarsa.
- Rekomendasi reorder.
- Estimasi stok habis berdasarkan rata-rata penggunaan.

Insight bersifat informatif dan tidak melakukan perubahan otomatis.

---

# 25. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Query yang efisien.
- Menggunakan Cache untuk Dashboard.
- Menggunakan Background Job untuk proses agregasi.
- Menggunakan Pagination bila diperlukan.
- Tidak melakukan perhitungan berat pada setiap request.
- Menghasilkan implementasi yang scalable.

---

# 26. Deliverables

Backend

- Analytics Service
- Inventory Statistics Service
- Report Service
- Aggregation Job
- Cache Service

Frontend

- Inventory Dashboard
- Inventory Analytics
- Trend Chart
- Consumption Chart
- Warehouse Comparison
- Stock Card Analytics
- Inventory Report
- Export Report

---

# 27. Definition of Done

Inventory Intelligence dianggap selesai apabila:

✓ Dashboard Inventory berjalan.

✓ Stock Analytics berjalan.

✓ Consumption Analytics berjalan.

✓ Batch Analytics berjalan.

✓ Cost Analytics berjalan.

✓ Reorder Recommendation tersedia.

✓ Inventory Report dapat di-export.

✓ Seluruh Analytics bersifat Read Only.

✓ Dokumentasi diperbarui.

---

# End of Document