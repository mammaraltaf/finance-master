<?php

namespace App\Http\Controllers;

use App\Classes\Enums\UserTypesEnum;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Manager]);
    }


    public function dashboard()
    {
        return view('manager.pages.dashboard');
    }

    public function getNewRequests()
    {
        $requests = RequestFlow::whereStatus(StatusEnum::New)->get();
        return view('manager.pages.new_requests', compact('requests'));
    }
}
