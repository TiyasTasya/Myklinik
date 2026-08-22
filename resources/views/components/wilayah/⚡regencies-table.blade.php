<?php

use App\Models\Regency;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Volt\Component;

new class extends Component implements HasTable
{
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Regency::query()->with('province'))
            ->columns([
                TextColumn::make('id')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Kab/Kota')
                    ->searchable(),
                TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->paginated([10, 25, 50]);
    }
}; ?>

<div>
    {{ $this->table }}
</div>
