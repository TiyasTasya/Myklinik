<?php

namespace App\Filament\Resources\Pendaftarans\Pages;

use App\Filament\Resources\Pasiens\PasienResource;
use App\Filament\Resources\Pendaftarans\PendaftaranResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPendaftarans extends ListRecords
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tombol Tambah Pasien Baru (Jika pasien belum pernah berobat/terdaftar)
            Action::make('tambah_pasien')
                ->label('Tambah Pasien Baru')
                ->icon('heroicon-m-user-plus')
                ->color('success')
                ->url(fn (): string => PasienResource::getUrl('create')),

            // Tombol Daftarkan Kunjungan / Antrian Pasien
            CreateAction::make()
                ->label('Daftarkan Pasien')
                ->icon('heroicon-m-plus')
                ->color('primary'),
        ];
    }
}
