# UtiFarm
# 06_Harvest
## Part 6 - Harvest Intelligence & Analytics

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
- 06_Harvest_Part_1.md
- 06_Harvest_Part_2.md
- 06_Harvest_Part_3.md
- 06_Harvest_Part_4.md
- 06_Harvest_Part_5.md

---

# 1. Purpose

Dokumen ini mendefinisikan Harvest Intelligence dan Analytics pada modul Harvest.

Analytics digunakan untuk mengubah data panen menjadi informasi yang membantu evaluasi performa budidaya serta mendukung pengambilan keputusan.

Analytics bersifat Read Only.

Analytics tidak mengubah transaksi operasional.

---

# 2. Objective

Harvest Intelligence digunakan untuk:

- Production Monitoring
- Yield Analysis
- Harvest Performance
- Grade Analysis
- Quality Analysis
- Revenue Analysis
- Decision Support

---

# 3. Data Sources

Analytics membaca data dari:

Harvest

↓

Culture Cycle

↓

Activities

↓

Warehouse

↓

Finance

↓

Master Data

---

# 4. Analytics Categories

Analytics dibagi menjadi:

- Harvest
- Yield
- Quality
- Grade
- Production
- Delivery
- Customer
- Revenue

---

# 5. Harvest Dashboard

Dashboard menampilkan:

- Total Harvest
- Harvest Today
- Harvest This Month
- Total Production
- Average Harvest Weight
- Pending Delivery
- Completed Harvest
- Estimated Revenue

---

# 6. Yield Analytics

Hitung:

- Estimated Harvest Weight
- Actual Harvest Weight
- Yield Percentage
- Production Efficiency
- Harvest Loss
- Packing Loss
- Delivery Loss

---

# 7. Grade Analytics

Analisis:

- Grade A
- Grade B
- Grade C
- Grade BS

Tampilkan:

- Quantity
- Weight
- Percentage

---

# 8. Quality Analytics

Analisis berdasarkan:

- Average Fish Weight
- Average Fish Size
- Quality Status
- Rejected Harvest
- QC Trend

---

# 9. Harvest Performance

Hitung:

- Harvest per Farm
- Harvest per Pond
- Harvest per Culture Cycle
- Harvest per Operator
- Harvest Duration

---

# 10. Delivery Analytics

Analisis:

- Pending Delivery
- Delivered Batch
- Delivery Performance
- Delivery Time

---

# 11. Customer Analytics

Tampilkan:

- Total Customer
- Harvest per Customer
- Delivery per Customer
- Revenue per Customer

---

# 12. Production Analytics

Hitung:

- Total Production
- Monthly Production
- Farm Production
- Pond Production
- Culture Cycle Production

---

# 13. Comparative Analytics

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

Customer

vs

Customer

---

# 14. Yield Ledger

Yield Ledger menampilkan:

- Estimated Weight
- Actual Weight
- Grade Weight
- Packing Weight
- Delivery Weight
- Final Accepted Weight

Ledger bersifat Read Only.

---

# 15. Harvest Trend

Tampilkan tren:

- Daily Harvest
- Weekly Harvest
- Monthly Harvest
- Yearly Harvest

---

# 16. Charts

Gunakan Chart untuk:

- Harvest Trend
- Grade Distribution
- Yield Trend
- Production Trend
- Delivery Trend
- Revenue Trend

---

# 17. KPI Monitoring

Pantau KPI:

- Survival Rate (SR)
- Feed Conversion Ratio (FCR)
- Average Daily Gain (ADG)
- Biomass
- Average Fish Weight
- Yield Percentage

Nilai KPI berasal dari Culture Cycle dan Harvest.

---

# 18. Report Generation

Support:

- Daily Harvest Report
- Weekly Harvest Report
- Monthly Harvest Report
- Harvest Summary
- Yield Report
- Grade Report
- Delivery Report

Export:

- PDF
- Excel
- CSV

---

# 19. Drill Down

Seluruh widget mendukung Drill Down.

Contoh:

Harvest

↓

Harvest Batch

↓

Harvest Session

↓

Harvest Detail

↓

Grading

↓

Packing

↓

Delivery

---

# 20. Future Ready

Harvest Intelligence harus mendukung:

- AI Harvest Prediction
- AI Yield Prediction
- AI Grade Prediction
- AI Revenue Prediction
- AI Production Optimization

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

Analytics mengikuti Role Based Access Control.

Pengguna hanya dapat melihat data:

- Company
- Farm
- Pond
- Culture Cycle

yang menjadi hak aksesnya.

---

# 23. Business Rules

Analytics bersifat Read Only.

Tidak boleh:

- Mengubah Harvest.
- Mengubah Delivery.
- Mengubah Yield.
- Mengubah KPI.

Analytics hanya membaca data.

---

# 24. Harvest Intelligence

Sistem memberikan insight seperti:

- Culture Cycle dengan hasil panen terbaik.
- Farm dengan produksi tertinggi.
- Pond dengan Yield tertinggi.
- Grade A tertinggi.
- Customer dengan pembelian terbesar.
- Rata-rata durasi panen.
- Estimasi kehilangan hasil panen.
- Perbandingan estimasi dan realisasi panen.

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
- Harvest Statistics Service
- Yield Analysis Service
- Report Service
- Aggregation Job
- Cache Service

Frontend

- Harvest Dashboard
- Yield Dashboard
- Harvest Analytics
- Grade Analytics
- Production Analytics
- Revenue Analytics
- Report Dashboard
- Export Report

---

# 27. Definition of Done

Harvest Intelligence dianggap selesai apabila:

✓ Dashboard Harvest berjalan.

✓ Yield Analytics berjalan.

✓ Grade Analytics berjalan.

✓ Production Analytics berjalan.

✓ Delivery Analytics berjalan.

✓ KPI Monitoring berjalan.

✓ Report dapat di-export.

✓ Seluruh Analytics bersifat Read Only.

✓ Dokumentasi diperbarui.

---

# End of Document