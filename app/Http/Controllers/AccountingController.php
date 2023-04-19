<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Jobs\AcceptOrRejectRequest;
use App\Models\RequestFlow;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Traits\LogActionTrait;
use App\Models\LogAction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AccountingController extends Controller
{
    use LogActionTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'role:' . UserTypesEnum::Accounting]);
    }

    public function dashboard()
    {
        // $this->authorize('accounting');
        return view('accounting.pages.dashboard');
    }

    public function supplier()
    {
        // $this->authorize('accounting');
        $suppliers = Supplier::all();
        return view('user.pages.supplier', compact('suppliers'));
    }


    public function viewrequests()
    {
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])->get();
        return view('accounting.pages.requests', compact('requests'));
    }

    public function payment($id)
    {
        $requests_data = RequestFlow::find($id);
        return response()->json($requests_data);
    }

    public function payments(Request $request)
    {
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])
            ->whereBetween('created_at', [$start, $end])
            ->get();
        return view('accounting.pages.requests', compact('requests'));
    }

    public function logfilters(Request $request)
    {
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
            ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
            ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
            ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
            ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
            ->whereIn('action', [ActionEnum::ACCOUNTING_REJECT, ActionEnum::ACCOUNTING_ACCEPT])
            ->whereBetween('log_actions.created_at', [$start, $end])
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('accounting.pages.accepted', compact('requests'));
    }
public function alldata(){
    $data_ids = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])->get();
    dd(response()->json($data_ids));
}
    public function logs()
    {
        $requests = LogAction::rightJoin('request_flows', 'request_flows.id', '=', 'log_actions.request_flow_id')
            ->rightJoin('companies', 'request_flows.company_id', '=', 'companies.id')
            ->rightJoin('departments', 'request_flows.department_id', '=', 'departments.id')
            ->rightJoin('suppliers', 'request_flows.supplier_id', '=', 'suppliers.id')
            ->rightJoin('type_of_expanses', 'request_flows.expense_type_id', '=', 'type_of_expanses.id')
            ->whereIn('action', [ActionEnum::ACCOUNTING_REJECT, ActionEnum::ACCOUNTING_ACCEPT])
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('accounting.pages.accepted', compact('requests'));
    }

    public function pay(Request $request, $id)
    {
        try {
            if (isset($_POST['button'])) {
                $status = $_POST['button'];
            }
            if ($status == "pay") {
                $requestFlow = RequestFlow::find($request->id);
                $requestFlow->status = StatusEnum::Paid;
                $requestFlow->save();
                $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::ACCOUNTING_ACCEPT);
                AcceptOrRejectRequest::dispatch($requestFlow);

                return redirect()->back()->with('success', 'Request Approved Successfully');
            } else {
                $requestFlow = RequestFlow::find($request->id);
                $requestFlow->status = StatusEnum::Rejected;
                $requestFlow->save();
                $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::ACCOUNTING_REJECT);
                AcceptOrRejectRequest::dispatch($requestFlow);
                return redirect()->back()->with('success', 'Request Rejected Successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function editsupplier($id)
    {
        $user = Supplier::find($id);
        return response()->json($user);
    }

    public function updatesupplier(Request $request, $id){
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:suppliers,id_software,'. $id,
                'tax_id' => 'required | unique:suppliers,tax_id,'. $id,
                'name' => 'required ',
                // 'bank_id' => 'required',
                // 'bank_name' => 'required',
                // 'bank_account' => 'required',
                // 'bank_swift' => 'required',
                // 'accounting_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $supplier = Supplier::find($id);
            $supplier->id_software = $input['id_software'];
            $supplier->tax_id = $input['tax_id'];
            $supplier->supplier_name = $input['name'];
            if(isset($input['bank_id'])){
                $supplier->bank_id = $input['bank_id'];
            }
            if(isset($input['bank_name'])){
                $supplier->bank_name = $input['bank_name']; }
            if(isset($input['bank_account'])){   $supplier->bank_account = $input['bank_account']; }
            if(isset($input['bank_swift'])){    $supplier->bank_swift = $input['bank_swift'];}
            if(isset($input['accounting_id'])){    $supplier->accounting_id = $input['accounting_id'];}

            $supplier->save();

            if($supplier){
                return redirect()->back()->with('success', 'Supplier updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



}
