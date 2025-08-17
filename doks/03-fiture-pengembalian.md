# Dokumentasi Fitur Pengembalian Buku

## Deskripsi

Fitur pengembalian buku memungkinkan admin atau petugas perpustakaan mencatat proses pengembalian buku oleh anggota. Fitur ini digabung dengan fitur peminjaman, yaitu dengan mengubah status transaksi peminjaman menjadi "dikembalikan". Sistem juga akan menghitung denda otomatis jika pengembalian dilakukan setelah tanggal jatuh tempo.

## Alur Fitur

1. **Proses Pengembalian**

    - Admin memilih transaksi peminjaman yang masih berstatus "dipinjam".
    - Admin melakukan aksi pengembalian pada transaksi tersebut.
    - Status transaksi berubah menjadi "dikembalikan".
    - Tanggal pengembalian dicatat.

2. **Perhitungan Denda**

    - Jika tanggal pengembalian lebih dari tanggal jatuh tempo, sistem menghitung jumlah hari keterlambatan.
    - Denda dihitung otomatis (misal: Rp 1.000 per hari terlambat, bisa disesuaikan).
    - Nilai denda disimpan pada transaksi peminjaman atau pada tabel denda terpisah.

3. **Tampilan di Admin**
    - Terdapat aksi "Kembalikan Buku" pada transaksi peminjaman yang masih aktif.
    - Informasi denda dan keterlambatan ditampilkan pada detail transaksi.

## Perubahan Database

-   Kolom `returned_at` pada tabel `loans` digunakan untuk mencatat tanggal pengembalian.
-   Kolom `status` pada tabel `loans` diubah menjadi "dikembalikan" saat proses pengembalian.
-   Kolom/tabel denda dapat ditambahkan jika ingin menyimpan detail denda secara terpisah.

## Validasi

-   Pengembalian hanya bisa dilakukan jika status peminjaman masih "dipinjam".
-   Denda hanya dihitung jika pengembalian lewat dari tanggal jatuh tempo.

## Catatan

-   Fitur ini terintegrasi dengan proses peminjaman, tidak perlu membuat tabel baru kecuali ingin menyimpan detail denda secara terpisah.
-   Perhitungan denda bisa disesuaikan sesuai kebijakan perpustakaan.

---

**Dokumentasi ini dibuat sebelum implementasi kode agar dapat direview dan disetujui.**
