<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use App\Traits\LogActionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LogAction;
class FinanceController extends Controller
{
    use LogActionTrait;
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Finance]);
    }

    public function dashboard()
    {
        // $this->authorize('finance');
        $requests = RequestFlow::with('company','supplier','typeOfExpense')->whereStatus(StatusEnum::SubmittedForReview)->get();
        $financeAccepted = LogAction::where('action', ActionEnum::FINANCE_ACCEPT)->count();
        $financeRejected = LogAction::where('action', ActionEnum::FINANCE_REJECT)->count();

        $data = [
            'labels' => ['Request Submitted For Review', 'Finance Accepted', 'Finance Rejected'],
            'datasets' => [
                [
//                    'data' => [10, 20, 30],
                    'data' => [$requests->count(), $financeAccepted, $financeRejected],
                    'backgroundColor' => ['#ff6384', '#36a2eb', '#ffce56'],
                    'hoverBackgroundColor' => ['#ff6384', '#36a2eb', '#ffce56']
                ]
            ]
        ];
        return view('finance.pages.dashboard', compact('requests','data'));
    }

    public function requestFinance(){
        $requests = RequestFlow::with('company','supplier','typeOfExpense')->whereStatus(StatusEnum::SubmittedForReview)->get();
        return view('finance.pages.request', compact('requests'));
    }
    public function filter($id){
        if($id=='1'){
            $requests=LogAction::rightJoin('request_flows','request_flows.id','=','log_actions.request_flow_id')
            ->rightJoin('companies','request_flows.company_id','=','companies.id')
            ->rightJoin('departments','request_flows.department_id','=','departments.id')
            ->rightJoin('suppliers','request_flows.supplier_id','=','suppliers.id')
            ->rightJoin('type_of_expanses','request_flows.expense_type_id','=','type_of_expanses.id')
            ->whereIn('action',[ActionEnum::FINANCE_REJECT,ActionEnum::FINANCE_ACCEPT])
            ->get(['log_actions.*','request_flows.*','companies.name as compname','departments.name as depname','suppliers.supplier_name as supname','type_of_expanses.name as expname'])->toArray();
            return view('finance.pages.accepted', compact('requests'));
        }elseif($id=='2'){
            $requests=LogAction::rightJoin('request_flows','request_flows.id','=','log_actions.request_flow_id')
            ->rightJoin('companies','request_flows.company_id','=','companies.id')
            ->rightJoin('departments','request_flows.department_id','=','departments.id')
            ->rightJoin('suppliers','request_flows.supplier_id','=','suppliers.id')
            ->rightJoin('type_of_expanses','request_flows.expense_type_id','=','type_of_expanses.id')
            ->whereIn('action',[ActionEnum::FINANCE_ACCEPT])
            ->get(['log_actions.*','request_flows.*','companies.name as compname','departments.name as depname','suppliers.supplier_name as supname','type_of_expanses.name as expname'])->toArray();
            return view('finance.pages.accepted', compact('requests'));

        }else{
            $requests=LogAction::rightJoin('request_flows','request_flows.id','=','log_actions.request_flow_id')
            ->rightJoin('companies','request_flows.company_id','=','companies.id')
            ->rightJoin('departments','request_flows.department_id','=','departments.id')
            ->rightJoin('suppliers','request_flows.supplier_id','=','suppliers.id')
            ->rightJoin('type_of_expanses','request_flows.expense_type_id','=','type_of_expanses.id')
            ->whereIn('action',[ActionEnum::FINANCE_REJECT])
            ->get(['log_actions.*','request_flows.*','companies.name as compname','departments.name as depname','suppliers.supplier_name as supname','type_of_expanses.name as expname'])->toArray();
            return view('finance.pages.accepted', compact('requests'));
        }
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
            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
