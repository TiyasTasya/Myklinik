<?php

namespace App\Filament\Resources\Countries;

use App\Filament\Resources\Countries\Pages; // <-- INI YANG KURANG
use App\Filament\Resources\Countries\Tables\CountriesTable;
use App\Models\Country;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use App\Filament\Resources\Countries\Schemas\CountryForm;
use App\Filament\Resources\Countries\Schemas\CountryInfolist;

class CountryResource extends Resource
{
    // Hubungkan kembali ke Eloquent Model Country
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'Negara';
    protected static ?string $modelLabel = 'Negara';
    protected static ?string $pluralModelLabel = 'Daftar Negara';

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CountryInfolist::configure($schema);
    }

    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'view' => Pages\ViewCountry::route('/{record}'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
