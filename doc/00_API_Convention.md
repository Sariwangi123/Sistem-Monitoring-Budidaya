# UtiFarm
# 00_API_Convention

Version : 1.0

Status : Active

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Business_Rules.md
- 00_Database_Convention.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar REST API yang digunakan pada seluruh aplikasi UtiFarm.

Seluruh Backend, Frontend, dan AI Coding Assistant wajib mengikuti konvensi ini.

---

# 2. API Principles

Seluruh API harus mengikuti prinsip berikut:

- RESTful API
- Stateless
- Consistent Response
- Secure by Default
- Versioned API
- Resource Based
- Production Ready

---

# 3. Base URL

```
/api/v1
```

Contoh

```
GET /api/v1/farms
```

---

# 4. Authentication

Menggunakan Laravel Sanctum.

Semua endpoint wajib menggunakan:

```
Authorization: Bearer {token}
```

Kecuali:

- Login
- Forgot Password
- Reset Password

---

# 5. HTTP Method Standard

GET

Mengambil Data

POST

Membuat Data

PUT

Mengubah Seluruh Data

PATCH

Mengubah Sebagian Data

DELETE

Soft Delete

---

# 6. URL Convention

Gunakan plural resource.

Benar

```
/companies

/farms

/ponds

/customers
```

Salah

```
/company

/getFarm

/createCustomer
```

---

# 7. API Versioning

Versi pertama

```
/api/v1
```

Apabila terdapat perubahan besar

```
/api/v2
```

Jangan mengubah endpoint lama.

---

# 8. Standard Success Response

```json
{
    "success": true,
    "message": "Success",
    "data": {},
    "meta": {}
}
```

---

# 9. Standard Error Response

```json
{
    "success": false,
    "message": "Validation Error",
    "errors": {}
}
```

---

# 10. HTTP Status Code

| Code | Keterangan |
|------|------------|
|200|Success|
|201|Created|
|204|No Content|
|400|Bad Request|
|401|Unauthorized|
|403|Forbidden|
|404|Not Found|
|409|Conflict|
|422|Validation Error|
|500|Internal Server Error|

---

# 11. Pagination Standard

Response

```json
{
    "success": true,
    "message": "Success",
    "data": [],
    "meta": {
        "current_page": 1,
        "per_page": 20,
        "total": 120,
        "last_page": 6
    }
}
```

Default

20 data

---

# 12. Search Standard

Gunakan query parameter.

```
GET /api/v1/farms?search=lele
```

Server Side Search.

---

# 13. Sorting Standard

```
GET /api/v1/farms?sort=name&order=asc
```

Default

created_at DESC

---

# 14. Filtering Standard

Contoh

```
GET /api/v1/ponds?status=ACTIVE

GET /api/v1/ponds?farm_id=1

GET /api/v1/activities?culture_cycle_id=5
```

---

# 15. Include Relationship

Gunakan parameter

```
include=
```

Contoh

```
GET /api/v1/farms?include=company

GET /api/v1/ponds?include=farm,pondArea
```

---

# 16. UUID Usage

Frontend hanya menggunakan UUID.

Contoh

```
GET

/api/v1/farms/{uuid}
```

Backend menggunakan ID internal.

---

# 17. Validation Error

Semua validasi menggunakan Form Request.

Contoh

```json
{
    "success": false,
    "message": "Validation Error",
    "errors": {
        "farm_name": [
            "Farm Name is required."
        ]
    }
}
```

---

# 18. Upload API

Support

- JPG
- PNG
- PDF
- XLSX
- CSV

Maximum

10 MB

Gunakan Multipart Form Data.

---

# 19. Import API

Gunakan endpoint

```
POST

/import
```

Response

Jumlah berhasil

Jumlah gagal

Error Detail

---

# 20. Export API

Support

CSV

Excel

PDF

---

# 21. Soft Delete API

Delete

```
DELETE

/resource/{uuid}
```

Restore

```
POST

/resource/{uuid}/restore
```

Force Delete

```
DELETE

/resource/{uuid}/force
```

Khusus Super Admin.

---

# 22. Batch Operation

Support

Batch Delete

Batch Restore

Batch Export

Menggunakan Array UUID.

---

# 23. API Resource

Seluruh response menggunakan Laravel API Resource.

Tidak mengembalikan Model secara langsung.

---

# 24. Rate Limiting

Default

60 Request

Per Menit

Gunakan Laravel Rate Limiter.

---

# 25. Logging

Catat:

Endpoint

Method

User

IP Address

Execution Time

Response Code

---

# 26. Security

Gunakan

Authentication

Authorization

Validation

Rate Limit

CSRF (Web)

CORS

HTTPS

---

# 27. Documentation

Seluruh endpoint harus terdokumentasi.

Minimal:

- Endpoint
- Method
- Parameter
- Request
- Response
- Error Response
- Authentication

Disarankan menggunakan OpenAPI / Swagger.

---

# 28. AI Coding Rules

AI Coding Assistant wajib:

- Mengikuti standar REST API.
- Menggunakan Laravel Resource.
- Menggunakan Form Request.
- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Tidak mengakses Model langsung dari Controller.
- Menggunakan UUID pada endpoint publik.
- Menggunakan response standar pada seluruh endpoint.
- Tidak membuat endpoint di luar spesifikasi.

---

# 29. Definition of Done

API dianggap selesai apabila:

- Endpoint berjalan.
- Validasi berjalan.
- Authentication berjalan.
- Authorization berjalan.
- Pagination berjalan.
- Search berjalan.
- Sorting berjalan.
- Filtering berjalan.
- Soft Delete berjalan.
- Response sesuai standar.
- Dokumentasi API tersedia.

---

# End of Document