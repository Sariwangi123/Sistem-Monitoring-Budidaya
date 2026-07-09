# AI IMPLEMENTATION INSTRUCTION

Anda adalah Senior Software Engineer dan Database Architect.

Gunakan dokumen berikut sebagai referensi utama:

1. 00_Project_Master.md
2. 01_Milestone_Foundation.md
3. 02_Master_Data_Part_1.md

Pada dokumen ini fokus hanya pada desain database Master Data.

Jangan membuat tabel transaksi.

Jangan membuat Dashboard.

Jangan membuat modul Culture Cycle.

Seluruh migration harus mengikuti standar Laravel 12.

Gunakan PostgreSQL.

Gunakan UUID.

Gunakan Foreign Key.

Gunakan Soft Delete.

Gunakan Audit Trail.

Gunakan Index pada seluruh kolom yang sering digunakan untuk pencarian.

Seluruh desain database harus memenuhi Third Normal Form (3NF).

---

# UtiFarm

# 02_Master_Data

## Part 2 — Database Design

Version : 1.0

Depends :

- 00_Project_Master.md
- 01_Milestone_Foundation.md
- 02_Master_Data_Part_1.md

---

# 1. Database Overview

Master Data merupakan fondasi seluruh database UtiFarm.

Semua modul transaksi akan menggunakan tabel pada dokumen ini sebagai referensi.

Seluruh tabel wajib:

- UUID Primary Key
- Soft Delete
- Audit Trail
- Timestamp
- Foreign Key
- Index

---

# 2. Database Standard

Seluruh tabel memiliki struktur dasar berikut.

| Field | Type | Description |
|--------|------|-------------|
| id | BIGINT | Auto Increment |
| uuid | UUID | Public Identifier |
| created_at | TIMESTAMP | Created Date |
| updated_at | TIMESTAMP | Updated Date |
| deleted_at | TIMESTAMP | Soft Delete |
| created_by | BIGINT | User ID |
| updated_by | BIGINT | User ID |
| deleted_by | BIGINT | User ID |

---

# 3. Company

Table

companies

Field utama

- company_code
- company_name
- legal_name
- email
- phone
- website
- tax_number
- address
- province_id
- city_id
- district_id
- village_id
- postal_code
- logo

Constraint

- company_code UNIQUE
- company_name UNIQUE

Index

- company_code
- company_name

---

# 4. Farm

Table

farms

Relationship

Company

1

↓

N

Farm

Field

- company_id
- farm_code
- farm_name
- latitude
- longitude
- area_size
- description

Constraint

- farm_code UNIQUE

Index

- company_id
- farm_name

---

# 5. Pond Area

Table

pond_areas

Relationship

Farm

1

↓

N

Pond Area

Field

- farm_id
- area_code
- area_name
- description

---

# 6. Pond

Table

ponds

Relationship

Pond Area

1

↓

N

Pond

Field

- pond_area_id
- pond_code
- pond_name
- pond_type
- pond_shape
- length
- width
- depth
- volume
- water_capacity
- status

Status

ACTIVE

INACTIVE

MAINTENANCE

---

# 7. Fish Species

Table

fish_species

Field

- species_code
- scientific_name
- local_name
- description

Unique

species_code

---

# 8. Fish Strain

Table

fish_strains

Relationship

Fish Species

1

↓

N

Fish Strain

Field

- fish_species_id
- strain_name
- description

---

# 9. Feed Brand

Table

feed_brands

Field

- brand_name
- manufacturer

---

# 10. Feed Category

Table

feed_categories

Field

- category_name

---

# 11. Feed Type

Table

feed_types

Relationship

Feed Brand

↓

Feed Category

Field

- brand_id
- category_id
- feed_code
- feed_name
- protein
- fat
- fiber
- moisture
- pellet_size

---

# 12. Medicine

Table

medicines

Field

- medicine_code
- medicine_name
- dosage
- description

---

# 13. Probiotic

Table

probiotics

Field

- probiotic_code
- probiotic_name
- dosage

---

# 14. Vitamin

Table

vitamins

Field

- vitamin_code
- vitamin_name
- dosage

---

# 15. Supplier

Table

suppliers

Field

- supplier_code
- supplier_name
- phone
- email
- address

---

# 16. Customer

Table

customers

Field

- customer_code
- customer_name
- phone
- email
- address

---

# 17. Employee

Table

employees

Field

- employee_number
- employee_name
- position
- phone
- email

---

# 18. Unit

Table

units

Field

- unit_code
- unit_name
- symbol

Contoh

Kg

Gram

Liter

Ml

Meter

Cm

---

# 19. Province

Table

provinces

Field

- province_name

---

# 20. City

Table

cities

Relationship

Province

1

↓

N

City

---

# 21. District

Relationship

City

↓

District

---

# 22. Village

Relationship

District

↓

Village

---

# 23. Index Strategy

Seluruh kolom berikut wajib memiliki index.

uuid

company_id

farm_id

pond_area_id

species_id

customer_id

supplier_id

created_at

deleted_at

---

# 24. Foreign Key Rules

Gunakan

ON UPDATE CASCADE

ON DELETE RESTRICT

Kecuali ditentukan lain.

---

# 25. Seeder Strategy

Seluruh tabel master memiliki Seeder.

Minimal:

- Province
- City
- Unit
- Role
- Permission
- Feed Category
- Fish Species

---

# 26. Factory Strategy

Seluruh tabel memiliki Factory untuk testing.

---

# 27. Migration Rules

Urutan migration wajib mengikuti dependency.

Company

↓

Farm

↓

Pond Area

↓

Pond

↓

Fish

↓

Feed

↓

Supplier

↓

Customer

↓

Employee

---

# 28. Deliverables

Codex harus menghasilkan:

✔ Migration

✔ Model

✔ Factory

✔ Seeder

✔ Relationship

✔ Policy

✔ Repository

✔ Service

---

# AI Coding Instructions

Implementasikan hanya database Master Data.

Gunakan Laravel Migration.

Gunakan PostgreSQL.

Gunakan UUID.

Gunakan Soft Delete.

Gunakan Relationship Eloquent.

Gunakan Foreign Key.

Jangan membuat tabel transaksi.

Jangan membuat Dashboard.

Jangan membuat Culture Cycle.

Pastikan seluruh migration dapat dijalankan tanpa error menggunakan perintah:

php artisan migrate

---

# End of Document