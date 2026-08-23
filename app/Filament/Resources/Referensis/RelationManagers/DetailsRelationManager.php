<?php

namespace App\Filament\Resources\Referensis\RelationManagers;

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

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $title = 'Detil Referensi';

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Detail Referensi berhasil ditambahkan';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('deskripsi')
                ->label('Deskripsi')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            TextInput::make('urutan')
                ->label('Urutan')
                ->numeric()
                ->default(0),

            Toggle::make('status')
                ->label('Status')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('deskripsi')
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
            ])
            ->defaultSort('urutan')
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Detail Referensi')
                    ->icon(Heroicon::Plus),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
