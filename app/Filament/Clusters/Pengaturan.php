<?php

namespace App\Filament\Clusters;

use BackedEnum;
use Filament\Clusters\Cluster;
use UnitEnum;

class Pengaturan extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|UnitEnum|null $navigationGroup = 'Master';

    protected static ?int $navigationSort = 99;

    public static function getNavigationLabel(): string
    {
        return 'Pengaturan';
    }

    public static function canAccess(): bool
    {
        return \App\Filament\Clusters\Pengaturan\Pages\PengaturanUmum::canAccess();
    }
}
