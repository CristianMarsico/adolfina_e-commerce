<?php

namespace App\Filament\Resources\Productos\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImagenesRelationManager extends RelationManager
{
    protected static string $relationship = 'imagenes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('path')
                    ->label('Imagen')
                    ->image()
                    ->directory('productos')
                    ->disk('public')
                    ->required(),
                Toggle::make('es_principal')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('path')
                    ->searchable(),
                IconColumn::make('es_principal')
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
                CreateAction::make()
                    ->mutateDataUsing(function (array $data, $livewire): array {
                        if ($data['es_principal'] ?? false) {
                            $livewire->getOwnerRecord()->imagenes()->update(['es_principal' => false]);
                        }
                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateDataUsing(function (array $data, $livewire, $record): array {
                        if ($data['es_principal'] ?? false) {
                            $livewire->getOwnerRecord()->imagenes()
                                ->where('id', '!=', $record->id)
                                ->update(['es_principal' => false]);
                        }
                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
