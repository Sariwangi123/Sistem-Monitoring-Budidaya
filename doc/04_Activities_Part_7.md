# UtiFarm
# 04_Activities
## Part 7 - Operational Intelligence & Analytics

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
- 03_Culture_Cycle
- 04_Activities_Part_1.md
- 04_Activities_Part_2.md
- 04_Activities_Part_3.md
- 04_Activities_Part_4.md
- 04_Activities_Part_5.md
- 04_Activities_Part_6.md

---

# 1. Purpose

Dokumen ini mendefinisikan Operational Intelligence dan Analytics pada modul Activities.

Tujuannya adalah mengubah data aktivitas menjadi informasi yang berguna untuk pengambilan keputusan.

Analytics tidak mengubah data operasional.

Analytics hanya membaca data yang telah tersedia.

---

# 2. Objective

Analytics digunakan untuk:

- Monitoring
- Evaluation
- Productivity Analysis
- Operational Analysis
- Trend Analysis
- Decision Support

---

# 3. Data Sources

Analytics membaca data dari:

Activities

↓

Culture Cycle

↓

Warehouse

↓

Harvest

↓

Finance

↓

Master Data

---

# 4. Analytics Categories

Analytics dibagi menjadi:

- Operational
- Productivity
- Water Quality
- Feeding
- Harvest
- Warehouse
- Finance
- User Performance

---

# 5. Operational Dashboard

Dashboard menampilkan:

- Total Activity
- Activity Today
- Activity This Week
- Activity This Month
- Pending Activity
- Completed Activity
- Critical Alert
- Reminder

---

# 6. Productivity Analytics

Hitung:

- Activity per User
- Activity per Farm
- Activity per Pond
- Activity per Culture Cycle
- Activity per Hari
- Activity per Bulan

---

# 7. Feeding Analytics

Tampilkan:

- Total Feeding
- Feed Consumption
- Feeding Frequency
- Feeding Trend
- Feed Efficiency

---

# 8. Water Quality Analytics

Parameter:

- Temperature Trend
- pH Trend
- DO Trend
- Ammonia Trend
- Nitrite Trend

Tampilkan dalam bentuk grafik.

---

# 9. Mortality Analytics

Hitung:

- Daily Mortality
- Weekly Mortality
- Monthly Mortality
- Mortality Rate
- Mortality Trend

---

# 10. Harvest Analytics

Tampilkan:

- Harvest Quantity
- Harvest Weight
- Harvest Value
- Harvest Trend
- Harvest Success Rate

---

# 11. User Performance

Hitung:

- Total Activity
- Activity by Category
- Average Activity per Day
- Productivity Score

---

# 12. Timeline Analytics

Analisis:

- Aktivitas per Jam
- Aktivitas per Hari
- Aktivitas per Minggu
- Aktivitas per Bulan

---

# 13. Event Analytics

Analisis berdasarkan:

Event Code

↓

Category

↓

Frequency

↓

Trend

↓

Status

---

# 14. Operational Heatmap

Heatmap menampilkan:

- Jam tersibuk
- Hari tersibuk
- Bulan tersibuk
- Area paling aktif

---

# 15. Comparative Analytics

Perbandingan:

Farm

vs

Farm

Culture Cycle

vs

Culture Cycle

Pond

vs

Pond

---

# 16. KPI Monitoring

Pantau KPI:

- Survival Rate
- Biomass
- ADG
- FCR
- Feed Consumption
- Harvest Rate

KPI berasal dari Culture Cycle.

Activities hanya menampilkan hasilnya.

---

# 17. Report Generation

Support:

- Daily Report
- Weekly Report
- Monthly Report
- Custom Report

Export:

- PDF
- Excel
- CSV

---

# 18. Drill Down

Seluruh grafik dapat dibuka menjadi detail.

Contoh:

Activity

↓

Daily Activity

↓

Activity Detail

↓

Reference Module

---

# 19. AI Ready

Analytics harus mendukung:

- AI Recommendation
- Predictive Analytics
- Smart Dashboard
- Smart Notification

Tanpa mengubah struktur database.

---

# 20. Future Analytics

Roadmap:

- Predictive Harvest
- Feed Recommendation
- Water Quality Prediction
- Disease Prediction
- Productivity Prediction

---

# 21. Performance Rules

Gunakan:

- Materialized View (jika diperlukan)
- Cache
- Background Job
- Aggregation Table (bila volume data besar)

Analytics tidak boleh mengganggu transaksi operasional.

---

# 22. Security Rules

Analytics mengikuti hak akses pengguna.

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

- Mengubah transaksi.
- Menghapus data.
- Mengubah KPI.

Analytics hanya membaca hasil transaksi.

---

# 24. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Query yang efisien.
- Menggunakan Cache untuk Dashboard.
- Menggunakan Pagination bila diperlukan.
- Menggunakan Background Job untuk proses agregasi.
- Tidak melakukan perhitungan berat pada setiap request.
- Menghasilkan implementasi yang scalable.

---

# 25. Deliverables

Backend

- Analytics Service
- Statistics Service
- Report Service
- Aggregation Job
- Cache Service

Frontend

- Dashboard Widget
- Analytics Page
- Trend Chart
- Heatmap
- Comparison Chart
- Export Report

---

# 26. Definition of Done

Operational Intelligence dianggap selesai apabila:

✓ Dashboard Analytics berjalan.

✓ Productivity Analytics berjalan.

✓ Timeline Analytics berjalan.

✓ Event Analytics berjalan.

✓ Heatmap tersedia.

✓ Comparative Analytics tersedia.

✓ Report dapat di-export.

✓ Seluruh Analytics bersifat Read Only.

✓ Dokumentasi diperbarui.

---

# End of Document