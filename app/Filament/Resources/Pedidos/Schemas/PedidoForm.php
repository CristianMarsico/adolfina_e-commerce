<?php

namespace App\Filament\Resources\Pedidos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PedidoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Usuario')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Invitado'),
                TextInput::make('email')
                    ->label('Email')
                    ->email(),
                TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('descuento')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->default(0),
                Select::make('estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'pagado' => 'Pagado',
                        'fallado' => 'Fallado',
                        'cancelado' => 'Cancelado',
                    ])
                    ->required(),
                TextInput::make('direccion'),
                TextInput::make('ciudad'),
                TextInput::make('codigo_postal'),
                TextInput::make('telefono'),
                Textarea::make('observaciones')
                    ->columnSpanFull(),
                TextInput::make('mp_preference_id')
                    ->label('MP Preference ID'),
                TextInput::make('mp_payment_id')
                    ->label('MP Payment ID'),
                TextInput::make('mp_status')
                    ->label('MP Status'),
            ]);
    }
}
