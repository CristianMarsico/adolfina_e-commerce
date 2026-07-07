<?php

namespace App\Filament\Resources\Etapas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EtapaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
