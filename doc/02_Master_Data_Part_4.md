# AI IMPLEMENTATION INSTRUCTION

Anda adalah Senior Frontend Engineer, UI Architect, React Specialist, dan UX Designer.

Gunakan dokumen berikut sebagai referensi utama:

1. 00_Project_Master.md
2. 01_Milestone_Foundation.md
3. 02_Master_Data_Part_1.md
4. 02_Master_Data_Part_2.md
5. 02_Master_Data_Part_3.md

Dokumen ini hanya membahas spesifikasi Frontend untuk Modul Master Data.

Gunakan:

- React
- TypeScript
- Vite
- TailwindCSS

Gunakan Component Based Architecture.

Gunakan Responsive Design.

Gunakan reusable component.

Jangan membuat business logic di dalam UI.

Seluruh komunikasi data menggunakan REST API.

---

# UtiFarm

# 02_Master_Data

## Part 4 — Frontend & UI Specification

Version : 1.0

Depends

- 00_Project_Master.md
- 01_Milestone_Foundation.md
- 02_Master_Data_Part_1.md
- 02_Master_Data_Part_2.md
- 02_Master_Data_Part_3.md

---

# 1. Objective

Frontend Master Data digunakan untuk mengelola seluruh data referensi aplikasi UtiFarm.

Seluruh halaman harus memiliki tampilan yang konsisten.

Seluruh komponen harus reusable.

---

# 2. Layout Standard

Semua halaman menggunakan layout berikut.

```

Header

↓

Sidebar

↓

Breadcrumb

↓

Toolbar

↓

Filter

↓

Data Table

↓

Pagination

↓

Footer

```

---

# 3. Menu Structure

Master Data

├── Company

├── Farm

├── Pond Area

├── Pond

├── Fish Species

├── Fish Strain

├── Feed Brand

├── Feed Category

├── Feed Type

├── Medicine

├── Probiotic

├── Vitamin

├── Supplier

├── Customer

├── Employee

├── Unit

└── General Reference

---

# 4. Page Standard

Setiap halaman CRUD memiliki struktur berikut.

Header

↓

Search Box

↓

Filter

↓

Action Button

↓

Data Table

↓

Pagination

↓

Information Summary

---

# 5. Data Table Standard

Kolom wajib mendukung:

- Sorting
- Filtering
- Search
- Pagination
- Hide Column
- Export
- Refresh

---

# 6. Toolbar Standard

Toolbar memiliki tombol berikut.

Create

Import

Export

Refresh

Column Setting

---

# 7. Search Standard

Search menggunakan:

- Instant Search
- Debounce 500 ms
- Server Side Search

---

# 8. Filter Standard

Support filter:

Status

Company

Farm

Category

Date

Supplier

Customer

---

# 9. Pagination

Support:

10

25

50

100

200

records

---

# 10. CRUD Form

Semua Form memiliki:

General Information

↓

Validation

↓

Save Button

↓

Cancel Button

---

# 11. Form Validation

Validasi dilakukan:

Realtime

On Submit

Server Validation

---

# 12. Input Component

Gunakan komponen berikut.

Text Box

Textarea

Number

Currency

Email

Phone

Password

Date

Time

Datetime

Checkbox

Radio Button

Switch

Select

Multi Select

Auto Complete

Upload Image

Upload File

---

# 13. Modal Standard

Semua modal memiliki ukuran.

Small

Medium

Large

Fullscreen

---

# 14. Delete Confirmation

Gunakan dialog konfirmasi.

Title

Delete Confirmation

Message

Apakah Anda yakin ingin menghapus data ini?

Button

Delete

Cancel

---

# 15. Loading State

Gunakan:

Skeleton Loading

Button Loading

Table Loading

---

# 16. Empty State

Apabila data kosong tampilkan:

Icon

Message

Action Button

---

# 17. Error State

Apabila API gagal.

Tampilkan:

Error Icon

Error Message

Retry Button

---

# 18. Success Notification

Gunakan Toast Notification.

Success

Warning

Info

Error

---

# 19. Upload Standard

Support:

JPG

PNG

PDF

XLSX

CSV

Maximum Size

10 MB

---

# 20. Responsive Design

Breakpoint

Mobile

Tablet

Desktop

Large Desktop

---

# 21. Accessibility

Gunakan:

ARIA Label

Keyboard Navigation

Focus Indicator

Color Contrast

---

# 22. Permission UI

Button Create

↓

Permission Create

Button Edit

↓

Permission Update

Button Delete

↓

Permission Delete

Button Export

↓

Permission Export

---

# 23. Component Structure

Gunakan reusable component.

Table

Form

Modal

Button

Input

Card

Badge

Alert

Toast

Loading

Pagination

Search

Filter

---

# 24. Folder Structure

```

src/

components/

common/

datatable/

forms/

layout/

modal/

pages/

master-data/

hooks/

services/

types/

utils/

```

---

# 25. State Management

Gunakan:

React Query

Context API

atau Zustand

Seluruh state server menggunakan React Query.

---

# 26. API Integration

Gunakan Axios.

Pisahkan:

API Client

Service

Hooks

UI

---

# 27. Validation Library

Gunakan:

React Hook Form

+

Zod

---

# 28. Performance

Gunakan:

Lazy Loading

Memoization

Virtual Table

Code Splitting

---

# 29. Deliverables

Codex harus menghasilkan:

✔ Layout

✔ Sidebar

✔ Breadcrumb

✔ CRUD Page

✔ DataTable

✔ Form

✔ Modal

✔ Search

✔ Filter

✔ Pagination

✔ API Integration

✔ Validation

✔ Responsive UI

---

# 30. AI Coding Instructions

Seluruh halaman harus menggunakan reusable component.

Jangan membuat styling inline.

Gunakan TailwindCSS.

Gunakan React Hook Form.

Gunakan Zod Validation.

Gunakan React Query.

Gunakan Axios.

Gunakan TypeScript Strict Mode.

Pisahkan:

UI

↓

Hook

↓

Service

↓

API

↓

Backend

Jangan membuat business logic pada component React.

Pastikan seluruh UI siap digunakan untuk seluruh Master Data.

---

# End of Document