<?php

namespace App\Filament\Resources\Talles;

use App\Filament\Resources\Talles\Pages\CreateTalle;
use App\Filament\Resources\Talles\Pages\EditTalle;
use App\Filament\Resources\Talles\Pages\ListTalles;
use App\Filament\Resources\Talles\Schemas\TalleForm;
use App\Filament\Resources\Talles\Tables\TallesTable;
use App\Models\Talle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TalleResource extends Resource
{
    protected static ?string $model = Talle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return TalleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TallesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTalles::route('/'),
            'create' => CreateTalle::route('/create'),
            'edit' => EditTalle::route('/{record}/edit'),
        ];
    }
}
