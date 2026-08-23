<?php

namespace App\Filament\Resources\Penyedias\Pages;

use App\Filament\Resources\Penyedias\PenyediaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPenyedia extends EditRecord
{
    protected static string $resource = PenyediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
