<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BarangInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_barang'),
                TextEntry::make('kategori.id')
                    ->label('Kategori'),
                TextEntry::make('satuan.id')
                    ->label('Satuan'),
                TextEntry::make('merk')
                    ->placeholder('-'),
                TextEntry::make('penyedia.id')
                    ->label('Penyedia'),
                TextEntry::make('generik')
                    ->placeholder('-'),
                TextEntry::make('jenis_penggunaan')
                    ->badge(),
                TextEntry::make('stok_minimum')
                    ->numeric(),
                IconEntry::make('status')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
