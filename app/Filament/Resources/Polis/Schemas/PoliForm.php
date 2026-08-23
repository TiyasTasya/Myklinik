<?php

namespace App\Filament\Resources\Polis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PoliForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Poli')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            Toggle::make('status')
                ->label('Status')
                ->default(true)
                ->columnStart(1),
        ]);
    }
}
