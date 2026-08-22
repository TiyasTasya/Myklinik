<?php

use App\Models\District;
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
            ->query(District::query()->with('regency'))
            ->columns([
                TextColumn::make('id')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Kecamatan')
                    ->searchable(),
                TextColumn::make('regency.name')
                    ->label('Kab/Kota')
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->paginated([10, 25, 50]);
    }

    // Tambahkan method kontrak wajib ini di sini:
    public function makeFilamentTranslatableContentDriver(): ?\Filament\Support\Contracts\TranslatableContentDriver
    {
        return null;
    }
}; ?>

<div>
    {{ $this->table }}
</div>
