# UtiFarm
# 06_Harvest
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
- 06_Harvest_Part_1.md
- 06_Harvest_Part_2.md
- 06_Harvest_Part_3.md
- 06_Harvest_Part_4.md

---

# 1. Purpose

Dokumen ini mendefinisikan aturan implementasi dan Business Engine untuk modul Harvest.

Harvest menggunakan pendekatan Harvest Management System (HMS) berbasis Workflow.

Seluruh proses panen harus mengikuti urutan bisnis yang telah ditentukan.

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

Business Validation

↓

Workflow Engine

↓

Database

↓

Activity

↓

Dashboard

↓

Finance

↓

Audit Trail

Controller tidak diperbolehkan memiliki Business Logic.

---

# 3. Harvest Principles

Prinsip utama:

- Harvest mengikuti Workflow.
- Setiap perubahan status harus tervalidasi.
- Setiap proses menghasilkan Activity.
- Seluruh histori harus dapat ditelusuri.
- Finance hanya menerima Harvest yang telah selesai.

---

# 4. Harvest Workflow

Planning

↓

Approved (Optional)

↓

Ready

↓

Harvesting

↓

Quality Control

↓

Packing

↓

Delivery

↓

Completed

↓

Closed

Workflow tidak boleh dilewati.

---

# 5. Harvest Planning Process

Flow:

Validation

↓

Planning Created

↓

Activity

↓

Dashboard

↓

Waiting Approval (Optional)

---

# 6. Harvest Execution Process

Flow:

Ready

↓

Start Harvest

↓

Create Harvest Session

↓

Harvest Detail

↓

Update Progress

↓

Activity

↓

Dashboard

---

# 7. Harvest Session Engine

Satu Harvest Batch dapat memiliki banyak Harvest Session.

Setiap Session:

- Memiliki Operator.
- Memiliki Waktu Mulai.
- Memiliki Waktu Selesai.
- Memiliki Harvest Detail.
- Memiliki QC.

Session dapat berjalan secara berurutan.

---

# 8. Quality Control Process

Flow:

Harvest Session

↓

Inspection

↓

Quality Assessment

↓

QC Result

↓

Activity

↓

Approval (Optional)

QC menjadi syarat sebelum Grading.

---

# 9. Grading Process

Flow:

Harvest Detail

↓

Grade A

↓

Grade B

↓

Grade C

↓

Grade BS

↓

Validation

↓

Yield Update

Jumlah seluruh Grade harus sama dengan Total Harvest.

---

# 10. Packing Process

Flow:

Grading

↓

Packing

↓

Package Verification

↓

Packing Completed

↓

Activity

Packing tidak boleh melebihi berat hasil Grading.

---

# 11. Delivery Process

Flow:

Packing Completed

↓

Delivery Preparation

↓

Shipment

↓

Delivered

↓

Finance Integration

↓

Activity

---

# 12. Yield Calculation

Yield dihitung berdasarkan:

Estimated Harvest

↓

Actual Harvest

↓

Grading

↓

Packing

↓

Delivery

Sistem menghitung:

- Yield Percentage
- Packing Loss
- Delivery Loss

---

# 13. Culture Cycle Integration

Partial Harvest

↓

Culture Cycle tetap Active.

Final Harvest

↓

Culture Cycle Closed.

---

# 14. Warehouse Integration

Harvest menggunakan data Warehouse untuk:

- Kemasan
- Material Pendukung
- Barang Operasional

Perubahan stok dicatat melalui Inventory Movement.

---

# 15. Activities Integration

Seluruh proses berikut wajib membuat Activity:

- Planning
- Start Harvest
- Finish Session
- QC
- Grading
- Packing
- Delivery
- Complete Harvest

---

# 16. Finance Integration

Finance hanya menerima Harvest dengan status:

Completed

Data yang dikirim:

- Total Weight
- Grade
- Customer
- Delivery
- Yield Summary

---

# 17. Reference Engine

Setiap transaksi wajib memiliki:

Reference Type

Reference UUID

Contoh:

Culture Cycle

Harvest Planning

Harvest Batch

Harvest Session

Packing

Delivery

Finance

---

# 18. Exception Handling

Gunakan Custom Exception.

Contoh:

- InvalidHarvestStatusException
- InvalidHarvestSessionException
- InvalidGradingException
- PackingWeightExceededException
- DeliveryBeforePackingException
- HarvestAlreadyCompletedException

---

# 19. Database Transaction

Gunakan DB::transaction() untuk:

- Create Harvest Batch
- Create Harvest Session
- Save Harvest Detail
- Save QC
- Save Grading
- Save Packing
- Save Delivery
- Complete Harvest

Rollback apabila salah satu proses gagal.

---

# 20. Performance Rules

Gunakan:

- Eager Loading
- Composite Index
- Lazy Loading Attachment
- Background Job untuk Analytics
- Optimized Query

Hindari Query N+1.

---

# 21. Security Rules

Harvest harus menerapkan:

- Authentication
- Authorization
- Audit Trail
- Role Based Access Control (RBAC)

Harvest Completed tidak dapat diubah kecuali oleh Super Admin.

---

# 22. Business Rules

- Harvest wajib memiliki Culture Cycle.
- Harvest wajib memiliki Harvest Batch.
- Harvest Session wajib memiliki Operator.
- QC wajib selesai sebelum Grading.
- Grading wajib selesai sebelum Packing.
- Packing wajib selesai sebelum Delivery.
- Delivery wajib selesai sebelum Finance.
- Final Harvest menutup Culture Cycle.
- Completed Harvest bersifat Read Only.

---

# 23. Acceptance Criteria

Business Engine dianggap selesai apabila:

✓ Harvest Planning berjalan.

✓ Harvest Session berjalan.

✓ Quality Control berjalan.

✓ Grading berjalan.

✓ Packing berjalan.

✓ Delivery berjalan.

✓ Yield Calculation berjalan.

✓ Activities menerima seluruh Event.

✓ Finance menerima Harvest Completed.

✓ Dashboard diperbarui otomatis.

---

# 24. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Service Layer.
- Menggunakan Repository Pattern.
- Menggunakan Workflow Engine.
- Menggunakan DB Transaction.
- Menggunakan UUID.
- Menggunakan Soft Delete.
- Menggunakan Audit Trail.
- Menggunakan Workflow sebagai dasar implementasi.
- Menghasilkan implementasi production-ready.

---

# 25. Deliverables

Backend

- Migration
- Model
- Repository
- Service
- Controller
- Form Request
- Resource
- Policy
- Feature Test

Frontend

- Workflow Timeline
- Harvest Workspace
- Harvest Session
- QC
- Grading
- Packing
- Delivery
- Yield Dashboard

---

# 26. Definition of Done

Modul Harvest dinyatakan selesai apabila:

- Workflow berjalan sesuai urutan.
- Harvest Session berjalan.
- QC berjalan.
- Grading berjalan.
- Packing berjalan.
- Delivery berjalan.
- Yield Calculation benar.
- Activities terintegrasi.
- Warehouse terintegrasi.
- Finance terintegrasi.
- Dashboard diperbarui.
- Seluruh Feature Test lulus.
- Dokumentasi diperbarui.

---

# End of Document