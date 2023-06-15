<?php
// app/Traits/Auditable.php

namespace App\Traits;

use App\Models\LogAction;
use Illuminate\Support\Facades\Auth;

trait LogActionTrait
{
    public function logActionCreate($user_id,$request_flow_id,$action)
    {
        LogAction::create([
            'user_id' => $user_id,
            'request_flow_id' => $request_flow_id,
            'action' => $action,
        ]);
     }
}
