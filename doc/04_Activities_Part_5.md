# UtiFarm
# 04_Activities
## Part 5 - Implementation Rules & Business Engine

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
- 04_Activities_Part_3.md
- 04_Activities_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan aturan implementasi dan Business Engine untuk modul Activities.

Activities merupakan pusat Event Tracking seluruh aplikasi.

Seluruh proses operasional yang dilakukan oleh pengguna maupun sistem harus menghasilkan Activity.

---

# 2. Business Engine

Flow implementasi:

REST API

↓

Controller

↓

Service

↓

Repository

↓

Database

↓

Event Dispatcher

↓

Timeline

↓

Dashboard

↓

Audit Trail

Controller tidak diperbolehkan memiliki Business Logic.

---

# 3. Activity Lifecycle

Setiap Activity memiliki lifecycle berikut.

Draft

↓

Validated

↓

Completed

↓

Archived

↓

Deleted (Soft Delete)

System Activity langsung berstatus Completed.

---

# 4. Activity Creation Rules

Activity dapat dibuat oleh:

- User
- System
- Module Integration

Setiap Activity wajib memiliki:

- Activity Type
- Category
- Timestamp
- User/System
- Reference Module
- Event Code

---

# 5. Event Processing Flow

Business Flow

Business Action

↓

Validation

↓

Create Activity

↓

Create Timeline

↓

Audit Trail

↓

Dispatch Event

↓

Update Related Module

↓

Notification (Future)

↓

Dashboard Refresh

---

# 6. Event Dispatcher

Setelah Activity dibuat, sistem harus mendistribusikan Event ke modul terkait.

Contoh:

Feeding

↓

Warehouse

↓

Dashboard

↓

Audit Trail

Sampling

↓

Culture Cycle

↓

Dashboard

↓

Report

Harvest

↓

Finance

↓

Dashboard

↓

Report

---

# 7. Timeline Builder

Setiap Activity otomatis ditambahkan ke Timeline.

Timeline diurutkan berdasarkan:

1. Activity Date
2. Activity Time
3. Created At

Timeline bersifat immutable.

---

# 8. Activity Validation

Validasi minimal:

- Culture Cycle masih aktif.
- Activity Type valid.
- Event Code valid.
- User memiliki hak akses.
- Timestamp valid.
- Reference Module tersedia.

---

# 9. Business Rules

Activity tidak boleh:

- Berdiri sendiri tanpa referensi.
- Mengubah Event Code.
- Menghapus System Activity.
- Mengubah histori yang telah diarsipkan.

---

# 10. Metadata Processing

Metadata hanya digunakan untuk:

- Informasi tambahan.
- Ringkasan event.
- Tampilan Timeline.

Metadata bukan sumber data utama.

Data utama tetap berada pada modul asal.

---

# 11. Reference Engine

Activity menyimpan:

Reference Type

Reference UUID

Saat Detail Activity dibuka:

↓

Sistem membuka modul asal.

Contoh:

Feeding

↓

Detail Feeding

Sampling

↓

Detail Sampling

Harvest

↓

Detail Harvest

---

# 12. Integration Engine

Activity menjadi penghubung antar modul.

Culture Cycle

↓

Activities

↓

Warehouse

↓

Harvest

↓

Finance

↓

Dashboard

↓

Report

Activities tidak menjadi tempat penyimpanan transaksi bisnis.

Activities hanya menyimpan histori dan referensi.

---

# 13. Dashboard Synchronization

Setelah Activity berhasil dibuat:

Refresh:

- Recent Activity
- Timeline
- KPI Widget
- Notification Badge

Dashboard tidak boleh melakukan perhitungan ulang secara langsung.

Dashboard membaca data yang telah diperbarui oleh modul terkait.

---

# 14. Audit Trail

Setiap Activity wajib mencatat:

- User
- Tanggal
- Waktu
- IP Address
- Device (Future)
- Event Code
- Modul
- Action

---

# 15. Exception Handling

Gunakan Custom Exception.

Contoh:

- Invalid Activity Type
- Invalid Event Code
- Invalid Reference
- Culture Cycle Closed
- Unauthorized Access
- Duplicate Activity

---

# 16. Database Transaction

Gunakan DB::transaction() untuk:

- Create Activity
- Update Activity
- Archive Activity
- Restore Activity
- Create Attachment
- Create Comment

Jika salah satu proses gagal, seluruh transaksi harus di-Rollback.

---

# 17. Performance Rules

Gunakan:

- Eager Loading
- Pagination
- Index
- Cache Recent Activity
- Lazy Loading Attachment

Hindari Query N+1.

---

# 18. Security Rules

Setiap Activity harus melalui:

- Authentication
- Authorization
- Validation
- Audit Trail

System Activity tidak dapat dimodifikasi oleh pengguna.

---

# 19. Integration Rules

Activity harus dapat menerima Event dari:

- Culture Cycle
- Warehouse
- Harvest
- Finance
- Dashboard
- Authentication
- System

Tanpa mengubah struktur database.

---

# 20. Business Event Matrix

| Source Module | Event | Action |
|---------------|-------|--------|
| Culture Cycle | Stocking | Create Activity |
| Culture Cycle | Sampling | Create Activity |
| Culture Cycle | Mortality | Create Activity |
| Warehouse | Stock Out | Create Activity |
| Warehouse | Stock Adjustment | Create Activity |
| Harvest | Partial Harvest | Create Activity |
| Harvest | Final Harvest | Create Activity |
| Finance | Revenue Posted | Create Activity |
| System | Login | Create Activity |
| System | Logout | Create Activity |

---

# 21. Acceptance Criteria

Business Engine dianggap selesai apabila:

✓ Activity otomatis dibuat.

✓ Timeline otomatis diperbarui.

✓ Dashboard menerima pembaruan.

✓ Audit Trail tercatat.

✓ Integrasi antar modul berjalan.

✓ Metadata tersimpan.

✓ Reference berjalan dengan benar.

---

# 22. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan Event Dispatcher.
- Menggunakan DB Transaction.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Tidak menduplikasi data transaksi.
- Menjadikan Activities sebagai Event Hub.
- Menghasilkan implementasi production-ready.

---

# 23. Deliverables

Backend

- Migration
- Model
- Repository
- Service
- Controller
- Request
- Resource
- Policy
- Feature Test

Frontend

- Timeline
- Activity Detail
- Attachment
- Comment
- Statistics
- Responsive Layout

---

# 24. Definition of Done

Modul Activities dinyatakan selesai apabila:

- Timeline berjalan dengan baik.
- Activity otomatis tercatat.
- Event Dispatcher berjalan.
- Integrasi antar modul berjalan.
- Dashboard menampilkan Recent Activity.
- Audit Trail lengkap.
- Seluruh endpoint lulus pengujian.
- Dokumentasi diperbarui.

---

# End of Document