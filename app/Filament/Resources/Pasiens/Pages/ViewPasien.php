<?php

namespace App\Filament\Resources\Pasiens\Pages;

use App\Filament\Resources\Pasiens\PasienResource;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPasien extends ViewRecord
{
    protected static string $resource = PasienResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
            ->label('')
            ->icon(TablerIcon::Edit)
            ->tooltip('Edit Pasien'),
        ];
    }
}
