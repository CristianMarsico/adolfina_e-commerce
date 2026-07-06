<?php

namespace App\Filament\Resources\Promocions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromocionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Textarea::make('descripcion')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Select::make('tipo_descuento')
                    ->label('Tipo de descuento')
                    ->options([
                        'porcentaje' => 'Porcentaje (%)',
                        'fijo' => 'Monto fijo ($)',
                    ])
                    ->required(),
                TextInput::make('valor_descuento')
                    ->label('Valor del descuento')
                    ->required()
                    ->numeric()
                    ->prefix(fn ($get) => $get('tipo_descuento') === 'porcentaje' ? '%' : '$')
                    ->minValue(0),
                DatePicker::make('fecha_inicio')
                    ->label('Fecha de inicio')
                    ->required(),
                DatePicker::make('fecha_fin')
                    ->label('Fecha de fin')
                    ->required()
                    ->afterOrEqual('fecha_inicio'),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
