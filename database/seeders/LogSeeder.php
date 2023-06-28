<?php

namespace Database\Seeders;

use App\Classes\Enums\ActionEnum;
use App\Models\LogAction;
use App\Models\RequestFlow;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $users = User::all()->pluck('id')->toArray();
        $requestFlows = RequestFlow::all()->pluck('id')->toArray();

        for( $i = 0; $i < 300; $i++ ){
            LogAction::create([
                'user_id' => $users[array_rand($users)],
                'request_flow_id' => $requestFlows[array_rand($requestFlows)],
                'action' => ActionEnum::$Statuses[array_rand(ActionEnum::$Statuses)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
