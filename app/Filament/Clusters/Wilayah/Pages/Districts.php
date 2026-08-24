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

class Districts extends Page implements HasTable
{
    use HasPageShield;
    use InteractsWithTable;

    protected static ?string $cluster = Wilayah::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Kecamatan berhasil ditambahkan';
    }

    protected static ?string $navigationLabel = 'Kecamatan';

    protected static ?string $title = 'Daftar Kecamatan';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.clusters.wilayah.pages.districts';

    public function table(Table $table): Table
    {
        return $table
            ->query(IndonesiaRegion::query()->whereRaw('CHAR_LENGTH(code) = 8'))
            ->columns([
                TextColumn::make('regency_name')
                    ->label('Kabupaten/Kota')
                    ->getStateUsing(function ($record) {
                        $regencyCode = substr($record->code, 0, 5);
                        return IndonesiaRegion::where('code', $regencyCode)->value('name') ?? '-';
                    }),
                TextColumn::make('code')
                    ->label('Kode Kecamatan')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Kecamatan')
                    ->searchable(),
            ])
            ->defaultSort('code', 'asc')
            ->actions([
                ActionGroup::make([
                    EditAction::make()->form([
                        TextInput::make('name')
                            ->label('Nama Kecamatan')
                            ->required()
                            ->maxLength(50),
                    ]),
                    DeleteAction::make(),
                ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Kecamatan')
                ->icon(Heroicon::Plus)
                ->model(IndonesiaRegion::class)
                ->form([
                    Select::make('regency_code')
                        ->label('Kabupaten/Kota')
                        ->options(IndonesiaRegion::whereRaw('CHAR_LENGTH(code) = 5')->orderBy('name')->pluck('name', 'code'))
                        ->searchable()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if (!$state) {
                                $set('code', '');
                                return;
                            }
                            $lastCode = IndonesiaRegion::where('code', 'like', $state . '.%')
                                ->whereRaw('CHAR_LENGTH(code) = 8')
                                ->orderByDesc('code')
                                ->value('code');
                            $suffix = $lastCode ? (int) substr($lastCode, -2) + 1 : 1;
                            $set('code', $state . '.' . str_pad($suffix, 2, '0', STR_PAD_LEFT));
                        }),
                    TextInput::make('code')
                        ->label('Kode Kecamatan (8 karakter)')
                        ->required()
                        ->maxLength(8)
                        ->unique(IndonesiaRegion::class, 'code')
                        ->helperText('Terisi otomatis saat kab/kota dipilih'),
                    TextInput::make('name')
                        ->label('Nama Kecamatan')
                        ->required()
                        ->maxLength(50),
                ])
                ->using(function (array $data): IndonesiaRegion {
                    unset($data['regency_code']);
                    $data['status'] = 'active';
                    return IndonesiaRegion::create($data);
                }),
        ];
    }
}
