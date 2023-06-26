<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\Company;
use App\Models\LogAction;
use App\Models\RequestFlow;
use App\Models\User;
use App\Traits\LogActionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SpectatorController extends Controller
{
    use LogActionTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'role:' . UserTypesEnum::Spectator]);
    }

    public function dashboard()
    {
        $user_id = Auth::user()->id;
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        return view('spectator.pages.dashboard', compact('user_id', 'companies_slug'));
    }

    public function selectCompany()
    {
        $companies = User::where('id', Auth::user()->id)->first()->companies;
        return view('spectator.pages.companylist', compact('companies'));
    }

    public function viewrequests()
    {
//        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])->get();
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
//        $departmentIds = $user->departments->pluck('id')->toArray();
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
            ->whereHas('company', function ($query) {
                $query->where('slug', Session::get('url-slug'));
            })
//            ->whereIn('department_id', $departmentIds)
//            ->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])
            ->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::FinanceOk])
            ->orderBy('request_flows.created_at', 'desc')
            ->get();

        return view('spectator.pages.requests', compact('requests', 'companies_slug'));
    }

    public function changepassword(Request $request)
    {
        $input = $request->all();
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id' => 'required',
                'currentPassword' => 'required',
                'password' => 'required',
                'passwordConfirm' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::find($input['id']);
            $oldpass = $input['currentPassword'];
            $newpass = $input['password'];
            $confirm = $input['passwordConfirm'];
            if ($oldpass == $user->original_password) {
                if ($newpass == $confirm) {
                    $user['original_password'] = $newpass;
                    $user['password'] = Hash::make($newpass);
                    $check = $user->save();
                    if ($check) {
                        return redirect()->back()->with('success', 'Password updated successfully');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong');
                    }

                } else {
                    return redirect()->back()->with('error', 'Passwords do not match.Please try again.');
                }
            } else {
                return redirect()->back()->with('error', 'Current password is wrong.Please try again.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function logs()
    {
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
        $comp_slug=Session::get('url-slug');
        $comp_id=Company::where('slug',$comp_slug)->pluck('id')->first();
        $req_logs_ids = RequestFlow::where('company_id', $comp_id)->pluck('id')->toArray();
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
            ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
            ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
            ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
            ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
            ->whereIn('request_flows.id', $req_logs_ids)
            // ->whereHas('company', function ($query) {
            //     $query->where('slug', Session::get('url-slug'));
            // })
            ->whereIn('action', [ActionEnum::MANAGER_REJECT, ActionEnum::MANAGER_ACCEPT])
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('spectator.pages.accepted', compact('requests','companies_slug'));
    }

    public function logfilters(Request $request)
    {
        $user = Auth::user();
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $comp_slug=Session::get('url-slug');
        $comp_id=Company::where('slug',$comp_slug)->pluck('id')->first();
        $req_logs_ids = RequestFlow::where('company_id', $comp_id)->pluck('id')->toArray();
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
            ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
            ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
            ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
            ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
            ->whereIn('request_flows.id', $req_logs_ids)
            ->whereIn('action', [ActionEnum::FINANCE_REJECT, ActionEnum::FINANCE_ACCEPT])
            ->whereDate('log_actions.created_at', '>=', $start)
            ->whereDate('log_actions.created_at', '<=', $end)
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('spectator.pages.accepted', compact('requests','companies_slug'));
    }
}
