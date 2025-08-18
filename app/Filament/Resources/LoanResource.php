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
                    ->label('Anggota')
                    ->options(fn () => \App\Models\Member::where('status', 'aktif')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'title')
                    ->label('Buku')
                    ->required(),
                Forms\Components\DatePicker::make('loaned_at')
                    ->label('Tanggal Pinjam')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('due_at', \Carbon\Carbon::parse($state)->addMonth()->format('Y-m-d'));
                        } else {
                            $set('due_at', null);
                        }
                    }),
                Forms\Components\DatePicker::make('due_at')
                    ->label('Tanggal Jatuh Tempo')
                    ->default(fn ($get) => $get('loaned_at') ? \Carbon\Carbon::parse($get('loaned_at'))->addMonth()->format('Y-m-d') : null)
                    ->reactive()
                    ->readOnly(),
                // Tanggal Pengembalian dihapus dari form, akan diisi otomatis saat pengembalian di menu denda/biaya ganti
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'hilang' => 'Hilang',
                        'rusak' => 'Rusak',
                    ])
                    ->default('dipinjam')
                    ->required(),

                Forms\Components\Select::make('book_condition')
                    ->label('Kondisi Buku Saat Dikembalikan')
                    ->options([
                        'normal' => 'Normal',
                        'rusak' => 'Rusak',
                        'hilang' => 'Hilang',
                    ])
                    ->required()
                    ->visible(fn ($get) => $get('status') !== 'dipinjam'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.name')->label('Anggota')->searchable(),
                Tables\Columns\TextColumn::make('book.title')->label('Buku')->searchable(),
                Tables\Columns\TextColumn::make('loaned_at')->label('Tanggal Pinjam'),
                Tables\Columns\TextColumn::make('due_at')->label('Tanggal Jatuh Tempo'),
                Tables\Columns\TextColumn::make('returned_at')->label('Tanggal Pengembalian'),
                Tables\Columns\TextColumn::make('status')->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'dipinjam',
                        'danger' => ['hilang', 'rusak'],
                    ]),
                Tables\Columns\TextColumn::make('denda')->label('Denda')->getStateUsing(function ($record) {
                    if ($record->returned_at && $record->returned_at > $record->due_at) {
                        $daysLate = \Carbon\Carbon::parse($record->returned_at)->diffInDays(\Carbon\Carbon::parse($record->due_at));
                        return 'Rp ' . number_format($daysLate * 1000, 0, ',', '.');
                    }
                    return '-';
                }),
            ])
            ->actions([
                Tables\Actions\Action::make('kembalikan')
                    ->label('Kembalikan Buku')
                    ->visible(fn ($record) => $record->status === 'dipinjam' && (!($record->returned_at && $record->book_condition === 'normal')))
                    ->form([
                        Forms\Components\Select::make('book_condition')
                            ->label('Kondisi Buku Saat Dikembalikan')
                            ->options([
                                'normal' => 'Normal',
                                'rusak' => 'Rusak',
                                'hilang' => 'Hilang',
                            ])
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->book_condition = $data['book_condition'];
                        $record->returned_at = now();
                        if ($data['book_condition'] === 'normal') {
                            if ($record->book) {
                                $record->book->increment('stock');
                            }
                            
                        } else {
                            $record->status = $data['book_condition'];
                        }
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('success'),
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
