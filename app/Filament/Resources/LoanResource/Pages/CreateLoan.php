<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;
    protected static bool $canCreateAnother = false;

    public function afterCreate(): void
    {
        $loan = $this->record;
        if ($loan && $loan->book) {
            $loan->book->decrement('stock');
        }
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
