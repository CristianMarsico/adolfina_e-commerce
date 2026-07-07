<?php

namespace App\Filament\Resources\Productos\Pages;

use App\Filament\Resources\Productos\ProductoResource;
use App\Filament\Resources\Productos\RelationManagers\AtributosRelationManager;
use App\Filament\Resources\Productos\RelationManagers\ImagenesRelationManager;
use App\Filament\Resources\Productos\RelationManagers\TallesRelationManager;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProducto extends EditRecord
{
    protected static string $resource = ProductoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getAllRelationManagers(): array
    {
        $managers = [
            ImagenesRelationManager::class,
            AtributosRelationManager::class,
        ];

        if ($this->record?->tiene_talles) {
            $managers[] = TallesRelationManager::class;
        }

        return $managers;
    }
}
