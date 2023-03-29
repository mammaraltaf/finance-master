<?php

namespace App\Http\Controllers;


use Exception;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\supplier_bank;
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
        return view('user.pages.request');
    }
}
