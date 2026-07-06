<?php

namespace App\Filament\Resources\Talles\Pages;

use App\Filament\Resources\Talles\TalleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTalles extends ListRecords
{
    protected static string $resource = TalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
