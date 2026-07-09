# UtiFarm
# 10_Notification
## Part 2 - Notification Architecture & Event Engine

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

---

# 1. Purpose

Dokumen ini mendefinisikan arsitektur Notification, Notification Event Engine, Event Bus, Notification Registry, Channel Resolver, dan Delivery Engine.

Notification menggunakan pendekatan Event Driven Architecture (EDA).

---

# 2. Notification Architecture

Notification menggunakan arsitektur:

Business Module

↓

Domain Event

↓

Event Bus

↓

Notification Event Engine

↓

Notification Registry

↓

Channel Resolver

↓

Delivery Engine

↓

Notification Center

↓

User

Notification tidak mengakses Business Module secara langsung.

---

# 3. Notification Philosophy

Notification menggunakan prinsip:

- Event Driven
- Loose Coupling
- Asynchronous Ready
- Channel Independent
- Modular
- Reusable

---

# 4. Notification Event Engine

Notification Event Engine bertugas:

- Menerima Domain Event
- Memvalidasi Event
- Menentukan Notification
- Menentukan Priority
- Menentukan Recipient
- Mengirim ke Delivery Engine

Engine tidak memiliki Business Logic.

---

# 5. Event Bus

Event Bus bertugas:

- Publish Event
- Subscribe Event
- Dispatch Event
- Retry Event

Event Bus menjadi pusat komunikasi antar modul.

---

# 6. Domain Event

Contoh Domain Event:

- HarvestCompletedEvent
- HarvestStartedEvent
- LowStockDetectedEvent
- StockReceivedEvent
- ExpenseApprovedEvent
- RevenuePostedEvent
- FinancialPeriodClosedEvent
- UserLoggedInEvent
- BackupCompletedEvent

Setiap Domain Event bersifat immutable.

---

# 7. Notification Registry

Seluruh Notification wajib terdaftar.

Metadata:

- Event Name
- Notification Type
- Priority
- Channel
- Recipient
- Template
- Retry Policy

---

# 8. Channel Resolver

Channel Resolver menentukan media pengiriman.

MVP:

- In-App

Future Ready:

- Email
- WhatsApp
- Telegram
- Push Notification
- SMS

---

# 9. Delivery Engine

Delivery Engine bertugas:

- Queue Notification
- Deliver Notification
- Retry Delivery
- Update Status

---

# 10. Recipient Resolver

Recipient Resolver menentukan penerima.

Berdasarkan:

- Role
- User
- Farm
- Department
- Company

---

# 11. Notification Template

Template terdiri dari:

- Title
- Message
- Icon
- Priority
- Action URL

Template dipisahkan dari Engine.

---

# 12. Notification Queue

Notification besar diproses menggunakan Queue.

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

---

# 13. Retry Policy

Retry maksimal:

3 kali.

Interval Retry dapat dikonfigurasi.

Setelah gagal:

Status menjadi Failed.

---

# 14. Delivery Status

Status:

Pending

↓

Sent

↓

Delivered

↓

Read

↓

Archived

---

# 15. Notification History

History menyimpan:

- Event
- Recipient
- Delivery Time
- Read Time
- Channel
- Status

---

# 16. Performance Rules

Gunakan:

- Queue
- Background Worker
- Cache Registry
- Batch Processing

Notification tidak boleh memperlambat transaksi utama.

---

# 17. Exception Handling

Gunakan Custom Exception.

Contoh:

- NotificationNotFoundException
- EventNotRegisteredException
- DeliveryFailedException
- InvalidRecipientException
- ChannelUnavailableException

---

# 18. Security Rules

Notification mengikuti:

- Authentication
- Authorization
- RBAC

Pengguna hanya menerima Notification sesuai hak akses.

---

# 19. Business Rules

- Notification tidak membuat transaksi.
- Notification tidak mengubah transaksi.
- Notification hanya memproses Domain Event.
- Domain Event bersifat immutable.
- Notification diproses secara asynchronous bila diperlukan.

---

# 20. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Event Driven Architecture.
- Menggunakan Notification Event Engine.
- Menggunakan Event Bus.
- Menggunakan Notification Registry.
- Menggunakan Delivery Engine.
- Menggunakan Queue.
- Menggunakan Service Layer.
- Menghasilkan implementasi production-ready.

---

# 21. Deliverables

Implementasi harus menghasilkan:

- Notification Event Engine
- Event Bus
- Notification Registry
- Channel Resolver
- Recipient Resolver
- Delivery Engine
- Notification Queue
- Background Worker
- Feature Test

---

# End of Document