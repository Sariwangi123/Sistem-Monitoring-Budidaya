# UtiFarm
# 04_Activities
## Part 2 - Database Design

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

---

# 1. Purpose

Dokumen ini mendefinisikan desain database untuk modul Activities.

Activities merupakan pusat pencatatan seluruh aktivitas operasional budidaya.

Seluruh event sistem maupun aktivitas pengguna akan disimpan pada modul ini.

---

# 2. Database Principles

Seluruh tabel wajib mengikuti:

- UUID
- Soft Delete
- Audit Trail
- Foreign Key
- Timestamp
- Index
- Referential Integrity

---

# 3. Module Relationship

Master Data

↓

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

Report Analytics

Activities menjadi pusat histori seluruh modul.

---

# 4. Main Entities

Entity utama terdiri dari:

- Activity
- Activity Category
- Activity Type
- Activity Attachment
- Activity Comment

Future Module

- Activity Notification
- Activity Reminder
- Activity Automation

---

# 5. Entity Relationship

Company

↓

Farm

↓

Pond Area

↓

Pond

↓

Culture Cycle

↓

Activity

↓

Attachment

↓

Comment

---

# 6. Table : activity_categories

Deskripsi

Master kategori aktivitas.

Contoh:

Production

Water Quality

Treatment

Harvest

Warehouse

Finance

Maintenance

Security

System

Field

category_code

category_name

description

status

---

# 7. Table : activity_types

Deskripsi

Master jenis aktivitas.

Relationship

activity_category_id

Field

event_code

activity_name

activity_category_id

icon

color

is_manual

is_system

status

description

---

# 8. Event Code Standard

Gunakan format:

ACT-001

ACT-002

ACT-003

...

Contoh

ACT-001

Feeding Recorded

ACT-002

Sampling Recorded

ACT-003

Water Quality Recorded

ACT-004

Mortality Recorded

ACT-005

Treatment Recorded

ACT-006

Partial Harvest

ACT-007

Final Harvest

ACT-008

Cycle Closed

ACT-009

Warehouse Stock Updated

ACT-010

Finance Transaction Created

Event Code bersifat unik.

---

# 9. Table : activities

Deskripsi

Menyimpan seluruh aktivitas operasional.

Relationship

company_id

farm_id

pond_area_id

pond_id

culture_cycle_id

activity_type_id

user_id

Field

activity_date

activity_time

event_code

title

description

status

reference_type

reference_uuid

metadata (JSONB)

---

# 10. Reference Rules

reference_type

Contoh:

Culture Cycle

Warehouse

Harvest

Finance

Dashboard

System

reference_uuid

UUID dari modul asal.

---

# 11. Metadata

Gunakan JSONB.

Contoh isi:

- Feed Quantity
- Water Quality Value
- Sampling Result
- Mortality Count

Metadata digunakan hanya untuk informasi tambahan.

Data utama tetap berada pada tabel transaksi masing-masing.

---

# 12. Table : activity_attachments

Relationship

activity_id

Field

file_name

file_type

file_size

storage_path

description

---

# 13. Table : activity_comments

Relationship

activity_id

user_id

Field

comment

comment_date

---

# 14. Status

Status Activity

Draft

Completed

Cancelled

Archived

---

# 15. Index Strategy

Index wajib dibuat pada:

uuid

event_code

activity_date

culture_cycle_id

user_id

activity_type_id

status

created_at

deleted_at

---

# 16. Foreign Key Rules

Gunakan

ON UPDATE CASCADE

ON DELETE RESTRICT

---

# 17. Constraint Rules

- Activity wajib memiliki Activity Type.
- Activity wajib memiliki User.
- Activity wajib memiliki Culture Cycle (kecuali System Activity).
- Event Code tidak boleh duplikat.
- Activity Type tidak boleh dihapus apabila masih digunakan.

---

# 18. Audit Strategy

Seluruh perubahan mencatat:

created_by

updated_by

deleted_by

timestamp

activity_log

---

# 19. Performance Strategy

Gunakan:

- Composite Index
- Server Side Pagination
- Server Side Search
- Lazy Loading Attachment
- Eager Loading Relationship

---

# 20. Migration Order

activity_categories

↓

activity_types

↓

activities

↓

activity_attachments

↓

activity_comments

---

# 21. Seeder

Minimal Seeder:

Activity Category

Activity Type

System Event

Production Event

Warehouse Event

Finance Event

---

# 22. Factory

Factory dibuat untuk:

- Testing
- Development
- Dummy Timeline

---

# 23. Business Constraint

- Activity tidak boleh dibuat tanpa Activity Type.
- System Activity dibuat otomatis oleh sistem.
- Manual Activity dibuat oleh pengguna.
- Attachment bersifat opsional.
- Comment bersifat opsional.

---

# 24. Future Ready

Database harus mendukung:

- Notification
- Reminder
- Automation
- IoT Event
- Sensor Event
- AI Recommendation

Tanpa mengubah struktur utama.

---

# 25. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan seluruh relationship Eloquent.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Migration Laravel.
- Menggunakan Event Code sebagai identitas aktivitas.
- Menyimpan metadata pada JSONB apabila diperlukan.
- Tidak menduplikasi data transaksi pada tabel Activities.

---

# 26. Deliverables

Codex harus menghasilkan:

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