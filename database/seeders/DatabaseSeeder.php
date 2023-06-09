<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            UserSeeder::class,
            RolesAndPermissionsSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            SupplierSeeder::class,
            TypeOfExpanseSeeder::class,
            RequestSeeder::class,
            LogSeeder::class
            ]);
    }
}
