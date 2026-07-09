<?php

namespace App\Filament\Resources\Marcas\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MarcaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()
                    ->directory('marcas')
                    ->disk('public')
                    ->maxSize(5120)
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth(300)
                    ->nullable(),
                Toggle::make('activo')
                    ->required(),
            ]);
    }
}
