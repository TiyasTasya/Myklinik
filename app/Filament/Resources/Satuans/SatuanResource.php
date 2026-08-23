<?php

namespace App\Filament\Resources\Satuans;

use App\Filament\Clusters\ManajemenBarang;
use App\Filament\Resources\Satuans\Pages\CreateSatuan;
use App\Filament\Resources\Satuans\Pages\EditSatuan;
use App\Filament\Resources\Satuans\Pages\ListSatuans;
use App\Filament\Resources\Satuans\Pages\ViewSatuan;
use App\Filament\Resources\Satuans\Schemas\SatuanForm;
use App\Filament\Resources\Satuans\Schemas\SatuanInfolist;
use App\Filament\Resources\Satuans\Tables\SatuansTable;
use App\Models\Satuan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SatuanResource extends Resource
{
    protected static ?string $model = Satuan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static ?string $cluster = ManajemenBarang::class;

    public static function getNavigationLabel(): string
    {
        return 'Satuan';
    }

    // Label tunggal (untuk form/notifikasi)
    public static function getModelLabel(): string
    {
        return 'Satuan';
    }

    // Label jamak (untuk judul halaman dan breadcrumb)
    public static function getPluralModelLabel(): string
    {
        return 'Daftar Satuan';
    }

    public static function form(Schema $schema): Schema
    {
        return SatuanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SatuanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SatuansTable::configure($table);
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
            'index' => ListSatuans::route('/'),
            'create' => CreateSatuan::route('/create'),
            'view' => ViewSatuan::route('/{record}'),
            'edit' => EditSatuan::route('/{record}/edit'),
        ];
    }
}
