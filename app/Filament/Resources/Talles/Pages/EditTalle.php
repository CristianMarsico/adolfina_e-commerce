<?php

namespace App\Filament\Resources\Talles\Pages;

use App\Filament\Resources\Talles\TalleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTalle extends EditRecord
{
    protected static string $resource = TalleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
