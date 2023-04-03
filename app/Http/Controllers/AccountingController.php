<?php

namespace App\Http\Controllers;

use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AccountingController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Accounting]);
    }

    public function dashboard()
    {
        // $this->authorize('accounting');
        $requests = RequestFlow::whereStatus(StatusEnum::SubmittedForReview)->get();
        return view('accounting.pages.dashboard', compact('requests'));
    }

    public function supplier()
    {
        // $this->authorize('accounting');
        $suppliers = Supplier::all();
        return view('user.pages.supplier', compact('suppliers'));
    }
}
