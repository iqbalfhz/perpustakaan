<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?string $navigationLabel = 'Peminjaman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->relationship('member', 'name')
                    ->label('Anggota')
                    ->required(),
                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'title')
                    ->label('Buku')
                    ->required(),
                Forms\Components\DateTimePicker::make('loaned_at')
                    ->label('Tanggal Pinjam')
                    ->required(),
                Forms\Components\DateTimePicker::make('due_at')
                    ->label('Tanggal Jatuh Tempo')
                    ->required(),
                Forms\Components\DateTimePicker::make('returned_at')
                    ->label('Tanggal Pengembalian')
                    ->nullable(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'requested' => 'Diminta',
                        'borrowed' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'lost' => 'Hilang',
                        'damaged' => 'Rusak',
                    ])
                    ->default('borrowed')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.name')->label('Anggota')->searchable(),
                Tables\Columns\TextColumn::make('book.title')->label('Buku')->searchable(),
                Tables\Columns\TextColumn::make('loaned_at')->label('Tanggal Pinjam')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('due_at')->label('Tanggal Jatuh Tempo')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('returned_at')->label('Tanggal Pengembalian')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('status')->label('Status'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
