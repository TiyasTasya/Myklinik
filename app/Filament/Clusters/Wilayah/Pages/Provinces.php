<?php

namespace App\Filament\Clusters\Wilayah\Pages;

use App\Filament\Clusters\Wilayah;
use App\Models\Province;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Provinces extends Page
{
    protected static ?string $cluster = Wilayah::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Provinsi berhasil ditambahkan';
    }

    protected static ?string $navigationLabel = 'Provinsi';

    protected static ?string $title = 'Data Provinsi';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.clusters.wilayah.pages.provinces';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Provinsi')
                ->icon(Heroicon::Plus)
                ->model(Province::class)
                ->form([
                    TextInput::make('id')
                        ->label('Kode (2 digit)')
                        ->required()
                        ->maxLength(2)
                        ->unique(Province::class, 'id')
                        ->disabled()
                        ->dehydrated()
                        ->default(function (): string {
                            $lastId = Province::orderByDesc('id')->value('id');
                            $next = $lastId ? ((int) $lastId) + 1 : 1;

                            return str_pad((string) $next, 2, '0', STR_PAD_LEFT);
                        })
                        ->helperText('Terisi otomatis, urutan berikutnya dari kode terakhir'),
                    TextInput::make('name')
                        ->label('Nama Provinsi')
                        ->required()
                        ->maxLength(255),
                ])
                ->using(function (array $data): Province {
                    return Province::create($data);
                }),
        ];
    }
}
