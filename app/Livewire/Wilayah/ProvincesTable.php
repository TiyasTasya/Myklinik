<?php

namespace App\Livewire\Wilayah;

use App\Models\Province;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ProvincesTable extends BaseWidget
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
            ->query(Province::query())
            ->columns([
                TextColumn::make('id')
                    ->label('Kode')
                    ->searchable()
                    ->extraAttributes(['class' => 'border-r border-gray-200 dark:border-white/10'])
                    ->extraHeaderAttributes(['class' => 'border-r border-gray-200 dark:border-white/10']),
                TextColumn::make('name')
                    ->label('Nama Provinsi')
                    ->searchable(),
            ])
            ->filters([
                Filter::make('id')
                    ->schema([
                        TextInput::make('id')
                            ->label('Kode'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['id'] ?? null,
                            fn(Builder $query, $value): Builder => $query->where('id', 'like', "%{$value}%"),
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (!($data['id'] ?? null)) {
                            return null;
                        }
                        return 'Kode: ' . $data['id'];
                    }),

                Filter::make('name')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Provinsi'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['name'] ?? null,
                            fn(Builder $query, $value): Builder => $query->where('name', 'like', "%{$value}%"),
                        );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (!($data['name'] ?? null)) {
                            return null;
                        }
                        return 'Nama: ' . $data['name'];
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->form([
                            TextInput::make('id')
                                ->label('Kode')
                                ->disabled(),
                            TextInput::make('name')
                                ->label('Nama Provinsi')
                                ->required()
                                ->maxLength(255),
                        ]),
                    DeleteAction::make(),
                ])
            ])
            ->defaultSort('name')
            ->paginated([10, 25, 50]);
    }
}
