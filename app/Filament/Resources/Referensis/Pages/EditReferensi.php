<?php

namespace App\Filament\Resources\Referensis\Pages;

use App\Filament\Resources\Referensis\ReferensiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReferensi extends EditRecord
{
    protected static string $resource = ReferensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
