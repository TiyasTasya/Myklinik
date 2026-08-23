<?php

namespace App\Filament\Resources\UnitEksternals\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubUnitsRelationManager extends RelationManager
{
    protected static string $relationship = 'subUnits';

    protected static ?string $title = 'Sub Unit (Eselon 2)';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Sub Unit')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Toggle::make('status')
                ->label('Status')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Sub Unit')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Sub Unit Kerja')
                    ->icon(Heroicon::Plus)
                    ->successNotificationTitle('Sub Unit berhasil ditambahkan'),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->successNotificationTitle('Sub Unit berhasil diperbarui'),
                    DeleteAction::make()
                        ->successNotificationTitle('Sub Unit berhasil dihapus'),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
