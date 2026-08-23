<?php

namespace App\Filament\Resources\Penyedias;

use App\Filament\Resources\Penyedias\Pages\CreatePenyedia;
use App\Filament\Resources\Penyedias\Pages\EditPenyedia;
use App\Filament\Resources\Penyedias\Pages\ListPenyedias;
use App\Filament\Resources\Penyedias\Pages\ViewPenyedia;
use App\Filament\Resources\Penyedias\Schemas\PenyediaForm;
use App\Filament\Resources\Penyedias\Schemas\PenyediaInfolist;
use App\Filament\Resources\Penyedias\Tables\PenyediasTable;
use App\Models\Penyedia;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PenyediaResource extends Resource
{
    protected static ?string $model = Penyedia::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|\UnitEnum|null $navigationGroup = 'Master';


    protected static ?string $pluralModelLabel = 'Daftar Penyedia';

    protected static ?string $navigationLabel = 'Penyedia';

    public static function form(Schema $schema): Schema
    {
        return PenyediaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PenyediaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenyediasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenyedias::route('/'),
            'create' => CreatePenyedia::route('/create'),
            'view' => ViewPenyedia::route('/{record}'),
            'edit' => EditPenyedia::route('/{record}/edit'),
        ];
    }
}
