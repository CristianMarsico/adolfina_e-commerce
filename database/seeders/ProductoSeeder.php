<?php

namespace Database\Seeders;

use App\Models\Etapa;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\ProductoImagen;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = Marca::pluck('id', 'nombre');
        $etapas = Etapa::pluck('id', 'nombre');

        $productos = [
            [
                'categoria_id' => 1, 'nombre' => 'Pañales Huggies Supreme RN x50',
                'descripcion' => 'Pañales descartables Huggies Supreme para recién nacido. Suaves y con protección total.',
                'marca_id' => $marcas['Huggies'], 'etapa_id' => $etapas['Bebé'], 'precio' => 8500, 'stock' => 100,
                'edad_talla' => 'RN (2-5 kg)', 'destacado' => true,
            ],
            [
                'categoria_id' => 1, 'nombre' => 'Pañales Pampers Premium Care M x48',
                'descripcion' => 'Pañales Pampers Premium Care, talla mediana. Máxima absorción y sequedad.',
                'marca_id' => $marcas['Pampers'], 'etapa_id' => $etapas['Bebé'], 'precio' => 9200, 'stock' => 80,
                'edad_talla' => 'M (6-11 kg)', 'destacado' => true,
            ],
            [
                'categoria_id' => 1, 'nombre' => 'Pañales Babysec G x42',
                'descripcion' => 'Pañales Babysec talla grande, con barreras anti-filtraje y ajuste elástico.',
                'marca_id' => $marcas['Babysec'], 'etapa_id' => $etapas['Niño'], 'precio' => 7800, 'stock' => 60,
                'edad_talla' => 'G (9-14 kg)', 'destacado' => false,
            ],
            [
                'categoria_id' => 2, 'nombre' => 'Body manga corta x3',
                'descripcion' => 'Pack de 3 bodies de algodón manga corta, ideal para el día a día.',
                'marca_id' => $marcas['Pequeño Mundo'], 'etapa_id' => $etapas['Bebé'], 'precio' => 5500, 'stock' => 40,
                'edad_talla' => 'RN - 12 meses', 'destacado' => true,
            ],
            [
                'categoria_id' => 2, 'nombre' => 'Enterito polar con capucha',
                'descripcion' => 'Enterito de polar suave con capucha, perfecto para el invierno.',
                'marca_id' => $marcas['Pequeño Mundo'], 'etapa_id' => $etapas['Bebé'], 'precio' => 9800, 'stock' => 30,
                'edad_talla' => '6-18 meses', 'destacado' => false,
            ],
            [
                'categoria_id' => 3, 'nombre' => 'Crema para pañal Mustela 100ml',
                'descripcion' => 'Crema protectora para la zona del pañal, previene y trata la irritación.',
                'marca_id' => $marcas['Mustela'], 'etapa_id' => $etapas['Bebé'], 'precio' => 6200, 'stock' => 50,
                'destacado' => true,
            ],
            [
                'categoria_id' => 3, 'nombre' => 'Shampoo + jabón líquido Johnson Baby 500ml',
                'descripcion' => 'Shampoo y jabón 2 en 1, fórmula suave sin lágrimas.',
                'marca_id' => $marcas['Johnson'], 'etapa_id' => $etapas['Bebé'], 'precio' => 4100, 'stock' => 70,
                'destacado' => false,
            ],
            [
                'categoria_id' => 4, 'nombre' => 'Leche NAN 1 polvo 800g',
                'descripcion' => 'Leche en polvo para lactantes desde el primer día.',
                'marca_id' => $marcas['Nestlé NAN'], 'etapa_id' => $etapas['Bebé'], 'precio' => 14500, 'stock' => 40,
                'edad_talla' => '0-6 meses', 'destacado' => true,
            ],
            [
                'categoria_id' => 4, 'nombre' => 'Papilla Nestum Multicereal 200g',
                'descripcion' => 'Papilla de multicereal fortificada con vitaminas y minerales.',
                'marca_id' => $marcas['Nestum'], 'etapa_id' => $etapas['Bebé'], 'precio' => 3200, 'stock' => 90,
                'edad_talla' => '6+ meses', 'destacado' => false,
            ],
            [
                'categoria_id' => 5, 'nombre' => 'Chupete ortodóntico silicona 0-6m x2',
                'descripcion' => 'Chupete de silicona ortodóntico con protector nasal. Pack x2.',
                'marca_id' => $marcas['Chicco'], 'etapa_id' => $etapas['Bebé'], 'precio' => 2800, 'stock' => 100,
                'destacado' => false,
            ],
        ];

        foreach ($productos as $data) {
            $producto = Producto::create($data);

            ProductoImagen::create([
                'producto_id' => $producto->id,
                'path' => 'productos/placeholder.jpg',
                'es_principal' => true,
            ]);

            ProductoImagen::create([
                'producto_id' => $producto->id,
                'path' => 'productos/placeholder2.jpg',
                'es_principal' => false,
            ]);

            ProductoImagen::create([
                'producto_id' => $producto->id,
                'path' => 'productos/placeholder3.jpg',
                'es_principal' => false,
            ]);
        }
    }
}
