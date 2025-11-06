<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

    }
}