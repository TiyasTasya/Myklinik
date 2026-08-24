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

class Villages extends Page implements HasTable
{
    use HasPageShield;
    use InteractsWithTable;

    protected static ?string $cluster = Wilayah::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Desa/Kelurahan';
    protected static ?string $title = 'Daftar Desa/Kelurahan';
    protected static ?int $navigationSort = 4;
    protected string $view = 'filament.clusters.wilayah.pages.villages';

    public function table(Table $table): Table
    {
        return $table
            ->query(IndonesiaRegion::query()->whereRaw('CHAR_LENGTH(code) = 13'))
            ->columns([
                TextColumn::make('district_name')
                    ->label('Kecamatan')
                    ->getStateUsing(function ($record) {
                        $districtCode = substr($record->code, 0, 8);
                        return IndonesiaRegion::where('code', $districtCode)->value('name') ?? '-';
                    }),
                TextColumn::make('code')
                    ->label('Kode Desa/Kelurahan')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Desa/Kelurahan')
                    ->searchable(),
                TextColumn::make('postal_code')
                    ->label('Kode Pos')
                    ->searchable(),
            ])
            ->defaultSort('code', 'asc')
            ->actions([
                ActionGroup::make([
                    EditAction::make()->form([
                        TextInput::make('code')->label('Kode Kelurahan')->disabled(),
                        TextInput::make('name')->label('Nama Desa/Kelurahan')->required()->maxLength(100),
                        TextInput::make('postal_code')->label('Kode Pos')->maxLength(10),
                    ]),
                    DeleteAction::make(),
                ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Desa/Kelurahan')
                ->icon(Heroicon::Plus)
                ->model(IndonesiaRegion::class)
                ->form([
                    Select::make('district_code')
                        ->label('Kecamatan')
                        ->searchable()
                        ->getSearchResultsUsing(
                            fn(string $search): array => IndonesiaRegion::query()
                                ->whereRaw('CHAR_LENGTH(code) = 8')
                                ->where('name', 'like', '%' . $search . '%')
                                ->limit(50)
                                ->pluck('name', 'code')
                                ->toArray()
                        )
                        ->getOptionLabelUsing(fn($value): ?string => IndonesiaRegion::where('code', $value)->value('name'))
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if (!$state) {
                                $set('code', '');
                                return;
                            }
                            $lastCode = IndonesiaRegion::where('code', 'LIKE', $state . '.%')
                                ->whereRaw('CHAR_LENGTH(code) = 13')
                                ->orderByDesc('code')
                                ->value('code');

                            $suffix = $lastCode ? (int) substr($lastCode, -4) + 1 : 1;
                            $set('code', $state . '.' . str_pad($suffix, 4, '0', STR_PAD_LEFT));
                        }),
                    TextInput::make('code')
                        ->label('Kode / ID Wilayah (13 karakter)')
                        ->required()
                        ->unique(IndonesiaRegion::class, 'code')
                        ->helperText('Terisi otomatis saat kecamatan dipilih'),
                    TextInput::make('name')
                        ->label('Nama Desa/Kelurahan')
                        ->required()
                        ->maxLength(100),
                    TextInput::make('postal_code')
                        ->label('Kode Pos')
                        ->maxLength(10),
                ])
                ->using(function (array $data): IndonesiaRegion {
                    unset($data['district_code']);
                    $data['status'] = 'active';
                    return IndonesiaRegion::create($data);
                }),
        ];
    }
}
