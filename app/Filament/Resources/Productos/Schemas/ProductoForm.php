<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('marca_id')
                    ->label('Marca')
                    ->relationship('marca', 'nombre')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('etapa_id')
                    ->label('Etapa')
                    ->relationship('etapa', 'nombre')
                    ->searchable()
                    ->preload()
                    ->nullable(),
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
                TextInput::make('edad_talla')
                    ->label('Edad / Talla')
                    ->maxLength(255),
                Toggle::make('activo')
                    ->required(),
                Toggle::make('destacado')
                    ->required(),
                Toggle::make('tiene_talles')
                    ->label('Tiene talles')
                    ->helperText('Desactivar si el producto no tiene talles (ej: juguetes, shampoo)')
                    ->default(true),
            ]);
    }
}
