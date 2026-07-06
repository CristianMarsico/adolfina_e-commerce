<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

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
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                RichEditor::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('marca')
                    ->maxLength(255),
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
            ]);
    }
}
