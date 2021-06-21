<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devRole = Role::create(['name'=>'developer']);
        $superAdminRole = Role::create(['name'=>'super admin']);
        $adminRole = Role::create(['name'=>'admin']);

        foreach (\Spatie\Permission\Models\Permission::all() as $permission){
            $devRole->givePermissionTo($permission->name);
            $superAdminRole->givePermissionTo($permission->name);
            $adminRole->givePermissionTo($permission->name);
        }

        Role::create(['name'=>'farmer']);
        Role::create(['name'=>'retailer']);
        Role::create(['name'=>'agricultural-officer']);
        Role::create(['name'=>'customer']);
    }
}
