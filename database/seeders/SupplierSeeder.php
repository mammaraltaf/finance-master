<?php

namespace Database\Seeders;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=20;$i++) {
        Supplier::firstOrCreate(
            [
            'id'    => $i,
            'id_software' => Str::random(10) ,
            'tax_id' => Str::random(10) ,
            'user_id' => 1,
            'supplier_name' => 'Supplier'.$i,
            'bank_id' => '100000',
            'bank_account' => '1222222',
            'bank_swift' => '12222222',
            'accounting_id' => '122222',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }}
}
