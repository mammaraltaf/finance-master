<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Exports\RequestExport;
use App\Jobs\AcceptOrRejectRequest;
use App\Models\RequestFlow;
use App\Models\Supplier;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Traits\LogActionTrait;
use App\Models\LogAction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\Switch_;

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
//        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])->get();
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
//        $departmentIds = $user->departments->pluck('id')->toArray();

        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')
            ->whereIn('company_id', $companyIds)
//            ->whereIn('department_id', $departmentIds)
//            ->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])
            ->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::FinanceOk, StatusEnum::FinanceThresholdExceeded])
            ->orderBy('request_flows.created_at', 'desc')
            ->get();

        return view('accounting.pages.requests', compact('requests'));
    }

    public function payment($id)
    {
        $requests_data = RequestFlow::find($id);
        return response()->json($requests_data);
    }

    public function payments(Request $request)
    {
        $user = Auth::user();
        $companyIds = $user->companies->pluck('id')->toArray();
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])
            ->whereIn('company_id', $companyIds)
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('request_flows.created_at', 'desc')
            ->get();
        return view('accounting.pages.requests', compact('requests'));
    }

    public function bulkPayOrReject(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bulkIds' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }

            $totalIds = explode(',', $request->bulkIds);

            if ($request->action == 'pay') {
                foreach ($totalIds as $id) {
                    $requestSingle = RequestFlow::find($id);
                    $requestSingle->status = StatusEnum::Paid;
                    $requestSingle->save();
                    $this->logActionCreate(Auth::id(), $id, ActionEnum::ACCOUNTING_ACCEPT);
                    AcceptOrRejectRequest::dispatch($requestSingle);
                }

                return response()->json(['success' => 'success']);
            } /*Rejected*/
            elseif ($request->action == 'reject') {
                foreach ($totalIds as $id) {
                    $requestSingle = RequestFlow::find($id);
                    $requestSingle->status = StatusEnum::Rejected;
                    $requestSingle->save();
                    $this->logActionCreate(Auth::id(), $id, ActionEnum::ACCOUNTING_REJECT);
                    AcceptOrRejectRequest::dispatch($requestSingle);
                }

                return response()->json(['success' => 'reject']);
//                    return response()->json(['success' => 'Bulk Requests Rejected successfully.']);
            } elseif ($request->action == 'bog') {
                // Get the data
                $bogRows = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('id', $totalIds)->get();
                // Format the data
                $formattedExportData = $bogRows->map(function ($requestData) {
                    return [
                        'company_bank_account_number' => $requestData->company->bog_account_number,
                        '','',
                        'supplier_bank_account' => $requestData->supplier->bank_account,
                        'supplier_name' => $requestData->supplier->supplier_name,
                        '',
                        'cost of goods/services',
                        'amount_in_gel'=> $requestData->amount_in_gel,
                    ];
                });

                // Export the data using the YourModelExport class
                $export = new RequestExport(StatusEnum::BOG_EXPORT_COLUMNS, StatusEnum::BOG_EXPORT, $formattedExportData);
                $now = now();
                $now = str_replace(array(":", "-", ' '), "", $now);
                $filename = 'BOG_Payment_' . $now . '.xlsx';
                $path = storage_path('app/public/' . $filename);
                $url = asset(str_replace('\\', '/', str_replace(storage_path('app/public'), 'storage', $path)));

                Excel::store($export, $filename, 'public');

                return response()->json([
                    'success' => 'success',
                    'file_name' => $filename,
                    'file_url' => $url
                ]);
            } elseif ($request->action == 'tbc') {
                // Get the data
                $tbcRows = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('id', $totalIds)->get();
                // Format the data
                $formattedExportData = $tbcRows->map(function ($requestData) {
                    return [
                        '',
                        'supplier_bank_account' => $requestData->supplier->bank_account,
                        'supplier_name' => $requestData->supplier->supplier_name,
                        '',
                        'amount_in_gel'=> $requestData->amount_in_gel,
                        'cost of goods/services',
                        '','','','',
                    ];
                });

                // Export the data using the YourModelExport class
                $export = new RequestExport([StatusEnum::TBC_EXPORT_COLUMNS,StatusEnum::TBC_EXPORT_COLUMNS_2], StatusEnum::TBC_EXPORT, $formattedExportData);
                $now = now();
                $now = str_replace(array(":", "-", ' '), "", $now);
                $filename = 'TBC_Payment_' . $now . '.xlsx';
                $path = storage_path('app/public/' . $filename);
                $url = asset(str_replace('\\', '/', str_replace(storage_path('app/public'), 'storage', $path)));

                Excel::store($export, $filename, 'public');

                return response()->json([
                    'success' => 'success',
                    'file_name' => $filename,
                    'file_url' => $url
                ]);

            }
            elseif ($request->action == 'fx') {
                foreach ($totalIds as $id) {
                    $requestSingle = RequestFlow::find($id);
                    if ($requestSingle->currency != 'GEL') {
                        switch ($requestSingle->currency) {
                            case 'USD':
                                $currency = 'USD';
                                $amount = $requestSingle->amount;
                                $updatedGelAmount = $this->getUpdatedFXRates($currency, $amount);
                                $requestSingle->amount_in_gel = $updatedGelAmount;
                                $requestSingle->save();
                                break;
                            case 'EUR':
                                $currency = 'EUR';
                                $amount = $requestSingle->amount;
                                $updatedGelAmount = $this->getUpdatedFXRates($currency, $amount);
                                $requestSingle->amount_in_gel = $updatedGelAmount;
                                $requestSingle->save();
                                break;
                        }
                    }

                    return response()->json(['success' => 'success']);
                }
            }

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }


        $input = $request->all();
        $ids = $input['ids'];
        $action = $input['action'];
        $user = Auth::user();
        $requests = RequestFlow::whereIn('id', $ids)->get();
        foreach ($requests as $request) {
            $this->dispatch(new AcceptOrRejectRequest($request, $action, $user));
        }
        return response()->json(['success' => 'Requests updated successfully.']);
    }

    public function getUpdatedFXRates($currency, $amount){
        $currentDate = Carbon::now()->format('Y-m-d');
        $url = "https://nbg.gov.ge/gw/api/ct/monetarypolicy/currencies/ka/json/?date=".$currentDate;
        $client = new Client();
        $response = $client->request('GET', $url);
        $body = $response->getBody()->getContents();
        $data = json_decode($body);
        switch ($currency){
            case 'USD':
                $updatedGelAmount = $amount * $data[0]->currencies[40]->rate;
                break;
            case 'EUR':
                $updatedGelAmount = $amount * $data[0]->currencies[13]->rate;
                break;
        }
        return $updatedGelAmount;
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
            ->whereIn('action', [ActionEnum::ACCOUNTING_REJECT, ActionEnum::ACCOUNTING_ACCEPT])
            ->whereBetween('log_actions.created_at', [$start, $end])
            ->orderBy('log_actions.created_at', 'desc')
            ->get(['log_actions.*', 'log_actions.created_at as log_date', 'request_flows.*', 'companies.name as compname', 'departments.name as depname', 'suppliers.supplier_name as supname', 'type_of_expanses.name as expname'])->toArray();
        return view('accounting.pages.accepted', compact('requests'));
    }

    public function alldata()
    {
        $data_ids = RequestFlow::with('company', 'supplier', 'typeOfExpense')->whereIn('status', [StatusEnum::DirectorConfirmed, StatusEnum::ManagerConfirmed])->get();
        dd(response()->json($data_ids));
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
            ->whereIn('company_id', $companyIds)
            ->whereIn('action', [ActionEnum::ACCOUNTING_REJECT, ActionEnum::ACCOUNTING_ACCEPT])
            ->orderBy('log_actions.created_at', 'desc')
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

    public function updatesupplier(Request $request, $id)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'unique:suppliers,id_software,' . $id,
                'tax_id' => 'required | unique:suppliers,tax_id,' . $id,
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
            $supplier->tax_id = $input['tax_id'];
            $supplier->supplier_name = $input['name'];
            if (isset($input['bank_id'])) {
                $supplier->bank_id = $input['bank_id'];
            }
            if (isset($input['bank_name'])) {
                $supplier->bank_name = $input['bank_name'];
            }
            if (isset($input['bank_account'])) {
                $supplier->bank_account = $input['bank_account'];
            }
            if (isset($input['bank_swift'])) {
                $supplier->bank_swift = $input['bank_swift'];
            }
            if (isset($input['accounting_id'])) {
                $supplier->accounting_id = $input['accounting_id'];
            }

            $supplier->save();

            if ($supplier) {
                return redirect()->back()->with('success', 'Supplier updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}
