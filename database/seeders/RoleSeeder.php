<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'admin'
        ]);
        $admin->syncPermissions([
            'access_dashboard',
            'manage_reports',
            'manage_users',
            'manage_families',
            'manage_categories',
            'manage_subcategories',
            'manage_products',
            'manage_options',
            'manage_covers',
            'manage_orders',
            'manage_drivers',
            'manage_shipments',
        ]);

        $driver = Role::create([
            'name' => 'driver'
        ]);
        $driver->syncPermissions([
            'access_dashboard',
            'manage_shipments',
        ]);

        $user = Role::create([
            'name' => 'user'
        ]);
        $user->syncPermissions([
            'access_dashboard',
        ]);


    }
}
