<?php

namespace Database\Seeders;
use App\Models\Company;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=20;$i++) {
        Department::firstOrCreate(
            [
            'id'    => $i,
            'id_software' => Str::random(10),
            'name' => 'Department '.$i,
            'company_id' => Company::all()->random()->id,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }}
}
