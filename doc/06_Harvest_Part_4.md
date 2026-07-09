# UtiFarm
# 06_Harvest
## Part 4 - Frontend & UI Specification

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 06_Harvest_Part_1.md
- 06_Harvest_Part_2.md
- 06_Harvest_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar User Interface (UI) dan User Experience (UX) untuk modul Harvest.

Harvest merupakan Harvest Management System (HMS) yang mengelola seluruh proses panen mulai dari perencanaan hingga pengiriman hasil panen.

UI harus mampu memandu pengguna mengikuti workflow panen secara berurutan.

---

# 2. Module Overview

Harvest terdiri dari:

- Harvest Dashboard
- Harvest Planning
- Harvest Batch
- Harvest Session
- Harvest Detail
- Quality Control
- Grading
- Packing
- Delivery
- Yield Analysis

---

# 3. Navigation

Sidebar

↓

Production

↓

Harvest

↓

Harvest Dashboard

---

# 4. Pages

Halaman yang tersedia:

- Harvest Dashboard
- Harvest Planning
- Harvest Batch List
- Harvest Detail
- Harvest Session
- Quality Control
- Grading
- Packing
- Delivery
- Yield Analysis

---

# 5. Harvest Dashboard

Dashboard menampilkan KPI:

- Total Harvest
- Harvest Today
- Pending Harvest
- Harvest Weight
- Grade A Percentage
- Pending Delivery
- Estimated Revenue
- Completed Harvest

---

# 6. Harvest Planning

Data Table.

Kolom:

- Planning Number
- Planned Date
- Pond
- Culture Cycle
- Estimated Weight
- Estimated Quantity
- Status

Toolbar:

- Create Planning
- Search
- Filter
- Export
- Refresh

---

# 7. Harvest Batch

Data Table.

Kolom:

- Batch Number
- Harvest Type
- Harvest Date
- Pond
- Customer
- Total Weight
- Status

Klik Batch membuka Detail Harvest.

---

# 8. Harvest Detail

Summary Card.

Menampilkan:

- Batch Number
- Pond
- Culture Cycle
- Harvest Type
- Harvest Date
- Customer
- Status

Tab:

Overview

Session

QC

Grading

Packing

Delivery

Yield Analysis

History

---

# 9. Harvest Session

Data Table.

Kolom:

- Session Number
- Start Time
- End Time
- Operator
- Weight
- Status

Button:

- Start Session
- Finish Session

---

# 10. Quality Control

Data Table.

Kolom:

- Inspection Date
- Inspector
- Average Size
- Fish Condition
- Quality Status
- Notes

---

# 11. Grading

Data Table.

Kolom:

- Grade
- Quantity
- Average Weight
- Total Weight
- Percentage

Visualisasi menggunakan Progress Bar.

---

# 12. Packing

Data Table.

Kolom:

- Packing Number
- Package Type
- Package Quantity
- Gross Weight
- Net Weight
- Operator

---

# 13. Delivery

Data Table.

Kolom:

- Delivery Number
- Customer
- Driver
- Vehicle
- Delivery Date
- Status

---

# 14. Yield Analysis

Dashboard menampilkan:

- Estimated Weight
- Actual Weight
- Yield Percentage
- Grade Distribution
- Packing Loss
- Delivery Loss

Gunakan Summary Card.

---

# 15. Charts

Tampilkan:

- Grade Distribution
- Harvest Trend
- Yield Trend
- Production Trend
- Harvest by Farm

---

# 16. Workflow Timeline

Tampilkan Progress Workflow.

Planning

↓

Approved

↓

Ready

↓

Harvesting

↓

QC

↓

Packing

↓

Delivery

↓

Completed

Status aktif diberi highlight.

---

# 17. Search

Support:

- Batch Number
- Planning Number
- Customer
- Pond
- Culture Cycle

Gunakan Debounce 500 ms.

---

# 18. Filter

Support:

- Farm
- Pond
- Customer
- Harvest Type
- Status
- Date Range

---

# 19. Sorting

Support:

- Harvest Date
- Batch Number
- Customer
- Created At

Default:

Harvest Date DESC

---

# 20. Notification Badge

Badge:

Planning

Ready

Harvesting

QC

Packing

Delivery

Completed

Cancelled

---

# 21. Dialog

Gunakan Confirmation Dialog untuk:

- Approve Planning
- Start Harvest
- Finish Session
- Complete QC
- Complete Packing
- Complete Delivery
- Complete Harvest

---

# 22. Loading State

Gunakan:

- Skeleton
- Spinner
- Table Loading
- Summary Card Loading

---

# 23. Empty State

Apabila belum ada Harvest.

Tampilkan:

Icon

↓

"No Harvest Data Found"

↓

Button

Create Harvest Planning

---

# 24. Responsive Design

Desktop

Split View

Tablet

Sidebar Collapse

Mobile

Card View

Bottom Sheet

---

# 25. Accessibility

Gunakan:

- Keyboard Navigation
- ARIA Label
- Focus Indicator
- Color Contrast

---

# 26. State Management

Gunakan:

React Query

Untuk:

- Harvest List
- Detail
- Session
- QC
- Grading
- Packing
- Delivery

Gunakan Context API / Zustand untuk state lokal.

---

# 27. API Integration

Flow:

Page

↓

Hook

↓

Service

↓

Axios

↓

REST API

Component tidak boleh mengakses API secara langsung.

---

# 28. User Experience Rules

- Workflow harus mengikuti urutan proses panen.
- Tombol aksi hanya muncul sesuai status.
- Dashboard diperbarui tanpa reload penuh.
- Semua aksi memberikan Toast Notification.
- Maksimal tiga klik untuk menjalankan aksi utama.

---

# 29. Approval Workflow UI

Apabila Approval diaktifkan:

Planning

↓

Waiting Approval

↓

Approved

↓

Harvest Ready

↓

Execution

↓

QC Approval

↓

Completed

Role yang tidak memiliki hak approval hanya dapat melihat status.

---

# 30. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan reusable component.
- Menggunakan Summary Card.
- Menggunakan Workflow Timeline Component.
- Menggunakan Data Table Component.
- Menggunakan React Query.
- Menggunakan React Hook Form.
- Menggunakan Zod Validation.
- Menggunakan Tailwind CSS.
- Tidak menggunakan inline style.
- Mengikuti UI Convention.
- Menghasilkan UI yang responsif dan konsisten.

---

# 31. Deliverables

Frontend harus menghasilkan:

- Harvest Dashboard
- Harvest Planning
- Harvest Batch
- Harvest Detail
- Harvest Session
- QC Module
- Grading Module
- Packing Module
- Delivery Module
- Yield Analysis Dashboard
- Workflow Timeline
- Responsive Layout

---

# End of Document