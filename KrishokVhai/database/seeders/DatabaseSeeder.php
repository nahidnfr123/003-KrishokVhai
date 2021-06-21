<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            CountryCityStateSeeder::class,
            UserTableSeeder::class,
            PostSeeder::class,
            ProductTableSeeder::class,
        ]);
        /*\App\Models\User::factory(10)->create()
            ->each(function ($user) {
                $roles = ['farmer', 'retailer', 'customer', 'agricultural-officer'];
                $user->assignRole([Arr::random($roles)]);
            });*/
    }
}
