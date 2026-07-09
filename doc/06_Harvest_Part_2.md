# UtiFarm
# 06_Harvest
## Part 2 - Database Design

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

---

# 1. Purpose

Dokumen ini mendefinisikan struktur database untuk modul Harvest.

Harvest menggunakan konsep Harvest Management System (HMS) yang mengelola seluruh proses panen mulai dari perencanaan hingga pengiriman hasil panen.

Seluruh proses harus memiliki histori yang dapat ditelusuri.

---

# 2. Database Principles

Seluruh tabel wajib menggunakan:

- UUID
- Soft Delete
- Audit Trail
- Timestamp
- Foreign Key
- Index

---

# 3. Harvest Philosophy

Harvest menggunakan prinsip:

Harvest Planning

↓

Harvest Batch

↓

Harvest Session

↓

Grading

↓

Packing

↓

Delivery

↓

Finance

Harvest Batch menjadi identitas bisnis utama.

Harvest Session menjadi pelaksanaan panen di lapangan.

---

# 4. Main Entities

Entity utama:

Harvest Planning

↓

Harvest Batch

↓

Harvest Session

↓

Harvest Detail

↓

Harvest Grading

↓

Harvest QC

↓

Harvest Packing

↓

Harvest Delivery

---

# 5. Entity Relationship

Company

↓

Farm

↓

Pond

↓

Culture Cycle

↓

Harvest Planning

↓

Harvest Batch

↓

Harvest Session

↓

Harvest Grading

↓

Harvest Packing

↓

Harvest Delivery

---

# 6. Table : harvest_plannings

Deskripsi

Perencanaan panen.

Relationship

culture_cycle_id

Field

planning_number

planned_date

estimated_weight

estimated_quantity

status

notes

---

# 7. Table : harvest_batches

Deskripsi

Dokumen utama panen.

Relationship

harvest_planning_id

culture_cycle_id

customer_id

Field

batch_number

harvest_type

harvest_date

status

notes

---

# 8. Table : harvest_sessions

Deskripsi

Pelaksanaan panen dalam satu batch.

Relationship

harvest_batch_id

Field

session_number

start_time

end_time

operator_id

status

notes

---

# 9. Table : harvest_details

Relationship

harvest_session_id

Field

fish_quantity

average_weight

total_weight

basket_count

notes

---

# 10. Table : harvest_gradings

Relationship

harvest_detail_id

Field

grade

quantity

average_weight

total_weight

percentage

notes

---

# 11. Table : harvest_quality_controls

Relationship

harvest_session_id

Field

inspection_date

quality_status

average_size

fish_condition

remarks

inspector_id

---

# 12. Table : harvest_packings

Relationship

harvest_batch_id

Field

packing_number

package_type

package_quantity

gross_weight

net_weight

packing_date

operator_id

---

# 13. Table : harvest_deliveries

Relationship

harvest_batch_id

customer_id

Field

delivery_number

delivery_date

vehicle_number

driver_name

destination

status

notes

---

# 14. Harvest Types

Harvest Type:

- Partial Harvest
- Final Harvest
- Emergency Harvest

---

# 15. Harvest Status

Planning

↓

Scheduled

↓

Ready

↓

Harvesting

↓

QC

↓

Packing

↓

Delivered

↓

Completed

---

# 16. Reference Rules

reference_type

Contoh:

Culture Cycle

Activities

Finance

Warehouse

Customer

reference_uuid

UUID transaksi asal.

---

# 17. Constraint Rules

- Harvest Batch wajib memiliki Culture Cycle.
- Harvest Session wajib memiliki Harvest Batch.
- Harvest Detail wajib memiliki Harvest Session.
- Grading wajib memiliki Harvest Detail.
- Packing wajib memiliki Harvest Batch.
- Delivery wajib memiliki Harvest Batch.
- Final Harvest hanya dapat dilakukan satu kali untuk setiap Culture Cycle.

---

# 18. Index Strategy

Index wajib dibuat pada:

uuid

planning_number

batch_number

session_number

delivery_number

harvest_date

culture_cycle_id

customer_id

created_at

deleted_at

---

# 19. Performance Strategy

Gunakan:

- Composite Index
- Server Side Search
- Server Side Pagination
- Eager Loading
- Optimized Query

---

# 20. Migration Order

harvest_plannings

↓

harvest_batches

↓

harvest_sessions

↓

harvest_details

↓

harvest_gradings

↓

harvest_quality_controls

↓

harvest_packings

↓

harvest_deliveries

---

# 21. Seeder

Minimal Seeder:

Harvest Type

Harvest Status

Grade

Packing Type

Quality Status

---

# 22. Factory

Factory digunakan untuk:

- Testing
- Dummy Harvest
- Dummy Batch
- Dummy Session
- Performance Testing

---

# 23. Business Constraint

- Harvest Session tidak boleh berada di luar Harvest Batch.
- Total Grading harus sama dengan Total Harvest Detail.
- Packing tidak boleh melebihi Total Harvest.
- Delivery hanya dapat dilakukan setelah Packing selesai.
- Completed Harvest bersifat Read Only.

---

# 24. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Harvest Batch sebagai identitas bisnis utama.
- Menggunakan Harvest Session sebagai pelaksanaan panen.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Menggunakan Eloquent Relationship.
- Menggunakan DB Transaction pada seluruh proses panen.
- Menghasilkan implementasi production-ready.

---

# 25. Deliverables

Implementasi harus menghasilkan:

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