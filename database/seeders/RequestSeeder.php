<?php

namespace Database\Seeders;

use App\Classes\Enums\ActionEnum;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Department;
use App\Models\Supplier;
use App\Models\TypeOfExpanse;
use App\Models\RequestFlow;
use Carbon\Carbon;
use App\Classes\Enums\StatusEnum;
use Illuminate\Support\Str;


class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = Carbon::now()->year;
        $companies = Company::all()->pluck('id')->toArray();
        $departments = Department::all()->pluck('id')->toArray();
        $Suppliers = Supplier::all()->pluck('id')->toArray();
        $expenses = TypeOfExpanse::all()->pluck('id')->toArray();
        for ($i = 1; $i <= 1000; $i++) {
            RequestFlow::create([
                'initiator' => 'user',
                'company_id' => $companies[array_rand($companies)],
                'department_id' => $departments[array_rand($departments)],
                'supplier_id' => $Suppliers[array_rand($Suppliers)],
                'expense_type_id' => $expenses[array_rand($expenses)],
                'currency' => 'USD',
                'amount' => '45',
                'amount_in_gel' => '10.09',
                'description' => 'Testing Description',
                'basis' => '168164621911.png',
                'payment_date' => Carbon::create($year, rand(1, 4), rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59)),
                'submission_date' => Carbon::create($year, rand(1, 4), rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59)),
                'status' => StatusEnum::$Statuses[array_rand(StatusEnum::$Statuses)],
                'user_id' => '3',
                'created_at' => Carbon::create($year, rand(1, 4), rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59)),
                'updated_at' => Carbon::create($year, rand(1, 4), rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59)),
            ]);

        }
    }
}
