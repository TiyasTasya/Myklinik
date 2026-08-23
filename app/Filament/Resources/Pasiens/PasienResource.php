<?php

namespace App\Filament\Resources\Pasiens;

use App\Filament\Resources\Pasiens\Pages\CreatePasien;
use App\Filament\Resources\Pasiens\Pages\EditPasien;
use App\Filament\Resources\Pasiens\Pages\ListPasiens;
use App\Filament\Resources\Pasiens\Pages\ViewPasien;
use App\Filament\Resources\Pasiens\Schemas\PasienForm;
use App\Filament\Resources\Pasiens\Schemas\PasienInfolist;
use App\Filament\Resources\Pasiens\Tables\PasiensTable;
use App\Models\Pasien;
use BackedEnum;
use Daljo25\FilamentTablerIcons\Enums\TablerIcon;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PasienResource extends Resource
{
    protected static ?string $model = Pasien::class;

    protected static string|BackedEnum|null $navigationIcon = TablerIcon::UserHeart;

    public static function getNavigationLabel(): string
    {
        return 'Pasien';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Daftar Pasien';
    }

    public static function form(Schema $schema): Schema
    {
        return PasienForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PasienInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PasiensTable::configure($table);
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
            'index' => ListPasiens::route('/'),
            'create' => CreatePasien::route('/create'),
            'view' => ViewPasien::route('/{record}'),
            'edit' => EditPasien::route('/{record}/edit'),
        ];
    }
}
