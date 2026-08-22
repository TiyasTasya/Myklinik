<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CountryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Negara'),
                TextEntry::make('code')
                    ->label('Kode ISO'),
                TextEntry::make('dial_code')
                    ->label('Kode Telepon'),
                TextEntry::make('flag')
                    ->label('Bendera'),
            ]);
    }
}
