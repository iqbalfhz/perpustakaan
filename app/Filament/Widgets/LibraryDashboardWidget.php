<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\Schema;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Filament\Support\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class LibraryDashboardWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $totalBiayaGantiRugi = \App\Models\Fine::where('jenis_denda', 'hilang')->orWhere('jenis_denda', 'rusak')->sum('jumlah');
        $totalDendaTerlambat = \App\Models\Fine::where('jenis_denda', 'terlambat')->sum('jumlah');
        $totalDenda = \App\Models\Fine::sum('jumlah');
        // Cek apakah kolom book_condition ada di tabel loans
        $bookConditionExists = Schema::hasColumn('loans', 'book_condition');
        $totalBukuRusak = $bookConditionExists
            ? Book::where('stock', '>', 0)->whereHas('loans', function($q){ $q->where('book_condition', 'rusak'); })->count()
            : 0;
        $totalBukuHilang = Book::where('stock', 0)->count();
        $totalBukuTersedia = Book::where('stock', '>', 0)->count();
        $totalPeminjamanAktif = Loan::where('status', 'dipinjam')->count();
        $totalPeminjamanSelesai = Loan::where('status', 'dikembalikan')->count();

        return [
            Card::make('Jumlah Buku', Book::count())
                ->description('Total koleksi di perpustakaan')
                ->icon('heroicon-o-book-open'),

            Card::make('Buku yang Dipinjam', $totalPeminjamanAktif)
                ->description('Sedang dipinjam anggota')
                ->icon('heroicon-o-clipboard-document'),

            Card::make('Jumlah Anggota', Member::count())
                ->description('Total anggota terdaftar')
                ->icon('heroicon-o-user-group'),

            Card::make('Biaya Ganti Rugi', 'Rp ' . number_format($totalBiayaGantiRugi, 0, ',', '.'))
                ->description('Total biaya rusak/hilang')
                ->icon('heroicon-o-currency-dollar'),

            Card::make('Denda Terlambat', 'Rp ' . number_format($totalDendaTerlambat, 0, ',', '.'))
                ->description('Total denda keterlambatan')
                ->icon('heroicon-o-clock'),

            Card::make('Total Semua Denda', 'Rp ' . number_format($totalDenda, 0, ',', '.'))
                ->description('Akumulasi semua denda')
                ->icon('heroicon-o-banknotes'),

            Card::make('Buku Rusak', $totalBukuRusak)
                ->description('Buku yang pernah rusak')
                ->icon('heroicon-o-exclamation-triangle'),

            Card::make('Buku Hilang', $totalBukuHilang)
                ->description('Buku yang hilang (stok 0)')
                ->icon('heroicon-o-x-mark'),

            Card::make('Buku Tersedia', $totalBukuTersedia)
                ->description('Buku yang bisa dipinjam')
                ->icon('heroicon-o-check'),

            Card::make('Peminjaman Selesai', $totalPeminjamanSelesai)
                ->description('Sudah dikembalikan')
                ->icon('heroicon-o-arrow-uturn-left'),
        ];
    }
}
