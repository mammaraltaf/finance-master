<?php

namespace Database\Seeders;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Super Admin*/
        User::firstOrCreate(
            [
                'email' => 'super-admin@finance.com',
            ],[
            'id'    => 1,
            'name' => UserTypesEnum::SuperAdmin,
            'email' => 'super-admin@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::SuperAdmin,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        /*User*/
        User::firstOrCreate(
            [
                'email' => 'admin@finance.com',
            ],[
            'id'    => 2,
            'name' => UserTypesEnum::Admin,
            'email' => 'admin@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Admin,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
            ]);

        /*User*/
        User::firstOrCreate(
            [
                'email' => 'user@finance.com',
            ],[
            'id'    => 3,
            'name' => UserTypesEnum::User,
            'email' => 'user@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::User,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        /*User*/
        User::firstOrCreate(
            [
                'email' => 'accounting@finance.com',
            ],[
            'id'    => 4,
            'name' => UserTypesEnum::Accounting,
            'email' => 'accounting@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Accounting,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        /*User*/
        User::firstOrCreate(
            [
                'email' => 'finance@finance.com',
            ],[
            'id'    => 5,
            'name' => UserTypesEnum::Finance,
            'email' => 'finance@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Finance,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        /*User*/
        User::firstOrCreate(
            [
                'email' => 'manager@finance.com',
            ],[
            'id'    => 6,
            'name' => UserTypesEnum::Manager,
            'email' => 'manager@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Manager,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        /*User*/
        User::firstOrCreate(
            [
                'email' => 'director@finance.com',
            ],[
            'id'    => 7,
            'name' => UserTypesEnum::Director,
            'email' => 'director@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Director,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        /*User*/
        User::firstOrCreate(
            [
                'email' => 'spectator@finance.com',
            ],[
            'id'    => 8,
            'name' => UserTypesEnum::Spectator,
            'email' => 'spectator@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Spectator,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

    }
}
