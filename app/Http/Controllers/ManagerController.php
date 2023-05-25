<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Jobs\AcceptOrRejectRequest;
use App\Models\RequestFlow;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\LogActionTrait;
use App\Models\LogAction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class ManagerController extends Controller
{
    use LogActionTrait;
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Manager]);
    }

    public function logfilters(Request $request)
    {
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $comp_slug=Session::get('url-slug');
        $comp_id=Company::where('slug',$comp_slug)->pluck('id')->first();
        $req_logs_ids = RequestFlow::where('company_id', $comp_id)->pluck('id')->toArray();
        $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
            ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
            ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
            ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
            ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
            ->whereIn('request_flows.id', $req_logs_ids)
            ->whereIn('action', [ActionEnum::MANAGER_REJECT, ActionEnum::MANAGER_ACCEPT])
            ->whereBetween('log_actions.created_at', [$start, $end])
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('manager.pages.accepted', compact('requests','companies_slug'));
    }
    public function dashboard()
    {
         $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $user_id=Auth::user()->id;
        return view('manager.pages.dashboard',compact('companies_slug','user_id'));
    }
    public function changepassword(Request $request){
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
          $oldpass=$input['currentPassword'];
          $newpass=$input['password'];
        $confirm=$input['passwordConfirm'];
        if($oldpass==$user->original_password){
    if($newpass==$confirm){
    $user['original_password']=$newpass;
    $user['password']=Hash::make($newpass);
    $check=$user->save();
    if ($check) {
        return redirect()->back()->with('success', 'Password updated successfully');
    }else{
        return redirect()->back()->with('error', 'Something went wrong');
    }

    }else{
        return redirect()->back()->with('error', 'Passwords do not match.Please try again.');
    }
        }else{
            return redirect()->back()->with('error', 'Current password is wrong.Please try again.');
        }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function viewrequests()
    {
//        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::FinanceOk])->get();

        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
//        $departmentIds = $user->departments->pluck('id')->toArray();
$companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
        ->whereHas('company', function ($query) {
            $query->where('slug', Session::get('url-slug'));
        })
            // ->whereIn('company_id', $companyIds)
//            ->whereIn('department_id', $departmentIds)
//            ->whereStatus(StatusEnum::FinanceOk)
            ->whereStatus(StatusEnum::SubmittedForReview)
            ->orderBy('request_flows.created_at', 'desc')
            ->get();
        return view('manager.pages.requests', compact('requests','companies_slug'));
    }
    public function payments(Request $request)
    {
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::FinanceOk])
        ->whereHas('company', function ($query) {
            $query->where('slug', Session::get('url-slug'));
        })
           ->whereBetween('created_at', [$start, $end])
           ->orderBy('request_flows.created_at', 'desc')
            ->get();
        return view('manager.pages.requests', compact('requests','companies_slug'));
    }

    public function approveRequest(Request $request)
    {
        try{
            $requestFlow = RequestFlow::with('company')->find($request->id);
            if (($requestFlow->amount_in_gel) > ($requestFlow->company->threshold_amount)) {
                $requestFlow->status = StatusEnum::ManagerThresholdExceeded;
            }
            else {
                $requestFlow->status = StatusEnum::ManagerConfirmed;
            }
            $requestFlow->comment = $request->comment ?? null ;
            $requestFlow->save();
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::MANAGER_ACCEPT);
            AcceptOrRejectRequest::dispatch($requestFlow);

            return redirect()->back()->with('success', 'Request Approved Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function rejectRequest(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'comment' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $requestFlow = RequestFlow::find($request->id);
            $requestFlow->status = StatusEnum::ManagerRejected;
            $requestFlow->comment = $request->comment;
            $requestFlow->save();
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::MANAGER_REJECT);
            AcceptOrRejectRequest::dispatch($requestFlow);
            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
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
        return view('manager.pages.accepted', compact('requests','companies_slug'));
    }
    public function filtering($id)
    {
        if ($id == "pending") {
            return $this->viewrequests();
        } else if ($id == "finance") {
            $user = Auth::user();
    $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
            ->whereHas('company', function ($query) {
                $query->where('slug', Session::get('url-slug'));
            })
                ->whereStatus(StatusEnum::FinanceOk)
                ->orderBy('request_flows.created_at', 'desc')
                ->get();
            return view('manager.pages.requests', compact('requests','companies_slug'));
                 }
}
}
