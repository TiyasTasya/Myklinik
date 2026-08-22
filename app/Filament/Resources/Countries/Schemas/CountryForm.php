<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Negara')
                    ->required(),
                TextInput::make('code')
                    ->label('Kode ISO')
                    ->required(),
                TextInput::make('dial_code')
                    ->label('Kode Telepon')
                    ->required(),
                TextInput::make('flag')
                    ->label('Bendera'),
            ]);
    }
}
