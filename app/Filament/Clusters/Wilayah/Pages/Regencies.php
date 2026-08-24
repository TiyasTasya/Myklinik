<?php

namespace App\Filament\Clusters\Wilayah\Pages;

use Aliziodev\IndonesiaRegions\Models\IndonesiaRegion;
use App\Filament\Clusters\Wilayah;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Regencies extends Page implements HasTable
{
    use HasPageShield;
    use InteractsWithTable;

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

    public function table(Table $table): Table
    {
        return $table
            ->query(IndonesiaRegion::query()->whereRaw('CHAR_LENGTH(code) = 5'))
            ->columns([
                TextColumn::make('provinsi_name')
                    ->label('Provinsi')
                    ->getStateUsing(function ($record) {
                        $provCode = substr($record->code, 0, 2);
                        return IndonesiaRegion::where('code', $provCode)->value('name') ?? '-';
                    }),
                TextColumn::make('code')
                    ->label('Kode Kabupaten/Kota')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Kabupaten/Kota')
                    ->searchable(),
            ])
            ->defaultSort('code', 'asc')
            ->actions([
                ActionGroup::make([
                    EditAction::make()->form([
                        TextInput::make('name')->label('Nama Kabupaten/Kota')->required()->maxLength(50),
                    ]),
                    DeleteAction::make(),
                ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kabupaten/Kota')
                ->icon(Heroicon::Plus)
                ->model(IndonesiaRegion::class)
                ->form([
                    Select::make('province_code')
                        ->label('Provinsi')
                        ->options(IndonesiaRegion::whereRaw('CHAR_LENGTH(code) = 2')->orderBy('name')->pluck('name', 'code'))
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if (!$state) {
                                $set('code', '');
                                return;
                            }
                            $lastCode = IndonesiaRegion::where('code', 'like', $state . '.%')
                                ->whereRaw('CHAR_LENGTH(code) = 5')
                                ->orderByDesc('code')
                                ->value('code');
                            $suffix = $lastCode ? (int) substr($lastCode, -2) + 1 : 1;
                            $set('code', $state . '.' . str_pad($suffix, 2, '0', STR_PAD_LEFT));
                        }),
                    TextInput::make('code')
                        ->label('Kode / ID Wilayah')
                        ->required()
                        ->unique(IndonesiaRegion::class, 'code')
                        ->helperText('Terisi otomatis saat provinsi dipilih'),
                    TextInput::make('name')
                        ->label('Nama Kabupaten/Kota')
                        ->required()
                        ->maxLength(50),
                ])
                ->using(function (array $data): IndonesiaRegion {
                    unset($data['province_code']);
                    $data['status'] = 'active';
                    return IndonesiaRegion::create($data);
                }),
        ];
    }
}
