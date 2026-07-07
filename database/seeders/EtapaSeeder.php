<?php

namespace Database\Seeders;

use App\Models\Etapa;
use Illuminate\Database\Seeder;

class EtapaSeeder extends Seeder
{
    public function run(): void
    {
        $etapas = [
            'Bebé',
            'Niño',
            'Adulto',
            'Unisex',
        ];

        foreach ($etapas as $nombre) {
            Etapa::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
