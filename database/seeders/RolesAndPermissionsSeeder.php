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
        /*------------------------------------------------------------------*/
        /*Create Roles*/
        $superadmin = Role::create(['name' => UserTypesEnum::SuperAdmin]);
//        $admin = Role::create(['name' => UserTypesEnum::Admin]);
//        $user = Role::create(['name' => UserTypesEnum::User]);
//        $accounting = Role::create(['name' => UserTypesEnum::Accounting]);
//        $finance = Role::create(['name' => UserTypesEnum::Finance]);
//        $manager = Role::create(['name' => UserTypesEnum::Manager]);
//        $director = Role::create(['name' => UserTypesEnum::Director]);
//
//        /*------------------------------------------------------------------*/
//        /*Company Permissions*/
//        $viewCompany = Permission::create(['name' => 'view-company']);
//        $createCompany = Permission::create(['name' => 'create-company']);
//        $editCompany = Permission::create(['name' => 'edit-company']);
//        $deleteCompany = Permission::create(['name' => 'delete-company']);
//
//        /*User Permissions*/
//        $viewUser = Permission::create(['name' => 'view-user']);
//        $createUser = Permission::create(['name' => 'create-user']);
//        $editUser = Permission::create(['name' => 'edit-user']);
//        $deleteUser = Permission::create(['name' => 'delete-user']);
//
//        /*Type Of Expense Permissions*/
//        $viewTypeOfExpense = Permission::create(['name' => 'view-type-of-expense']);
//        $createTypeOfExpense = Permission::create(['name' => 'create-type-of-expense']);
//        $editTypeOfExpense = Permission::create(['name' => 'edit-type-of-expense']);
//        $deleteTypeOfExpense = Permission::create(['name' => 'delete-type-of-expense']);
//
//        /*Departments Permissions*/
//        $viewDepartments = Permission::create(['name' => 'view-departments']);
//        $createDepartments = Permission::create(['name' => 'create-departments']);
//        $editDepartments = Permission::create(['name' => 'edit-departments']);
//        $deleteDepartments = Permission::create(['name' => 'delete-departments']);
//
//        /*Supplier Permissions*/
//        $viewSupplier = Permission::create(['name' => 'view-supplier']);
//        $createsupplier = Permission::create(['name' => 'create-supplier']);
//        $editSupplier = Permission::create(['name' => 'edit-supplier']);
//        $deleteSupplier = Permission::create(['name' => 'delete-supplier']);
//
//        $createsupplier = Permission::create(['name' => 'create supplier']);
//
//        $createrequest = Permission::create(['name' => 'create request']);
//
//        /*Assign Permission to Roles*/
//        /*Super Admin*/
//        $superadmin->syncPermissions([
//            /*company permissions*/
//            $viewCompany, $createCompany, $editCompany, $deleteCompany,
//            $createUser, $editUser, $viewUser, $deleteUser,
//            $viewTypeOfExpense, $createTypeOfExpense, $editTypeOfExpense, $deleteTypeOfExpense,
//            $viewDepartments, $createDepartments, $editDepartments, $deleteDepartments,
//            $viewSupplier, $editSupplier, $deleteSupplier,
//        ]);

//        $user->syncPermissions([
//            $createsupplier,
//            $createrequest,
//        ]);

        /*------------------------------------------------------------------*/

        /*Assign Role*/
        User::find(1)->assignRole($superadmin);
//       User::find(2)->assignRole($admin);
//       User::find(3)->assignRole($user);
//       User::find(4)->assignRole($accounting);
//       User::find(5)->assignRole($finance);
//       User::find(6)->assignRole($manager);
//       User::find(7)->assignRole($director);

    }
}
