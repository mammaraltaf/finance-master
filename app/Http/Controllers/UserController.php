<?php

namespace App\Http\Controllers;


use Exception;

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
use App\Models\TypeOfExpanse;
use Illuminate\Support\Facades\Auth;
use File;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::User]);
    }

    public function dashboard()
    {
        // $this->authorize('user');
         return view('user.pages.dashboard');
    }

    public function supplier()
    {
        $suppliers = Supplier::all();
//        $suppliers=Supplier::rightJoin('supplier_bank','supplier_bank.supplier_id','=','suppliers.id')
//          ->select('suppliers.*','supplier_bank.*')
//         ->get()->toArray();
        return view('user.pages.supplier', compact('suppliers'));
    }

    public function addsupplier(Request $request){
        $this->authorize('create supplier');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:suppliers,id_software',
                'tax_id' => 'required | unique:suppliers,tax_id',
                'name' => 'required ',
                'bank_id' => 'required',
                'bank_name' => 'required',
                'bank_account' => 'required',
                'bank_swift' => 'required',
                'accounting_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $supplier_data = Supplier::create([
                'id_software' => $input['id_software'],
                'tax_id' => $input['tax_id'],
                'supplier_name' => $input['name'],
                'bank_id' => $input['bank_id'],
                'bank_name' => $input['bank_name'],
                'bank_account' => $input['bank_account'],
                'bank_swift' => $input['bank_swift'],
                'accounting_id' => $input['accounting_id'],
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

    public function request(){
        $user = Auth::user();
        $requests = RequestFlow::all();
        $companies = Company::all(['id', 'name','user_id']);
        $departments = Department::all(['id', 'name','user_id']);
        $suppliers = supplier::all();
        $expenses = TypeOfExpanse::all();
        return view('user.pages.request',compact('requests','user','companies','departments','suppliers','expenses'));
    }
    public function updatesupplier(Request $request, $id){
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:suppliers,id_software,'. $id,
                'tax_id' => 'required | unique:suppliers,tax_id,'. $id,
                'name' => 'required ',
                'bank_id' => 'required',
                'bank_name' => 'required',
                'bank_account' => 'required',
                'bank_swift' => 'required',
                'accounting_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $supplier = Supplier::find($id);
            $supplier->id_software = $input['id_software'];
            $supplier->tax_id = $input['tax_id'];
            $supplier->supplier_name = $input['name'];
            $supplier->bank_id = $input['bank_id'];
            $supplier->bank_name = $input['bank_name'];
            $supplier->bank_account = $input['bank_account'];
            $supplier->bank_swift = $input['bank_swift'];
            $supplier->accounting_id = $input['accounting_id'];
           
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


    public function addrequest(Request $request){
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
                'amount' => 'required',
                'description' => 'required',
                'basis' => 'required',
                'due-date-payment' => 'required',
                'due-date' => 'required'
            ]);
             if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $files = [];
        if($request->hasfile('basis'))
         {
            foreach($request->file('basis') as $file)
            {
                $name = time().rand(1,50).'.'.$file->extension();
                $file->move(public_path('basis'), $name);  
                $files[] = $name;  
            }
         }
         $basis=implode(',',$files);
            if(isset($_POST['button'])){
                $status=$_POST['button'];
            }
            $request_data = RequestFlow::create([
                'initiator' => $input['initiator_id'],
                'company' => $input['company'],
                'department' => $input['department'],
                'supplier' => $input['supplier'],
                'expense_type' => $input['expense_type'],
                'currency' => $input['currency'],
                'amount' => $input['amount'],
                'description' => $input['description'],
                'basis' => $basis,   
                'payment_date' => $input['due-date-payment'],
                'submission_date' => $input['due-date'],
                'status' => $status,
                'user_id' => auth()->user()->id
            ]);

            if ($request_data) {
                return redirect()->back()->with('success', 'Request successfull');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleterequest(Request $request){
        try {
            $all_files = RequestFlow::where('id', $request->id)->pluck('basis')->first();
            $files=explode(',',$all_files);
            foreach($files as $file){
                if(\File::exists(public_path('basis/'.$file))){
                    \File::delete(public_path('basis/'.$file));
                    }
            }
            
            RequestFlow::where('id',$request->id)->delete();
            return redirect()->back()->with('success','Request deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    
    public function editrequest($id)
    {
        $requested = RequestFlow::find($id);
        return response()->json($requested);
    }

    public function updaterequest(Request $request, $id){
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'company' => 'required',
                'department' => 'required',
                'supplier' => 'required',
                'expense-type' => 'required',
                'currency' => 'required',
                'amount' => 'required',
                'description' => 'required',
                // 'basis' => 'required',
                'due-date-payment2' => 'required',
                'due-date2' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $request = RequestFlow::find($id);
           
            $request->company = $input['company'];
            $request->department = $input['department'];
            $request->supplier = $input['supplier'];
            $request->expense_type = $input['expense-type'];
            $request->currency = $input['currency'];
            $request->amount = $input['amount'];
            $request->description = $input['description'];
            $request->payment_date = $input['due-date-payment2'];
            $request->submission_date = $input['due-date2'];
            $request->save();

            if($request){
                return redirect()->back()->with('success', 'Request updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
