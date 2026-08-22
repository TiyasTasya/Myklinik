<?php

use App\Models\Province;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Volt\Component;

new class extends Component implements HasTable
{
    use InteractsWithTable;

    public function makeFilamentTranslatableContentDriver(): ?\Filament\Support\Contracts\TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Province::query())
            ->columns([
                TextColumn::make('id')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Provinsi')
                    ->searchable(),
            ])
            ->defaultSort('name')
            ->paginated([10, 25, 50]);
    }
}; ?>

<div>
    {{ $this->table }}
</div>
