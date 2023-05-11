<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Jobs\AcceptOrRejectRequest;
use App\Models\RequestFlow;
use App\Traits\LogActionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LogAction;
use Carbon\Carbon;
class FinanceController extends Controller
{
    use LogActionTrait;
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Finance]);
    }



    public function requestFinance(){
        $user = Auth::user();
//        $requests = RequestFlow::with('company','supplier','typeOfExpense')
//            ->whereHas('company', function($query) use ($user) {
//                $query->where('id', $user->companies->pluck('id'));
//            })
//            ->whereHas('department', function($query) use ($user) {
//                $query->where('id', $user->departments->pluck('id'));
//            })
//            ->whereStatus(StatusEnum::SubmittedForReview)
//            ->get();
        $companyIds = $user->companies->pluck('id')->toArray();
//        $departmentIds = $user->departments->pluck('id')->toArray();

        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
            ->whereIn('company_id', $companyIds)
//            ->whereIn('department_id', $departmentIds)
//            ->whereStatus(StatusEnum::SubmittedForReview)
            ->whereStatus(StatusEnum::ManagerConfirmed)
            ->orderBy('request_flows.created_at', 'desc')
            ->get();

        return view('finance.pages.request', compact('requests'));
    }

    public function payments(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $companyIds = $user->companies->pluck('id')->toArray();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
        ->whereIn('company_id', $companyIds)
        ->whereIn('status', [StatusEnum::SubmittedForReview])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('request_flows.created_at', 'desc')
            ->get();
        return view('finance.pages.request', compact('requests'));
    }

    public function logs()
    {
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
        $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
            ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
            ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
            ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
            ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
            ->whereIn('request_flows.company_id', $companyIds)
            ->whereIn('action', [ActionEnum::FINANCE_REJECT,ActionEnum::FINANCE_ACCEPT])
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*','request_flows.id as reqid', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
           return view('finance.pages.accepted', compact('requests'));
    }


    public function logfilters(Request $request)
    {
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
            ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
            ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
            ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
            ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
            ->whereIn('request_flows.company_id', $companyIds)
            ->whereIn('action', [ActionEnum::FINANCE_REJECT, ActionEnum::FINANCE_ACCEPT])
            ->whereBetween('log_actions.created_at', [$start, $end])
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('finance.pages.accepted', compact('requests'));
    }
//    public function getNewRequests()
//    {
//        $requests = RequestFlow::whereStatus(StatusEnum::SubmittedForReview)->get();
//        return view('finance.pages.new_requests', compact('requests'));
//    }

    public function getRequestDetail($id){
        try{
            $request = RequestFlow::find($id);
            return response()->json($request);
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function approveRequest(Request $request)
    {
        try{
            $requestFlow = RequestFlow::find($request->id);
            $requestFlow->status = StatusEnum::FinanceOk;
            $requestFlow->comment = $request->comment ?? null ;
            $requestFlow->save();
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::FINANCE_ACCEPT);
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
            $requestFlow->status = StatusEnum::FinanceRejected;
            $requestFlow->comment = $request->comment;
            $requestFlow->save();

            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::FINANCE_REJECT);
            AcceptOrRejectRequest::dispatch($requestFlow);

            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
