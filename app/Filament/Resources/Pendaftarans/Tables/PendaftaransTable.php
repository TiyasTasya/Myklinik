<?php

namespace App\Filament\Resources\Pendaftarans\Tables;

use App\Models\Pendaftaran;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PendaftaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['pasien', 'poli', 'dokter']))
            ->searchPlaceholder('Cari No. RM / Nama Pasien / No. Registrasi...')
            ->searchDebounce('400ms')
            ->columns([
                TextColumn::make('no_pendaftaran')
                    ->label('No. Registrasi')
                    ->searchable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('tanggal_pendaftaran')
                    ->label('Waktu')
                    ->dateTime('d/m/Y H:i'),

                TextColumn::make('pasien.nama')
                    ->label('Nama Pasien')
                    ->searchable(['nama', 'no_rm', 'nama_panggilan'])
                    ->weight('semibold')
                    ->description(fn (Pendaftaran $record): ?string => $record->pasien ? "No. RM: {$record->pasien->no_rm}" : null),

                TextColumn::make('poli.nama')
                    ->label('Poli Layanan')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                TextColumn::make('dokter.nama_lengkap')
                    ->label('Dokter / DPJP')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('status_pelayanan')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'Menunggu',
                        'info'    => 'Sedang Diperiksa',
                        'success' => 'Selesai',
                        'danger'  => 'Batal',
                    ]),

                ViewColumn::make('no_antrian')
                    ->label('Antrian')
                    ->view('filament.tables.columns.antrian-box')
                    ->alignment(Alignment::Center),
            ])
            ->defaultSort('tanggal_pendaftaran', 'desc')
            ->filtersLayout(FiltersLayout::Dropdown)
            ->filtersFormColumns(2)
            ->filtersTriggerAction(
                fn ($action) => $action
                    ->button()
                    ->label('Filter Data')
                    ->icon('heroicon-m-funnel')
                    ->size('sm')
            )
            ->filters([
                // Filter Rentang Tanggal
                Filter::make('periode')
                    ->label('Rentang Tanggal')
                    ->columns(2)
                    ->columnSpanFull()
                    ->form([
                        DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->placeholder('dd/mm/yyyy'),

                        DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->placeholder('dd/mm/yyyy'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'] ?? null,
                                fn (Builder $q, $date) => $q->whereDate('tanggal_pendaftaran', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'] ?? null,
                                fn (Builder $q, $date) => $q->whereDate('tanggal_pendaftaran', '<=', $date),
                            );
                    }),

                // Filter Poli
                SelectFilter::make('poli_id')
                    ->label('Poli / Ruangan')
                    ->relationship('poli', 'nama')
                    ->searchable()
                    ->preload()
                    ->placeholder('Semua Poli'),

                // Filter Status Pelayanan
                SelectFilter::make('status_pelayanan')
                    ->label('Status Pelayanan')
                    ->options([
                        'Menunggu'         => 'Menunggu Antrian',
                        'Sedang Diperiksa' => 'Sedang Dilayani',
                        'Selesai'          => 'Selesai Pelayanan',
                        'Batal'            => 'Pendaftaran Batal',
                    ])
                    ->placeholder('Semua Status'),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->label('Lihat Data Registrasi'),
                    EditAction::make()->label('Ubah Data Registrasi'),
                    DeleteAction::make()->label('Hapus Pendaftaran'),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
