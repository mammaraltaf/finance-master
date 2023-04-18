<?php

namespace Database\Seeders;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=20;$i++) {
        Company::firstOrCreate(
            [
            'id'    => $i,
            'id_software' =>  Str::random(10) ,
            'tax_id' => mt_rand(1000,9999),
            'name' => 'Company '.$i,
            'slug' => 'company-'.$i,
            'threshold_amount' => 1000,
            'legal_address' => 'Address '.$i,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }
}
}
