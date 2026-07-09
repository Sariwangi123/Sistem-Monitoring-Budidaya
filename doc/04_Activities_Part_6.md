# UtiFarm
# 04_Activities
## Part 6 - Notification & Automation Engine

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
- 04_Activities_Part_5.md

---

# 1. Purpose

Dokumen ini mendefinisikan Notification Engine dan Automation Engine pada modul Activities.

Tujuannya adalah membantu pengguna mengelola operasional budidaya secara proaktif.

Notification dan Automation bersifat membantu, bukan menggantikan keputusan pengguna.

---

# 2. Objective

Automation digunakan untuk:

- Reminder
- Alert
- Notification
- Scheduled Activity
- Automatic Activity
- Escalation

---

# 3. Automation Principles

Automation harus:

- Mudah dipahami.
- Mudah dikonfigurasi.
- Tidak mengubah transaksi bisnis secara otomatis.
- Tidak mengubah data utama tanpa tindakan pengguna.

Automation hanya menghasilkan:

- Reminder
- Notification
- Activity
- Recommendation

---

# 4. Notification Categories

Kategori Notification:

- Information
- Reminder
- Warning
- Critical
- Success

---

# 5. Notification Priority

Priority:

Low

Medium

High

Critical

---

# 6. Notification Channels

Versi MVP

- In-App Notification

Future

- Email
- WhatsApp
- Telegram
- Push Notification

---

# 7. Notification Lifecycle

Created

↓

Unread

↓

Read

↓

Archived

---

# 8. Automation Trigger

Automation dapat dipicu oleh:

- Event
- Jadwal
- Perubahan Data
- Kondisi Tertentu

---

# 9. Rule Based Automation

Automation menggunakan Rule.

Contoh:

IF

DO < Minimum

THEN

Create Critical Alert

---

IF

Feed Stock < Minimum

THEN

Create Low Stock Notification

---

IF

Sampling Due Date

THEN

Create Reminder

---

# 10. Reminder Rules

Reminder dibuat untuk:

- Feeding
- Sampling
- Water Quality
- Harvest
- Treatment
- Maintenance

---

# 11. Critical Alert Rules

Critical Alert dibuat apabila:

- DO rendah.
- pH di luar batas.
- Mortalitas tinggi.
- Feed habis.
- Populasi turun drastis.
- Culture Cycle gagal.

---

# 12. Daily Reminder

Setiap hari sistem memeriksa:

- Jadwal Feeding
- Jadwal Sampling
- Jadwal Water Quality
- Jadwal Harvest

Jika belum dilakukan maka sistem membuat Reminder.

---

# 13. Harvest Reminder

Sistem memberikan pengingat:

H-14

H-7

H-3

H-1

berdasarkan Estimated Harvest Date.

---

# 14. Warehouse Notification

Sistem membuat Notification apabila:

- Feed Minimum Stock
- Medicine Minimum Stock
- Expired Feed
- Expired Medicine

---

# 15. Finance Notification

Notification:

- Invoice Due
- Payment Due
- Outstanding Payment

---

# 16. Dashboard Notification

Dashboard menampilkan:

- Total Reminder
- Total Alert
- Critical Notification
- Pending Activity

---

# 17. Activity Integration

Setiap Notification otomatis membuat:

System Activity

Kategori:

System

Event Code:

ACT-SYS-001

dan seterusnya.

---

# 18. Escalation Rules

Reminder yang diabaikan dapat berubah menjadi Warning.

Warning yang diabaikan dapat berubah menjadi Critical.

Contoh:

Reminder

↓

Warning

↓

Critical

↓

Resolved

---

# 19. Automation Matrix

| Trigger | Condition | Automation |
|----------|-----------|------------|
| Feeding | Belum dilakukan | Reminder |
| Sampling | Lewat jadwal | Reminder |
| Water Quality | DO rendah | Critical Alert |
| Water Quality | pH abnormal | Warning |
| Mortality | > Threshold | Critical Alert |
| Warehouse | Feed minimum | Low Stock Notification |
| Harvest | H-7 | Harvest Reminder |
| Finance | Invoice jatuh tempo | Payment Reminder |

---

# 20. Notification Badge

Badge:

Information

Reminder

Warning

Critical

Resolved

---

# 21. User Rules

Pengguna dapat:

- Membaca Notification.
- Menandai sudah dibaca.
- Mengarsipkan.
- Membuka modul terkait.

Pengguna tidak dapat mengubah isi Notification.

---

# 22. Future Ready

Automation Engine harus mendukung:

- IoT Sensor
- AI Recommendation
- Machine Learning
- Smart Feeding
- Smart Water Quality

tanpa mengubah struktur utama.

---

# 23. Performance Rules

Gunakan:

- Queue
- Scheduler
- Cache
- Background Job

Automation tidak boleh mengganggu performa aplikasi utama.

---

# 24. Security Rules

Notification hanya dapat dilihat oleh pengguna yang memiliki hak akses terhadap Farm dan Culture Cycle terkait.

---

# 25. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Laravel Scheduler.
- Menggunakan Queue untuk proses berat.
- Menggunakan Notification Service.
- Tidak menjalankan automation secara synchronous apabila dapat dipindahkan ke background.
- Menghasilkan implementasi yang mudah dikembangkan.

---

# 26. Deliverables

Implementasi harus menghasilkan:

Backend

- Notification Service
- Reminder Service
- Automation Service
- Scheduler
- Queue Job
- Event Listener

Frontend

- Notification Center
- Notification Badge
- Reminder List
- Alert Panel

---

# 27. Definition of Done

Notification & Automation dianggap selesai apabila:

- Reminder berjalan sesuai jadwal.
- Alert dibuat berdasarkan Rule.
- Dashboard menampilkan Notification.
- Notification dapat dibaca pengguna.
- Automation berjalan melalui Scheduler.
- Queue digunakan untuk proses asynchronous.
- Dokumentasi diperbarui.

---

# End of Document