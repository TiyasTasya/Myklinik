<?php

namespace App\Filament\Resources\UnitEksternals\Pages;

use App\Filament\Resources\UnitEksternals\UnitEksternalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUnitEksternal extends ViewRecord
{
    protected static string $resource = UnitEksternalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
