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
                    ->toggleable(),

                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),

                TextColumn::make('nama_lengkap')
                    ->searchable(),

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
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Cuti' => 'warning',
                        'Nonaktif' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
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
