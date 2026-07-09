# UtiFarm
# 03_Culture_Cycle
## Part 3 - REST API Specification

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
- 03_Culture_Cycle_Part_1.md
- 03_Culture_Cycle_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan seluruh REST API pada modul Culture Cycle.

Semua endpoint mengikuti:

- REST API
- Versioning
- UUID
- Standard Response
- Authentication
- Authorization

sesuai dengan:

00_API_Convention.md

---

# 2. Base URL

/api/v1

---

# 3. Authentication

Semua endpoint menggunakan

Bearer Token

Laravel Sanctum.

---

# 4. Authorization

Role yang diperbolehkan:

- Super Admin
- Farm Owner
- Farm Manager
- Technician

Viewer hanya memiliki akses GET.

---

# 5. Resource Endpoint

GET

/culture-cycles

List Culture Cycle.

---

GET

/culture-cycles/{uuid}

Detail Culture Cycle.

---

POST

/culture-cycles

Membuat Draft Culture Cycle.

Status awal:

Draft

---

PUT

/culture-cycles/{uuid}

Mengubah Draft.

Tidak dapat mengubah Cycle yang Running.

---

DELETE

/culture-cycles/{uuid}

Soft Delete.

Hanya apabila belum memiliki transaksi.

---

# 6. Business Endpoint

Business Endpoint digunakan untuk menjalankan proses budidaya.

---

## Prepare Pond

POST

/culture-cycles/{uuid}/prepare

Mengubah status:

Draft

↓

Prepared

---

## Stocking

POST

/culture-cycles/{uuid}/stocking

Mengubah status:

Prepared

↓

Stocked

↓

Running

Input:

- tanggal
- supplier
- batch
- jumlah benih
- berat awal

---

## Water Quality

POST

/culture-cycles/{uuid}/water-quality

Mencatat:

- suhu
- pH
- DO
- amonia
- nitrit
- salinitas

---

GET

/culture-cycles/{uuid}/water-quality

Riwayat Water Quality.

---

## Sampling

POST

/culture-cycles/{uuid}/sampling

Input:

- berat rata-rata
- panjang
- jumlah sampel

Output:

- biomassa
- ADG
- Survival Rate

---

GET

/culture-cycles/{uuid}/sampling

Riwayat Sampling.

---

## Mortality

POST

/culture-cycles/{uuid}/mortality

Input:

- jumlah mati
- penyebab
- catatan

Output

Update Population.

---

GET

/culture-cycles/{uuid}/mortality

Riwayat Mortalitas.

---

## Feeding Summary

POST

/culture-cycles/{uuid}/feeding

Input

- feed
- quantity
- frequency

Output

Warehouse Stock berkurang.

---

GET

/culture-cycles/{uuid}/feeding

Riwayat Feeding.

---

## Treatment

POST

/culture-cycles/{uuid}/treatment

Input

- medicine
- dosage
- reason

---

GET

/culture-cycles/{uuid}/treatment

Riwayat Treatment.

---

## Growth

GET

/culture-cycles/{uuid}/growth

Menampilkan:

- Average Weight
- Biomassa
- ADG
- Population

---

## KPI

GET

/culture-cycles/{uuid}/kpi

Response:

- Biomassa
- FCR
- SR
- ADG
- Mortalitas
- Feed Consumption

---

## Partial Harvest

POST

/culture-cycles/{uuid}/partial-harvest

Status tetap:

Running

---

## Final Harvest

POST

/culture-cycles/{uuid}/final-harvest

Status berubah:

Harvesting

↓

Completed

---

## Close Cycle

POST

/culture-cycles/{uuid}/close

Menutup Culture Cycle.

Hanya dapat dilakukan setelah:

- Final Harvest selesai
- Tidak ada transaksi tertunda

---

## Reopen Cycle

POST

/culture-cycles/{uuid}/reopen

Khusus

Super Admin

---

# 7. Search

GET

/culture-cycles?search=

Server Side Search.

---

# 8. Filter

Support

farm_id

pond_id

species_id

status

date

---

# 9. Sorting

Support

stocking_date

created_at

cycle_code

status

Default

created_at DESC

---

# 10. Pagination

Default

20 data.

---

# 11. Include

Support

include=

Contoh

company

farm

pond

sampling

harvest

---

# 12. Standard Response

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

# 13. HTTP Status

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

# 14. Business Validation

Tidak dapat:

- Stocking sebelum Prepared.
- Sampling sebelum Running.
- Harvest sebelum Running.
- Close sebelum Final Harvest.

Semua validasi dilakukan pada Service Layer.

---

# 15. Integration

Endpoint berikut akan memanggil modul lain.

Warehouse

↓

Mengurangi Feed.

Harvest

↓

Membuat transaksi panen.

Finance

↓

Membuat transaksi penjualan.

Dashboard

↓

Refresh KPI.

---

# 16. Logging

Catat:

- User
- Endpoint
- Method
- Execution Time
- Status
- Activity

---

# 17. API Resource

Gunakan Laravel API Resource.

Tidak mengembalikan Model langsung.

---

# 18. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan UUID.
- Menggunakan Form Request.
- Menggunakan API Resource.
- Menggunakan Repository Pattern.
- Menggunakan Service Layer.
- Menggunakan Database Transaction.
- Mengikuti seluruh Business Rules.
- Mengimplementasikan seluruh Business Endpoint sesuai State Machine.

---

# 19. Deliverables

Implementasi API harus menghasilkan:

- API Route
- Controller
- Request Validation
- API Resource
- Service
- Repository
- Policy
- Feature Test

---

# End of Document