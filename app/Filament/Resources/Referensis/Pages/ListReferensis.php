<?php

namespace App\Filament\Resources\Referensis\Pages;

use App\Filament\Resources\Referensis\ReferensiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListReferensis extends ListRecords
{
    protected static string $resource = ReferensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Refensi')
            ->icon(Heroicon::Plus),
        ];
    }
}
