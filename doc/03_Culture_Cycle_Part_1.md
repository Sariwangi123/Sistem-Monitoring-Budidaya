# UtiFarm
# 03_Culture_Cycle
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
- 01_Milestone_Foundation.md
- 02_Master_Data

---

# 1. Purpose

Dokumen ini mendefinisikan proses bisnis (Business Process) modul Culture Cycle.

Culture Cycle merupakan inti dari aplikasi UtiFarm yang mengelola seluruh proses budidaya ikan mulai dari persiapan kolam hingga panen selesai.

Seluruh modul lain seperti Activities, Warehouse, Harvest, Finance, Dashboard, dan Report bergantung pada data Culture Cycle.

---

# 2. Objective

Tujuan modul ini adalah:

- Mengelola satu siklus budidaya ikan.
- Menyimpan seluruh histori budidaya.
- Menghasilkan data produksi.
- Menjadi dasar perhitungan KPI budidaya.
- Menjadi sumber data Dashboard dan Laporan.

---

# 3. Business Process

Satu Culture Cycle memiliki alur berikut.

Preparation

↓

Stocking (Tebar Benih)

↓

Acclimatization

↓

Daily Operation

↓

Water Quality Monitoring

↓

Sampling

↓

Growth Monitoring

↓

Feed Management

↓

Treatment

↓

Partial Harvest (Optional)

↓

Final Harvest

↓

Cycle Closed

---

# 4. Scope

Modul ini mencakup:

- Persiapan Budidaya
- Tebar Benih
- Manajemen Siklus
- Monitoring Pertumbuhan
- Monitoring Biomassa
- Mortalitas
- Feeding Summary
- Water Quality Summary
- Treatment Summary
- Penutupan Siklus

---

# 5. Actors

Super Admin

Farm Owner

Farm Manager

Technician

Viewer

---

# 6. Dependency

Culture Cycle membutuhkan data dari:

Company

↓

Farm

↓

Pond Area

↓

Pond

↓

Fish Species

↓

Fish Strain

↓

Supplier

↓

Feed

↓

Warehouse

↓

Employee

---

# 7. State Machine

Status Culture Cycle.

Draft

↓

Prepared

↓

Stocked

↓

Running

↓

Harvesting

↓

Completed

↓

Archived

Status tidak boleh melompati tahapan.

Contoh yang tidak diperbolehkan:

Draft

↓

Completed

---

# 8. Lifecycle Rules

Setiap Pond hanya boleh memiliki satu Culture Cycle yang aktif.

Culture Cycle baru hanya dapat dibuat apabila:

- Pond tersedia.
- Tidak ada Culture Cycle aktif.
- Persiapan kolam telah selesai.

---

# 9. Stocking Rules

Saat Tebar Benih wajib mencatat:

- Tanggal Tebar
- Pond
- Jenis Ikan
- Strain
- Supplier
- Batch Benih
- Jumlah Benih
- Berat Awal
- Ukuran Benih

Setelah Tebar Benih, status berubah menjadi:

Running

---

# 10. Daily Operation

Selama status Running, sistem menerima data:

- Feeding
- Water Quality
- Sampling
- Mortalitas
- Treatment
- Catatan Harian

Semua aktivitas harus memiliki referensi ke Culture Cycle.

---

# 11. Biomass Rules

Biomassa dihitung berdasarkan:

- Jumlah ikan hidup
- Berat rata-rata

Biomassa diperbarui setiap Sampling.

---

# 12. Growth Monitoring

Growth dihitung berdasarkan data Sampling.

Parameter:

- Average Weight
- Weight Gain
- ADG (Average Daily Gain)
- Growth Trend

---

# 13. Feed Management

Feed digunakan berdasarkan:

- Jadwal Feeding
- Jenis Feed
- Jumlah Feed

Penggunaan Feed otomatis mengurangi stok Warehouse.

---

# 14. Mortality Rules

Setiap Mortalitas wajib mencatat:

- Tanggal
- Jumlah Mati
- Penyebab
- Catatan

Jumlah ikan hidup diperbarui otomatis.

---

# 15. Water Quality Rules

Parameter minimal:

- Suhu
- pH
- DO
- Amonia
- Nitrit

Semua parameter memiliki satuan yang konsisten.

---

# 16. Treatment Rules

Treatment wajib memiliki:

- Tanggal
- Jenis Treatment
- Produk
- Dosis
- Alasan
- Pelaksana

---

# 17. Harvest Rules

Partial Harvest:

- Tidak menutup Culture Cycle.

Final Harvest:

- Menutup Culture Cycle.
- Mengubah status menjadi Completed.
- Pond kembali tersedia.

---

# 18. KPI Generated

Culture Cycle menghasilkan KPI:

- Biomassa
- Survival Rate
- FCR
- ADG
- Feed Consumption
- Mortalitas
- Lama Budidaya
- Total Produksi

---

# 19. Integration

Modul ini terintegrasi dengan:

Activities

Warehouse

Harvest

Finance

Dashboard

Report Analytics

---

# 20. Business Rules

- Satu Pond hanya memiliki satu Culture Cycle aktif.
- Semua aktivitas harus mengacu pada Culture Cycle.
- Tidak boleh menghapus Culture Cycle yang memiliki transaksi.
- Semua perubahan harus tercatat dalam Audit Trail.
- Cycle yang sudah Completed tidak dapat diedit kecuali oleh Super Admin.

---

# 21. Deliverables

Dokumen berikutnya:

03_Culture_Cycle_Part_2.md

Membahas:

- Database Design
- Entity Relationship
- Table Structure
- Foreign Key
- Constraint
- Migration Rules

---

# 22. AI Coding Instructions

AI Coding Assistant wajib:

- Mengikuti seluruh Business Rules.
- Tidak membuat lebih dari satu Culture Cycle aktif pada Pond yang sama.
- Tidak membuat transaksi di luar Culture Cycle.
- Menggunakan status sesuai State Machine.
- Menjaga integritas data antar modul.
- Mengimplementasikan kode yang production-ready.

---

# End of Document