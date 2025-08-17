# Dokumentasi Fitur Laporan Perpustakaan

## Deskripsi

Fitur laporan menyediakan rekap data bulanan/tahunan untuk membantu analisis dan pengambilan keputusan di perpustakaan.

## Jenis Laporan

1. **Jumlah Buku Dipinjam (Rekap Bulanan/Tahunan)**

    - Tabel rekap jumlah peminjaman buku per bulan/tahun.
    - Menampilkan total transaksi, total buku, dan tren peminjaman.
    - Contoh output:
      | Bulan/Tahun | Jumlah Peminjaman | Jumlah Buku |  
       |-------------|-------------------|-------------|
      | 01/2025 | 120 | 150 |
      | 02/2025 | 98 | 110 |

2. **Top 10 Buku Paling Banyak Dipinjam**

    - Daftar 10 buku dengan jumlah peminjaman terbanyak dalam periode tertentu.
    - Menampilkan judul, penulis, kategori, dan jumlah peminjaman.
    - Contoh output:
      | Judul Buku | Penulis | Kategori | Jumlah Dipinjam |
      |-------------------|--------------|------------|-----------------|
      | Algoritma Dasar | A. Budi | Komputer | 45 |
      | Fisika Modern | C. Sari | Sains | 38 |

3. **Daftar Anggota Aktif & Statistik Peminjaman**

    - Menampilkan anggota dengan status "aktif".
    - Statistik jumlah peminjaman, keterlambatan, dan total denda per anggota.
    - Bisa difilter berdasarkan periode pendaftaran atau aktivitas.
    - Contoh output:
      | Nama Anggota | NIM/NIP | Jumlah Pinjam | Keterlambatan | Total Denda |
      |--------------|------------|---------------|---------------|-------------|
      | Siti Aminah | 1910110001 | 12 | 2 | Rp 5.000 |

4. **Total Denda Masuk (Rekap Per Jenis Denda)**
    - Rekap total denda yang sudah dibayar dalam periode tertentu.
    - Denda dikelompokkan berdasarkan jenis: terlambat, hilang, rusak.
    - Contoh output:
      | Jenis Denda | Total Denda Dibayar |
      |-------------|---------------------|
      | Terlambat | Rp 120.000 |
      | Hilang | Rp 50.000 |
      | Rusak | Rp 30.000 |

## Alur Fitur

-   Admin memilih jenis laporan dan periode waktu.
-   Sistem menampilkan data rekap sesuai filter.
-   Data bisa diekspor (misal: PDF, Excel) jika diperlukan.

## Perubahan Database

-   Tidak ada perubahan database, fitur ini hanya mengambil data dari tabel yang sudah ada: `loans`, `books`, `members`, `fines`.

## Validasi

-   Filter periode waktu wajib diisi.
-   Data laporan hanya menampilkan status dan transaksi yang relevan.

## Catatan

-   Fitur laporan dapat dikembangkan sesuai kebutuhan (misal: grafik, export, dsb).
-   Implementasi dapat menggunakan query builder/Eloquent untuk rekap data.

---

**Dokumentasi ini dibuat sebelum implementasi kode agar dapat direview dan disetujui.**
