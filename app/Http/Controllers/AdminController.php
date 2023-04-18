<?php

namespace App\Http\Controllers;
use App\Classes\Enums\StatusEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\Supplier;
use App\Models\TypeOfExpanse;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Admin]);
    }

    public function dashboard()
    {
        return view('admin.pages.dashboard');
    }
    public function typeOfExpense()
    {
        // $companies = User::where('id', Auth::user()->id)->first()->companies;
        // $typeOfExpenses = TypeOfExpanse::where('id', Auth::user()->id);
        // return view('super-admin.pages.type-of-expense', compact('typeOfExpenses'));
    }
}
