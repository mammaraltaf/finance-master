<?php

namespace Database\Seeders;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::firstOrCreate(
            [
            'id'    => 1,
            'id_software' => '1',
            'tax_id' => '1',
            'user_id' => 1,
            'supplier_name' => 'Supplier 1',
            'bank_id' => '100000',
            'bank_account' => '1222222',
            'bank_swift' => '12222222',
            'accounting_id' => '122222',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }
}
