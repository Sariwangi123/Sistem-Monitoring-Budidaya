# UtiFarm
# 07_Finance
## Part 4 - Frontend & UI Specification

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 07_Finance_Part_1.md
- 07_Finance_Part_2.md
- 07_Finance_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan standar User Interface (UI) dan User Experience (UX) untuk modul Finance.

Finance merupakan Aquaculture Financial Management System (AFMS) yang mengelola biaya operasional, pendapatan, profitabilitas, dan analisis keuangan.

UI harus memberikan gambaran kondisi finansial secara cepat, akurat, dan mudah dipahami.

---

# 2. Module Overview

Finance terdiri dari:

- Financial Dashboard
- Expense
- Revenue
- Journal
- Financial Ledger
- Cost Center
- Cost Object
- Profit Summary
- Financial Report
- Financial Analytics

---

# 3. Navigation

Sidebar

↓

Finance

↓

Financial Dashboard

---

# 4. Pages

Halaman yang tersedia:

- Financial Dashboard
- Expense
- Revenue
- Journal
- Financial Ledger
- Cost Center
- Cost Object
- Profit Summary
- Financial Report
- Financial Analytics

---

# 5. Financial Dashboard

Dashboard menampilkan KPI:

- Total Expense
- Total Revenue
- Gross Profit
- Net Profit
- Cost per KG
- Profit Margin
- Pending Posting
- Closed Period

---

# 6. Expense

Data Table.

Kolom:

- Expense Number
- Date
- Category
- Cost Center
- Cost Object
- Amount
- Status

Toolbar:

- Create Expense
- Search
- Filter
- Export
- Refresh

---

# 7. Revenue

Data Table.

Kolom:

- Revenue Number
- Date
- Customer
- Harvest Batch
- Quantity
- Total Revenue
- Status

---

# 8. Journal

Data Table.

Kolom:

- Journal Number
- Date
- Description
- Transaction Count
- Status

Button:

- View Detail
- Post Journal

---

# 9. Financial Ledger

Ledger menggunakan format running balance.

Kolom:

- Date
- Document Number
- Transaction Type
- Debit
- Credit
- Balance
- Cost Center
- User

Ledger bersifat Read Only.

---

# 10. Cost Center

Data Table.

Kolom:

- Cost Center Code
- Cost Center Name
- Farm
- Culture Cycle
- Status

---

# 11. Cost Object

Data Table.

Kolom:

- Object Code
- Object Name
- Category
- Status

---

# 12. Profit Summary

Summary Card.

Menampilkan:

- Revenue
- Cost of Production
- Gross Profit
- Operational Cost
- Net Profit
- Profit Margin

---

# 13. Financial Analytics

Dashboard menampilkan:

- Expense by Category
- Revenue Trend
- Profit Trend
- Cost per KG
- Revenue per Farm
- Revenue per Customer

---

# 14. Charts

Gunakan Chart untuk:

- Expense Trend
- Revenue Trend
- Profit Trend
- Cost Distribution
- Revenue Distribution
- Monthly Comparison

---

# 15. Financial Workspace

Workspace terdiri dari:

Overview

↓

Ledger

↓

Expense

↓

Revenue

↓

Profit

↓

Analytics

↓

Report

---

# 16. Search

Support:

- Document Number
- Cost Center
- Cost Object
- Customer
- Supplier
- Journal Number

Gunakan Debounce 500 ms.

---

# 17. Filter

Support:

- Financial Period
- Farm
- Culture Cycle
- Cost Center
- Cost Object
- Category
- Status
- Date Range

---

# 18. Sorting

Support:

- Transaction Date
- Amount
- Revenue
- Expense
- Profit
- Created At

Default:

Transaction Date DESC

---

# 19. Notification Badge

Badge:

Draft

Validated

Posted

Completed

Closed

Cancelled

---

# 20. Dialog

Gunakan Confirmation Dialog untuk:

- Post Expense
- Post Revenue
- Post Journal
- Calculate Profit
- Close Financial Period
- Reopen Financial Period

---

# 21. Loading State

Gunakan:

- Skeleton
- Spinner
- Table Loading
- Dashboard Card Loading

---

# 22. Empty State

Apabila belum ada transaksi.

Tampilkan:

Icon

↓

"No Financial Transaction"

↓

Button

Create Expense

---

# 23. Responsive Design

Desktop

Financial Workspace

Tablet

Sidebar Collapse

Mobile

Card View

Bottom Sheet

---

# 24. Accessibility

Gunakan:

- Keyboard Navigation
- ARIA Label
- Focus Indicator
- Color Contrast

---

# 25. State Management

Gunakan:

React Query

Untuk:

- Dashboard
- Ledger
- Expense
- Revenue
- Profit Summary
- Analytics

Gunakan Context API / Zustand untuk state lokal.

---

# 26. API Integration

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

# 27. User Experience Rules

- Dashboard selalu menjadi halaman pertama.
- Ledger bersifat Read Only.
- Profit Summary diperbarui otomatis.
- Dashboard menggunakan Refresh tanpa reload penuh.
- Gunakan Toast Notification untuk seluruh transaksi.

---

# 28. Financial Workspace Layout

Desktop menggunakan Split Workspace.

Panel kiri:

- Dashboard
- Filter
- KPI

Panel kanan:

- Detail
- Ledger
- Profit Summary
- Analytics

---

# 29. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan reusable component.
- Menggunakan Summary Card.
- Menggunakan Data Table Component.
- Menggunakan Ledger Component.
- Menggunakan React Query.
- Menggunakan React Hook Form.
- Menggunakan Zod Validation.
- Menggunakan Tailwind CSS.
- Tidak menggunakan inline style.
- Mengikuti UI Convention.
- Menghasilkan UI yang responsif dan production-ready.

---

# 30. Deliverables

Frontend harus menghasilkan:

- Financial Dashboard
- Expense Module
- Revenue Module
- Journal Module
- Financial Ledger
- Cost Center Module
- Cost Object Module
- Profit Summary
- Financial Analytics
- Responsive Financial Workspace

---

# End of Document