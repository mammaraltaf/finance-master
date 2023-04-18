<?php

namespace Database\Seeders;
use App\Models\TypeOfExpanse;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class TypeOfExpanseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=20;$i++) {
        TypeOfExpanse::firstOrCreate(
            [
            'id'    => $i,
            'id_software' =>  Str::random(10),
            'name' => 'Type of expanse' .$i,
            'accounting_id' => '1',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }}
}
