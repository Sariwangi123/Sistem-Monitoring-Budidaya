# UtiFarm
# 05_Warehouse
## Part 3 - REST API Specification

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
- 05_Warehouse_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk modul Warehouse.

Warehouse menggunakan pendekatan Inventory Management System (IMS).

Seluruh perubahan stok dilakukan melalui Inventory Movement.

API mengikuti standar pada:

00_API_Convention.md

---

# 2. Base URL

/api/v1

---

# 3. Authentication

Seluruh endpoint menggunakan:

Bearer Token

Laravel Sanctum.

---

# 4. Authorization

Role:

- Super Admin
- Farm Owner
- Farm Manager
- Warehouse Staff
- Finance Staff

Viewer hanya memiliki akses GET.

---

# 5. Master Endpoint

Warehouse

GET

/warehouses

List Warehouse.

---

GET

/warehouses/{uuid}

Detail Warehouse.

---

POST

/warehouses

Create Warehouse.

---

PUT

/warehouses/{uuid}

Update Warehouse.

---

DELETE

/warehouses/{uuid}

Soft Delete.

---

# 6. Warehouse Location Endpoint

GET

/warehouse-locations

POST

/warehouse-locations

PUT

/warehouse-locations/{uuid}

DELETE

/warehouse-locations/{uuid}

---

# 7. Inventory Item Endpoint

GET

/inventory-items

GET

/inventory-items/{uuid}

POST

/inventory-items

PUT

/inventory-items/{uuid}

DELETE

/inventory-items/{uuid}

---

# 8. Current Stock Endpoint

GET

/current-stock

Menampilkan stok terkini.

---

GET

/current-stock/{item_uuid}

Detail stok suatu item.

---

GET

/current-stock/warehouse/{warehouse_uuid}

Stok berdasarkan Warehouse.

---

GET

/current-stock/location/{location_uuid}

Stok berdasarkan Location.

---

# 9. Inventory Movement Endpoint

GET

/inventory-movements

Daftar seluruh Movement.

---

GET

/inventory-movements/{uuid}

Detail Movement.

---

# 10. Stock In

POST

/inventory/stock-in

Digunakan untuk:

- Receiving
- Purchase
- Return
- Initial Stock

Output

- Inventory Movement
- Current Stock Update
- Activity

---

# 11. Stock Out

POST

/inventory/stock-out

Digunakan untuk:

- Feeding
- Treatment
- Operational Usage

Output

- Inventory Movement
- Current Stock Update
- Activity

---

# 12. Stock Transfer

POST

/inventory/transfer

Transfer antar Warehouse.

Output

- Transfer Out
- Transfer In
- Movement History

---

# 13. Stock Adjustment

POST

/inventory/adjustment

Digunakan apabila terjadi:

- Selisih
- Kerusakan
- Koreksi

Adjustment wajib memiliki alasan.

---

# 14. Stock Opname

POST

/inventory/stock-opname

Membuat Stock Opname.

---

POST

/inventory/stock-opname/{uuid}/submit

Submit hasil Opname.

---

POST

/inventory/stock-opname/{uuid}/approve

Approve Opname.

---

# 15. Batch Endpoint

GET

/inventory/batches

GET

/inventory/batches/{uuid}

---

GET

/inventory/batches/expired

Menampilkan Batch yang kedaluwarsa.

---

GET

/inventory/batches/near-expired

Menampilkan Batch yang mendekati kedaluwarsa.

---

# 16. Stock Card Endpoint

GET

/stock-card

Stock Card seluruh item.

---

GET

/stock-card/{item_uuid}

Stock Card berdasarkan Item.

---

GET

/stock-card/{item_uuid}/batch/{batch_uuid}

Stock Card berdasarkan Batch.

---

# 17. Search

Support:

search=

Pencarian berdasarkan:

- Item Code
- Item Name
- Batch
- Lot Number
- Warehouse

---

# 18. Filter

Support:

company_id

farm_id

warehouse_id

location_id

category_id

batch_id

status

expired

date_range

---

# 19. Sorting

Support:

movement_date

item_code

warehouse

batch

created_at

Default

movement_date DESC

---

# 20. Pagination

Default:

20 data.

Pilihan:

10

20

50

100

---

# 21. Include

Support

include=

Contoh

warehouse

location

item

batch

user

activity

culture_cycle

---

# 22. Export Endpoint

GET

/inventory/export

Support

- CSV
- Excel
- PDF

---

# 23. Statistics Endpoint

GET

/inventory/statistics

Menampilkan:

- Total Item
- Total Stock
- Low Stock
- Near Expired
- Expired Item
- Warehouse Usage

---

# 24. Business Validation

Tidak diperbolehkan:

- Stock negatif.
- Stock Out melebihi Available Stock.
- Batch kedaluwarsa digunakan.
- Transfer ke Warehouse yang sama.
- Adjustment tanpa alasan.

---

# 25. Standard Response

Success

{
    "success": true,
    "message": "Success",
    "data": {},
    "meta": {}
}

---

Validation Error

{
    "success": false,
    "message": "Validation Error",
    "errors": {}
}

---

# 26. HTTP Status

200

201

204

400

401

403

404

409

422

500

---

# 27. Logging

Seluruh endpoint mencatat:

- User
- Endpoint
- Method
- Execution Time
- Activity
- Reference Number

---

# 28. API Resource

Gunakan:

Laravel API Resource.

Tidak mengembalikan Model secara langsung.

---

# 29. Integration

Warehouse akan berkomunikasi dengan:

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

# 30. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan UUID.
- Menggunakan Form Request.
- Menggunakan API Resource.
- Menggunakan Repository Pattern.
- Menggunakan Service Layer.
- Menggunakan Database Transaction.
- Tidak mengubah Current Stock secara langsung.
- Seluruh perubahan stok dilakukan melalui Inventory Movement.

---

# 31. Deliverables

Implementasi harus menghasilkan:

- API Route
- Controller
- Form Request
- API Resource
- Repository
- Service
- Policy
- Feature Test

---

# End of Document