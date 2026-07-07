<?php

namespace App\Filament\Resources\Talles\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductosRelationManager extends RelationManager
{
    protected static string $relationship = 'productos';

    protected static ?string $title = 'Productos';

    public function table(Table $table): Table
    {
        return $table
            ->badge(fn () => $this->getOwnerRecord()->productos()->count())
            ->columns([
                TextColumn::make('nombre'),
                TextColumn::make('pivot.stock')
                    ->label('Stock'),
                TextColumn::make('precio')
                    ->numeric('decimal:2'),
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
