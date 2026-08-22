<?php

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PegawaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Mengubah user_id menjadi Select agar mengambil data dari tabel users
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Akun User Login')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->maxLength(50),

                TextInput::make('nama_lengkap')
                    ->required()
                    ->maxLength(150),

                TextInput::make('tempat_tanggal_lahir')
                    ->label('Tempat, Tanggal Lahir')
                    ->placeholder('Contoh: Jakarta, 17 Agustus 1995')
                    ->required()
                    ->maxLength(100),

                Select::make('jenis_kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan'
                    ])
                    ->required(),

                Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('profesi')
                    ->required()
                    ->maxLength(100),

                // Mengubah status menjadi Select agar seragam dengan tabelnya
                Select::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Nonaktif' => 'Nonaktif',
                    ])
                    ->default('Aktif')
                    ->required(),
            ]);
    }
}
