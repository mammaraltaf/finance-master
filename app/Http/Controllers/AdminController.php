<?php

namespace App\Http\Controllers;
use App\Classes\Enums\StatusEnum;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\RequestFlow;
use App\Models\TypeOfExpanse;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
    public function viewrequests()
    {

        $user = Auth::user(); 
        $company = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->where('company_id', $company)->get();
       return view('admin.pages.requests', compact('requests'));
    }
    public function payments(Request $request)
    {
        $user = Auth::user(); 
        $company = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->where('company_id', $company)
            ->whereBetween('created_at', [$start, $end])
            ->get();
        return view('admin.pages.requests', compact('requests'));
    }
    public function company()
    {
        $user = Auth::user(); 
        $company_id = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
        $companys = Company::where('id',$company_id)->get();
        $admin = User::where('id', $user->id)->get();
        return view('admin.pages.company', compact('companys','admin'));
    }
    public function editCompany($id)
    {
        // dd($id);
        $company = Company::with(['users'=>function($query){
            $query->where('user_type', UserTypesEnum::Admin);
        }])
            ->where('id', $id)
            ->first();
// dd($company);
        return response()->json($company);
    }
}
