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
                'email' => 'user@finance.com',
            ],[
            'id'    => 2,
            'name' => UserTypesEnum::User,
            'email' => 'user@finance.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::User,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
            ]);
    }
}
