# UtiFarm
# 11_System_Administration
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
- 11_System_Administration_Part_1.md
- 11_System_Administration_Part_2.md

---

# 1. Purpose

Dokumen ini mendefinisikan spesifikasi REST API untuk System Administration.

Administration API digunakan untuk mengelola platform UtiFarm, termasuk User Management, Role, Permission, Configuration, Security, Monitoring, Audit, Backup, dan Integration.

API mengikuti standar:

00_API_Convention.md

---

# 2. Base URL

/api/v1/admin

---

# 3. Authentication

Seluruh endpoint menggunakan:

Bearer Token

Laravel Sanctum.

---

# 4. Authorization

Seluruh endpoint menggunakan Role Based Access Control (RBAC).

Role yang dapat mengakses:

- Super Admin
- Administrator (opsional)
- Farm Owner (terbatas)

Seluruh endpoint harus melalui Policy dan Permission.

---

# 5. User Management Endpoint

GET

/users

Daftar pengguna.

---

GET

/users/{user_id}

Detail pengguna.

---

POST

/users

Membuat pengguna baru.

---

PUT

/users/{user_id}

Memperbarui data pengguna.

---

PATCH

/users/{user_id}/activate

Mengaktifkan pengguna.

---

PATCH

/users/{user_id}/deactivate

Menonaktifkan pengguna.

---

PATCH

/users/{user_id}/reset-password

Reset password.

---

DELETE

/users/{user_id}

Soft Delete.

---

# 6. Role Endpoint

GET

/roles

---

GET

/roles/{role_id}

---

POST

/roles

---

PUT

/roles/{role_id}

---

DELETE

/roles/{role_id}

Role bawaan sistem tidak boleh dihapus.

---

# 7. Permission Endpoint

GET

/permissions

---

GET

/permissions/{permission_id}

---

POST

/permissions

---

PUT

/permissions/{permission_id}

---

DELETE

/permissions/{permission_id}

---

PATCH

/roles/{role_id}/permissions

Assign Permission ke Role.

---

# 8. Configuration Endpoint

GET

/configurations

---

GET

/configurations/{group}

---

PUT

/configurations/{group}

Update Configuration.

---

GET

/configurations/history

Riwayat perubahan.

---

POST

/configurations/rollback

Rollback ke versi sebelumnya.

---

# 9. Security Endpoint

GET

/security/policies

---

PUT

/security/policies

---

GET

/security/sessions

---

DELETE

/security/sessions/{session_id}

Force Logout Session.

---

GET

/security/login-history

---

# 10. Audit Endpoint

GET

/audit

---

GET

/audit/{audit_id}

---

GET

/audit/export

Support:

- PDF
- Excel
- CSV

Audit bersifat Read Only.

---

# 11. Monitoring Endpoint

GET

/monitoring/system

---

GET

/monitoring/database

---

GET

/monitoring/cache

---

GET

/monitoring/queue

---

GET

/monitoring/storage

---

GET

/monitoring/health

---

# 12. Backup Endpoint

GET

/backups

---

POST

/backups

Membuat Backup baru.

---

GET

/backups/{backup_id}

---

POST

/backups/{backup_id}/restore

Restore Backup.

---

DELETE

/backups/{backup_id}

Menghapus Backup sesuai kebijakan retensi.

---

# 13. Integration Endpoint

GET

/integrations

---

GET

/integrations/{integration_id}

---

PUT

/integrations/{integration_id}

---

POST

/integrations/{integration_id}/test

Test koneksi integrasi.

---

# 14. Dashboard Administration Endpoint

GET

/dashboard

Menampilkan ringkasan:

- Active User
- Queue
- Storage
- Backup
- Security Alert

---

# 15. Search

Support:

search=

Mencari:

- User
- Role
- Permission
- Configuration
- Audit

---

# 16. Filter

Support:

- company
- farm
- role
- status
- date_range

---

# 17. Standard Response

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

# 18. HTTP Status

200

201

202

204

400

401

403

404

409

422

500

---

# 19. Logging

Seluruh endpoint mencatat:

- User
- Role
- Action
- IP Address
- User Agent
- Execution Time
- Timestamp

---

# 20. API Resource

Gunakan:

Laravel API Resource.

Response tidak mengembalikan Model secara langsung.

---

# 21. Business Validation

Tidak diperbolehkan:

- Menghapus Audit Trail.
- Menghapus Role bawaan sistem.
- Mengubah Permission tanpa hak akses.
- Mengakses Configuration tanpa RBAC.
- Restore Backup tanpa konfirmasi.
- Mengakses Administration API tanpa autentikasi.

---

# 22. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan REST API.
- Menggunakan Administration Service.
- Menggunakan Administration Engine.
- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan API Resource.
- Menggunakan Policy.
- Menggunakan Form Request Validation.
- Menghasilkan implementasi production-ready.

---

# 23. Deliverables

Implementasi harus menghasilkan:

- Administration Route
- User Controller
- Role Controller
- Permission Controller
- Configuration Controller
- Security Controller
- Monitoring Controller
- Audit Controller
- Backup Controller
- Integration Controller
- API Resource
- Feature Test
- API Documentation

---

# End of Document