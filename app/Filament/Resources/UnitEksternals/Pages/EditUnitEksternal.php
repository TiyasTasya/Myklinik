<?php

namespace App\Filament\Resources\UnitEksternals\Pages;

use App\Filament\Resources\UnitEksternals\UnitEksternalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUnitEksternal extends EditRecord
{
    protected static string $resource = UnitEksternalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
