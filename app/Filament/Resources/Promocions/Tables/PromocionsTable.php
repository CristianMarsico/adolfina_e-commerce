<?php

namespace App\Filament\Resources\Promocions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PromocionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->searchable(),
                TextColumn::make('tipo_descuento')->badge(),
                TextColumn::make('valor_descuento')
                    ->label('Descuento')
                    ->formatStateUsing(fn ($record) => $record->tipo_descuento === 'porcentaje' ? "{$record->valor_descuento}%" : "\${$record->valor_descuento}"),
                TextColumn::make('fecha_inicio')->date()->sortable(),
                TextColumn::make('fecha_fin')->date()->sortable(),
                TextColumn::make('productos_count')->label('Productos')->counts('productos'),
                IconColumn::make('activo')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('activo'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
