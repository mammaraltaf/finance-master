<?php

namespace Database\Seeders;
use App\Models\TypeOfExpanse;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TypeOfExpanseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfExpanse::firstOrCreate(
            [
            'id'    => 1,
            'id_software' => '1',
            'name' => 'Type of expanse 1',
            'accounting_id' => '1',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }
}
