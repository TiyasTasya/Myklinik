<?php

namespace App\Filament\Resources\Pasiens\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PasiensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('no_rm')
                    ->label('Rekam Medis')
                    ->searchable(),

                TextColumn::make('nama')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->formatStateUsing(fn($record) => collect([
                        $record->gelar_depan,
                        $record->nama,
                        $record->gelar_belakang,
                    ])->filter()->join(' ')),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d/m/Y'),

                TextColumn::make('tempatLahir.name')
                    ->label('Tempat Lahir')
                    ->searchable(),

                TextColumn::make('nama_ibu')
                    ->label('Nama Ibu')
                    ->placeholder('-')
                    // Diambil dari relasi keluarga (hasMany) yang SHDK-nya "Ibu",
                    // karena tidak ada kolom ibu terpisah di tabel pasiens.
                    ->state(fn($record) => optional(
                        $record->keluargas->first(
                            fn($k) => str_contains(strtolower((string) optional($k->statusKeluarga)->deskripsi), 'ibu')
                        )
                    )->nama),

                // ===== Kolom tambahan, disembunyikan default (bisa dimunculkan lewat menu kolom) =====
                TextColumn::make('norm_manual')
                    ->label('Nomor Rekam Medis')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('agama.deskripsi')
                    ->label('Agama')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('unitEksternal.nama')
                    ->label('Unit Eksternal')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status_pasien')
                    ->label('Status')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('tanggal_lahir')
                    ->schema([
                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir'),
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder => $query
                            ->when($data['tanggal_lahir'], fn(Builder $query, $date): Builder => $query->whereDate('tanggal_lahir', $date))
                    ),

                Filter::make('alamat')
                    ->schema([
                        TextInput::make('alamat')
                            ->label('Alamat Pasien'),
                    ])
                    ->query(
                        fn(Builder $query, array $data): Builder => $query
                            ->when($data['alamat'], fn(Builder $query, $value): Builder => $query->where('alamat', 'like', "%{$value}%"))
                    ),

                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ]),

                SelectFilter::make('status_pasien')
                    ->label('Status')
                    ->options([
                        'Hidup' => 'Hidup / Aktif',
                        'Meninggal' => 'Meninggal',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
