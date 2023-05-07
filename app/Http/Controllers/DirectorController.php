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
class DirectorController extends Controller
{
    use LogActionTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Director]);
    }

    public function dashboard()
    {
        // $this->authorize('director');
         return view('director.pages.dashboard');
    }
    public function viewrequests()
    {
//        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
//                    ->whereIn('status', [StatusEnum::ManagerConfirmed, StatusEnum::ThresholdExceeded])
//                    ->get();
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
//        $departmentIds = $user->departments->pluck('id')->toArray();

        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
            ->whereIn('company_id', $companyIds)
//            ->whereIn('department_id', $departmentIds)
            ->whereIn('status', [StatusEnum::ThresholdExceeded])
            ->orderBy('request_flows.created_at', 'desc')
            ->get();


        return view('director.pages.requests', compact('requests'));
    }

    public function payments(Request $request)
    {
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
        ->whereIn('company_id', $companyIds)
            ->whereIn('status', [StatusEnum::FinanceOk, StatusEnum::ManagerConfirmed])
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('request_flows.created_at', 'desc')
            ->get();
        return view('director.pages.requests', compact('requests'));
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
            ->whereIn('action', [ActionEnum::DIRECTOR_REJECT,ActionEnum::DIRECTOR_ACCEPT])
            ->whereIn('company_id', $companyIds)
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('director.pages.accepted', compact('requests'));
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
            ->whereIn('company_id', $companyIds)
              ->whereIn('action', [ActionEnum::DIRECTOR_REJECT, ActionEnum::DIRECTOR_ACCEPT])
            ->whereBetween('log_actions.created_at', [$start, $end])
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('director.pages.accepted', compact('requests'));
    }

    public function approveRequest(Request $request)
    {
        try{
            $requestFlow = RequestFlow::with('company')->find($request->id);
            // if ($requestFlow->amount_in_gel > $requestFlow->company->threshold_amount) {
            //     $requestFlow->status = StatusEnum::ConfirmedPartially;
            // }
            // else {
                $requestFlow->status = StatusEnum::DirectorConfirmed;
            //}
            $requestFlow->comment = $request->comment ?? null ;
            $requestFlow->save();
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::DIRECTOR_ACCEPT);
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
            $requestFlow->status = StatusEnum::DirectorRejected;
            $requestFlow->comment = $request->comment;
            $requestFlow->save();
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::DIRECTOR_REJECT);
            AcceptOrRejectRequest::dispatch($requestFlow);
            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
