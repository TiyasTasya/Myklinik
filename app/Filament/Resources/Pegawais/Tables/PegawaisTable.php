<?php

namespace App\Filament\Resources\Pegawais\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PegawaisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom Nomor Urut di sebelah kiri
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(),

                // Menampilkan nama user dari tabel relasi
                TextColumn::make('user.name')
                    ->label('Akun User')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tempat_tanggal_lahir')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Laki-laki' => 'info',
                        'Perempuan' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('profesi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Cuti' => 'warning',
                        'Nonaktif' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
