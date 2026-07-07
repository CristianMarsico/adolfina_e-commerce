<?php

namespace App\Filament\Resources\Productos\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TallesRelationManager extends RelationManager
{
    protected static string $relationship = 'talles';

    protected static ?string $title = 'Talles';

    public function table(Table $table): Table
    {
        return $table
            ->badge(fn () => $this->getOwnerRecord()->talles()->count())
            ->columns([
                TextColumn::make('nombre'),
                TextColumn::make('pivot.stock')
                    ->label('Stock'),
                TextColumn::make('descripcion')
                    ->limit(40),
            ])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('stock')
                            ->label('Stock')
                            ->numeric()
                            ->default(0),
                    ])
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                DetachAction::make(),
            ]);
    }
}
