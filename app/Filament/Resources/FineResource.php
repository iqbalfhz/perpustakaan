<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FineResource\Pages;
use App\Models\Fine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class FineResource extends Resource
{
    protected static ?string $model = Fine::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?string $navigationLabel = 'Denda / Biaya Ganti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('loan_id')
                    ->relationship('loan', 'id')
                    ->label('Peminjaman')
                    ->required(),
                Forms\Components\Select::make('jenis_denda')
                    ->label('Jenis Denda')
                    ->options([
                        'terlambat' => 'Terlambat',
                        'hilang' => 'Hilang',
                        'rusak' => 'Rusak',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'belum dibayar' => 'Belum Dibayar',
                        'sudah dibayar' => 'Sudah Dibayar',
                    ])
                    ->default('belum dibayar')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('loan.id')->label('ID Peminjaman')->searchable(),
                Tables\Columns\TextColumn::make('loan.member.name')->label('Anggota')->searchable(),
                Tables\Columns\TextColumn::make('loan.book.title')->label('Buku')->searchable(),
                Tables\Columns\TextColumn::make('jenis_denda')->label('Jenis Denda')->badge()->colors([
                    'warning' => 'terlambat',
                    'danger' => ['hilang', 'rusak'],
                ]),
                Tables\Columns\TextColumn::make('jumlah')->label('Jumlah')->money('IDR'),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->colors([
                    'success' => 'sudah dibayar',
                    'danger' => 'belum dibayar',
                ]),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->date('d M Y'),
                Tables\Columns\TextColumn::make('loan.id')->label('Detail Peminjaman')
                    ->formatStateUsing(function($state) {
                        if (!$state) return '-';
                        return '<a href="/admin/loans/' . $state . '/edit" target="_blank">Lihat</a>';
                    })
                    ->html(),
            ])
            ->actions([
                Tables\Actions\Action::make('bayar')
                    ->label('Tandai Sudah Dibayar')
                    ->visible(fn($record) => $record->status === 'belum dibayar')
                    ->action(function($record) {
                        $record->status = 'sudah dibayar';
                        $record->save();
                    })
                    ->color('success')
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFines::route('/'),
            'create' => Pages\CreateFine::route('/create'),
            'edit' => Pages\EditFine::route('/{record}/edit'),
        ];
    }
}
