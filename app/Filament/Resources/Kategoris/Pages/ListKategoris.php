<?php

namespace App\Filament\Resources\Kategoris\Pages;

use App\Filament\Resources\Kategoris\KategoriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListKategoris extends ListRecords
{
    protected static string $resource = KategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kategori')
                ->icon(Heroicon::Plus),
        ];
    }
}
