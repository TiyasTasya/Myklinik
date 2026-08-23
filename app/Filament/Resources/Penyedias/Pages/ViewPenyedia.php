<?php

namespace App\Filament\Resources\Penyedias\Pages;

use App\Filament\Resources\Penyedias\PenyediaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPenyedia extends ViewRecord
{
    protected static string $resource = PenyediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
