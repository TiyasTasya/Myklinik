<?php

namespace App\Filament\Resources\UnitEksternals\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UnitEksternalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Unit')
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
