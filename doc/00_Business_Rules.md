# UtiFarm
# 00_Business_Rules

Version : 1.0

Status : Active

Depends :

- 00_Project_Master.md
- 00_Development_Convention.md

---

# 1. Purpose

Dokumen ini mendefinisikan seluruh aturan bisnis (Business Rules) yang berlaku pada aplikasi UtiFarm.

Seluruh implementasi Backend, Frontend, Database, API, dan AI Coding Assistant wajib mengikuti aturan yang terdapat pada dokumen ini.

Apabila terjadi konflik antara implementasi dengan Business Rules, maka Business Rules menjadi acuan utama.

---

# 2. General Principles

Seluruh proses budidaya harus mengikuti prinsip berikut.

- Satu data hanya memiliki satu sumber (Single Source of Truth).
- Tidak boleh ada duplikasi data.
- Seluruh transaksi harus dapat ditelusuri (Traceable).
- Seluruh aktivitas harus memiliki Audit Trail.
- Data historis tidak boleh dihapus secara permanen kecuali oleh Super Admin.
- Seluruh proses harus dapat direproduksi berdasarkan data yang tersimpan.

---

# 3. Company Rules

- Satu perusahaan dapat memiliki banyak Farm.
- Setiap Farm hanya dimiliki oleh satu Company.
- Company tidak dapat dihapus apabila masih memiliki Farm aktif.

---

# 4. Farm Rules

- Satu Farm dapat memiliki banyak Pond Area.
- Satu Farm dapat memiliki banyak Gudang.
- Setiap Farm memiliki konfigurasi sendiri.
- Farm yang masih memiliki Culture Cycle aktif tidak boleh dihapus.

---

# 5. Pond Area Rules

- Satu Pond Area dapat memiliki banyak Pond.
- Pond Area tidak dapat dihapus apabila masih memiliki Pond aktif.

---

# 6. Pond Rules

- Setiap Pond hanya berada pada satu Pond Area.
- Setiap Pond hanya boleh memiliki satu Culture Cycle aktif.
- Pond dengan Culture Cycle aktif tidak dapat dihapus.
- Pond yang sedang Maintenance tidak dapat digunakan untuk Tebar Benih.
- Status Pond hanya boleh:
  - Active
  - Maintenance
  - Inactive

---

# 7. Culture Cycle Rules

- Culture Cycle dimulai dari Tebar Benih.
- Culture Cycle berakhir setelah Panen Total.
- Culture Cycle tidak dapat ditutup sebelum seluruh transaksi selesai.
- Tidak boleh membuat Culture Cycle baru apabila masih terdapat Culture Cycle aktif pada Pond yang sama.

---

# 8. Seed Rules

- Benih harus memiliki Supplier.
- Benih harus memiliki Jenis Ikan.
- Benih harus memiliki tanggal penerimaan.
- Benih yang sudah digunakan tidak dapat digunakan kembali.

---

# 9. Feed Rules

- Setiap Feed memiliki Brand.
- Setiap Feed memiliki Category.
- Setiap Feed memiliki ukuran Pellet.
- Penggunaan Feed mengurangi stok Gudang.
- Tidak boleh menggunakan Feed apabila stok tidak mencukupi.

---

# 10. Warehouse Rules

- Seluruh barang masuk menambah stok.
- Seluruh barang keluar mengurangi stok.
- Stok tidak boleh bernilai negatif.
- Setiap transaksi gudang wajib memiliki referensi.
- Stock Opname hanya dapat dilakukan oleh pengguna yang memiliki hak akses.

---

# 11. Activity Rules

Seluruh aktivitas harian wajib terkait dengan:

- Farm
- Pond
- Culture Cycle
- User
- Tanggal

Aktivitas tanpa Culture Cycle tidak diperbolehkan.

---

# 12. Water Quality Rules

Setiap pengukuran kualitas air wajib memiliki:

- Tanggal
- Jam
- Pond
- Parameter
- Nilai
- Satuan

---

# 13. Sampling Rules

Sampling wajib mencatat:

- Berat rata-rata
- Jumlah sampel
- Biomassa
- Survival Rate
- Catatan

---

# 14. Harvest Rules

- Panen dapat dilakukan sebagian (Partial Harvest).
- Panen Total menutup Culture Cycle.
- Setelah Panen Total, Pond kembali tersedia.
- Panen harus memiliki Customer.
- Panen harus memiliki Grade.

---

# 15. Finance Rules

- Seluruh pengeluaran harus memiliki kategori.
- Seluruh pemasukan harus memiliki sumber.
- Setiap transaksi harus memiliki tanggal.
- HPP dihitung berdasarkan seluruh biaya pada Culture Cycle.
- Profit dihitung setelah Culture Cycle selesai.

---

# 16. Dashboard Rules

Dashboard hanya menampilkan data.

Dashboard tidak boleh mengubah data transaksi.

Semua KPI dihitung berdasarkan data aktual.

---

# 17. User Rules

Setiap User:

- Memiliki Role.
- Memiliki Status.
- Memiliki Farm Access.

User yang Nonaktif tidak dapat Login.

---

# 18. Permission Rules

Hak akses menggunakan Role Based Access Control (RBAC).

Role default:

- Super Admin
- Farm Owner
- Farm Manager
- Technician
- Warehouse Staff
- Finance Staff
- Viewer

---

# 19. Delete Rules

Master Data menggunakan Soft Delete.

Data transaksi tidak boleh dihapus secara permanen.

Data yang memiliki relasi aktif tidak dapat dihapus.

---

# 20. Audit Rules

Seluruh perubahan data wajib mencatat:

- User
- Tanggal
- Waktu
- Aktivitas
- Data Lama
- Data Baru

---

# 21. Reporting Rules

Laporan hanya mengambil data yang telah tersimpan.

Laporan tidak boleh mengubah data transaksi.

---

# 22. Validation Rules

Seluruh input wajib divalidasi sebelum disimpan.

Data yang tidak valid harus ditolak.

---

# 23. Security Rules

Seluruh aktivitas memerlukan:

- Authentication
- Authorization
- Activity Logging

---

# 24. Future Rules

Apabila terdapat modul baru, maka Business Rules harus diperbarui terlebih dahulu sebelum implementasi dilakukan.

Tidak diperbolehkan membuat implementasi yang melanggar Business Rules.

---

# 25. AI Coding Rules

AI Coding Assistant wajib:

- Membaca dokumen ini sebelum melakukan implementasi.
- Tidak membuat business process baru tanpa persetujuan.
- Tidak mengubah aturan bisnis yang telah ditetapkan.
- Mengimplementasikan seluruh modul sesuai Business Rules.
- Meminta klarifikasi apabila menemukan aturan bisnis yang belum didefinisikan.

---

# End of Document