<?php

namespace App\Filament\Resources\Tindakans;

use App\Filament\Resources\Tindakans\Pages\CreateTindakan;
use App\Filament\Resources\Tindakans\Pages\EditTindakan;
use App\Filament\Resources\Tindakans\Pages\ListTindakans;
use App\Filament\Resources\Tindakans\Pages\ViewTindakan;
use App\Filament\Resources\Tindakans\Schemas\TindakanForm;
use App\Filament\Resources\Tindakans\Schemas\TindakanInfolist;
use App\Filament\Resources\Tindakans\Tables\TindakansTable;
use App\Models\Tindakan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TindakanResource extends Resource
{
    protected static ?string $model = Tindakan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static string|\UnitEnum|null $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Tindakan';

    protected static ?string $pluralModelLabel = 'Tindakan';

    protected static ?string $navigationLabel = 'Tindakan';

    public static function form(Schema $schema): Schema
    {
        return TindakanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TindakanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TindakansTable::configure($table);
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
            'index' => ListTindakans::route('/'),
            'create' => CreateTindakan::route('/create'),
            'view' => ViewTindakan::route('/{record}'),
            'edit' => EditTindakan::route('/{record}/edit'),
        ];
    }
}
