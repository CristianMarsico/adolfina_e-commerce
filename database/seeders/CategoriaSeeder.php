<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Pañales'],
            ['nombre' => 'Ropa'],
            ['nombre' => 'Higiene'],
            ['nombre' => 'Alimentación'],
            ['nombre' => 'Accesorios'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }
    }
}
