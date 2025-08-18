# Dokumentasi Perubahan Status Peminjaman Buku

## 1. Enum Status pada Tabel Loans

-   Status pada kolom `status` kini: `dipinjam`, `normal`, `rusak`, `hilang`.
-   Status `dipinjam`: Buku sedang dipinjam dan belum dikembalikan.
-   Status `normal`: Buku sudah dikembalikan dalam kondisi baik.
-   Status `rusak`: Buku dikembalikan dalam kondisi rusak, otomatis kena denda Rp 50.000.
-   Status `hilang`: Buku dikembalikan dalam kondisi hilang, otomatis kena denda Rp 150.000.

## 2. Perubahan di Factory, Model, dan Resource

-   **LoanFactory**: Status randomElement sudah termasuk `normal`.
-   **Model Loan**: Fillable dan logic sudah support status baru.
-   **LoanResource**:
    -   Form dan table sudah support status `normal`.
    -   Badge status: `normal` dan `dipinjam` hijau, `rusak`/`hilang` merah.
    -   Action pengembalian otomatis mengubah status ke `normal` jika buku dikembalikan baik.

## 3. Logic Pengembalian

-   Jika buku dikembalikan normal:
    -   Status jadi `normal`, stok bertambah 1, alert sukses tanpa denda.
-   Jika rusak/hilang:
    -   Status ikut kondisi, stok tidak bertambah, alert warning dan denda otomatis tercatat di tabel fines.
-   Kolom denda di tabel peminjaman akan menampilkan denda rusak/hilang jika ada.

## 4. Catatan Migrasi

-   Pastikan jalankan `php artisan migrate:fresh --seed` setelah perubahan enum status agar tidak error.
-   Semua logic sudah sinkron di migration, factory, model, resource, dan seeder.

---

_Dokumentasi ini dibuat otomatis oleh GitHub Copilot berdasarkan perubahan terakhir di source control dan permintaan user._
