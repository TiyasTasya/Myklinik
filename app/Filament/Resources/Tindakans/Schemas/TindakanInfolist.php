<?php

namespace App\Filament\Resources\Tindakans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TindakanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_tindakan'),
                TextEntry::make('kategori_tindakan'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
