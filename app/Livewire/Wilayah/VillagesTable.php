<?php

namespace App\Livewire\Wilayah;

use App\Models\District;
use App\Models\Village;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class VillagesTable extends BaseWidget
{
    protected function makeTable(): Table
    {
        return parent::makeTable()
            ->paginationMode(PaginationMode::Default);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->query(Village::query()->with('district'))
            ->columns([
                TextColumn::make('id')
                    ->label('Kode')
                    ->searchable()
                    ->extraAttributes(['class' => 'border-r border-gray-200 dark:border-white/10'])
                    ->extraHeaderAttributes(['class' => 'border-r border-gray-200 dark:border-white/10']),
                TextColumn::make('name')
                    ->label('Nama Desa/Kelurahan')
                    ->searchable()
                    ->extraAttributes(['class' => 'border-r border-gray-200 dark:border-white/10'])
                    ->extraHeaderAttributes(['class' => 'border-r border-gray-200 dark:border-white/10']),
                TextColumn::make('district.name')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('id')
                    ->schema([
                        TextInput::make('id')->label('Kode'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['id'] ?? null,
                            fn(Builder $query, $value): Builder => $query->where('id', 'like', "%{$value}%"),
                        );
                    })
                    ->indicateUsing(fn(array $data): ?string => ($data['id'] ?? null) ? 'Kode: ' . $data['id'] : null),

                Filter::make('name')
                    ->schema([
                        TextInput::make('name')->label('Nama Desa/Kelurahan'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['name'] ?? null,
                            fn(Builder $query, $value): Builder => $query->where('name', 'like', "%{$value}%"),
                        );
                    })
                    ->indicateUsing(fn(array $data): ?string => ($data['name'] ?? null) ? 'Nama: ' . $data['name'] : null),

                SelectFilter::make('district_id')
                    ->label('Kecamatan')
                    ->options(District::orderBy('name')->pluck('name', 'id'))
                    ->searchable(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->form([
                            TextInput::make('id')->label('Kode')->disabled(),
                            Select::make('district_id')
                                ->label('Kecamatan')
                                ->options(District::orderBy('name')->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                            TextInput::make('name')->label('Nama Desa/Kelurahan')->required()->maxLength(50),
                        ]),
                    DeleteAction::make()

                ])
            ])
            ->defaultSort('name')
            ->paginated([10, 25, 50]);
    }
}
