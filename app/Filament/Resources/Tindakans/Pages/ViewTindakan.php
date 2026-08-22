<?php

namespace App\Filament\Resources\Tindakans\Pages;

use App\Filament\Resources\Tindakans\TindakanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTindakan extends ViewRecord
{
    protected static string $resource = TindakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
