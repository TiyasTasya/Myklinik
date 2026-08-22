<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Wilayah extends Cluster
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Wilayah';

    protected static ?string $title = 'Data Wilayah Indonesia';

    protected static ?int $navigationSort = 10;
}
