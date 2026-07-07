<?php

namespace App\Filament\Resources\Etapas;

use App\Filament\Resources\Etapas\Pages\CreateEtapa;
use App\Filament\Resources\Etapas\Pages\EditEtapa;
use App\Filament\Resources\Etapas\Pages\ListEtapas;
use App\Filament\Resources\Etapas\Schemas\EtapaForm;
use App\Filament\Resources\Etapas\Tables\EtapasTable;
use App\Models\Etapa;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EtapaResource extends Resource
{
    protected static ?string $model = Etapa::class;

    protected static ?string $label = 'Etapa';
    protected static ?string $pluralLabel = 'Etapas';
    protected static ?string $navigationLabel = 'Etapas';

    protected static string|UnitEnum|null $navigationGroup = 'Configuración';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return EtapaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EtapasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEtapas::route('/'),
            'create' => CreateEtapa::route('/create'),
            'edit' => EditEtapa::route('/{record}/edit'),
        ];
    }
}
