# UtiFarm
# 06_Harvest
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
- 06_Harvest_Part_1.md
- 06_Harvest_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk modul Harvest.

Harvest menggunakan pendekatan Harvest Management System (HMS).

Seluruh proses panen dilakukan melalui Workflow API.

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
- Technician
- Quality Control
- Warehouse Staff
- Finance Staff

Viewer hanya memiliki akses GET.

---

# 5. Harvest Planning Endpoint

GET

/harvest-plannings

---

GET

/harvest-plannings/{uuid}

---

POST

/harvest-plannings

---

PUT

/harvest-plannings/{uuid}

---

DELETE

/harvest-plannings/{uuid}

Soft Delete.

---

# 6. Harvest Batch Endpoint

GET

/harvest-batches

---

GET

/harvest-batches/{uuid}

---

POST

/harvest-batches

Membuat Harvest Batch.

---

PUT

/harvest-batches/{uuid}

Update Harvest Batch.

---

# 7. Harvest Session Endpoint

GET

/harvest-sessions

---

GET

/harvest-sessions/{uuid}

---

POST

/harvest-sessions

Membuat Session Panen.

---

PUT

/harvest-sessions/{uuid}

Update Session.

---

# 8. Workflow Endpoint

POST

/harvest-batches/{uuid}/start

Mengubah status:

Ready

↓

Harvesting

---

POST

/harvest-sessions/{uuid}/finish

Menyelesaikan Session.

---

POST

/harvest-batches/{uuid}/complete

Mengubah status:

Harvesting

↓

Completed

---

# 9. Harvest Detail Endpoint

POST

/harvest-sessions/{uuid}/details

---

GET

/harvest-sessions/{uuid}/details

---

PUT

/harvest-details/{uuid}

---

DELETE

/harvest-details/{uuid}

---

# 10. Grading Endpoint

POST

/harvest-details/{uuid}/grading

---

GET

/harvest-details/{uuid}/grading

---

PUT

/harvest-gradings/{uuid}

---

# 11. Quality Control Endpoint

POST

/harvest-sessions/{uuid}/quality-control

---

GET

/harvest-sessions/{uuid}/quality-control

---

PUT

/harvest-quality-controls/{uuid}

---

# 12. Packing Endpoint

POST

/harvest-batches/{uuid}/packing

---

GET

/harvest-batches/{uuid}/packing

---

PUT

/harvest-packings/{uuid}

---

# 13. Delivery Endpoint

POST

/harvest-batches/{uuid}/delivery

---

GET

/harvest-batches/{uuid}/delivery

---

PUT

/harvest-deliveries/{uuid}

---

# 14. Yield Analysis Endpoint

GET

/harvest-batches/{uuid}/yield

Response:

- Estimated Weight
- Actual Weight
- Grade Distribution
- Packing Weight
- Delivered Weight
- Yield Percentage

---

# 15. Search

Support:

search=

Pencarian berdasarkan:

- Batch Number
- Planning Number
- Session Number
- Customer
- Culture Cycle

---

# 16. Filter

Support:

company_id

farm_id

pond_id

culture_cycle_id

customer_id

harvest_type

status

date_range

---

# 17. Sorting

Support:

harvest_date

batch_number

created_at

Default:

harvest_date DESC

---

# 18. Pagination

Default:

20 data.

Pilihan:

10

20

50

100

---

# 19. Include

Support:

include=

Contoh:

planning

sessions

details

grading

quality_control

packing

delivery

customer

culture_cycle

---

# 20. Export Endpoint

GET

/harvest/export

Support:

- PDF
- Excel
- CSV

---

# 21. Statistics Endpoint

GET

/harvest/statistics

Output:

- Total Harvest
- Partial Harvest
- Final Harvest
- Harvest Weight
- Grade Distribution
- Pending Delivery

---

# 22. Business Validation

Tidak diperbolehkan:

- Final Harvest sebelum seluruh Session selesai.
- Delivery sebelum Packing selesai.
- Packing sebelum QC selesai.
- Session tanpa Harvest Batch.
- Batch tanpa Culture Cycle.

---

# 23. Standard Response

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

# 24. HTTP Status

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

# 25. Logging

Seluruh endpoint mencatat:

- User
- Endpoint
- Method
- Document Number
- Batch Number
- Execution Time

---

# 26. API Resource

Gunakan:

Laravel API Resource.

Tidak mengembalikan Model secara langsung.

---

# 27. Integration

Harvest berkomunikasi dengan:

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

# 28. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan UUID.
- Menggunakan Form Request.
- Menggunakan API Resource.
- Menggunakan Repository Pattern.
- Menggunakan Service Layer.
- Menggunakan Database Transaction.
- Menggunakan Workflow API.
- Mengikuti seluruh Business Rules.

---

# 29. Deliverables

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