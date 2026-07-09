# UtiFarm
# 04_Activities
## Part 1 - Overview & Business Process

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
- 03_Culture_Cycle

---

# 1. Purpose

Modul Activities merupakan pusat pencatatan seluruh aktivitas operasional budidaya.

Semua aktivitas yang dilakukan oleh pengguna maupun sistem harus tercatat pada modul ini.

Activities menjadi sumber utama histori operasional, audit operasional, timeline budidaya, dan analisis aktivitas.

---

# 2. Objective

Tujuan modul Activities adalah:

- Mencatat seluruh aktivitas budidaya.
- Menjadi timeline operasional.
- Menjadi histori seluruh Culture Cycle.
- Menjadi sumber data Dashboard.
- Menjadi sumber Audit Operasional.
- Menjadi dasar analisis produktivitas.

---

# 3. Scope

Modul ini mencakup:

- Manual Activity
- System Activity
- Daily Log
- Timeline
- Event Tracking
- Activity History
- Operational Notes

---

# 4. Business Process

Seluruh aktivitas berasal dari Culture Cycle.

Culture Cycle

↓

Running

↓

User Activity

↓

Activity Recorded

↓

Business Process

↓

Dashboard Update

↓

Audit Trail

↓

Timeline Updated

---

# 5. Actors

- Super Admin
- Farm Owner
- Farm Manager
- Technician
- Warehouse Staff
- Finance Staff
- Viewer (Read Only)

---

# 6. Dependency

Activities bergantung pada:

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

Employee

↓

Master Data

---

# 7. Activity Classification

Activity dibagi menjadi dua kategori.

## Manual Activity

Aktivitas yang dilakukan oleh pengguna.

Meliputi:

- Feeding
- Water Quality
- Sampling
- Mortality
- Treatment
- Maintenance
- Observation
- Cleaning
- Pond Preparation
- Fish Transfer
- Harvest Preparation

---

## System Activity

Aktivitas yang dibuat otomatis oleh sistem.

Meliputi:

- Culture Cycle Created
- Culture Cycle Started
- Culture Cycle Closed
- KPI Updated
- Dashboard Refreshed
- Warehouse Stock Updated
- Harvest Completed
- Finance Transaction Created
- User Login
- User Logout

---

# 8. Activity Categories

Setiap Activity memiliki Category.

Kategori:

Production

Feeding

Sampling

Water Quality

Treatment

Maintenance

Warehouse

Harvest

Finance

System

Security

---

# 9. Activity Timeline

Semua aktivitas disusun berdasarkan waktu.

Contoh:

08:00

↓

Feeding

↓

09:30

Water Quality

↓

11:00

Sampling

↓

15:00

Treatment

↓

17:00

Observation

Timeline menjadi histori utama Culture Cycle.

---

# 10. Business Event Matrix

| Event | Trigger | Source Module | Target Module |
|--------|----------|---------------|---------------|
| Stocking | User melakukan stocking | Culture Cycle | Activities |
| Feeding | User menyimpan feeding | Activities | Warehouse |
| Sampling | User menyimpan sampling | Activities | Culture Cycle |
| Water Quality | User menyimpan kualitas air | Activities | Dashboard |
| Mortality | User menyimpan mortalitas | Activities | Culture Cycle |
| Treatment | User menyimpan treatment | Activities | Warehouse |
| Partial Harvest | User melakukan panen sebagian | Harvest | Activities |
| Final Harvest | User melakukan panen akhir | Harvest | Finance |
| Dashboard Refresh | KPI berubah | Culture Cycle | Dashboard |
| System Notification | Event selesai | System | Activities |

---

# 11. Activity Flow

User

↓

Input Activity

↓

Validation

↓

Save Activity

↓

Update Related Module

↓

Refresh Dashboard

↓

Audit Trail

↓

Notification

---

# 12. Business Rules

- Setiap Activity wajib memiliki Culture Cycle.
- Setiap Activity wajib memiliki tanggal dan waktu.
- Setiap Activity wajib memiliki pelaksana (User).
- Activity tidak boleh berdiri sendiri tanpa referensi.
- Activity yang telah disimpan tidak boleh dihapus secara permanen.
- Semua perubahan wajib tercatat pada Audit Trail.

---

# 13. Timeline Rules

Timeline harus:

- Berurutan berdasarkan waktu.
- Menampilkan aktivitas terbaru di bagian atas (default).
- Dapat difilter berdasarkan tanggal, kategori, dan pengguna.
- Tidak boleh memiliki timestamp yang tidak valid.

---

# 14. Notification Rules

Beberapa Activity dapat menghasilkan notifikasi.

Contoh:

- Mortalitas tinggi.
- DO rendah.
- pH di luar batas normal.
- Feed hampir habis.
- Jadwal Sampling.
- Jadwal Panen.

---

# 15. Integration

Activities terintegrasi dengan:

Culture Cycle

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

---

# 16. Output

Modul menghasilkan:

- Activity Timeline
- Daily Log
- Operational History
- Dashboard Event
- Audit History
- Productivity Report

---

# 17. Acceptance Criteria

Modul dianggap memenuhi spesifikasi apabila:

✓ Seluruh aktivitas dapat dicatat.

✓ Timeline diperbarui secara otomatis.

✓ Integrasi antar modul berjalan.

✓ Audit Trail tersimpan.

✓ Dashboard menerima pembaruan.

✓ Riwayat aktivitas dapat ditelusuri.

---

# 18. AI Coding Instructions

AI Coding Assistant wajib:

- Menjadikan Activities sebagai pusat histori operasional.
- Tidak membuat Activity tanpa referensi Culture Cycle.
- Menggunakan Event Matrix sebagai acuan integrasi.
- Mencatat seluruh aktivitas sistem secara otomatis.
- Mengikuti seluruh Business Rules.
- Menghasilkan implementasi yang production-ready.

---

# 19. Deliverables

Dokumen berikutnya:

04_Activities_Part_2.md

Membahas:

- Database Design
- Entity Relationship
- Activity Table
- Event Table
- Timeline Table
- Constraint
- Migration Rules

---

# End of Document