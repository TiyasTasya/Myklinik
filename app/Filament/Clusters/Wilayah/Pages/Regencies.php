<?php

namespace App\Filament\Clusters\Wilayah\Pages;

use App\Filament\Clusters\Wilayah;
use App\Models\Province;
use App\Models\Regency;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;

class Regencies extends Page
{
    protected static ?string $cluster = Wilayah::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-library';

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Kabupaten/Kota berhasil ditambahkan';
    }

    protected static ?string $navigationLabel = 'Kabupaten/Kota';

    protected static ?string $title = 'Daftar Kabupaten/Kota';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.clusters.wilayah.pages.regencies';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kab/Kota')
                ->icon(Heroicon::Plus)
                ->model(Regency::class)
                ->form([
                    Select::make('province_id')
                        ->label('Provinsi')
                        ->options(Province::orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if (!$state) {
                                $set('id', '');
                                return;
                            }
                            $lastId = Regency::where('province_id', $state)->orderByDesc('id')->value('id');
                            $suffix = $lastId ? (int) substr($lastId, 2) + 1 : 1;
                            $set('id', $state . str_pad($suffix, 2, '0', STR_PAD_LEFT));
                        }),
                    TextInput::make('id')
                        ->label('Kode (4 digit)')
                        ->required()
                        ->maxLength(4)
                        ->unique(Regency::class, 'id')
                        ->helperText('Terisi otomatis saat provinsi dipilih'),
                    TextInput::make('name')
                        ->label('Nama Kab/Kota')
                        ->required()
                        ->maxLength(50),
                ])
                ->using(function (array $data): Regency {
                    return Regency::create($data);
                }),
        ];
    }
}
