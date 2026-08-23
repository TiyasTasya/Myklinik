<?php

namespace App\Filament\Resources\UnitEksternals\Pages;

use App\Filament\Resources\UnitEksternals\UnitEksternalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListUnitEksternals extends ListRecords
{
    protected static string $resource = UnitEksternalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Unit Kerja')
            ->icon(Heroicon::Plus),
        ];
    }
}
