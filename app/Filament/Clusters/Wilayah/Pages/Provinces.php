<?php

namespace App\Filament\Clusters\Wilayah\Pages;

use Aliziodev\IndonesiaRegions\Models\IndonesiaRegion;
use App\Filament\Clusters\Wilayah;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Provinces extends Page implements HasTable
{
    use HasPageShield;
    use InteractsWithTable;

    protected static ?string $cluster = Wilayah::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Provinsi berhasil ditambahkan';
    }

    protected static ?string $navigationLabel = 'Provinsi';

    protected static ?string $title = 'Daftar Provinsi';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.clusters.wilayah.pages.provinces';

    public function table(Table $table): Table
    {
        return $table
            ->query(IndonesiaRegion::query()->whereRaw('CHAR_LENGTH(code) = 2'))
            ->columns([
                TextColumn::make('code')
                    ->label('Kode Provinsi')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Provinsi')
                    ->searchable(),
            ])
            ->defaultSort('code', 'asc')
            ->actions([
                ActionGroup::make([
                    EditAction::make()->form([
                        TextInput::make('name')
                            ->label('Nama Provinsi')
                            ->required()
                            ->maxLength(255),
                    ]),
                    DeleteAction::make(),
                ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Provinsi')
                ->icon(Heroicon::Plus)
                ->model(IndonesiaRegion::class)
                ->form([
                    TextInput::make('code')
                        ->label('Kode (2 digit)')
                        ->required()
                        ->maxLength(2)
                        ->unique(IndonesiaRegion::class, 'code')
                        ->disabled()
                        ->dehydrated()
                        ->default(function (): string {
                            $lastId = IndonesiaRegion::whereRaw('CHAR_LENGTH(code) = 2')->orderByDesc('code')->value('code');
                            $next = $lastId ? ((int) $lastId) + 1 : 1;

                            return str_pad((string) $next, 2, '0', STR_PAD_LEFT);
                        })
                        ->helperText('Terisi otomatis, urutan berikutnya dari kode terakhir'),
                    TextInput::make('name')
                        ->label('Nama Provinsi')
                        ->required()
                        ->maxLength(255),
                ])
                ->using(function (array $data): IndonesiaRegion {
                    $data['status'] = 'active';
                    return IndonesiaRegion::create($data);
                }),
        ];
    }
}
