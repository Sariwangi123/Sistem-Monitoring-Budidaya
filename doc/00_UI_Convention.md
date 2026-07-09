# UtiFarm
# 00_UI_Convention

Version : 1.0

Status : Active

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_API_Convention.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar User Interface (UI) dan User Experience (UX) yang digunakan pada seluruh aplikasi UtiFarm.

Seluruh halaman harus memiliki tampilan, perilaku, dan pengalaman pengguna yang konsisten.

Seluruh Frontend Developer dan AI Coding Assistant wajib mengikuti konvensi ini.

---

# 2. UI Principles

Seluruh UI mengikuti prinsip berikut.

- Simple
- Consistent
- Responsive
- Accessible
- Easy to Learn
- Fast
- Reusable Component

---

# 3. Technology

Frontend menggunakan:

- React
- TypeScript
- Vite
- Tailwind CSS

Library:

- React Hook Form
- React Query
- Zod
- Axios

---

# 4. Layout Standard

Setiap halaman menggunakan struktur berikut.

Header

↓

Sidebar

↓

Breadcrumb

↓

Page Title

↓

Toolbar

↓

Content

↓

Footer

---

# 5. Sidebar

Sidebar wajib memiliki:

- Logo
- Menu
- Collapse
- User Profile
- Logout

Menu dikelompokkan berdasarkan modul.

---

# 6. Header

Header berisi:

- Nama Aplikasi
- Farm Aktif
- Notification
- User Profile
- Theme Switch (Future)

---

# 7. Breadcrumb

Seluruh halaman wajib memiliki Breadcrumb.

Contoh

Dashboard

↓

Master Data

↓

Farm

---

# 8. Page Header

Setiap halaman memiliki:

- Judul
- Deskripsi singkat
- Action Button

---

# 9. Data Table Standard

Seluruh Data Table memiliki:

- Search
- Filter
- Sort
- Pagination
- Refresh
- Export
- Column Visibility

---

# 10. Form Standard

Seluruh Form menggunakan:

React Hook Form

+

Zod Validation

Layout:

Label

↓

Input

↓

Validation Message

---

# 11. Button Standard

Jenis Button:

Primary

Secondary

Success

Warning

Danger

Ghost

Icon Button

---

# 12. Input Component

Komponen standar:

- Text
- Number
- Currency
- Email
- Password
- Date
- Time
- DateTime
- Select
- Multi Select
- Text Area
- Checkbox
- Radio
- Switch
- File Upload
- Image Upload

---

# 13. Modal

Ukuran Modal:

Small

Medium

Large

Fullscreen

Modal digunakan untuk:

- Create
- Edit
- Detail
- Confirmation

---

# 14. Confirmation Dialog

Seluruh proses berikut wajib menggunakan dialog konfirmasi:

- Delete
- Restore
- Force Delete
- Reset Password
- Logout

---

# 15. Notification

Gunakan Toast Notification.

Jenis:

- Success
- Warning
- Error
- Information

---

# 16. Loading State

Gunakan:

- Skeleton
- Spinner
- Button Loading
- Table Loading

Hindari tampilan kosong saat proses berlangsung.

---

# 17. Empty State

Apabila data kosong tampilkan:

- Icon
- Judul
- Deskripsi
- Tombol Tambah Data

---

# 18. Error State

Apabila terjadi kesalahan tampilkan:

- Error Icon
- Pesan Error
- Tombol Retry

---

# 19. Search

Gunakan:

Server Side Search

Debounce

500 ms

---

# 20. Filter

Filter diletakkan di atas tabel.

Gunakan:

Dropdown

Date Range

Status

Farm

Category

Supplier

Customer

---

# 21. Pagination

Pilihan jumlah data:

10

20

50

100

Default

20

---

# 22. Responsive Design

Breakpoint:

Mobile

Tablet

Desktop

Large Desktop

Seluruh halaman harus dapat digunakan pada perangkat mobile.

---

# 23. Accessibility

Gunakan:

- Keyboard Navigation
- Focus Indicator
- ARIA Label
- Color Contrast

---

# 24. Icon

Gunakan satu library icon untuk seluruh aplikasi.

Direkomendasikan:

Lucide React

---

# 25. Typography

Gunakan maksimal:

- Heading
- Sub Heading
- Body
- Caption

Hindari penggunaan terlalu banyak ukuran font.

---

# 26. Color Standard

Gunakan warna berdasarkan fungsi.

Primary

Success

Warning

Danger

Info

Gray

Hindari penggunaan warna yang tidak memiliki makna.

---

# 27. Card

Gunakan Card untuk:

- Dashboard
- Summary
- Information
- Statistics

---

# 28. Dashboard Widget

Widget memiliki struktur:

Icon

↓

Title

↓

Value

↓

Description

↓

Trend

---

# 29. File Upload

Support:

- JPG
- PNG
- PDF
- XLSX
- CSV

Maximum

10 MB

---

# 30. Export

Support:

- CSV
- Excel
- PDF

---

# 31. Print

Halaman laporan harus memiliki:

Print Friendly View

---

# 32. Component Structure

Gunakan reusable component.

components/

├── button/

├── card/

├── datatable/

├── dialog/

├── form/

├── input/

├── modal/

├── pagination/

├── search/

├── select/

├── table/

├── toast/

└── upload/

---

# 33. State Management

Gunakan:

React Query

untuk Server State.

Gunakan:

Context API

atau

Zustand

untuk Client State.

---

# 34. API Communication

Gunakan:

Axios

↓

Service

↓

React Query

↓

Component

Component tidak boleh melakukan request API secara langsung.

---

# 35. Performance

Gunakan:

- Lazy Loading
- Code Splitting
- Memoization
- Virtual Table (apabila diperlukan)

---

# 36. UI Consistency

Semua halaman harus:

- Memiliki layout yang sama.
- Menggunakan komponen yang sama.
- Menggunakan warna yang sama.
- Menggunakan spacing yang sama.
- Menggunakan typography yang sama.

---

# 37. AI Coding Rules

AI Coding Assistant wajib:

- Menggunakan reusable component.
- Tidak membuat inline style.
- Menggunakan Tailwind CSS.
- Menggunakan React Hook Form.
- Menggunakan Zod.
- Menggunakan React Query.
- Menggunakan Axios.
- Mengikuti struktur folder yang telah ditentukan.
- Tidak membuat tampilan berbeda tanpa persetujuan.

---

# 38. Definition of Done

UI dianggap selesai apabila:

- Responsive.
- Konsisten.
- Validasi berjalan.
- Tidak terdapat layout yang rusak.
- Tidak terdapat warning React.
- Tidak terdapat error TypeScript.
- Komponen dapat digunakan ulang.
- Siap digunakan pada seluruh modul.

---

# End of Document