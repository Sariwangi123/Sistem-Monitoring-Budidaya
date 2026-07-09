# UtiFarm
# 03_Culture_Cycle
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
- 03_Culture_Cycle_Part_1.md
- 03_Culture_Cycle_Part_2.md
- 03_Culture_Cycle_Part_3.md
- 03_Culture_Cycle_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan aturan implementasi (Implementation Rules) dan Business Engine pada modul Culture Cycle.

Seluruh logika bisnis harus diimplementasikan pada Service Layer.

Controller tidak diperbolehkan memiliki Business Logic.

---

# 2. Business Engine

Seluruh proses budidaya dijalankan melalui Service Layer.

Flow:

REST API

↓

Controller

↓

Service

↓

Repository

↓

Database

---

# 3. State Machine

Status yang diperbolehkan:

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

Tidak diperbolehkan berpindah status secara langsung.

---

# 4. State Validation

Draft

↓

Prepare

↓

Prepared

Prepared

↓

Stocking

↓

Running

Running

↓

Partial Harvest

↓

Running

Running

↓

Final Harvest

↓

Harvesting

Harvesting

↓

Close Cycle

↓

Completed

Completed

↓

Archive

↓

Archived

---

# 5. Database Transaction

Seluruh proses berikut wajib menggunakan:

DB::transaction()

- Create Cycle
- Prepare Pond
- Stocking
- Sampling
- Feeding
- Mortality
- Water Quality
- Treatment
- Harvest
- Close Cycle

Apabila salah satu proses gagal maka seluruh transaksi harus di-Rollback.

---

# 6. Stocking Process

Saat Stocking berhasil:

- Update status menjadi Running.
- Simpan jumlah benih awal.
- Simpan berat awal.
- Simpan populasi awal.
- Membuat Activity Log.
- Membuat Audit Trail.

---

# 7. Sampling Process

Saat Sampling berhasil:

Hitung otomatis:

Average Weight

Biomass

ADG

Survival Rate

Growth Trend

Update KPI.

---

# 8. Biomass Formula

Biomassa

=

Jumlah Ikan Hidup

×

Berat Rata-rata

---

# 9. Survival Rate Formula

SR

=

(Jumlah Ikan Hidup

÷

Jumlah Benih Awal)

×

100%

---

# 10. ADG Formula

ADG

=

(Berat Saat Ini

-

Berat Sebelumnya)

÷

Jumlah Hari

---

# 11. Feed Consumption

Feed Consumption

=

Total Feed yang diberikan selama Culture Cycle.

Nilai dihitung otomatis.

---

# 12. FCR Formula

FCR

=

Total Feed

÷

Total Biomassa Panen

Perhitungan final dilakukan setelah panen selesai.

---

# 13. Water Quality Process

Setelah input Water Quality:

- Simpan histori.
- Refresh Dashboard.
- Simpan Activity Log.

Tidak mengubah KPI produksi.

---

# 14. Mortality Process

Saat Mortalitas dicatat:

- Kurangi Current Population.
- Hitung ulang Biomassa.
- Hitung ulang Survival Rate.
- Refresh KPI.

---

# 15. Feeding Process

Saat Feeding:

- Kurangi stok Warehouse.
- Tambahkan Feed Consumption.
- Simpan Activity.
- Refresh KPI.

---

# 16. Treatment Process

Treatment tidak mengubah:

- Biomassa
- Populasi

Treatment hanya mencatat histori.

---

# 17. Partial Harvest

Saat Partial Harvest:

- Kurangi Population.
- Kurangi Biomassa.
- Tambahkan Harvest History.
- Refresh KPI.

Status tetap:

Running.

---

# 18. Final Harvest

Saat Final Harvest:

- Kurangi seluruh Population.
- Simpan hasil panen.
- Hitung produksi akhir.
- Hitung FCR.
- Hitung Profit (Finance Module).
- Status menjadi Harvesting.

---

# 19. Close Cycle

Close hanya diperbolehkan apabila:

- Final Harvest selesai.
- Population = 0.
- Tidak ada transaksi tertunda.

Setelah berhasil:

Status menjadi Completed.

Pond menjadi Available.

---

# 20. Dashboard Integration

Setelah setiap transaksi berikut:

- Sampling
- Mortality
- Feeding
- Harvest

Dashboard harus memperbarui:

- Biomassa
- Population
- SR
- ADG
- Feed Consumption

---

# 21. Finance Integration

Saat Harvest:

Kirim data ke Finance:

- Total Produksi
- Harga Jual
- Nilai Penjualan

Finance menghitung:

Revenue

HPP

Profit

---

# 22. Warehouse Integration

Saat Feeding:

↓

Warehouse

↓

Reduce Stock

Saat Treatment:

↓

Warehouse

↓

Reduce Medicine Stock

---

# 23. Activity Log

Seluruh proses mencatat:

- User
- Tanggal
- Jam
- Aktivitas
- Culture Cycle

---

# 24. Audit Trail

Audit wajib mencatat:

- Data Lama
- Data Baru
- User
- Timestamp

---

# 25. Exception Handling

Business Exception:

- Pond masih aktif.
- Stok Feed tidak cukup.
- Status tidak valid.
- Sampling belum diperbolehkan.
- Harvest belum diperbolehkan.

Gunakan Custom Exception.

---

# 26. Performance Rules

Gunakan:

- Eager Loading
- Pagination
- Cache (Dashboard)
- Optimized Query

Hindari Query N+1.

---

# 27. Acceptance Criteria

Modul dianggap selesai apabila:

✓ Create Cycle berjalan.

✓ Prepare Pond berjalan.

✓ Stocking berjalan.

✓ Sampling berjalan.

✓ Feeding berjalan.

✓ Water Quality berjalan.

✓ Mortality berjalan.

✓ Treatment berjalan.

✓ Partial Harvest berjalan.

✓ Final Harvest berjalan.

✓ Close Cycle berjalan.

✓ Dashboard Update berjalan.

✓ Warehouse Update berjalan.

✓ Finance Integration berjalan.

---

# 28. AI Coding Instructions

AI Coding Assistant wajib:

- Mengikuti State Machine.
- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan DB Transaction.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Mengimplementasikan seluruh rumus KPI sesuai dokumen.
- Tidak menyimpan nilai KPI secara manual apabila dapat dihitung dari data transaksi.
- Menghasilkan kode yang production-ready.

---

# 29. Deliverables

Implementasi harus menghasilkan:

Backend

- Migration
- Model
- Repository
- Service
- Controller
- Request
- Resource
- Policy
- Feature Test

Frontend

- List Page
- Detail Page
- KPI Dashboard
- Timeline
- Wizard
- CRUD
- Business Action
- Chart
- Responsive Layout

---

# 30. Definition of Done

Culture Cycle dinyatakan selesai apabila:

- Seluruh Business Rules telah diterapkan.
- Seluruh REST API berfungsi.
- Frontend sesuai UI Specification.
- KPI dihitung otomatis.
- Integrasi Warehouse berjalan.
- Integrasi Harvest berjalan.
- Integrasi Finance berjalan.
- Dashboard menampilkan data terbaru.
- Seluruh testing utama lulus.
- Dokumentasi diperbarui.

---

# End of Document