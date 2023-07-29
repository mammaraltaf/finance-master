<?php

namespace App\Http\Controllers;


use App\Classes\Enums\StatusEnum;
use App\Jobs\AcceptOrRejectRequest;
use App\Traits\LogActionTrait;
use Exception;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\RequestFlow;
use App\Models\supplier_bank;
use App\Models\Company;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\TypeOfExpanse;
use Illuminate\Support\Facades\Auth;
use File;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use LogActionTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'role:' . UserTypesEnum::User]);
    }

    public function selectCompany()
    {
        $companies = User::where('id', Auth::user()->id)->first()->companies;
        return view('user.pages.companylist', compact('companies'));
    }

    public function dashboard(Request $request)
    {
        // $this->authorize('user');
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        $user_id = Auth::user()->id;
        return view('user.pages.dashboard', compact('companies_slug', 'user_id'));
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

    public function supplier()
    {
        $suppliers = Supplier::all();
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
//        $suppliers=Supplier::rightJoin('supplier_bank','supplier_bank.supplier_id','=','suppliers.id')
//          ->select('suppliers.*','supplier_bank.*')
//         ->get()->toArray();
        return view('user.pages.supplier', compact('suppliers', 'companies_slug'));
    }

    public function addsupplier(Request $request)
    {
//        $this->authorize('create supplier');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
//                'id_software' => 'required | unique:suppliers,id_software',
                'tax_id' => 'required | unique:suppliers,tax_id',
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

            $supplier_data = Supplier::create([
                'id_software' => Str::random(10),
                'tax_id' => $input['tax_id'],
                'supplier_name' => $input['name'],
                // 'bank_id' => $input['bank_id'],
                // 'bank_name' => $input['bank_name'],
                // 'bank_account' => $input['bank_account'],
                // 'bank_swift' => $input['bank_swift'],
                // 'accounting_id' => $input['accounting_id'],
                'user_id' => auth()->user()->id,
            ]);

            if ($supplier_data) {
                return redirect()->back()->with('success', 'Supplier created successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
//                'id_software' => 'required | unique:suppliers,id_software,' . $id,
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
            // $supplier->bank_id = $input['bank_id'];
            // $supplier->bank_name = $input['bank_name'];
            // $supplier->bank_account = $input['bank_account'];
            // $supplier->bank_swift = $input['bank_swift'];
            // $supplier->accounting_id = $input['accounting_id'];

            $supplier->save();

            if ($supplier) {
                return redirect()->back()->with('success', 'Supplier updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deletesupplier(Request $request)
    {
        try {
            supplier::where('id', $request->id)->delete();
            return redirect()->back()->with('success', 'Supplier deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function addrequest(Request $request)
    {
        // $this->authorize('create request');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'initiator_id' => 'required',
                'company' => 'required',
                'department' => 'required',
                'supplier' => 'required',
                'expense_type' => 'required',
                'currency' => 'required',
                'amount_in_gel' => 'required',
                'amount' => 'required',
                'description' => 'required',
                'basis' => 'required|array|min:1',
                'basis.*' => 'mimes:jpeg,jpg,png,pdf,doc,docx,xls,xlsx,csv,xlsm,txt,rtf,msg',
                'due-date-payment' => 'required',
                'due-date' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $files = [];
            if ($request->hasfile('basis')) {
                foreach ($request->file('basis') as $file) {
                    $name = time() . rand(1, 50) . '.' . $file->extension();
                    $file->move(public_path('basis'), $name);
                    $files[] = $name;
                }
            }
            $basis = implode(',', $files);
//            if (isset($_POST['button'])) {
//                $status = $_POST['button'];
//            }
            $status = StatusEnum::SubmittedForReview;
            $request_data = RequestFlow::create([
                'initiator' => $input['initiator_id'],
                'company_id' => $input['company'],
                'department_id' => $input['department'],
                'supplier_id' => $input['supplier'],
                'expense_type_id' => $input['expense_type'],
                'currency' => $input['currency'],
                'amount' => $input['amount'],
                'amount_in_gel' => number_format($input['amount_in_gel'],2,".",""),
                'description' => $input['description'],
                'basis' => $basis,
                'request_link' => $input['request_link'],
                'payment_date' => $input['due-date-payment'],
                'submission_date' => $input['due-date'],
                'status' =>$status,
                'user_id' => auth()->user()->id
            ]);


            if ($request_data) {
                if ($status == $request_data->status) {
                    $this->logActionCreate(Auth::id(), $request_data->id, 'User Request created');
                    AcceptOrRejectRequest::dispatch($request_data);
                }
                return redirect()->back()->with('success', 'Request successfull');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleterequest(Request $request)
    {
        try {
            $all_files = RequestFlow::where('id', $request->id)->pluck('basis')->first();
            $files = explode(',', $all_files);
            foreach ($files as $file) {
                if (File::exists(public_path('basis/' . $file))) {
                    File::delete(public_path('basis/' . $file));
                }
            }

            $check=RequestFlow::where('id', $request->id)->delete();
            if($check){
                return redirect()->back()->with('success', 'Request deleted Successfully');
            }else{
                return redirect()->back()->with('error', $e->getMessage());
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editrequest($id)
    {
        $requested = RequestFlow::find($id);
        return response()->json($requested);
    }

    public function updaterequest(Request $request,$id)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'company' => 'required',
                'department' => 'required',
                'supplier' => 'required',
                'expense-type' => 'required',
                'currency' => 'required',
                'amount' => 'required',
                'description' => 'required',
                'due-date-payment2' => 'required',
                'due-date2' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if (isset($_POST['button'])) {
                $status = $_POST['button'];
            }
            // dd($input);
            if ($input['basis3'] == null) {
                $all_files = RequestFlow::where('id', $request->id)->pluck('basis')->first();
                $files = explode(',', $all_files);
                foreach ($files as $file) {
                    if (File::exists(public_path('basis/' . $file))) {
                        File::delete(public_path('basis/' . $file));
                    }
                }
                if (isset($input['basis'])) {
                    $files = [];
                    if ($request->hasfile('basis')) {
                        foreach ($request->file('basis') as $file) {
                            $name = time() . rand(1, 50) . '.' . $file->extension();
                            $file->move(public_path('basis'), $name);
                            $files[] = $name;
                        }
                    }
                    $basis = implode(',', $files);
                }

            } else {
                $all_files = RequestFlow::where('id', $request->id)->pluck('basis')->first();
                $existing_files = explode(',', $all_files);
                $keep = explode(',', $input['basis3']);
                //dd($keep);
                if (isset($input['basis'])) {
                    $files = [];
                    if ($request->hasfile('basis')) {
                        foreach ($request->file('basis') as $file) {
                            $name = time() . rand(1, 50) . '.' . $file->extension();
                            $file->move(public_path('basis'), $name);
                            $files[] = $name;
                        }
                    }
                    $basis = implode(',', array_merge($files, $keep));

                } else {
                    $basis = implode(',', $keep);
                }


                $removed = array_diff($existing_files, $keep);

                foreach ($removed as $remove) {
                    if (File::exists(public_path('basis/' . $remove))) {
                        File::delete(public_path('basis/' . $remove));
                    }
                }


            }
            $request = RequestFlow::find($id);
            $request->company_id = $input['company'];
            $request->department_id = $input['department'];
            $request->supplier_id = $input['supplier'];
            $request->expense_type_id = $input['expense-type'];
            $request->currency = $input['currency'];
            $request->amount = $input['amount'];
            $request->amount_in_gel = $input['gel-amount2'];
            $request->description = $input['description'];
            $request->payment_date = $input['due-date-payment2'];
            $request->submission_date = $input['due-date2'];
            $request->request_link = $input['request_link'];
            if (isset($basis)) {
                $request->basis = $basis;
            }
            $request->status = $status;
            $request->save();

            if ($request) {
                if ($status == $request->status) {
                    $this->logActionCreate(Auth::id(), $request->id, 'User Request Re-Submitted');
                    AcceptOrRejectRequest::dispatch($request);
                }
                return redirect()->back()->with('success', 'Request successfull');

            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function filter($id)
    {
        if ($id == "all") {
            return $this->request();
        } else if ($id == "review") {
            $user = Auth::user();
            $requests = RequestFlow::with('company')
                ->where('user_id', $user->id)
                ->whereHas('company', function ($query) {
                    $query->where('slug', Session::get('url-slug'));
                })->where('status', StatusEnum::SubmittedForReview)->orderBy('created_at', 'desc')->get();
            $companies = Company::where('slug', Session::get('url-slug'))->get();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $departments = DepartmentUser::where('user_id', Auth::user()->id)
                ->rightJoin('departments', 'departments.id', '=', 'department_user.department_id')
                ->select('departments.*')
                ->get();
            $suppliers = supplier::all();
            $expenses = TypeOfExpanse::all();
            return view('user.pages.request', compact('requests', 'user', 'companies', 'departments', 'suppliers', 'expenses', 'companies_slug'));
        } else if ($id == "rejected") {
            $user = Auth::user();
            $requests = RequestFlow::with('company')
                ->where('user_id', $user->id)
                ->whereHas('company', function ($query) {
                    $query->where('slug', Session::get('url-slug'));
                })->whereIn('status', [StatusEnum::FinanceRejected, StatusEnum::ManagerRejected, StatusEnum::DirectorRejected, StatusEnum::Rejected])->orderBy('created_at', 'desc')->get();
            $companies = Company::where('slug', Session::get('url-slug'))->get();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $departments = DepartmentUser::where('user_id', Auth::user()->id)
                ->rightJoin('departments', 'departments.id', '=', 'department_user.department_id')
                ->select('departments.*')
                ->get();
            $suppliers = supplier::all();
            $expenses = TypeOfExpanse::all();
            return view('user.pages.request', compact('requests', 'user', 'companies', 'departments', 'suppliers', 'expenses', 'companies_slug'));
        } else if ($id == "finance") {
            $user = Auth::user();
            $requests = RequestFlow::with('company')
                ->where('user_id', $user->id)
                ->whereHas('company', function ($query) {
                    $query->where('slug', Session::get('url-slug'));
                })->where('status', StatusEnum::FinanceOk)->orderBy('created_at', 'desc')->get();
            $companies = Company::where('slug', Session::get('url-slug'))->get();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $departments = DepartmentUser::where('user_id', Auth::user()->id)
                ->rightJoin('departments', 'departments.id', '=', 'department_user.department_id')
                ->select('departments.*')
                ->get();
            $suppliers = supplier::all();
            $expenses = TypeOfExpanse::all();
            return view('user.pages.request', compact('requests', 'user', 'companies', 'departments', 'suppliers', 'expenses', 'companies_slug'));
        } else if ($id == "confirmed") {
            $user = Auth::user();
            $requests = RequestFlow::with('company')
                ->where('user_id', $user->id)
                ->whereHas('company', function ($query) {
                    $query->where('slug', Session::get('url-slug'));
                })->whereIn('status', [StatusEnum::ManagerConfirmed,StatusEnum::DirectorConfirmed,StatusEnum::ConfirmedPartially])->orderBy('created_at', 'desc')->get();
            $companies = Company::where('slug', Session::get('url-slug'))->get();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $departments = DepartmentUser::where('user_id', Auth::user()->id)
                ->rightJoin('departments', 'departments.id', '=', 'department_user.department_id')
                ->select('departments.*')
                ->get();
            $suppliers = supplier::all();
            $expenses = TypeOfExpanse::all();
            return view('user.pages.request', compact('requests', 'user', 'companies', 'departments', 'suppliers', 'expenses', 'companies_slug'));
        }
        else if (StatusEnum::ThresholdExceeded){
            $user = Auth::user();
            $requests = RequestFlow::with('company')
                ->where('user_id', $user->id)
                ->whereHas('company', function ($query) {
                    $query->where('slug', Session::get('url-slug'));
                })->whereIn('status',[StatusEnum::ThresholdExceeded, StatusEnum::FinanceThresholdExceeded, StatusEnum::ManagerThresholdExceeded])
                ->orderBy('created_at', 'desc')->get();
            $companies = Company::where('slug', Session::get('url-slug'))->get();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $departments = DepartmentUser::where('user_id', Auth::user()->id)
                ->rightJoin('departments', 'departments.id', '=', 'department_user.department_id')
                ->select('departments.*')
                ->get();
            $suppliers = supplier::all();
            $expenses = TypeOfExpanse::all();
            return view('user.pages.request', compact('requests', 'user', 'companies', 'departments', 'suppliers', 'expenses', 'companies_slug'));

        }
        else {
            $user = Auth::user();
            $requests = RequestFlow::with('company')
                ->where('user_id', $user->id)
                ->whereHas('company', function ($query) {
                    $query->where('slug', Session::get('url-slug'));
                })->where('status', 'paid')->orderBy('created_at', 'desc')->get();
            $companies = Company::where('slug', Session::get('url-slug'))->get();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
            $departments = DepartmentUser::where('user_id', Auth::user()->id)
                ->rightJoin('departments', 'departments.id', '=', 'department_user.department_id')
                ->select('departments.*')
                ->get();
            $suppliers = supplier::all();
            $expenses = TypeOfExpanse::all();
            return view('user.pages.request', compact('requests', 'user', 'companies', 'departments', 'suppliers', 'expenses', 'companies_slug'));
        }
    }

    public function request()
    {
        $user = Auth::user();
        $requests = RequestFlow::with('company')
            ->where('user_id', $user->id)
            ->whereHas('company', function ($query) {
                $query->where('slug', Session::get('url-slug'));
            })->orderBy('created_at', 'desc')->get();

        $data = $this->getSessionSetting(Session::get('url-slug'));
        $data['requests'] = $requests;
        $data['user'] = $user;

        return view('user.pages.request', $data);
    }
    public function rejected_requests(){
        $user = Auth::user();
        $requests = RequestFlow::where('user_id', $user->id)
            ->whereHas('company', function ($query) {
                $query->where('slug', Session::get('url-slug'));
            })
            ->where('status', 'like', '%rejected%')
            ->orderBy('created_at', 'desc')->get();

        $data = $this->getSessionSetting(Session::get('url-slug'));
        $data['requests'] = $requests;
        $data['user'] = $user;

        return view('user.pages.rejectedrequest', $data);
    }


    /*This method returns the Sesstion data bases on the url slug provided*/
    public function getSessionSetting($urlSlug){
            $companies = Company::where('slug', $urlSlug)->get();
            $companies_slug = User::where('id', Auth::user()->id)->first()->companies;

            $departments = DepartmentUser::where('user_id', Auth::user()->id)
                ->rightJoin('departments', 'departments.id', '=', 'department_user.department_id')
                ->select('departments.*')
                ->get();

            $suppliers = supplier::all();
            $expenses = TypeOfExpanse::all();

            return compact('companies', 'departments', 'suppliers', 'expenses', 'companies_slug');
    }


}
