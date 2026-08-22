<?php

use App\Models\Village;
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
            ->query(Village::query()->with('district'))
            ->columns([
                TextColumn::make('id')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Desa/Kelurahan')
                    ->searchable(),
                TextColumn::make('district.name')
                    ->label('Kecamatan')
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
