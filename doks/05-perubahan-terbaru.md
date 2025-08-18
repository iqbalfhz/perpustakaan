# Dokumentasi Perubahan & Fitur Terbaru Perpustakaan

## 1. Sinkronisasi Status & Field Peminjaman

-   **Status peminjaman (`status`)** kini hanya: `dipinjam`, `hilang`, `rusak` (mengikuti migration `loans`).
-   **Field `book_condition`**: Menyimpan kondisi buku saat dikembalikan (`normal`, `rusak`, `hilang`).
-   Semua resource, factory, dan seeder sudah disesuaikan agar hanya menggunakan status di atas.

## 2. Otomatisasi Stok Buku

-   **Stok buku otomatis berkurang 1** saat peminjaman (hanya di event `creating` model Loan).
-   Tidak ada duplikasi pengurangan stok di resource/page lain (CreateLoan, dsb sudah dihapus).
-   **Stok bertambah 1** hanya jika buku dikembalikan dalam kondisi `normal` (langsung di action Filament, bukan event model).
-   Jika dikembalikan dalam kondisi `rusak` atau `hilang`, stok tidak bertambah dan status berubah sesuai kondisi.

## 3. Action Pengembalian Buku di Filament

-   Action "Kembalikan Buku" hanya muncul jika status `dipinjam` dan belum pernah dikembalikan dalam kondisi normal.
-   Saat pengembalian, user wajib memilih kondisi buku (`normal`, `rusak`, `hilang`).
-   Setelah pengembalian normal, action otomatis hilang (dengan pengecekan `returned_at` dan `book_condition`).
-   Jika dikembalikan dalam kondisi rusak/hilang, status akan berubah ke `rusak`/`hilang` dan action juga hilang.

## 4. Perbaikan Factory & Seeder

-   **LoanFactory**: Status hanya `dipinjam`, `hilang`, `rusak`. Field lain sudah sesuai migration.
-   **FineFactory**: Field dan enum sudah sesuai migration (`jenis_denda`, `jumlah`, `status`).
-   **Seeder**: Sudah memanggil semua seeder yang diperlukan, tidak ada error enum atau field tidak ditemukan saat migrate:fresh --seed.

## 5. Perubahan di Model Loan

-   Event `creating` saja yang mengurangi stok.
-   Tidak ada event lain (updating/updating) yang memodifikasi stok.
-   Penambahan stok dilakukan manual di action pengembalian pada Filament.

## 6. Perubahan di Resource Filament

-   Form dan Table LoanResource sudah sinkron dengan migration.
-   Action pengembalian sudah sesuai logika aplikasi perpustakaan.
-   Tidak ada status baru di enum, hanya menggunakan yang sudah ada.

## 7. File yang Diubah

-   `app/Filament/Resources/LoanResource.php` (form, table, action pengembalian)
-   `app/Filament/Resources/LoanResource/Pages/CreateLoan.php` (hapus duplikasi stok)
-   `app/Models/Loan.php` (event stok)
-   `database/factories/LoanFactory.php` (enum status)
-   `database/factories/FineFactory.php` (field dan enum)
-   `database/seeders/DatabaseSeeder.php` (urutan seeder)
-   `database/migrations/2025_08_17_104927_create_loans_table.php` (enum status)

## 8. Alur Peminjaman & Pengembalian

1. **Peminjaman**:
    - User memilih anggota & buku, status otomatis `dipinjam`.
    - Stok buku langsung berkurang 1.
2. **Pengembalian**:
    - User klik action "Kembalikan Buku".
    - Pilih kondisi buku:
        - `normal`: returned_at terisi, book_condition = normal, stok bertambah 1, action hilang.
        - `rusak`/`hilang`: returned_at terisi, book_condition & status ikut pilihan, stok tidak bertambah, action hilang.

## 9. Catatan

-   Semua perubahan sudah diuji dengan migrate:fresh --seed dan berjalan tanpa error.
-   Logic stok dan pengembalian sudah sesuai kebutuhan aplikasi perpustakaan.
-   Tidak ada penambahan status baru di enum, hanya menggunakan yang sudah ada.

---

_Dokumentasi ini dibuat otomatis oleh GitHub Copilot berdasarkan perubahan terakhir di source control dan permintaan user. Silakan update jika ada fitur baru atau perubahan selanjutnya._
