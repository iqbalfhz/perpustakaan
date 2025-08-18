# Dokumentasi Fitur Peminjaman Buku (Filament Perpustakaan)

## 1. Alur Peminjaman Buku

-   User memilih anggota dan buku yang ingin dipinjam.
-   Hanya buku dengan stok > 0 yang bisa dipilih.
-   Satu user tidak bisa meminjam buku yang sama lebih dari satu kali secara bersamaan (validasi otomatis).
-   Field status dan kondisi buku tidak muncul saat create loan, status otomatis 'dipinjam'.

## 2. Alur Pengembalian Buku

-   Action "Kembalikan Buku" hanya muncul jika status masih 'dipinjam'.
-   User wajib memilih kondisi buku saat pengembalian:
    -   Normal: status menjadi 'normal', stok bertambah 1, tidak ada denda.
    -   Rusak: status menjadi 'rusak', stok tidak bertambah, denda otomatis Rp 50.000.
    -   Hilang: status menjadi 'hilang', stok tidak bertambah, denda otomatis Rp 150.000.
-   Notifikasi akan muncul sesuai kondisi pengembalian dan denda.
-   Kolom denda di tabel akan menampilkan denda rusak/hilang jika ada.

## 3. Validasi & Otomatisasi

-   Tidak bisa create loan jika stok buku 0.
-   Tidak bisa create loan jika user sudah meminjam buku yang sama dan belum dikembalikan.
-   Status dan kondisi buku hanya bisa diubah lewat proses pengembalian, tidak saat create.

## 4. Perubahan Kode Penting

-   Migration: enum status pada loans kini: 'dipinjam', 'normal', 'rusak', 'hilang'.
-   LoanFactory, model, resource sudah sinkron dengan enum status baru.
-   Logic pengembalian, denda, dan stok sudah otomatis sesuai kebutuhan aplikasi perpustakaan.

---

_Dokumentasi ini dibuat otomatis oleh GitHub Copilot berdasarkan perubahan terakhir di source control dan permintaan user. Silakan update jika ada fitur baru atau perubahan selanjutnya._
