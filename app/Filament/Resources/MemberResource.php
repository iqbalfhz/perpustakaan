<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?string $navigationLabel = 'Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('nim_nip')
                    ->label('NIM/NIP')
                    ->required()
                    ->rules(['regex:/^[0-9]+$/']) // hanya boleh angka
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Masukkan NIM/NIP hanya angka'),

                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),

                Forms\Components\TextInput::make('phone')
                    ->label('Telepon')
                    ->maxLength(20),

                Forms\Components\DatePicker::make('registered_at')
                    ->label('Tanggal Daftar')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ])
                    ->default('aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('nim_nip')
                ->label('NIM/NIP')
                ->formatStateUsing(fn ($state) => (string) $state)
                ->searchable(),

            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable()
                ->copyable() // bisa klik copy di tabel
                ->copyMessage('Email berhasil disalin')
                ->copyMessageDuration(1500),

            Tables\Columns\TextColumn::make('phone')
                ->label('Telepon')
                ->searchable()
                ->sortable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('registered_at')
                ->label('Tanggal Daftar')
                ->date('d M Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->colors([
                    'success' => 'aktif',
                    'danger'  => 'nonaktif',
                ])
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label('Filter Status')
                ->options([
                    'aktif' => 'Aktif',
                    'nonaktif' => 'Nonaktif',
                ]),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),   // tombol Lihat
            Tables\Actions\EditAction::make(),   // tombol Edit
            Tables\Actions\DeleteAction::make(), // tombol Hapus
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(), // hapus banyak data sekaligus
        ]);
}


    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit'   => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
