<?php

namespace App\Http\Controllers;

use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use Illuminate\Http\Request;

class DirectorController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Director]);
    }

    public function dashboard()
    {
        // $this->authorize('director');
        $requests = RequestFlow::whereStatus(StatusEnum::SubmittedForReview)->get();
        return view('director.pages.dashboard', compact('requests'));
    }

}
