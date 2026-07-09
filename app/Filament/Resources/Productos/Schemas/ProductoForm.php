<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre', modifyQueryUsing: fn ($query) => $query->where('activo', true))
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('marca_id')
                    ->label('Marca')
                    ->relationship('marca', 'nombre', modifyQueryUsing: fn ($query) => $query->where('activo', true))
                    ->nullable()
                    ->searchable()
                    ->preload(),
                Select::make('etapa_id')
                    ->label('Etapa / Edad')
                    ->relationship('etapa', 'nombre', modifyQueryUsing: fn ($query) => $query->where('activo', true))
                    ->nullable()
                    ->searchable()
                    ->preload(),
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('precio')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Grid::make(2)->columnSpanFull()
                    ->schema([
                        TextInput::make('edad_talla')
                            ->label('Talla')
                            ->maxLength(255)
                            ->hidden(fn ($get) => !$get('tiene_talla')),
                        Toggle::make('tiene_talla')
                            ->label('Tiene talla')
                            ->default(true)
                            ->live()
                            ->extraAttributes(fn ($get) => $get('tiene_talla') ? ['class' => 'self-end'] : [])
                            ->columnSpan(fn ($get) => $get('tiene_talla') ? 1 : 2),
                    ]),
                Grid::make(2)->columnSpanFull()
                    ->schema([
                        Toggle::make('activo')->default(true),
                        Toggle::make('destacado')->default(false),
                    ]),
            ]);
    }
}
