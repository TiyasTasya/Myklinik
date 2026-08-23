<?php

namespace App\Filament\Resources\Penyedias\Pages;

use App\Filament\Resources\Penyedias\PenyediaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenyedias extends ListRecords
{
    protected static string $resource = PenyediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
