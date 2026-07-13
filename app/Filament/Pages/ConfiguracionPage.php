<?php

namespace App\Filament\Pages;

use App\Models\Configuracion;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ConfiguracionPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Configuración';

    protected static ?string $title = 'Configuración del negocio';

    protected static ?string $slug = 'configuracion';

    public ?array $data = [];

    public function mount(): void
    {
        $config = Configuracion::firstOrCreate(['id' => 1]);
        $this->data = $config->toArray();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Información del negocio')
                    ->schema([
                        TextInput::make('nombre_negocio')
                            ->required()
                            ->maxLength(255)
                            ->label('Nombre del negocio'),
                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->maxLength(1000),
                    ]),
                Section::make('Contacto')
                    ->schema([
                        TextInput::make('direccion')
                            ->label('Dirección')
                            ->maxLength(255),
                        TextInput::make('telefono')
                            ->label('Teléfono')
                            ->maxLength(50),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp (solo números, ej: 541112345678)')
                            ->maxLength(50),
                    ]),
                Section::make('Redes sociales')
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram (URL)')
                            ->maxLength(255)
                            ->url(),
                        TextInput::make('facebook')
                            ->label('Facebook (URL)')
                            ->maxLength(255)
                            ->url(),
                    ]),
                Section::make('Otros')
                    ->schema([
                        TextInput::make('horarios')
                            ->label('Horarios de atención')
                            ->maxLength(255),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar cambios')
                ->action('save')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $data = $this->data;
        $config = Configuracion::firstOrCreate(['id' => 1]);
        $config->update($data);

        Notification::make()
            ->title('Configuración guardada correctamente')
            ->success()
            ->send();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Configuración';
    }
}
