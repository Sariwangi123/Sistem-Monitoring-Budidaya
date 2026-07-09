# UtiFarm
# 05_Warehouse
## Part 4 - Frontend & UI Specification

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 05_Warehouse_Part_1.md
- 05_Warehouse_Part_2.md
- 05_Warehouse_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar User Interface (UI) dan User Experience (UX) untuk modul Warehouse.

Warehouse merupakan Inventory Management System (IMS) yang digunakan untuk mengelola seluruh persediaan operasional.

UI harus cepat, sederhana, responsif, dan memudahkan pengguna melakukan transaksi inventory.

---

# 2. Module Overview

Warehouse terdiri dari:

- Warehouse Dashboard
- Inventory List
- Current Stock
- Stock Card
- Inventory Movement
- Stock In
- Stock Out
- Transfer
- Adjustment
- Stock Opname
- Batch Management
- Expired Items

---

# 3. Navigation

Sidebar

↓

Inventory

↓

Warehouse

↓

Dashboard

---

# 4. Pages

Halaman yang tersedia:

- Warehouse Dashboard
- Inventory List
- Current Stock
- Inventory Detail
- Stock Card
- Movement History
- Stock In
- Stock Out
- Transfer
- Adjustment
- Stock Opname
- Batch Management
- Expired Inventory

---

# 5. Warehouse Dashboard

Dashboard menampilkan KPI:

- Total Inventory Item
- Total Current Stock
- Low Stock
- Near Expired
- Expired Item
- Pending Stock Opname
- Total Warehouse
- Today's Movement

---

# 6. Inventory List

Data Table.

Kolom:

- Item Code
- Item Name
- Category
- Unit
- Warehouse
- Current Stock
- Available Stock
- Reorder Level
- Status

Toolbar:

- Add Item
- Search
- Filter
- Export
- Refresh

---

# 7. Current Stock

Menampilkan stok aktual.

Kolom:

- Item
- Warehouse
- Location
- Batch
- Current Quantity
- Reserved Quantity
- Available Quantity

Gunakan warna untuk:

Hijau

Normal

Kuning

Low Stock

Merah

Out of Stock

---

# 8. Inventory Detail

Summary Card:

- Item Code
- Item Name
- Category
- Brand
- Unit
- Current Stock
- Reorder Level
- Last Movement

Tab:

Overview

Batch

Movement

Stock Card

Attachment

History

---

# 9. Stock Card

Stock Card menggunakan format ledger.

Kolom:

- Date
- Document Number
- Movement Type
- Reference
- Stock In
- Stock Out
- Balance
- User

Default diurutkan berdasarkan tanggal terbaru.

---

# 10. Inventory Movement

Data Table.

Kolom:

- Document Number
- Movement Date
- Movement Type
- Warehouse
- Item
- Quantity
- Reference Module
- User

---

# 11. Stock In Form

Field:

- Warehouse
- Location
- Supplier
- Item
- Batch
- Quantity
- Unit Cost
- Production Date
- Expired Date
- Notes

---

# 12. Stock Out Form

Field:

- Warehouse
- Location
- Item
- Batch
- Quantity
- Reference Module
- Culture Cycle
- Notes

---

# 13. Transfer Form

Field:

- Source Warehouse
- Source Location
- Destination Warehouse
- Destination Location
- Item
- Batch
- Quantity
- Notes

---

# 14. Adjustment Form

Field:

- Warehouse
- Item
- Batch
- Adjustment Type
- Quantity
- Reason
- Notes

---

# 15. Stock Opname

Halaman terdiri dari:

Header:

- Opname Number
- Warehouse
- Date
- Status

Detail:

- Item
- System Quantity
- Physical Quantity
- Difference
- Adjustment

---

# 16. Batch Management

Menampilkan:

- Batch Number
- Lot Number
- Production Date
- Expired Date
- Quantity
- Status

Badge:

Available

Near Expired

Expired

Consumed

---

# 17. Expired Inventory

Daftar item:

- Near Expired
- Expired
- Disposal Recommendation

Filter:

- 30 Hari
- 60 Hari
- 90 Hari

---

# 18. Search

Support:

- Item Code
- Item Name
- Batch
- Document Number
- Supplier

Gunakan Debounce 500 ms.

---

# 19. Filter

Support:

- Warehouse
- Location
- Category
- Batch
- Supplier
- Status
- Date Range
- Expired Status

---

# 20. Sorting

Support:

- Item Name
- Current Stock
- Movement Date
- Batch
- Expired Date

Default:

Movement Date DESC

---

# 21. Charts

Dashboard menampilkan:

- Stock Movement Trend
- Inventory Consumption
- Stock by Category
- Warehouse Utilization
- Expired Trend

---

# 22. Notification Badge

Badge:

Available

Low Stock

Out of Stock

Near Expired

Expired

Reserved

---

# 23. Dialog

Gunakan Confirmation Dialog untuk:

- Stock In
- Stock Out
- Transfer
- Adjustment
- Submit Stock Opname
- Approve Stock Opname

---

# 24. Loading State

Gunakan:

- Skeleton
- Spinner
- Table Loading
- Card Loading

---

# 25. Empty State

Apabila belum ada inventory.

Tampilkan:

Icon

↓

"No Inventory Found"

↓

Button

Create Inventory Item

---

# 26. Responsive Design

Desktop

Sidebar + Table + Detail Panel

Tablet

Sidebar Collapse

Mobile

Card View

Bottom Sheet

---

# 27. Accessibility

Gunakan:

- Keyboard Navigation
- ARIA Label
- Focus Indicator
- Color Contrast

---

# 28. State Management

Gunakan:

React Query

Untuk:

- Inventory List
- Current Stock
- Stock Card
- Movement
- Batch

Gunakan Context API / Zustand untuk state lokal.

---

# 29. API Integration

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

# 30. User Experience Rules

- Maksimal tiga klik untuk transaksi utama.
- Stock Card dapat dibuka langsung dari Item.
- Detail Item tidak memerlukan perpindahan halaman pada desktop.
- Setelah transaksi berhasil, Current Stock diperbarui tanpa reload penuh.
- Tampilkan Toast untuk seluruh aksi.

---

# 31. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan reusable component.
- Menggunakan Data Table Component.
- Menggunakan Summary Card.
- Menggunakan React Query.
- Menggunakan React Hook Form.
- Menggunakan Zod Validation.
- Menggunakan Tailwind CSS.
- Tidak menggunakan inline style.
- Mengikuti UI Convention.
- Menghasilkan UI yang responsif dan mudah digunakan.

---

# 32. Deliverables

Frontend harus menghasilkan:

- Warehouse Dashboard
- Inventory List
- Current Stock Page
- Inventory Detail
- Stock Card
- Inventory Movement
- Stock In Form
- Stock Out Form
- Transfer Form
- Adjustment Form
- Stock Opname
- Batch Management
- Expired Inventory
- Responsive Layout

---

# End of Document