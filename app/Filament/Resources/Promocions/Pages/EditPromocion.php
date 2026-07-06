<?php

namespace App\Filament\Resources\Promocions\Pages;

use App\Filament\Resources\Promocions\PromocionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPromocion extends EditRecord
{
    protected static string $resource = PromocionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
