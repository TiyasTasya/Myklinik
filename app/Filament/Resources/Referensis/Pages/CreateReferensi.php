<?php

namespace App\Filament\Resources\Referensis\Pages;

use App\Filament\Resources\Referensis\ReferensiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReferensi extends CreateRecord
{
    protected static string $resource = ReferensiResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Referensi berhasil ditambahkan';
    }
}
