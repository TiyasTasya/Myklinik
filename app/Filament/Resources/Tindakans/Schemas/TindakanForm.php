<?php

namespace App\Filament\Resources\Tindakans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TindakanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_tindakan')
                    ->required(),
                TextInput::make('kategori_tindakan')
                    ->required(),
                Select::make('status')
                    ->options(['Aktif' => 'Aktif', 'Non Aktif' => 'Non aktif'])
                    ->default('Aktif')
                    ->required(),
            ]);
    }
}
