# Dokumentasi Fitur Perpustakaan

Berikut adalah fitur-fitur utama aplikasi perpustakaan sesuai perubahan terbaru di source control:

## 1. Manajemen Kategori Buku

-   CRUD kategori buku.
-   Slug kategori otomatis dari nama.
-   Kategori digunakan sebagai dropdown pada input buku.

## 2. Manajemen Buku

-   CRUD data buku.
-   Relasi ke kategori buku.
-   Validasi ISBN dan kode buku unik.

## 3. Manajemen Anggota

-   CRUD data anggota (mahasiswa, dosen, dll).
-   Kolom: nama, NIM/NIP, alamat, email, telepon, tanggal daftar, status.
-   Validasi unik NIM/NIP dan email.
-   Status anggota: aktif/nonaktif.

## 4. Peminjaman Buku

-   CRUD transaksi peminjaman buku oleh anggota.
-   Kolom: anggota, buku, tanggal pinjam, tanggal jatuh tempo, tanggal pengembalian, status (requested, borrowed, returned, lost, damaged).
-   Relasi ke anggota dan buku.

## 5. Seeder & Factory

-   Data dummy untuk kategori, buku, anggota, dan peminjaman sesuai struktur tabel.
-   Semua field wajib diisi pada factory dan seeder.

## 6. Validasi & Migrasi

-   Semua field dan tipe data pada resource sudah sesuai dengan migration.
-   Migrasi sudah diperbaiki agar field sesuai kebutuhan aplikasi.

## 7. Filament Admin

-   Semua fitur CRUD diakses melalui Filament admin.
-   Form dan tabel sudah sesuai kebutuhan dan validasi.

---

**Dokumentasi ini mengikuti perubahan terakhir pada branch utama dan source control terbaru.**
