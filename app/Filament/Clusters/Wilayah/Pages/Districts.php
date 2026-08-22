<?php

namespace App\Filament\Clusters\Wilayah\Pages;

use App\Filament\Clusters\Wilayah;
use App\Models\District;
use App\Models\Regency;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;

class Districts extends Page
{
    protected static ?string $cluster = Wilayah::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Kecamatan';

    protected static ?string $title = 'Data Kecamatan';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.clusters.wilayah.pages.districts';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kecamatan')
                ->icon(Heroicon::Plus)
                ->model(District::class)
                ->form([
                    Select::make('regency_id')
                        ->label('Kabupaten/Kota')
                        ->options(Regency::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if (!$state) { $set('id', ''); return; }
                            $lastId = District::where('regency_id', $state)->orderByDesc('id')->value('id');
                            $suffix = $lastId ? (int) substr($lastId, 4) + 1 : 1;
                            $set('id', $state . str_pad($suffix, 3, '0', STR_PAD_LEFT));
                        }),
                    TextInput::make('id')
                        ->label('Kode (7 digit)')
                        ->required()
                        ->maxLength(7)
                        ->unique(District::class, 'id')
                        ->helperText('Terisi otomatis saat kab/kota dipilih'),
                    TextInput::make('name')
                        ->label('Nama Kecamatan')
                        ->required()
                        ->maxLength(50),
                ])
                ->using(function (array $data): District {
                    return District::create($data);
                }),
        ];
    }
}
