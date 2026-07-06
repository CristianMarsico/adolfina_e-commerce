<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\ProductoImagen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'categoria_id' => 1, 'nombre' => 'Pañales Huggies Supreme RN x50',
                'descripcion' => 'Pañales descartables Huggies Supreme para recién nacido. Suaves y con protección total.',
                'marca' => 'Huggies', 'precio' => 8500, 'stock' => 100,
                'edad_talla' => 'RN (2-5 kg)', 'slug' => 'huggies-supreme-rn-x50', 'destacado' => true,
            ],
            [
                'categoria_id' => 1, 'nombre' => 'Pañales Pampers Premium Care M x48',
                'descripcion' => 'Pañales Pampers Premium Care, talla mediana. Máxima absorción y sequedad.',
                'marca' => 'Pampers', 'precio' => 9200, 'stock' => 80,
                'edad_talla' => 'M (6-11 kg)', 'slug' => 'pampers-premium-care-m-x48', 'destacado' => true,
            ],
            [
                'categoria_id' => 1, 'nombre' => 'Pañales Babysec G x42',
                'descripcion' => 'Pañales Babysec talla grande, con barreras anti-filtraje y ajuste elástico.',
                'marca' => 'Babysec', 'precio' => 7800, 'stock' => 60,
                'edad_talla' => 'G (9-14 kg)', 'slug' => 'babysec-g-x42', 'destacado' => false,
            ],
            [
                'categoria_id' => 2, 'nombre' => 'Body manga corta x3',
                'descripcion' => 'Pack de 3 bodies de algodón manga corta, ideal para el día a día.',
                'marca' => 'Pequeño Mundo', 'precio' => 5500, 'stock' => 40,
                'edad_talla' => 'RN - 12 meses', 'slug' => 'body-manga-corta-x3', 'destacado' => true,
            ],
            [
                'categoria_id' => 2, 'nombre' => 'Enterito polar con capucha',
                'descripcion' => 'Enterito de polar suave con capucha, perfecto para el invierno.',
                'marca' => 'Pequeño Mundo', 'precio' => 9800, 'stock' => 30,
                'edad_talla' => '6-18 meses', 'slug' => 'enterito-polar-capucha', 'destacado' => false,
            ],
            [
                'categoria_id' => 3, 'nombre' => 'Crema para pañal Mustela 100ml',
                'descripcion' => 'Crema protectora para la zona del pañal, previene y trata la irritación.',
                'marca' => 'Mustela', 'precio' => 6200, 'stock' => 50,
                'slug' => 'crema-panal-mustela-100ml', 'destacado' => true,
            ],
            [
                'categoria_id' => 3, 'nombre' => 'Shampoo + jabón líquido Johnson Baby 500ml',
                'descripcion' => 'Shampoo y jabón 2 en 1, fórmula suave sin lágrimas.',
                'marca' => 'Johnson', 'precio' => 4100, 'stock' => 70,
                'slug' => 'shampoo-jabon-johnson-500ml', 'destacado' => false,
            ],
            [
                'categoria_id' => 4, 'nombre' => 'Leche NAN 1 polvo 800g',
                'descripcion' => 'Leche en polvo para lactantes desde el primer día.',
                'marca' => 'Nestlé NAN', 'precio' => 14500, 'stock' => 40,
                'edad_talla' => '0-6 meses', 'slug' => 'leche-nan-1-polvo-800g', 'destacado' => true,
            ],
            [
                'categoria_id' => 4, 'nombre' => 'Papilla Nestum Multicereal 200g',
                'descripcion' => 'Papilla de multicereal fortificada con vitaminas y minerales.',
                'marca' => 'Nestum', 'precio' => 3200, 'stock' => 90,
                'edad_talla' => '6+ meses', 'slug' => 'papilla-nestum-multicereal-200g', 'destacado' => false,
            ],
            [
                'categoria_id' => 5, 'nombre' => 'Chupete ortodóntico silicona 0-6m x2',
                'descripcion' => 'Chupete de silicona ortodóntico con protector nasal. Pack x2.',
                'marca' => 'Chicco', 'precio' => 2800, 'stock' => 100,
                'slug' => 'chupete-ortodontico-silicona-x2', 'destacado' => false,
            ],
        ];

        foreach ($productos as $data) {
            $producto = Producto::create($data);

            ProductoImagen::create([
                'producto_id' => $producto->id,
                'path' => 'productos/placeholder.jpg',
                'orden' => 0,
                'es_principal' => true,
            ]);

            ProductoImagen::create([
                'producto_id' => $producto->id,
                'path' => 'productos/placeholder2.jpg',
                'orden' => 1,
                'es_principal' => false,
            ]);

            ProductoImagen::create([
                'producto_id' => $producto->id,
                'path' => 'productos/placeholder3.jpg',
                'orden' => 2,
                'es_principal' => false,
            ]);
        }
    }
}
