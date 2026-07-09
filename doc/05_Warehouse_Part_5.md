# UtiFarm
# 05_Warehouse
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
- 05_Warehouse_Part_1.md
- 05_Warehouse_Part_2.md
- 05_Warehouse_Part_3.md
- 05_Warehouse_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan aturan implementasi dan Business Engine untuk modul Warehouse.

Warehouse menggunakan pendekatan Inventory Management System (IMS) berbasis Inventory Movement sebagai sumber data utama.

Seluruh perubahan stok harus dilakukan melalui Business Engine.

---

# 2. Business Engine

Flow implementasi:

REST API

↓

Controller

↓

Service

↓

Repository

↓

Inventory Movement

↓

Current Stock Update

↓

Activity

↓

Dashboard

↓

Audit Trail

Controller tidak diperbolehkan memiliki Business Logic.

---

# 3. Inventory Principles

Prinsip utama:

- Inventory Movement adalah Source of Truth.
- Current Stock merupakan hasil agregasi Movement.
- Stock Card merupakan tampilan ledger.
- Seluruh perubahan stok harus dapat ditelusuri.

---

# 4. Movement Lifecycle

Draft

↓

Validated

↓

Posted

↓

Completed

↓

Archived

Movement yang telah berstatus Posted tidak boleh diubah.

---

# 5. Stock In Process

Stock In digunakan untuk:

- Initial Stock
- Receiving
- Purchase
- Return

Business Flow:

Validation

↓

Create Inventory Movement

↓

Update Current Stock

↓

Create Activity

↓

Audit Trail

↓

Dashboard Refresh

---

# 6. Stock Out Process

Stock Out digunakan untuk:

- Feeding
- Treatment
- Operational Usage

Business Flow:

Validation

↓

Check Available Stock

↓

Create Inventory Movement

↓

Update Current Stock

↓

Create Activity

↓

Dashboard Refresh

Jika stok tidak mencukupi, transaksi ditolak.

---

# 7. Transfer Process

Transfer terdiri dari dua transaksi:

Transfer Out

↓

Transfer In

Kedua transaksi harus berada dalam satu DB Transaction.

---

# 8. Adjustment Process

Adjustment hanya digunakan apabila terjadi:

- Koreksi stok
- Kerusakan
- Kehilangan
- Selisih opname

Adjustment wajib memiliki alasan yang terdokumentasi.

---

# 9. Stock Opname Process

Flow:

Buat Opname

↓

Hitung Fisik

↓

Bandingkan dengan Sistem

↓

Selisih

↓

Adjustment

↓

Selesai

Stock Opname tidak mengubah stok secara langsung.

Perubahan dilakukan melalui Adjustment.

---

# 10. Batch Management

Batch digunakan untuk:

- Feed
- Medicine
- Vitamin
- Chemical

Setiap transaksi wajib mempertahankan hubungan dengan Batch.

---

# 11. Expired Management

Item dengan status Expired:

- Tidak dapat digunakan untuk Stock Out.
- Tetap tersedia pada histori.
- Dapat diproses melalui Disposal (Future).

---

# 12. Stock Calculation

Current Stock dihitung berdasarkan:

Total Stock In

-

Total Stock Out

+

Adjustment Plus

-

Adjustment Minus

Perhitungan dilakukan oleh Service Layer.

---

# 13. Available Stock Formula

Available Stock

=

Current Stock

-

Reserved Stock

Reserved Stock disiapkan untuk pengembangan fitur Reservation di masa depan.

---

# 14. Stock Card Engine

Stock Card dihasilkan dari:

Inventory Movement

berdasarkan:

- Item
- Warehouse
- Batch
- Periode

Stock Card bersifat Read Only.

---

# 15. FIFO Rule

Versi MVP menggunakan:

FIFO (First In First Out)

Batch yang lebih lama digunakan terlebih dahulu.

---

# 16. FEFO Ready

Arsitektur harus mendukung:

FEFO

(First Expired First Out)

Tanpa perubahan struktur database.

---

# 17. Activity Integration

Setiap Inventory Movement wajib membuat Activity.

Contoh:

Stock In

↓

Activity

Stock Out

↓

Activity

Transfer

↓

Activity

Adjustment

↓

Activity

---

# 18. Dashboard Integration

Dashboard diperbarui setelah:

- Stock In
- Stock Out
- Transfer
- Adjustment
- Stock Opname

Dashboard tidak menghitung stok secara langsung.

Dashboard membaca Current Stock.

---

# 19. Finance Integration

Warehouse menyediakan data:

- Quantity
- Unit Cost
- Total Cost

Finance menggunakan data tersebut untuk:

- Inventory Valuation
- Cost of Goods
- Operational Cost

---

# 20. Reference Engine

Setiap Movement wajib memiliki:

Reference Type

Reference UUID

Contoh:

Receiving

Feeding

Treatment

Harvest

Adjustment

Stock Opname

---

# 21. Exception Handling

Gunakan Custom Exception.

Contoh:

- StockNotAvailableException
- InvalidBatchException
- ExpiredItemException
- InvalidWarehouseException
- InvalidTransferException

---

# 22. Database Transaction

Gunakan DB::transaction() untuk:

- Stock In
- Stock Out
- Transfer
- Adjustment
- Stock Opname Approval

Rollback apabila salah satu proses gagal.

---

# 23. Performance Rules

Gunakan:

- Eager Loading
- Composite Index
- Cache Current Stock
- Background Job (Analytics)
- Optimized Query

Hindari Query N+1.

---

# 24. Security Rules

Warehouse harus menerapkan:

- Authentication
- Authorization
- Audit Trail
- Role Based Access Control (RBAC)

Movement yang telah Posted tidak dapat diubah oleh pengguna biasa.

---

# 25. Business Rules

- Current Stock tidak boleh negatif.
- Movement wajib memiliki Warehouse.
- Movement wajib memiliki User.
- Batch Expired tidak dapat digunakan.
- Stock Adjustment wajib memiliki alasan.
- Transfer menghasilkan dua Movement.
- Movement yang telah Posted tidak boleh dihapus.

---

# 26. Acceptance Criteria

Business Engine dianggap selesai apabila:

✓ Stock In berjalan.

✓ Stock Out berjalan.

✓ Transfer berjalan.

✓ Adjustment berjalan.

✓ Stock Opname berjalan.

✓ Current Stock diperbarui otomatis.

✓ Activity tercatat.

✓ Dashboard diperbarui.

✓ Finance menerima data biaya.

---

# 27. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan DB Transaction.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Menggunakan Inventory Movement sebagai Source of Truth.
- Tidak memperbarui Current Stock secara manual.
- Menghasilkan implementasi production-ready.

---

# 28. Deliverables

Backend

- Migration
- Model
- Repository
- Service
- Controller
- Form Request
- Resource
- Policy
- Feature Test

Frontend

- Inventory Dashboard
- Stock Card
- Inventory Movement
- Stock In
- Stock Out
- Transfer
- Adjustment
- Stock Opname

---

# 29. Definition of Done

Modul Warehouse dinyatakan selesai apabila:

- Seluruh Inventory Movement berjalan.
- Current Stock selalu konsisten.
- Stock Card dapat ditampilkan.
- Batch Management berjalan.
- FIFO diterapkan.
- Integrasi Activities berjalan.
- Integrasi Finance berjalan.
- Dashboard menampilkan data terbaru.
- Seluruh pengujian utama lulus.
- Dokumentasi diperbarui.

---

# End of Document