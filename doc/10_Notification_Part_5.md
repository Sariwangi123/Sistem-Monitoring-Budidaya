# UtiFarm
# 10_Notification
## Part 5 - Notification Engine & Business Rules

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
- 10_Notification_Part_1.md
- 10_Notification_Part_2.md
- 10_Notification_Part_3.md
- 10_Notification_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan Notification Engine, Delivery Engine, Notification Policy Engine, serta Business Rules pada modul Notification.

Notification Engine bertanggung jawab mengelola seluruh proses komunikasi sistem secara konsisten dan terpusat.

---

# 2. Notification Engine

Flow implementasi:

Domain Event

↓

Notification Event Engine

↓

Notification Policy Engine

↓

Recipient Resolver

↓

Channel Resolver

↓

Notification Queue

↓

Delivery Engine

↓

Notification Center

↓

User

Controller tidak memiliki Business Logic.

---

# 3. Notification Principles

Notification menggunakan prinsip:

- Event Driven
- Read Only terhadap Business Module
- Asynchronous
- Loose Coupling
- Modular
- Channel Independent
- Scalable

---

# 4. Notification Workflow

Business Event

↓

Event Validation

↓

Policy Resolution

↓

Recipient Resolution

↓

Channel Resolution

↓

Queue

↓

Delivery

↓

Status Update

↓

History

---

# 5. Notification Event Engine

Notification Event Engine bertugas:

- Menerima Domain Event.
- Memvalidasi Event.
- Memanggil Policy Engine.
- Membuat Notification Task.
- Mengirim ke Queue.

Engine tidak memiliki Business Logic.

---

# 6. Notification Policy Engine

Policy Engine menentukan:

- Priority
- Recipient
- Channel
- Expired Time
- Retry Policy
- Action URL

Policy dipisahkan dari kode program.

---

# 7. Recipient Resolver

Recipient Resolver menentukan penerima berdasarkan:

- User
- Role
- Farm
- Department
- Company

Recipient dapat lebih dari satu.

---

# 8. Channel Resolver

Channel Resolver menentukan media pengiriman.

MVP:

- In-App Notification

Future Ready:

- Email
- WhatsApp
- Telegram
- Push Notification
- SMS

---

# 9. Delivery Engine

Delivery Engine bertugas:

- Mengirim Notification.
- Memperbarui Status.
- Menjalankan Retry.
- Menyimpan History.

---

# 10. Queue Processing

Notification diproses menggunakan Queue.

Status:

Pending

↓

Processing

↓

Delivered

↓

Failed

↓

Retry

↓

Archived

---

# 11. Retry Policy

Retry maksimal:

3 kali.

Interval Retry dapat dikonfigurasi.

Notification yang tetap gagal diberi status Failed.

---

# 12. Notification Status

Status yang didukung:

- Pending
- Sent
- Delivered
- Read
- Archived
- Failed

---

# 13. Notification History

History menyimpan:

- Event Name
- Notification Type
- Recipient
- Channel
- Delivery Time
- Read Time
- Status

History bersifat Read Only.

---

# 14. Notification Lifecycle

Notification mengikuti siklus:

Created

↓

Queued

↓

Delivered

↓

Read

↓

Archived

---

# 15. Performance Rules

Gunakan:

- Queue
- Background Worker
- Batch Delivery
- Cache Registry
- Lazy Loading

Notification tidak boleh memperlambat transaksi bisnis.

---

# 16. Security Rules

Notification menerapkan:

- Authentication
- Authorization
- Role Based Access Control (RBAC)
- Audit Trail

Pengguna hanya dapat melihat Notification miliknya.

---

# 17. Exception Handling

Gunakan Custom Exception.

Contoh:

- NotificationPolicyException
- NotificationDeliveryException
- RecipientNotFoundException
- ChannelNotAvailableException
- NotificationQueueException

---

# 18. Logging

Catat:

- Event Name
- Notification ID
- Recipient
- Channel
- Delivery Status
- Retry Count
- Execution Time

---

# 19. Business Rules

- Notification tidak mengubah Business Module.
- Notification hanya menerima Domain Event.
- Domain Event bersifat immutable.
- Notification diproses melalui Queue.
- Notification mengikuti Policy Engine.
- Notification History tidak boleh diubah.

---

# 20. Quality Assurance

Setiap Notification wajib memiliki:

- Unit Test
- Feature Test
- Delivery Test
- Queue Test
- Permission Test
- Retry Test

---

# 21. Acceptance Criteria

Notification Engine dianggap selesai apabila:

✓ Notification Event Engine berjalan.

✓ Notification Policy Engine berjalan.

✓ Recipient Resolver berjalan.

✓ Channel Resolver berjalan.

✓ Queue Processing berjalan.

✓ Delivery Engine berjalan.

✓ Retry Policy berjalan.

✓ Notification History berjalan.

✓ Seluruh Feature Test lulus.

---

# 22. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Notification Event Engine.
- Menggunakan Notification Policy Engine.
- Menggunakan Queue.
- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan Background Worker.
- Menghasilkan implementasi production-ready.
- Mengikuti seluruh Business Rules.

---

# 23. Deliverables

Backend

- Notification Controller
- Notification Service
- Notification Event Engine
- Notification Policy Engine
- Recipient Resolver
- Channel Resolver
- Delivery Engine
- Queue Worker
- Notification History Service
- Feature Test

Frontend

- Notification Center
- Notification History
- Notification Preference
- Notification Badge
- Notification Action Panel

---

# 24. Definition of Done

Notification dianggap selesai apabila:

- Notification Center berjalan.
- Notification Event Engine berjalan.
- Notification Policy Engine berjalan.
- Queue Processing berjalan.
- Delivery Engine berjalan.
- Notification History berjalan.
- Retry Policy berjalan.
- Hak akses diterapkan.
- Dokumentasi diperbarui.

---

# End of Document