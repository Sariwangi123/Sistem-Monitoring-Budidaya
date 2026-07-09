# UtiFarm
# 10_Notification
## Part 4 - Frontend & Notification Center

Version : 1.0

Status : Draft

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md
- 00_UI_Convention.md
- 00_API_Convention.md
- 00_Project_Structure.md
- 10_Notification_Part_1.md
- 10_Notification_Part_2.md
- 10_Notification_Part_3.md

---

# 1. Purpose

Dokumen ini mendefinisikan User Interface (UI) dan User Experience (UX) untuk Notification Center.

Notification Center menjadi pusat seluruh komunikasi sistem kepada pengguna.

Notification bersifat Read Only terhadap Business Module.

---

# 2. Notification Philosophy

Notification harus:

- Cepat
- Ringkas
- Informatif
- Mudah dicari
- Mudah difilter
- Mudah ditindaklanjuti

Notification bukan halaman transaksi.

---

# 3. Workspace

Workspace terdiri dari:

- Inbox
- Unread
- Archive
- History
- Preference

Workspace mengikuti Role pengguna.

---

# 4. Layout

Desktop

Notification Navigation

↓

Notification List

↓

Notification Detail

↓

Action Panel

Tablet

↓

Responsive Layout

Mobile

↓

Single Panel

---

# 5. Notification Navigation

Panel kiri menampilkan:

- All Notification
- Unread
- Critical
- Warning
- Operational
- Inventory
- Harvest
- Financial
- Executive
- Security
- System
- Archive

---

# 6. Notification List

Kolom:

- Priority Icon
- Title
- Category
- Source Module
- Time
- Status

Support:

- Search
- Sort
- Filter
- Pagination

---

# 7. Notification Detail

Menampilkan:

- Title
- Full Message
- Category
- Source Module
- Event Name
- Priority
- Created At
- Read At
- Action Button

---

# 8. Action Panel

Action:

- Mark as Read
- Archive
- Retry (Failed Only)
- Open Related Module

Action mengikuti hak akses pengguna.

---

# 9. Notification Badge

Badge menampilkan:

- Total Unread
- Critical Count

Badge tampil pada Top Navigation.

---

# 10. Search

Global Search.

Mencari:

- Notification Title
- Message
- Event Name
- Source Module

---

# 11. Filter

Support:

- Category
- Priority
- Status
- Source Module
- Date Range

---

# 12. Notification Timeline

Notification dapat dikelompokkan:

- Today
- Yesterday
- This Week
- This Month
- Older

---

# 13. Notification Preference

Pengguna dapat mengatur:

- In-App Notification
- Reminder
- Sound
- Desktop Notification (Future)
- Email (Future)
- WhatsApp (Future)

---

# 14. Notification History

Menampilkan:

- Read Notification
- Archived Notification
- Delivery Status
- Read Time

---

# 15. Critical Notification

Notification Critical:

- Selalu berada di bagian atas.
- Menggunakan warna sesuai UI Convention.
- Tidak dapat diabaikan tanpa tindakan pengguna.

---

# 16. Reminder Panel

Reminder menampilkan:

- Feeding Schedule
- Harvest Schedule
- Financial Deadline
- System Maintenance

---

# 17. Loading State

Gunakan:

- Skeleton
- Spinner
- Progressive Loading

Notification tetap dapat dibaca saat data lain masih dimuat.

---

# 18. Empty State

Apabila tidak ada Notification.

Tampilkan:

Icon

↓

"No Notification"

↓

Pesan:

"Semua notifikasi telah ditangani."

---

# 19. Responsive Design

Desktop

Three Panel Layout

Tablet

Two Panel Layout

Mobile

Single Panel

Card View

---

# 20. Accessibility

Gunakan:

- Keyboard Navigation
- Screen Reader
- ARIA Label
- High Contrast
- Focus Indicator

---

# 21. State Management

Gunakan:

React Query

Untuk:

- Notification List
- Notification Detail
- Notification History
- Preference

Gunakan Context API atau Zustand untuk state lokal.

---

# 22. API Integration

Flow:

Notification Workspace

↓

Hook

↓

Notification Service

↓

REST API

↓

Notification Center

Component tidak boleh mengakses API secara langsung.

---

# 23. User Experience Rules

- Notification terbaru berada di urutan paling atas.
- Badge diperbarui secara otomatis.
- Detail Notification terbuka tanpa reload halaman.
- Filter dipertahankan selama sesi aktif.
- Action menghasilkan Toast Notification.

---

# 24. Notification Center Layout

Panel kiri:

- Navigation

Panel tengah:

- Notification List

Panel kanan:

- Detail Notification
- Action Panel

---

# 25. Future Ready

Mendukung:

- Notification Pinning
- Favorite Notification
- Snooze Notification
- Bulk Action
- Desktop Notification
- Push Notification

---

# 26. AI Coding Instructions

AI Coding Assistant wajib:

- Menggunakan Notification Center Workspace.
- Menggunakan Reusable Component.
- Menggunakan React Query.
- Menggunakan Tailwind CSS.
- Menggunakan Responsive Layout.
- Menggunakan Three Panel Layout.
- Tidak menggunakan inline style.
- Mengikuti UI Convention.
- Menghasilkan UI production-ready.

---

# 27. Deliverables

Frontend harus menghasilkan:

- Notification Center
- Notification Navigation
- Notification List
- Notification Detail
- Notification History
- Notification Preference
- Reminder Panel
- Responsive Layout

---

# End of Document