# Dokumentasi CRUD Perpustakaan

Dokumen ini menjelaskan langkah-langkah dan perubahan yang telah dilakukan pada aplikasi perpustakaan sesuai dengan source control terbaru.

## 1. Struktur Database

-   **Kategori Buku**: Tabel `categories` dengan kolom `id`, `name`, `slug`, dan timestamps.
-   **Buku**: Tabel `books` dengan kolom `id`, `category_id` (relasi ke kategori), `isbn`, `code`, `title`, `author`, `publisher`, `year`, `stock`, `replacement_cost`, dan timestamps.

## 2. Migrasi

-   Perbaikan migrasi pada tabel `books` agar kolom `isbn` dan `code` menggunakan tipe string dengan panjang maksimal dan unique.
-   Penambahan relasi foreign key `category_id` pada tabel `books`.

## 3. Model

-   **Category**: Slug otomatis diisi dari nama kategori menggunakan event Eloquent.
-   **Book**: Relasi ke kategori dan field sesuai migrasi.

## 4. Factory & Seeder

-   **BookFactory**: Menyesuaikan field dengan migrasi, memastikan data valid dan relasi ke kategori.
-   **BookSeeder**: Menggunakan factory untuk generate data buku.

## 5. Filament Resource

-   **CategoryResource**: Form input kategori, slug otomatis dari nama, slug tidak bisa diubah manual.
-   **BookResource**: Form input buku, field kategori sebagai dropdown, relasi ke kategori.

## 6. Proses CRUD

-   Input kategori melalui admin Filament, slug otomatis dari nama.
-   Input buku melalui admin Filament, pilih kategori dari dropdown.
-   Data validasi dan relasi sudah sesuai kebutuhan aplikasi perpustakaan.

## 7. Perbaikan Error

-   Error slug dan isbn diatasi dengan perbaikan migrasi dan event model.
-   Factory dan seeder disesuaikan agar data sesuai struktur tabel.

---

**Dokumentasi ini mengikuti perubahan terakhir pada branch utama dan source control terbaru.**
