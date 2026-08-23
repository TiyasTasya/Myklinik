<?php

namespace App\Filament\Resources\Polis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PoliInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('nama')
                ->label('Nama Poli'),

            TextEntry::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Non Aktif')
                ->color(fn ($state) => $state ? 'success' : 'danger'),
        ]);
    }
}
