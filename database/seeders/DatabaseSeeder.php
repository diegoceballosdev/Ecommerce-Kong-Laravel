<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Storage::deleteDirectory('products');
        Storage::makeDirectory('products');
        // User::factory(10)->create();

        //llamada a seeders:
        $this->call([

            PermissionSeeder::class,
            RoleSeeder::class,

            FamilySeeder::class,
            OptionSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Diego Ezequiel',
            'last_name' => 'Ceballos',
            'document_type' => 1,
            'document_number' => '87654321',
            'email' => 'diegoceballos95@yahoo.com',
            'phone' => '12345678',
            'password' => bcrypt('12341234'),
        ])->assignRole('admin');

        User::factory(20)->create()
            ->each(fn($u) => $u->assignRole('user')); //contraseña por defecto es: "password"

        //antes deben crearse familias, categorias, subcategorias:
        Product::factory(100)->create();
    }
}