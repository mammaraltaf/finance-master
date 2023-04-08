<?php

namespace Database\Seeders;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::firstOrCreate(
            [
            'id'    => 1,
            'id_software' => '1',
            'tax_id' => '1',
            'name' => 'Company 1',
            'slug' => 'company-1',
            'threshold_amount' => 1000,
            'legal_address' => 'Address 1',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }
}
