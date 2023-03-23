<?php

namespace Database\Seeders;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
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
        $createCompany = Permission::create(['name' => 'create company']);
        $editCompany = Permission::create(['name' => 'edit company']);
        $viewCompany = Permission::create(['name' => 'view company']);
        $deleteCompany = Permission::create(['name' => 'delete company']);

        $createUser = Permission::create(['name' => 'create user']);
        $editUser = Permission::create(['name' => 'edit user']);
        $viewUser = Permission::create(['name' => 'view user']);
        $deleteUser = Permission::create(['name' => 'delete user']);

        /*Assign Permission to Roles*/
        /*Super Admin*/
        $superadmin->syncPermissions([
            $createCompany,
            $editCompany,
            $viewCompany,
            $deleteCompany,
            $createUser,
            $editUser,
            $viewUser,
            $deleteUser,
        ]);



        /*Assign Role*/
        User::find(1)->assignRole($superadmin);
        User::find(2)->assignRole($user);

    }
}
