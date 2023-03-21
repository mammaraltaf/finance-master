<?php

namespace Database\Seeders;

use App\Classes\Enums\UserTypesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Create Roles*/
        $superadmin = Role::create(['name' => UserTypesEnum::SuperAdmin]);
        $admin = Role::create(['name' => UserTypesEnum::Admin]);
        $user = Role::create(['name' => UserTypesEnum::User]);
        $accounting = Role::create(['name' => UserTypesEnum::Accounting]);
        $finance = Role::create(['name' => UserTypesEnum::Finance]);
        $manager = Role::create(['name' => UserTypesEnum::Manager]);
        $director = Role::create(['name' => UserTypesEnum::Director]);

        /*Create Permissions*/



        /*Assign Permission to Roles*/
    }
}
