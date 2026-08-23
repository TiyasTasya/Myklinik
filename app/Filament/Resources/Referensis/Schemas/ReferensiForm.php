<?php

namespace App\Filament\Resources\Referensis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReferensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Referensi')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            TextInput::make('kode')
                ->label('Kode')
                ->maxLength(50)
                ->unique(ignoreRecord: true),
        ]);
    }
}
