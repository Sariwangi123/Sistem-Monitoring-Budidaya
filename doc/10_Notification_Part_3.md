# UtiFarm
# 10_Notification
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
- 10_Notification_Part_1.md
- 10_Notification_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk Notification Center.

Notification API digunakan oleh Frontend untuk membaca, mengelola status, dan mengatur preferensi Notification.

Business Event tidak dikirim melalui REST API, melainkan melalui Notification Event Engine.

---

# 2. Base URL

/api/v1/notifications

---

# 3. Authentication

Seluruh endpoint menggunakan:

Bearer Token

Laravel Sanctum.

---

# 4. Authorization

Notification mengikuti Role Based Access Control.

Role:

- Super Admin
- Farm Owner
- Farm Manager
- Warehouse Staff
- Finance Staff
- Technician
- Viewer

Pengguna hanya dapat melihat Notification miliknya.

---

# 5. Notification List Endpoint

GET

/

Support Query:

- status
- category
- priority
- unread_only
- page
- per_page

Output:

- Notification List
- Pagination
- Total Unread

---

# 6. Notification Detail Endpoint

GET

/{notification_id}

Output:

- Title
- Message
- Category
- Priority
- Channel
- Status
- Created At
- Read At
- Action URL

---

# 7. Mark As Read

PATCH

/{notification_id}/read

Mengubah status menjadi Read.

---

PATCH

/read-all

Menandai seluruh Notification menjadi Read.

---

# 8. Archive Notification

PATCH

/{notification_id}/archive

Mengubah status menjadi Archived.

---

PATCH

/archive-all

Mengarsipkan seluruh Notification yang telah dibaca.

---

# 9. Delete Notification

DELETE

/{notification_id}

Hanya menghapus Notification milik pengguna.

Tidak menghapus Domain Event.

---

# 10. Notification Preference

GET

/preferences

Menampilkan preferensi Notification pengguna.

---

PUT

/preferences

Mengubah preferensi Notification.

Contoh:

- In-App Enabled
- Email Enabled (Future)
- WhatsApp Enabled (Future)
- Reminder Enabled

---

# 11. Notification History

GET

/history

Support:

- date_range
- category
- status

---

# 12. Notification Search

GET

/search

Support:

search=

Mencari berdasarkan:

- Title
- Message
- Category

---

# 13. Notification Statistics

GET

/statistics

Output:

- Total Notification
- Total Unread
- Total Archived
- Notification by Category
- Notification by Priority

---

# 14. Retry Notification

POST

/{notification_id}/retry

Hanya untuk Notification dengan status Failed.

Memerlukan permission yang sesuai.

---

# 15. Notification Registry

GET

/registry

Super Admin only.

Menampilkan metadata Notification Registry.

---

# 16. Notification Template

GET

/templates

Super Admin only.

Menampilkan daftar Template Notification.

---

# 17. Export Notification History

GET

/export

Support:

- PDF
- Excel
- CSV

---

# 18. Search

Support:

search=

Mencari:

- Notification Title
- Category
- Event Name

---

# 19. Filter

Support:

- category
- priority
- status
- channel
- date_range

---

# 20. Standard Response

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

# 21. HTTP Status

200

201

204

400

401

403

404

422

500

---

# 22. Logging

Seluruh endpoint mencatat:

- User
- Notification ID
- Action
- Execution Time
- IP Address

---

# 23. API Resource

Gunakan:

Laravel API Resource.

Response tidak mengembalikan Model secara langsung.

---

# 24. Integration

Notification menerima Domain Event dari:

- Master Data
- Culture Cycle
- Activities
- Warehouse
- Harvest
- Finance
- Dashboard
- Report
- System Administration

Frontend hanya membaca Notification melalui REST API.

---

# 25. Business Validation

Tidak diperbolehkan:

- Mengubah Domain Event melalui API.
- Mengubah Notification milik pengguna lain.
- Menghapus Notification sistem.
- Mengakses Notification tanpa autentikasi.

---

# 26. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan Notification Service.
- Menggunakan Notification Event Engine.
- Menggunakan Laravel API Resource.
- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan Queue bila diperlukan.
- Mengikuti seluruh Business Rules.

---

# 27. Deliverables

Implementasi harus menghasilkan:

- Notification Route
- Notification Controller
- Notification Service
- Notification Repository
- Notification Resource
- Notification Preference Service
- Feature Test
- API Documentation

---

# End of Document