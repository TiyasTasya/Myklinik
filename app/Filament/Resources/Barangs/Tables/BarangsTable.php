<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),

                TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),

                TextColumn::make('satuan.nama')
                    ->label('Satuan')
                    ->searchable(),

                TextColumn::make('merk')
                    ->label('Merk')
                    ->searchable(),

                TextColumn::make('penyedia.nama')
                    ->label('Penyedian')
                    ->searchable(),

                TextColumn::make('generik')
                    ->label('Generik')
                    ->searchable(),

                TextColumn::make('jenis_penggunaan')
                    ->label('Jenis Penggunaan')
                    ->badge()
                    ->color(fn(string $state): string => $state === 'Obat Dalam' ? 'info' : 'warning'),

                TextColumn::make('stok_minimum')
                    ->label('Stok Minimum')
                    ->numeric(),

                IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ])
            ->recordUrl(null)
            ->filters([
                SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama'),

                SelectFilter::make('jenis_penggunaan')
                    ->label('Jenis Penggunaan')
                    ->options([
                        'Obat Dalam' => 'Obat Dalam',
                        'Obat Luar' => 'Obat Luar',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([1 => 'Aktif', 0 => 'Non Aktif']),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
