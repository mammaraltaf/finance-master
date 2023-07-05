<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\LogAction;
use App\Models\RequestFlow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function selectCompany()
    {
        $companies = User::where('id', Auth::user()->id)->first()->companies;
        return view('user.pages.companylist', compact('companies'));
    }

    public function requestDetail($id){
        $requestFlow = RequestFlow::whereId($id)->first();
        $lastUserWhoTookAction = LogAction::where('request_flow_id', $id)->orderBy('created_at', 'desc')->pluck('user_id')->first();
        $lastUserWhoTookAction = User::where('id', $lastUserWhoTookAction)->pluck('name')->first();
        $requestFlow->lastUserWhoTookAction = $lastUserWhoTookAction;
        return response()->json($requestFlow);
    }

    public function logDetail($id){
        $logs = LogAction::whereId($id)->first();
        return response()->json($logs);
    }

    public function getDepartments(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'ids' => 'required|array|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()]);
            }

            $departments = Department::whereIn('company_id', $request->ids)->get();
            return response()->json($departments);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function logging(Request $request)
    {
        try{
            $user = Auth::user();
            $departmentIds = $user->departments->pluck('id')->toArray();
            $comp_slug = Session::get('url-slug');
            $comp_id = Company::where('slug', $comp_slug)->pluck('id')->first();
            $req_logs_ids = RequestFlow::where('company_id', $comp_id)->whereIn('department_id', $departmentIds)->pluck('id')->toArray();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;

            $requests = LogAction::with('requestFlow', 'requestFlow.company', 'requestFlow.supplier', 'requestFlow.typeOfExpense')
                ->whereIn('request_flow_id', $req_logs_ids)
                ->orderBy('log_actions.created_at', 'desc')
                ->get();

            return view('logs.logging', compact('requests', 'companies_slug'));
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function logFilters(Request $request)
    {
        try {
            $user = Auth::user();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $comp_slug = Session::get('url-slug');
            $comp_id = Company::where('slug', $comp_slug)->pluck('id')->first();
            $req_logs_ids = RequestFlow::where('company_id', $comp_id)->pluck('id')->toArray();
            $input = $request->all();
            $start = Carbon::parse($input['start-date'])->toDateTimeString();
            $end = Carbon::parse($input['end-date'])->toDateTimeString();

//            $requests = LogAction::with('requestFlow', 'requestFlow.company', 'requestFlow.supplier', 'requestFlow.typeOfExpense')
//                ->whereIn('request_flow_id', $req_logs_ids)
//                ->whereDate('log_actions.created_at', '>=', $start)
//                ->whereDate('log_actions.created_at', '<=', $end)
//                ->orderBy('log_actions.created_at', 'desc')
//                ->get();


            $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
                ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
                ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
                ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
                ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
                ->whereIn('request_flows.id', $req_logs_ids)
//                ->whereIn('action', [ActionEnum::FINANCE_REJECT, ActionEnum::FINANCE_ACCEPT])
                ->whereDate('log_actions.created_at', '>=', $start)
                ->whereDate('log_actions.created_at', '<=', $end)
                ->orderBy('log_actions.created_at', 'desc')
                ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
            return view('logs.accepted', compact('requests', 'companies_slug'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
