<?php

namespace App\Filament\Resources\Promocions;

use App\Filament\Resources\Promocions\Pages\CreatePromocion;
use App\Filament\Resources\Promocions\Pages\EditPromocion;
use App\Filament\Resources\Promocions\Pages\ListPromocions;
use App\Filament\Resources\Promocions\RelationManagers\ProductosRelationManager;
use App\Filament\Resources\Promocions\Schemas\PromocionForm;
use App\Filament\Resources\Promocions\Tables\PromocionsTable;
use App\Models\Promocion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PromocionResource extends Resource
{
    protected static ?string $model = Promocion::class;

    protected static ?string $label = 'Promoción';
    protected static ?string $pluralLabel = 'Promociones';
    protected static ?string $navigationLabel = 'Promociones';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFire;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return PromocionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PromocionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProductosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromocions::route('/'),
            'create' => CreatePromocion::route('/create'),
            'edit' => EditPromocion::route('/{record}/edit'),
        ];
    }
}
