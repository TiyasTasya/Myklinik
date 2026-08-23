<?php

namespace App\Filament\Resources\UnitEksternals\Pages;

use App\Filament\Resources\UnitEksternals\UnitEksternalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUnitEksternal extends CreateRecord
{
    protected static string $resource = UnitEksternalResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Unit Eksternal berhasil ditambahkan';
    }
}
