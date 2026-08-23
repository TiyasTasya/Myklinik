<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use UnitEnum;

class Wilayah extends Cluster
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Wilayah';

    protected static ?string $title = 'Data Wilayah Indonesia';

    protected static string|UnitEnum|null $navigationGroup = 'Master';

    protected static ?int $navigationSort = 10;

}
