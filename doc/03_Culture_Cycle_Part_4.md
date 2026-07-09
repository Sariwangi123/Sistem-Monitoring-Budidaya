# UtiFarm
# 03_Culture_Cycle
## Part 4 - Frontend & UI Specification

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 03_Culture_Cycle_Part_1.md
- 03_Culture_Cycle_Part_2.md
- 03_Culture_Cycle_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan tampilan (UI) dan alur penggunaan (UX) pada modul Culture Cycle.

Seluruh halaman harus mengikuti standar yang terdapat pada:

00_UI_Convention.md

---

# 2. Module Overview

Culture Cycle merupakan pusat operasional budidaya.

Pengguna dapat:

- Membuat Culture Cycle
- Melakukan Stocking
- Monitoring Budidaya
- Mencatat Sampling
- Mencatat Water Quality
- Mencatat Mortalitas
- Mencatat Feeding
- Mencatat Treatment
- Melakukan Harvest
- Menutup Cycle

---

# 3. Navigation

Sidebar

↓

Production

↓

Culture Cycle

↓

List Culture Cycle

---

# 4. Pages

Modul terdiri dari halaman:

- Culture Cycle List
- Create Culture Cycle
- Culture Cycle Detail
- Sampling
- Water Quality
- Feeding
- Mortality
- Treatment
- Harvest
- KPI Summary

---

# 5. Culture Cycle List

Data Table berisi:

- Cycle Code
- Pond
- Fish Species
- Stocking Date
- Population
- Biomass
- Status
- Action

Toolbar:

- Add Cycle
- Search
- Filter
- Export
- Refresh

---

# 6. Create Culture Cycle

Menggunakan Wizard.

Step 1

Farm

↓

Pond Area

↓

Pond

---

Step 2

Fish Species

↓

Fish Strain

↓

Supplier

---

Step 3

Stocking Information

↓

Review

↓

Save

---

# 7. Detail Page

Bagian atas:

Summary Card

Menampilkan:

- Cycle Code
- Pond
- Species
- Population
- Biomass
- Status
- Culture Age (Hari)

---

# 8. KPI Cards

Tampilkan:

- Biomass
- Survival Rate
- FCR
- ADG
- Feed Consumption
- Average Weight

Gunakan Card yang konsisten.

---

# 9. Tabs

Gunakan Tab Navigation.

Tab:

Overview

Sampling

Water Quality

Feeding

Mortality

Treatment

Harvest

History

---

# 10. Timeline

Tampilkan Timeline.

Contoh:

Draft

↓

Prepared

↓

Stocked

↓

Running

↓

Harvesting

↓

Completed

Status aktif diberi highlight.

---

# 11. Sampling Page

Data Table.

Kolom:

Tanggal

Average Weight

Average Length

Sample Count

Biomass

ADG

SR

Action

Button:

Tambah Sampling

---

# 12. Water Quality

Data Table.

Kolom:

Tanggal

Temperature

pH

DO

Ammonia

Nitrite

Salinity

Action

---

# 13. Feeding

Data Table.

Kolom:

Tanggal

Feed

Quantity

Frequency

Operator

Action

---

# 14. Mortality

Data Table.

Kolom:

Tanggal

Dead Count

Reason

Operator

Action

---

# 15. Treatment

Data Table.

Kolom:

Tanggal

Medicine

Dosage

Reason

Executor

Action

---

# 16. Harvest

Data Table.

Kolom:

Tanggal

Harvest Type

Quantity

Average Weight

Total Weight

Selling Price

Total Value

Action

---

# 17. Charts

Gunakan Chart untuk:

Growth

↓

Biomass

↓

Feed Consumption

↓

Water Quality

↓

Mortality Trend

---

# 18. Action Button

Button berubah mengikuti Status.

Draft

- Edit
- Delete
- Prepare

Prepared

- Stocking

Running

- Sampling
- Feeding
- Water Quality
- Mortality
- Treatment
- Partial Harvest

Harvesting

- Final Harvest

Completed

- View Only

Archived

- View Only

---

# 19. Form Standard

Gunakan:

React Hook Form

+

Zod

Semua input tervalidasi sebelum dikirim.

---

# 20. Dialog

Gunakan Confirmation Dialog.

Untuk:

- Delete
- Prepare
- Stocking
- Final Harvest
- Close Cycle

---

# 21. Notification

Gunakan Toast.

Jenis:

Success

Warning

Error

Information

---

# 22. Loading

Gunakan:

Skeleton

Spinner

Button Loading

Table Loading

---

# 23. Empty State

Apabila belum ada Culture Cycle.

Tampilkan:

Icon

↓

"No Culture Cycle Found"

↓

Button

Create Culture Cycle

---

# 24. Responsive Design

Desktop

Tablet

Mobile

Semua halaman harus responsif.

---

# 25. Accessibility

Gunakan:

Keyboard Navigation

ARIA Label

Focus Indicator

Color Contrast

---

# 26. State Management

Gunakan:

React Query

Untuk:

- List
- Detail
- KPI
- Timeline

Gunakan:

Context API / Zustand

Untuk state lokal.

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

# 28. Page Flow

List

↓

Detail

↓

Business Action

↓

Refresh KPI

↓

Refresh Timeline

↓

Refresh Table

---

# 29. User Experience Rules

- Maksimal tiga klik untuk mengakses aksi utama.
- Tombol aksi hanya tampil jika status mengizinkan.
- Setelah aksi berhasil, halaman diperbarui tanpa reload penuh.
- Gunakan loading indicator pada seluruh proses asynchronous.
- Tampilkan pesan yang jelas jika aksi gagal.

---

# 30. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan layout yang konsisten.
- Menggunakan reusable component.
- Menggunakan React Query.
- Menggunakan React Hook Form.
- Menggunakan Zod Validation.
- Menggunakan Tailwind CSS.
- Tidak membuat inline style.
- Mengikuti seluruh UI Convention.
- Menyesuaikan Action Button dengan State Machine.
- Mengimplementasikan halaman yang responsif.

---

# 31. Deliverables

Frontend harus menghasilkan:

- List Page
- Detail Page
- Wizard Create
- KPI Dashboard
- Timeline Status
- Data Table
- Chart
- Modal
- Form
- Toast Notification
- Responsive Layout

---

# End of Document