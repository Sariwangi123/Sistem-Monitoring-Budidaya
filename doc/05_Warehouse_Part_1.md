# UtiFarm
# 05_Warehouse
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

---

# 1. Purpose

Modul Warehouse merupakan Inventory Management System (IMS) yang mengelola seluruh persediaan pada UtiFarm.

Warehouse tidak hanya menyimpan informasi stok, tetapi juga mengelola seluruh siklus pergerakan barang mulai dari penerimaan hingga penggunaan.

Semua perubahan stok harus dapat ditelusuri (traceable).

---

# 2. Objective

Tujuan modul Warehouse:

- Mengelola persediaan.
- Mengontrol stok.
- Mencatat seluruh pergerakan barang.
- Mengurangi kehilangan stok.
- Mendukung operasional budidaya.
- Menjadi sumber data Finance.
- Menjadi sumber data Dashboard.

---

# 3. Scope

Warehouse mencakup:

- Warehouse
- Storage Location
- Inventory Item
- Batch
- Lot Number
- Expired Date
- Stock In
- Stock Out
- Stock Transfer
- Stock Adjustment
- Stock Opname
- Inventory Movement
- Stock Card

---

# 4. Business Process

Supplier

↓

Receiving

↓

Warehouse

↓

Storage Location

↓

Available Stock

↓

Operational Usage

↓

Activities

↓

Culture Cycle

↓

Harvest

↓

Finance

↓

Report

---

# 5. Inventory Lifecycle

Purchase

↓

Receiving

↓

Inspection

↓

Available

↓

Reserved (Future)

↓

Issued

↓

Consumed

↓

Closed

---

# 6. Actors

- Super Admin
- Farm Owner
- Farm Manager
- Warehouse Staff
- Technician
- Finance Staff
- Viewer

---

# 7. Dependency

Warehouse membutuhkan data dari:

Company

↓

Farm

↓

Warehouse

↓

Supplier

↓

Item Category

↓

Item

↓

Unit

↓

Culture Cycle

↓

Activities

---

# 8. Inventory Categories

Kategori Inventory:

- Feed
- Medicine
- Vitamin
- Probiotic
- Chemical
- Equipment
- Spare Part
- Laboratory
- Packaging
- Office Supply

Kategori dapat ditambahkan tanpa mengubah struktur sistem.

---

# 9. Inventory Flow

Receiving

↓

Quality Check

↓

Warehouse

↓

Storage

↓

Stock Movement

↓

Consumption

↓

Stock Adjustment

↓

Stock Opname

↓

Archive

---

# 10. Business Event Matrix

| Event | Trigger | Source | Target |
|--------|----------|---------|----------|
| Receiving | Barang diterima | Warehouse | Activities |
| Stock In | Barang masuk | Warehouse | Dashboard |
| Stock Out | Barang digunakan | Warehouse | Activities |
| Feed Issued | Feeding dilakukan | Culture Cycle | Warehouse |
| Medicine Issued | Treatment dilakukan | Culture Cycle | Warehouse |
| Transfer | Pindah lokasi | Warehouse | Activities |
| Stock Adjustment | Koreksi stok | Warehouse | Activities |
| Stock Opname | Opname selesai | Warehouse | Dashboard |

---

# 11. Warehouse Rules

- Setiap Item memiliki Unit.
- Setiap Item memiliki Category.
- Setiap transaksi memiliki Warehouse.
- Setiap transaksi memiliki User.
- Seluruh perubahan stok harus menghasilkan Movement History.
- Seluruh perubahan stok harus menghasilkan Activity.

---

# 12. Stock Movement

Jenis pergerakan stok:

- Stock In
- Stock Out
- Transfer
- Adjustment
- Opname
- Return (Future)
- Disposal (Future)

Movement History tidak boleh dihapus.

---

# 13. Batch & Lot Tracking

Inventory dapat menggunakan:

- Batch Number
- Lot Number
- Production Date
- Expired Date

Fitur ini wajib tersedia untuk:

- Feed
- Medicine
- Vitamin
- Chemical

---

# 14. Traceability

Setiap penggunaan inventory harus dapat ditelusuri.

Contoh:

Feed

↓

Stock Out

↓

Culture Cycle

↓

Feeding

↓

Harvest

↓

Report

Seluruh histori harus tetap tersedia.

---

# 15. Integration

Warehouse terintegrasi dengan:

Activities

↓

Culture Cycle

↓

Harvest

↓

Finance

↓

Dashboard

↓

Report Analytics

---

# 16. Business Rules

- Stock tidak boleh bernilai negatif.
- Stock Out hanya diperbolehkan apabila stok mencukupi.
- Stock Adjustment wajib memiliki alasan.
- Stock Opname wajib menghasilkan Adjustment apabila terdapat selisih.
- Batch yang telah habis tetap disimpan sebagai histori.
- Item kedaluwarsa tidak boleh digunakan untuk transaksi baru.

---

# 17. Inventory Principles

Warehouse menggunakan prinsip:

- FIFO (First In First Out)

Sistem harus dirancang agar dapat mendukung:

- FEFO (First Expired First Out)

di masa depan tanpa perubahan arsitektur besar.

---

# 18. Acceptance Criteria

Warehouse dianggap memenuhi spesifikasi apabila:

✓ Stock dapat dikelola.

✓ Seluruh Movement tercatat.

✓ Stock Card tersedia.

✓ Batch Tracking berjalan.

✓ Integrasi Activities berjalan.

✓ Integrasi Culture Cycle berjalan.

✓ Dashboard menerima pembaruan.

---

# 19. AI Coding Instructions

AI Coding Assistant wajib:

- Menganggap Warehouse sebagai Inventory Management System.
- Tidak memperlakukan Warehouse sebagai penyimpanan stok sederhana.
- Selalu mencatat Inventory Movement.
- Selalu membuat Activity untuk setiap perubahan stok.
- Mengikuti Business Rules.
- Menghasilkan implementasi production-ready.

---

# 20. Deliverables

Dokumen berikutnya:

05_Warehouse_Part_2.md

Membahas:

- Database Design
- Entity Relationship
- Warehouse Structure
- Inventory Structure
- Stock Card
- Movement History
- Constraint
- Migration Rules

---

# End of Document