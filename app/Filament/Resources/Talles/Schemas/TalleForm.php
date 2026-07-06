<?php

namespace App\Filament\Resources\Talles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TalleForm
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

                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
