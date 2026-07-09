# UtiFarm
# 00_Database_Convention

Version : 1.0

Status : Active

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_Business_Rules.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar desain database yang digunakan pada seluruh aplikasi UtiFarm.

Seluruh Migration, Model, Repository, Service, API, dan AI Coding Assistant wajib mengikuti aturan pada dokumen ini.

---

# 2. Database Engine

Database yang digunakan:

- PostgreSQL 17+

Character Set

UTF-8

Timezone

UTC

---

# 3. Design Principles

Database dirancang berdasarkan prinsip:

- Normalisasi hingga Third Normal Form (3NF)
- Single Source of Truth
- Referential Integrity
- Data Consistency
- High Readability
- Scalability

---

# 4. Naming Convention

## Table

Menggunakan:

snake_case

Contoh

companies

farms

pond_areas

ponds

culture_cycles

warehouse_transactions

---

## Column

Menggunakan:

snake_case

Contoh

company_name

farm_name

created_at

updated_at

deleted_at

---

## Foreign Key

Format:

{table_singular}_id

Contoh

company_id

farm_id

pond_id

supplier_id

customer_id

---

## Pivot Table

Urut berdasarkan alfabet.

Contoh

role_user

permission_role

---

# 5. Primary Key Standard

Semua tabel memiliki:

id

BIGINT

AUTO INCREMENT

dan

uuid

UUID

PUBLIC IDENTIFIER

UUID digunakan untuk:

- API
- Frontend
- Public URL

ID digunakan untuk:

- Internal Database
- Foreign Key

---

# 6. Standard Columns

Semua tabel wajib memiliki:

id

uuid

created_at

updated_at

deleted_at

created_by

updated_by

deleted_by

---

# 7. Data Type Standard

Gunakan tipe data berikut.

String

VARCHAR

Text

TEXT

Integer

INTEGER

Big Integer

BIGINT

Decimal

DECIMAL(15,2)

Boolean

BOOLEAN

Date

DATE

Time

TIME

Timestamp

TIMESTAMP

UUID

UUID

JSON

JSONB

---

# 8. Soft Delete

Master Data wajib menggunakan Soft Delete.

Data transaksi tidak boleh dihapus secara permanen.

---

# 9. Foreign Key Rules

Gunakan Foreign Key pada seluruh relasi.

Default:

ON UPDATE CASCADE

ON DELETE RESTRICT

---

# 10. Index Rules

Buat Index pada:

uuid

created_at

deleted_at

status

foreign key

kolom pencarian utama

---

# 11. Unique Rules

Gunakan UNIQUE pada:

company_code

farm_code

pond_code

employee_number

supplier_code

customer_code

feed_code

medicine_code

dan kode unik lainnya.

---

# 12. Audit Trail

Seluruh perubahan wajib menyimpan:

created_by

updated_by

deleted_by

---

# 13. Status Standard

Gunakan ENUM atau lookup table sesuai kebutuhan.

Contoh Status:

ACTIVE

INACTIVE

MAINTENANCE

CLOSED

---

# 14. Transaction Rules

Seluruh transaksi database menggunakan:

Database Transaction

Commit

Rollback

Tidak boleh menyimpan data sebagian.

---

# 15. Relationship Rules

Relationship menggunakan Eloquent.

Jenis relationship:

One To One

One To Many

Many To Many

Has Many Through

Gunakan relationship sesuai kebutuhan.

---

# 16. Migration Rules

Migration harus dibuat sesuai urutan dependency.

Contoh

companies

↓

farms

↓

pond_areas

↓

ponds

↓

culture_cycles

↓

activities

↓

harvests

---

# 17. Seeder Rules

Minimal terdapat Seeder untuk:

Role

Permission

Province

City

District

Village

Unit

Fish Species

Feed Category

Expense Category

Income Category

---

# 18. Factory Rules

Factory dibuat hanya untuk:

Testing

Dummy Data

Development

Tidak digunakan pada Production.

---

# 19. JSON Rules

Gunakan JSONB hanya apabila struktur data dinamis.

Hindari penggunaan JSON untuk data relasional.

---

# 20. Decimal Rules

Gunakan DECIMAL untuk:

Harga

Biaya

Berat

Biomassa

Volume

Jangan menggunakan FLOAT untuk data keuangan.

---

# 21. Date Rules

Gunakan:

DATE

untuk tanggal.

Gunakan:

TIMESTAMP

untuk audit.

---

# 22. UUID Rules

UUID dibuat otomatis menggunakan Laravel.

UUID tidak boleh diubah setelah data dibuat.

---

# 23. Delete Rules

Master Data

Soft Delete

Transaksi

Tidak boleh Force Delete

Super Admin dapat melakukan Restore pada Master Data.

---

# 24. Performance Rules

Gunakan:

Index

Pagination

Lazy Loading

Eager Loading

Optimasi Query

Hindari Query N+1.

---

# 25. Security Rules

Seluruh Query menggunakan:

Eloquent ORM

atau

Query Builder

Jangan menggunakan Raw SQL kecuali benar-benar diperlukan.

---

# 26. Backup Rules

Database harus mendukung:

Backup Harian

Backup Mingguan

Restore

Point In Time Recovery (Future)

---

# 27. AI Coding Rules

AI Coding Assistant wajib:

- Mengikuti seluruh konvensi database.
- Tidak membuat tabel di luar spesifikasi.
- Tidak mengubah struktur tabel tanpa persetujuan.
- Menggunakan Foreign Key.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Migration Laravel.

---

# 28. Definition of Done

Database dianggap selesai apabila:

- Migration berhasil dijalankan.
- Foreign Key valid.
- Index telah dibuat.
- Seeder berjalan.
- Factory berjalan.
- Tidak ada konflik dependency.
- Struktur database sesuai dokumentasi.

---

# End of Document