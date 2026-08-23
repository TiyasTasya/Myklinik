<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->unique(table: 'kategoris', column: 'nama'),
                    ])
                    ->createOptionModalHeading('Tambah Kategori Baru'),

                Select::make('satuan_id')
                    ->label('Satuan')
                    ->relationship('satuan', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->label('Nama Satuan')
                            ->required()
                            ->maxLength(255)
                            ->unique(table: 'satuans', column: 'nama'),
                    ])
                    ->createOptionModalHeading('Tambah Satuan Baru'),

                TextInput::make('merk')
                    ->label('Merk')
                    ->maxLength(255),

                Select::make('penyedia_id')
                    ->label('Penyedia')
                    ->relationship('penyedia', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('generik')
                    ->label('Generik')
                    ->maxLength(255),

                Select::make('jenis_penggunaan')
                    ->label('Jenis Penggunaan')
                    ->options([
                        'Obat Dalam' => 'Obat Dalam',
                        'Obat Luar' => 'Obat Luar',
                    ])
                    ->required(),

                TextInput::make('stok_minimum')
                    ->label('Stok Minimum')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Toggle::make('status')
                    ->label('Status')
                    ->default(true),
            ]);
    }
}
