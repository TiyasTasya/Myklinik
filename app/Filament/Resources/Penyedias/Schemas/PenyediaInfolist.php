<?php

namespace App\Filament\Resources\Penyedias\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PenyediaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama')
                    ->label('Nama'),

                TextEntry::make('alamat')
                    ->label('Alamat')
                    ->columnSpanFull(),

                TextEntry::make('no_telepon')
                    ->label('No. Telepon'),

                TextEntry::make('fax')
                    ->label('Fax'),

                TextEntry::make('tanggal')
                    ->label('Tanggal')
                    ->date('d/m/Y'),

                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Non Aktif' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }
}
