<?php

namespace App\Filament\Resources\Pasiens\Pages;

use App\Filament\Resources\Pasiens\PasienResource;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPasien extends EditRecord
{
    protected static string $resource = PasienResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('')
                ->icon(TablerIcon::Eye)
                ->tooltip('Lihat Detail Pasien'),
            DeleteAction::make()
                ->label('')
                ->icon(TablerIcon::Trash)
                ->tooltip('Hapus Pasien'),
        ];
    }
}
