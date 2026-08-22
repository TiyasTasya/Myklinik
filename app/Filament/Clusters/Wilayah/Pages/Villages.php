<?php

namespace App\Filament\Clusters\Wilayah\Pages;

use App\Filament\Clusters\Wilayah;
use App\Models\District;
use App\Models\Village;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;

class Villages extends Page
{
    protected static ?string $cluster = Wilayah::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'Desa/Kelurahan';

    protected static ?string $title = 'Data Desa/Kelurahan';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.clusters.wilayah.pages.villages';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Desa/Kelurahan')
                ->icon(Heroicon::Plus)
                ->model(Village::class)
                ->form([
                    Select::make('district_id')
                        ->label('Kecamatan')
                        ->options(District::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if (!$state) { $set('id', ''); return; }
                            $lastId = Village::where('district_id', $state)->orderByDesc('id')->value('id');
                            $suffix = $lastId ? (int) substr($lastId, 7) + 1 : 1;
                            $set('id', $state . str_pad($suffix, 3, '0', STR_PAD_LEFT));
                        }),
                    TextInput::make('id')
                        ->label('Kode (10 digit)')
                        ->required()
                        ->maxLength(10)
                        ->unique(Village::class, 'id')
                        ->helperText('Terisi otomatis saat kecamatan dipilih'),
                    TextInput::make('name')
                        ->label('Nama Desa/Kelurahan')
                        ->required()
                        ->maxLength(50),
                ])
                ->using(function (array $data): Village {
                    return Village::create($data);
                }),
        ];
    }
}
