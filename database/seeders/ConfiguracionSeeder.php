<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        Configuracion::firstOrCreate(['id' => 1], [
            'nombre_negocio' => 'Pañalera',
            'descripcion' => 'Tu tienda de confianza para el cuidado de tu bebé. Pañales, ropa, higiene y más.',
            'direccion' => null,
            'telefono' => '+54 11 3435-2107',
            'email' => 'contacto@panalera.com',
            'whatsapp' => '541112345678',
            'instagram' => null,
            'facebook' => null,
            'horarios' => null,
        ]);
    }
}
