# UtiFarm
# 03_Culture_Cycle
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
- 01_Milestone_Foundation.md
- 02_Master_Data
- 03_Culture_Cycle_Part_1.md

---

# 1. Purpose

Dokumen ini mendefinisikan struktur database untuk modul Culture Cycle.

Seluruh tabel harus mengikuti standar pada
00_Database_Convention.md.

---

# 2. Database Principles

Seluruh tabel wajib:

- UUID
- Soft Delete
- Audit Trail
- Timestamp
- Foreign Key
- Index

---

# 3. Main Entity

Entity utama:

Culture Cycle

↓

Sampling

↓

Mortality

↓

Water Quality

↓

Growth Summary

↓

Feed Summary

↓

Treatment Summary

↓

Harvest Summary

---

# 4. Entity Relationship

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

Sampling

↓

Activities

↓

Harvest

↓

Finance

---

# 5. Table : culture_cycles

Deskripsi

Menyimpan informasi utama satu siklus budidaya.

Primary Key

id

UUID

uuid

Relationship

company_id

farm_id

pond_area_id

pond_id

fish_species_id

fish_strain_id

supplier_id

employee_id

Field

cycle_code

cycle_name

stocking_date

estimated_harvest_date

actual_harvest_date

initial_seed_quantity

current_population

initial_average_weight

current_average_weight

current_biomass

status

notes

---

# 6. Status

Status yang diperbolehkan:

Draft

Prepared

Stocked

Running

Harvesting

Completed

Archived

---

# 7. Constraint

Satu Pond hanya boleh memiliki:

1 Culture Cycle

dengan status:

Draft

Prepared

Stocked

Running

Harvesting

Tidak boleh terdapat dua cycle aktif.

---

# 8. Table : culture_cycle_samplings

Relationship

culture_cycle_id

Field

sampling_date

sample_count

average_weight

average_length

biomass

adg

survival_rate

notes

---

# 9. Table : culture_cycle_mortalities

Relationship

culture_cycle_id

Field

mortality_date

dead_count

mortality_reason

notes

---

# 10. Table : culture_cycle_water_qualities

Relationship

culture_cycle_id

Field

measurement_date

temperature

ph

do

ammonia

nitrite

salinity

notes

---

# 11. Table : culture_cycle_feed_summaries

Relationship

culture_cycle_id

feed_id

Field

feeding_date

feed_quantity

feeding_frequency

notes

---

# 12. Table : culture_cycle_treatments

Relationship

culture_cycle_id

medicine_id

Field

treatment_date

dosage

reason

executor_id

notes

---

# 13. Table : culture_cycle_growths

Relationship

culture_cycle_id

Field

growth_date

average_weight

weight_gain

adg

biomass

population

notes

---

# 14. Table : culture_cycle_harvests

Relationship

culture_cycle_id

customer_id

Field

harvest_date

harvest_type

grade

quantity

average_weight

total_weight

selling_price

total_value

notes

---

# 15. Calculated Fields

Field berikut tidak diinput manual.

current_population

current_average_weight

current_biomass

survival_rate

adg

fcr

feed_consumption

total_production

Seluruh nilai dihitung otomatis oleh Service Layer.

---

# 16. Foreign Key Rules

Gunakan:

ON UPDATE CASCADE

ON DELETE RESTRICT

---

# 17. Index Rules

Index wajib dibuat pada:

uuid

culture_cycle_id

pond_id

stocking_date

status

harvest_date

created_at

deleted_at

---

# 18. Migration Order

companies

↓

farms

↓

pond_areas

↓

ponds

↓

master_data

↓

culture_cycles

↓

sampling

↓

mortality

↓

water_quality

↓

feed_summary

↓

treatment

↓

harvest

---

# 19. Seeder

Minimal Seeder:

Status Culture Cycle

Harvest Type

Water Quality Parameter

---

# 20. Factory

Semua tabel memiliki Factory.

Digunakan untuk:

Testing

Development

---

# 21. Business Constraint

- Tidak boleh menghapus Culture Cycle yang memiliki transaksi.
- Sampling tidak boleh dibuat apabila status belum Running.
- Harvest hanya dapat dilakukan pada status Harvesting.
- Completed bersifat Read Only.

---

# 22. Database Transaction

Seluruh proses berikut menggunakan DB Transaction:

- Create Cycle
- Stocking
- Harvest
- Close Cycle
- Restore

---

# 23. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan seluruh relationship Eloquent.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Migration Laravel.
- Menggunakan Foreign Key.
- Menggunakan Audit Trail.
- Tidak menyimpan calculated field secara manual.
- Menghitung seluruh KPI melalui Service Layer.

---

# 24. Deliverables

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