<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        /*// Dashboard permissions ...
        Permission::create(['name' => 'access dashboard']);

        // Settings Management permissions ...
        Permission::create(['name' => 'view settings']);
        Permission::create(['name' => 'edit settings']);

        // Role Management permissions ...
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'edit permissions']);

        // User Management permissions ...
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'block or unblock users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'restore users']);
        Permission::create(['name' => 'destroy users']);*/

        // Category Management permissions ...

        // Product Management permissions ...

        // Order Management permissions ...
    }
}
