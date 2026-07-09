# UtiFarm
# 04_Activities
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
- 03_Culture_Cycle
- 04_Activities_Part_1.md
- 04_Activities_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk modul Activities.

Activities berfungsi sebagai pusat histori operasional, event tracking, timeline, dan audit aktivitas pada seluruh aplikasi UtiFarm.

Seluruh endpoint mengikuti standar pada:

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

Role yang diperbolehkan:

- Super Admin
- Farm Owner
- Farm Manager
- Technician
- Warehouse Staff
- Finance Staff

Viewer hanya memiliki akses baca (GET).

---

# 5. Resource Endpoint

GET

/activities

Menampilkan daftar aktivitas.

---

GET

/activities/{uuid}

Menampilkan detail aktivitas.

---

POST

/activities

Membuat Manual Activity.

---

PUT

/activities/{uuid}

Mengubah Activity.

Hanya diperbolehkan untuk Draft Activity.

---

DELETE

/activities/{uuid}

Soft Delete.

Tidak diperbolehkan menghapus System Activity.

---

# 6. Timeline Endpoint

GET

/activities/timeline

Menampilkan seluruh timeline.

---

GET

/activities/timeline/{culture_cycle_uuid}

Timeline berdasarkan Culture Cycle.

---

GET

/activities/timeline/today

Timeline hari ini.

---

GET

/activities/timeline/date/{date}

Timeline berdasarkan tanggal.

---

# 7. Daily Log Endpoint

GET

/activities/daily-log

Menampilkan Daily Log.

---

GET

/activities/daily-log/{culture_cycle_uuid}

Daily Log berdasarkan Culture Cycle.

---

# 8. Activity Type Endpoint

GET

/activity-types

Daftar Activity Type.

---

GET

/activity-categories

Daftar Category.

---

# 9. Attachment Endpoint

POST

/activities/{uuid}/attachments

Upload lampiran.

---

GET

/activities/{uuid}/attachments

Daftar lampiran.

---

DELETE

/activities/{uuid}/attachments/{attachment_uuid}

Menghapus lampiran.

---

# 10. Comment Endpoint

POST

/activities/{uuid}/comments

Menambahkan komentar.

---

GET

/activities/{uuid}/comments

Daftar komentar.

---

DELETE

/activities/{uuid}/comments/{comment_uuid}

Soft Delete komentar.

---

# 11. Search

GET

/activities?search=

Server Side Search.

Mendukung pencarian:

- Judul
- Event Code
- Deskripsi
- User
- Pond
- Culture Cycle

---

# 12. Filter

Support filter:

company_id

farm_id

pond_id

culture_cycle_id

activity_category_id

activity_type_id

user_id

status

date

date_range

---

# 13. Sorting

Support:

activity_date

activity_time

event_code

created_at

status

Default:

activity_date DESC

activity_time DESC

---

# 14. Pagination

Default:

20 data

Pilihan:

10

20

50

100

---

# 15. Include

Support:

include=

Contoh:

user

culture_cycle

attachments

comments

activity_type

activity_category

---

# 16. Export Endpoint

GET

/activities/export

Format:

CSV

Excel

PDF

---

# 17. Event Endpoint

GET

/activities/events

Daftar seluruh Event.

---

GET

/activities/events/{event_code}

Detail Event.

---

# 18. Statistics Endpoint

GET

/activities/statistics

Menampilkan statistik aktivitas.

Output:

- Total Activity
- Manual Activity
- System Activity
- Daily Activity
- Monthly Activity

---

# 19. User Activity Endpoint

GET

/users/{uuid}/activities

Riwayat aktivitas pengguna.

---

# 20. Dashboard Endpoint

GET

/dashboard/recent-activities

Digunakan Dashboard.

Limit default:

10 aktivitas terbaru.

---

# 21. Business Validation

Tidak diperbolehkan:

- Menghapus System Activity.
- Membuat Activity tanpa Activity Type.
- Membuat Activity tanpa User.
- Membuat Activity tanpa Timestamp.
- Mengubah Event Code.

---

# 22. Standard Response

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

# 23. HTTP Status

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

# 24. Logging

Seluruh endpoint mencatat:

- User
- Endpoint
- Method
- IP Address
- Execution Time
- Response Code

---

# 25. API Resource

Seluruh response menggunakan:

Laravel API Resource.

Tidak mengembalikan Model secara langsung.

---

# 26. Event Integration

Beberapa endpoint akan dipanggil oleh modul lain.

Culture Cycle

↓

Create Activity

Warehouse

↓

Create Activity

Harvest

↓

Create Activity

Finance

↓

Create Activity

System

↓

Create Activity

---

# 27. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan UUID.
- Menggunakan Laravel Resource.
- Menggunakan Form Request.
- Menggunakan Repository Pattern.
- Menggunakan Service Layer.
- Menggunakan Event Code sebagai identitas aktivitas.
- Menggunakan Standard Response.
- Mengikuti seluruh Business Rules.

---

# 28. Deliverables

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