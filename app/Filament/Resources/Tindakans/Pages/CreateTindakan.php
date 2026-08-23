<?php

namespace App\Filament\Resources\Tindakans\Pages;

use App\Filament\Resources\Tindakans\TindakanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTindakan extends CreateRecord
{
    protected static string $resource = TindakanResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Tindakan berhasil ditambahkan';
    }
}
