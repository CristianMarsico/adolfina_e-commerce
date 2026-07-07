<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriaSeeder::class,
            MarcaSeeder::class,
            EtapaSeeder::class,
            ProductoSeeder::class,
            ConfiguracionSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@panalera.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
                'is_admin' => true,
            ]
        );
    }
}
