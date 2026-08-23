<?php

namespace App\Filament\Resources\Polis\Pages;

use App\Filament\Resources\Polis\PoliResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListPolis extends ListRecords
{
    protected static string $resource = PoliResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Poli')
            ->icon(Heroicon::Plus),
        ];
    }
}
