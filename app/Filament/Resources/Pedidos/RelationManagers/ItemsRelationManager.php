<?php

namespace App\Filament\Resources\Pedidos\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Productos';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('producto.nombre')
                    ->label('Producto')
                    ->searchable(),
                TextColumn::make('cantidad'),
                TextColumn::make('precio_unitario')
                    ->label('Precio unitario')
                    ->money('ARS'),
                TextColumn::make('subtotal')
                    ->money('ARS'),
            ]);
    }
}
