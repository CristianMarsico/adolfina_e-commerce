<?php

namespace App\Filament\Resources\Promocions\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductosRelationManager extends RelationManager
{
    protected static string $relationship = 'productos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('categoria_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('slug'),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('marca'),
                TextInput::make('precio')
                    ->required()
                    ->numeric(),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('edad_talla')
                    ->columnSpanFull(),
                Toggle::make('activo')
                    ->required(),
                Toggle::make('destacado')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->inverseRelationship('promociones')
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('categoria_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('marca')
                    ->searchable(),
                TextColumn::make('precio')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('activo')
                    ->boolean(),
                IconColumn::make('destacado')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->multiple()
                    ->label('Vincular producto existente'),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
