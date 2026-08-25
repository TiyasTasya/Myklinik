<?php

namespace App\Filament\Resources\Pendaftarans\Pages;

use App\Filament\Resources\Pendaftarans\PendaftaranResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPendaftaran extends ViewRecord
{
    protected static string $resource = PendaftaranResource::class;

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $this->record->loadMissing([
            'pasien.tempatLahir',
            'pasien.agama',
            'pasien.pendidikan',
            'pasien.pekerjaan',
            'pasien.statusPerkawinan',
            'pasien.golonganDarah',
            'pasien.sukuBangsa',
            'pasien.country',
            'pasien.village',
            'pasien.district',
            'pasien.regency',
            'pasien.province',
            'pasien.jenisKartu',
            'pasien.keluargas.statusKeluarga',
            'pasien.kontaks.jenisKontak',
            'pasien.pendaftarans.poli',
            'pasien.pendaftarans.dokter',
            'poli',
            'dokter',
            'petugas',
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
