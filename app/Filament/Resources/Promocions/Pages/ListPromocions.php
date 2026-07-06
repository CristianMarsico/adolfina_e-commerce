<?php

namespace App\Filament\Resources\Promocions\Pages;

use App\Filament\Resources\Promocions\PromocionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPromocions extends ListRecords
{
    protected static string $resource = PromocionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
