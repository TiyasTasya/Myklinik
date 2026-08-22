<?php

namespace App\Filament\Resources\Countries\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(),

                TextColumn::make('flag')
                    ->label('Bendera')
                    ->size('lg'),

                TextColumn::make('name')
                    ->label('Nama Negara')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Kode ISO')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('dial_code')
                    ->label('Kode Telepon')
                    ->searchable(),
            ])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
