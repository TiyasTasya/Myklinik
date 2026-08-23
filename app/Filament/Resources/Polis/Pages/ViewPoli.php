<?php

namespace App\Filament\Resources\Polis\Pages;

use App\Filament\Resources\Polis\PoliResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPoli extends ViewRecord
{
    protected static string $resource = PoliResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
