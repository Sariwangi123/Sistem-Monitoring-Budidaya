# UtiFarm
# 06_Harvest
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

---

# 1. Purpose

Harvest merupakan Harvest Management System (HMS) yang mengelola seluruh proses panen ikan mulai dari perencanaan panen hingga hasil panen diterima sebagai dasar pencatatan keuangan.

Harvest menjadi tahap akhir dari Culture Cycle dan sumber utama data produksi.

Seluruh proses panen harus dapat ditelusuri (traceable).

---

# 2. Objective

Tujuan modul Harvest:

- Mengelola proses panen.
- Mengelola Partial Harvest.
- Mengelola Final Harvest.
- Mengelola Grading hasil panen.
- Mengelola Quality Control.
- Menghasilkan data produksi.
- Menjadi sumber data Finance.
- Menjadi sumber Dashboard.
- Menjadi sumber Report Analytics.

---

# 3. Scope

Modul Harvest mencakup:

- Harvest Planning
- Harvest Preparation
- Harvest Execution
- Partial Harvest
- Final Harvest
- Harvest Batch
- Quality Control
- Grading
- Packing
- Delivery
- Harvest Summary
- Yield Analysis

---

# 4. Business Process

Culture Cycle

↓

Harvest Planning

↓

Harvest Preparation

↓

Harvest Execution

↓

Quality Control

↓

Grading

↓

Packing

↓

Delivery

↓

Finance

↓

Report

---

# 5. Harvest Lifecycle

Planning

↓

Scheduled

↓

Ready

↓

Harvesting

↓

Completed

↓

Closed

---

# 6. Actors

- Super Admin
- Farm Owner
- Farm Manager
- Technician
- Quality Control
- Warehouse Staff
- Finance Staff
- Viewer

---

# 7. Dependency

Harvest membutuhkan data dari:

Company

↓

Farm

↓

Pond

↓

Culture Cycle

↓

Activities

↓

Warehouse

↓

Customer

---

# 8. Harvest Types

Jenis Panen:

- Partial Harvest
- Final Harvest
- Emergency Harvest

Jenis panen dapat dikembangkan tanpa mengubah arsitektur utama.

---

# 9. Harvest Batch

Setiap panen menghasilkan Harvest Batch.

Contoh:

Culture Cycle A

↓

Harvest Batch HV-001

↓

Grade A

↓

Grade B

↓

Grade C

Harvest Batch menjadi referensi utama seluruh transaksi panen.

---

# 10. Business Event Matrix

| Event | Trigger | Source | Target |
|--------|----------|---------|----------|
| Harvest Planning | Jadwal dibuat | Harvest | Activities |
| Harvest Started | Panen dimulai | Harvest | Activities |
| Partial Harvest | Panen sebagian | Harvest | Culture Cycle |
| Final Harvest | Panen selesai | Harvest | Finance |
| Grading Completed | QC selesai | Harvest | Dashboard |
| Packing Completed | Packing selesai | Harvest | Activities |
| Delivery Completed | Barang dikirim | Harvest | Finance |

---

# 11. Harvest Rules

- Setiap Harvest wajib memiliki Culture Cycle.
- Setiap Harvest wajib memiliki Harvest Batch.
- Setiap Harvest wajib memiliki tanggal panen.
- Setiap Harvest wajib memiliki penanggung jawab.
- Seluruh proses panen harus menghasilkan Activity.
- Final Harvest menutup Culture Cycle.

---

# 12. Quality Control

QC dilakukan terhadap hasil panen.

Parameter minimal:

- Berat rata-rata
- Ukuran
- Kondisi ikan
- Tingkat kerusakan
- Catatan QC

---

# 13. Grading

Hasil panen dapat dibagi menjadi beberapa Grade.

Contoh:

Grade A

Grade B

Grade C

Grade BS

Jumlah seluruh Grade harus sama dengan total hasil panen.

---

# 14. Packing

Packing mencatat:

- Tanggal
- Jenis Kemasan
- Jumlah Kemasan
- Berat Bersih
- Berat Kotor
- Operator

---

# 15. Delivery

Delivery mencatat:

- Customer
- Kendaraan
- Driver
- Tanggal Pengiriman
- Nomor Dokumen
- Status Pengiriman

---

# 16. Integration

Harvest terintegrasi dengan:

Activities

↓

Culture Cycle

↓

Warehouse

↓

Finance

↓

Dashboard

↓

Report Analytics

---

# 17. Business Rules

- Partial Harvest tidak menutup Culture Cycle.
- Final Harvest wajib menutup Culture Cycle.
- Seluruh hasil panen harus memiliki Grade.
- Packing dilakukan setelah Grading.
- Delivery dilakukan setelah Packing.
- Seluruh perubahan status harus tercatat pada Activity.

---

# 18. Yield Analysis

Harvest menghasilkan informasi:

- Total Harvest Weight
- Average Weight
- Harvest Duration
- Survival Rate
- Feed Conversion Ratio (FCR)
- Average Daily Gain (ADG)
- Total Production

Yield Analysis digunakan sebagai evaluasi satu Culture Cycle.

---

# 19. Acceptance Criteria

Harvest dianggap memenuhi spesifikasi apabila:

✓ Harvest Planning berjalan.

✓ Harvest Execution berjalan.

✓ Partial Harvest berjalan.

✓ Final Harvest berjalan.

✓ Grading berjalan.

✓ Packing berjalan.

✓ Delivery berjalan.

✓ Integrasi Finance berjalan.

✓ Dashboard menerima data panen.

---

# 20. AI Coding Instructions

AI Coding Assistant wajib:

- Menganggap Harvest sebagai Harvest Management System.
- Menggunakan Harvest Batch sebagai identitas bisnis.
- Tidak melakukan Final Harvest sebelum seluruh validasi terpenuhi.
- Menghasilkan Activity untuk setiap proses panen.
- Mengikuti seluruh Business Rules.
- Menghasilkan implementasi production-ready.

---

# 21. Deliverables

Dokumen berikutnya:

06_Harvest_Part_2.md

Membahas:

- Database Design
- Entity Relationship
- Harvest Batch
- Harvest Detail
- Grading
- Packing
- Delivery
- Constraint
- Migration Rules

---

# End of Document