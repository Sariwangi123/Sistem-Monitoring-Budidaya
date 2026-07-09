# AI IMPLEMENTATION INSTRUCTION

Anda adalah Senior Backend Engineer, API Architect, dan Laravel Expert.

Gunakan dokumen berikut sebagai referensi utama:

1. 00_Project_Master.md
2. 01_Milestone_Foundation.md
3. 02_Master_Data_Part_1.md
4. 02_Master_Data_Part_2.md

Fokus dokumen ini hanya pada spesifikasi REST API untuk modul Master Data.

Seluruh endpoint wajib mengikuti standar REST API.

Gunakan Laravel Resource.

Gunakan Form Request Validation.

Gunakan Service Layer.

Gunakan Repository Pattern.

Gunakan Authentication menggunakan Laravel Sanctum.

Semua endpoint wajib production-ready.

---

# UtiFarm

# 02_Master_Data

## Part 3 — REST API Specification

Version : 1.0

Depends :

- 00_Project_Master.md
- 01_Milestone_Foundation.md
- 02_Master_Data_Part_1.md
- 02_Master_Data_Part_2.md

---

# 1. API Overview

Seluruh Master Data diakses menggunakan REST API.

Base URL

/api/v1

Format

JSON

Encoding

UTF-8

Timezone

UTC

---

# 2. Authentication

Semua endpoint (kecuali Login) wajib menggunakan Bearer Token.

Authorization:

Bearer {token}

---

# 3. Standard Response

## Success Response

HTTP Status

200 OK

```json
{
  "success": true,
  "message": "Success",
  "data": {},
  "meta": {}
}
```

---

## Validation Error

HTTP Status

422

```json
{
  "success": false,
  "message": "Validation Error",
  "errors": {}
}
```

---

## Unauthorized

HTTP Status

401

```json
{
  "success": false,
  "message": "Unauthorized"
}
```

---

## Forbidden

HTTP Status

403

```json
{
  "success": false,
  "message": "Forbidden"
}
```

---

## Not Found

HTTP Status

404

```json
{
  "success": false,
  "message": "Data Not Found"
}
```

---

## Internal Server Error

HTTP Status

500

```json
{
  "success": false,
  "message": "Internal Server Error"
}
```

---

# 4. Standard CRUD Endpoint

Semua Master Data menggunakan pola endpoint berikut.

| Method | Endpoint | Keterangan |
|----------|------------------------|----------------|
| GET | /resource | List |
| GET | /resource/{uuid} | Detail |
| POST | /resource | Create |
| PUT | /resource/{uuid} | Update |
| DELETE | /resource/{uuid} | Soft Delete |

---

# 5. Query Parameters

List endpoint wajib mendukung:

page

per_page

search

sort

order

filter

Contoh

GET

/api/v1/farms?page=1&per_page=20&search=Farm A

---

# 6. Company API

Endpoint

GET /companies

GET /companies/{uuid}

POST /companies

PUT /companies/{uuid}

DELETE /companies/{uuid}

---

# 7. Farm API

GET /farms

GET /farms/{uuid}

POST /farms

PUT /farms/{uuid}

DELETE /farms/{uuid}

---

# 8. Pond Area API

GET /pond-areas

GET /pond-areas/{uuid}

POST /pond-areas

PUT /pond-areas/{uuid}

DELETE /pond-areas/{uuid}

---

# 9. Pond API

GET /ponds

GET /ponds/{uuid}

POST /ponds

PUT /ponds/{uuid}

DELETE /ponds/{uuid}

---

# 10. Fish Species API

GET /fish-species

GET /fish-species/{uuid}

POST /fish-species

PUT /fish-species/{uuid}

DELETE /fish-species/{uuid}

---

# 11. Fish Strain API

GET /fish-strains

GET /fish-strains/{uuid}

POST /fish-strains

PUT /fish-strains/{uuid}

DELETE /fish-strains/{uuid}

---

# 12. Feed API

GET /feed-brands

GET /feed-categories

GET /feed-types

POST

PUT

DELETE

---

# 13. Medicine API

GET

POST

PUT

DELETE

---

# 14. Probiotic API

GET

POST

PUT

DELETE

---

# 15. Vitamin API

GET

POST

PUT

DELETE

---

# 16. Supplier API

GET

POST

PUT

DELETE

---

# 17. Customer API

GET

POST

PUT

DELETE

---

# 18. Employee API

GET

POST

PUT

DELETE

---

# 19. Unit API

GET

POST

PUT

DELETE

---

# 20. Province API

GET

Only Read

---

# 21. City API

GET

Only Read

---

# 22. District API

GET

Only Read

---

# 23. Village API

GET

Only Read

---

# 24. Validation Rules

POST dan PUT wajib menggunakan Form Request.

Minimal validasi:

required

nullable

string

integer

numeric

uuid

email

exists

unique

boolean

date

---

# 25. Pagination Standard

Response wajib memiliki:

current_page

last_page

per_page

total

links

---

# 26. Search Standard

Search menggunakan:

ILIKE (PostgreSQL)

Support:

Single Keyword

Multiple Keyword

Partial Search

---

# 27. Sorting Standard

Default

created_at DESC

Support

ASC

DESC

---

# 28. Filtering

Semua endpoint mendukung filter berdasarkan field utama.

Contoh

status

company

farm

species

supplier

customer

---

# 29. API Documentation

Seluruh endpoint wajib dibuatkan:

OpenAPI 3.1

Swagger UI

Postman Collection

---

# 30. Deliverables

Codex harus menghasilkan:

✔ Route

✔ Controller

✔ Form Request

✔ API Resource

✔ Repository

✔ Service

✔ Policy

✔ Swagger

✔ Postman Collection

---

# AI Coding Instructions

Gunakan Laravel Resource.

Gunakan Form Request.

Gunakan Repository Pattern.

Gunakan Service Layer.

Gunakan UUID.

Gunakan Soft Delete.

Gunakan Sanctum Authentication.

Jangan membuat Business Logic pada Controller.

Jangan mengakses Model secara langsung dari Controller.

Controller hanya memanggil Service Layer.

Pastikan seluruh endpoint mengikuti standar REST API.

Seluruh endpoint harus siap digunakan oleh frontend React.

---

# End of Document