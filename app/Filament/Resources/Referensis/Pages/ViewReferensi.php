<?php

namespace App\Filament\Resources\Referensis\Pages;

use App\Filament\Resources\Referensis\ReferensiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReferensi extends ViewRecord
{
    protected static string $resource = ReferensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
