# UtiFarm
# 05_Warehouse
## Part 2 - Database Design

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Business_Rules.md
- 00_Database_Convention.md
- 00_API_Convention.md
- 00_Coding_Convention.md
- 00_Project_Structure.md
- 05_Warehouse_Part_1.md

---

# 1. Purpose

Dokumen ini mendefinisikan struktur database untuk modul Warehouse.

Warehouse menggunakan konsep Inventory Management System (IMS).

Seluruh perubahan inventory harus dapat ditelusuri melalui Inventory Movement.

---

# 2. Database Principles

Seluruh tabel wajib menggunakan:

- UUID
- Soft Delete
- Audit Trail
- Timestamp
- Foreign Key
- Index

---

# 3. Inventory Philosophy

Warehouse menggunakan prinsip:

Inventory Movement

↓

Stock Card

↓

Current Stock

Movement History menjadi sumber data utama.

Current Stock merupakan hasil agregasi Movement.

---

# 4. Main Entities

Entity utama:

Warehouse

↓

Warehouse Location

↓

Inventory Item

↓

Inventory Stock

↓

Inventory Batch

↓

Inventory Movement

↓

Stock Card

↓

Stock Opname

---

# 5. Entity Relationship

Company

↓

Farm

↓

Warehouse

↓

Warehouse Location

↓

Inventory Item

↓

Inventory Batch

↓

Inventory Movement

↓

Inventory Stock

↓

Stock Opname

---

# 6. Table : warehouses

Deskripsi

Master Warehouse.

Field

warehouse_code

warehouse_name

farm_id

description

status

---

# 7. Table : warehouse_locations

Deskripsi

Lokasi penyimpanan dalam Warehouse.

Field

warehouse_id

location_code

location_name

description

status

---

# 8. Table : inventory_items

Deskripsi

Master inventory.

Relationship

item_category_id

unit_id

supplier_id

Field

item_code

item_name

brand

specification

minimum_stock

maximum_stock

reorder_level

status

---

# 9. Table : inventory_batches

Relationship

inventory_item_id

warehouse_location_id

Field

batch_number

lot_number

production_date

expired_date

received_date

status

---

# 10. Table : inventory_movements

Deskripsi

Ledger seluruh transaksi inventory.

Relationship

inventory_item_id

warehouse_id

warehouse_location_id

batch_id

culture_cycle_id

activity_id

user_id

Field

movement_number

movement_type

movement_date

quantity

unit_cost

total_cost

reference_type

reference_uuid

notes

---

# 11. Movement Types

Movement Type:

- Stock In
- Stock Out
- Transfer In
- Transfer Out
- Adjustment Plus
- Adjustment Minus
- Stock Opname
- Return
- Disposal

---

# 12. Table : inventory_stocks

Deskripsi

Ringkasan stok saat ini.

Relationship

inventory_item_id

warehouse_location_id

batch_id

Field

current_quantity

reserved_quantity

available_quantity

last_movement_at

Catatan:

Nilai tabel ini diperbarui otomatis berdasarkan Inventory Movement.

---

# 13. Table : stock_opnames

Relationship

warehouse_id

user_id

Field

opname_number

opname_date

status

notes

---

# 14. Table : stock_opname_details

Relationship

stock_opname_id

inventory_item_id

batch_id

Field

system_quantity

physical_quantity

difference_quantity

adjustment_required

notes

---

# 15. Stock Card

Stock Card merupakan tampilan dari:

Inventory Movement

berdasarkan:

- Item
- Batch
- Warehouse
- Periode

Stock Card tidak memiliki tabel terpisah.

Stock Card dihasilkan dari query terhadap Inventory Movement.

---

# 16. Reference Rules

reference_type

Contoh:

Receiving

Culture Cycle

Feeding

Treatment

Transfer

Harvest

Adjustment

Stock Opname

reference_uuid

UUID transaksi asal.

---

# 17. Constraint Rules

- Stock tidak boleh negatif.
- Batch wajib mengikuti Item.
- Movement wajib memiliki Warehouse.
- Stock hanya diperbarui melalui Movement.
- Stock Opname menghasilkan Adjustment apabila terdapat selisih.

---

# 18. Index Strategy

Index wajib dibuat pada:

uuid

movement_number

movement_date

inventory_item_id

warehouse_id

batch_id

reference_uuid

created_at

deleted_at

---

# 19. Performance Strategy

Gunakan:

- Composite Index
- Server Side Search
- Server Side Pagination
- Eager Loading
- Optimized Query

Current Stock dapat menggunakan cache apabila diperlukan.

---

# 20. Migration Order

warehouses

↓

warehouse_locations

↓

inventory_items

↓

inventory_batches

↓

inventory_movements

↓

inventory_stocks

↓

stock_opnames

↓

stock_opname_details

---

# 21. Seeder

Minimal Seeder:

Warehouse

Warehouse Location

Movement Type

Inventory Category

---

# 22. Factory

Factory digunakan untuk:

- Testing
- Dummy Stock
- Dummy Movement
- Performance Testing

---

# 23. Business Constraint

- Inventory Movement tidak boleh dihapus.
- Current Stock tidak boleh diedit manual.
- Batch kedaluwarsa tetap disimpan sebagai histori.
- Adjustment wajib memiliki alasan.
- Transfer menghasilkan dua Movement (Out dan In).

---

# 24. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Inventory Movement sebagai sumber data utama.
- Tidak memperbarui Current Stock secara manual.
- Menggunakan DB Transaction pada seluruh proses Inventory.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Menggunakan Eloquent Relationship.
- Menghasilkan implementasi production-ready.

---

# 25. Deliverables

Implementasi harus menghasilkan:

✔ Migration

✔ Model

✔ Relationship

✔ Factory

✔ Seeder

✔ Repository

✔ Service

✔ Policy

---

# End of Document