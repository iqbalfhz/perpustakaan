<?php

namespace App\Filament\Resources\FineResource\Pages;

use App\Filament\Resources\FineResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFine extends CreateRecord
{
    protected static string $resource = FineResource::class;
    protected static bool $canCreateAnother = false;

    public function afterCreate(): void
    {
        $fine = $this->record;
        if ($fine) {
            if ($fine->jenis_denda === 'terlambat' && $fine->loan && $fine->loan->returned_at && $fine->loan->due_at) {
                $daysLate = \Carbon\Carbon::parse($fine->loan->returned_at)->diffInDays(\Carbon\Carbon::parse($fine->loan->due_at));
                $fine->jumlah = $daysLate * 5000;
                $fine->save();
            } elseif ($fine->jenis_denda === 'rusak') {
                $fine->jumlah = 50000;
                $fine->save();
            } elseif ($fine->jenis_denda === 'hilang') {
                $fine->jumlah = 150000;
                $fine->save();
            }
        }
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
