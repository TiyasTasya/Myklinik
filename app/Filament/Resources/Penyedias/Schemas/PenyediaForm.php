<?php

namespace App\Filament\Resources\Penyedias\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PenyediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('no_telepon')
                    ->label('No. Telepon')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('fax')
                    ->label('Fax')
                    ->maxLength(20),

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->displayFormat('d/m/Y'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Non Aktif' => 'Non Aktif',
                    ])
                    ->default('Aktif')
                    ->required(),
            ]);
    }
}
