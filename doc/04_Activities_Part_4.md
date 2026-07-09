# UtiFarm
# 04_Activities
## Part 4 - Frontend & UI Specification

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 03_Culture_Cycle
- 04_Activities_Part_1.md
- 04_Activities_Part_2.md
- 04_Activities_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar User Interface (UI) dan User Experience (UX) untuk modul Activities.

Activities merupakan pusat histori operasional seluruh proses budidaya.

UI harus memudahkan pengguna untuk:

- Melihat Timeline
- Melihat Daily Log
- Menambahkan Activity
- Menelusuri histori
- Melihat detail setiap event

---

# 2. Module Overview

Activities menjadi pusat seluruh aktivitas operasional.

Halaman utama terdiri dari:

- Timeline
- Daily Log
- Activity List
- Calendar View
- Activity Detail
- Attachment
- Comment
- Statistics

---

# 3. Navigation

Sidebar

↓

Production

↓

Activities

↓

Operational Timeline

---

# 4. Pages

Halaman yang tersedia:

- Activity Dashboard
- Activity Timeline
- Daily Log
- Calendar View
- Activity Detail
- Activity Statistics
- Activity Attachment
- Activity Comment

---

# 5. Activity Dashboard

Bagian atas menampilkan KPI.

Card:

- Total Activity
- Manual Activity
- System Activity
- Today's Activity
- Pending Activity
- Completed Activity

---

# 6. Activity Timeline

Timeline merupakan halaman utama.

Urutan:

Activity Terbaru

↓

Activity Lama

Setiap item menampilkan:

- Icon
- Event Code
- Judul
- Waktu
- User
- Pond
- Culture Cycle
- Status

---

# 7. Daily Log

Menampilkan aktivitas berdasarkan tanggal.

Contoh:

08:00

Feeding

↓

09:30

Water Quality

↓

11:00

Sampling

↓

13:00

Treatment

↓

16:00

Observation

---

# 8. Calendar View

Activity dapat ditampilkan berdasarkan kalender.

Fitur:

- Month View
- Week View
- Day View

Klik tanggal akan membuka Daily Log.

---

# 9. Activity Detail

Bagian atas:

Summary Card

Menampilkan:

- Event Code
- Activity Type
- Category
- Culture Cycle
- Pond
- Operator
- Tanggal
- Jam
- Status

---

# 10. Detail Tabs

Gunakan Tab Navigation.

Tab:

Overview

Attachment

Comment

History

Audit Trail

---

# 11. Activity Card

Setiap Activity Card menampilkan:

- Icon
- Event Code
- Judul
- Deskripsi Singkat
- Timestamp
- User
- Badge Status

Klik Card membuka Detail Activity.

---

# 12. Search

Support:

- Event Code
- Judul
- Pond
- Culture Cycle
- User

Gunakan Debounce 500 ms.

---

# 13. Filter

Filter yang tersedia:

- Company
- Farm
- Pond
- Culture Cycle
- Category
- Activity Type
- User
- Status
- Date Range

---

# 14. Sorting

Support:

- Tanggal
- Jam
- Event Code
- User
- Status

Default:

Tanggal DESC

Jam DESC

---

# 15. Attachment

Support:

- JPG
- PNG
- PDF
- XLSX
- DOCX

Maximum:

10 MB

Preview untuk file gambar dan PDF.

---

# 16. Comment

Setiap Activity dapat memiliki komentar.

Field:

- User
- Tanggal
- Isi Komentar

Comment diurutkan berdasarkan waktu.

---

# 17. Statistics

Tampilkan:

- Activity per Hari
- Activity per Minggu
- Activity per Bulan
- Activity per User
- Activity per Category

---

# 18. Charts

Gunakan Chart untuk:

- Daily Activity Trend
- Weekly Activity Trend
- Monthly Activity Trend
- Activity by Category
- Activity by User

---

# 19. Notification Badge

Tampilkan badge untuk:

- New
- Warning
- Critical
- Completed
- Archived

---

# 20. Color Standard

Production

Blue

Water Quality

Cyan

Treatment

Orange

Warehouse

Purple

Harvest

Green

Finance

Emerald

System

Gray

Security

Red

---

# 21. Action Button

Button tersedia sesuai hak akses.

Create

Edit

View

Comment

Upload Attachment

Export

Refresh

Delete (Soft Delete)

---

# 22. Empty State

Apabila belum ada aktivitas.

Tampilkan:

Icon

↓

"No Activity Found"

↓

Button

Create Activity

---

# 23. Loading State

Gunakan:

- Skeleton
- Spinner
- Table Loading
- Timeline Loading

---

# 24. Responsive Design

Desktop

Tablet

Mobile

Timeline tetap nyaman digunakan pada seluruh perangkat.

---

# 25. Accessibility

Gunakan:

- Keyboard Navigation
- Focus Indicator
- ARIA Label
- Color Contrast

---

# 26. State Management

Gunakan:

React Query

Untuk:

- Timeline
- Detail
- Statistics
- Comment
- Attachment

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

- Timeline harus diperbarui tanpa reload penuh.
- Aktivitas terbaru tampil paling atas.
- Klik Activity membuka Detail.
- Semua aksi memberikan feedback melalui Toast.
- Maksimal tiga klik untuk membuka Detail Activity.

---

# 29. Responsive Layout

Desktop

Sidebar + Timeline + Detail Panel

Tablet

Sidebar Collapse + Timeline

Mobile

Timeline Full Screen

Detail menggunakan Bottom Sheet atau Full Screen.

---

# 30. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan reusable component.
- Menggunakan Timeline Component.
- Menggunakan Card Component.
- Menggunakan React Query.
- Menggunakan React Hook Form.
- Menggunakan Zod.
- Menggunakan Tailwind CSS.
- Tidak membuat inline style.
- Mengikuti UI Convention.
- Menghasilkan UI yang responsif.

---

# 31. Deliverables

Frontend harus menghasilkan:

- Activity Dashboard
- Timeline
- Daily Log
- Calendar View
- Detail Page
- Attachment Module
- Comment Module
- Statistics Page
- Chart
- Responsive Layout

---

# End of Document