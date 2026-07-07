<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = ['Huggies', 'Pampers', 'Babysec', 'Pequeño Mundo', 'Mustela', 'Johnson', 'Nestlé NAN', 'Nestum', 'Chicco'];

        foreach ($marcas as $nombre) {
            Marca::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
