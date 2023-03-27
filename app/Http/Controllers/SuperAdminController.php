<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\TypeOfExpanse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Classes\Enums\UserTypesEnum;
use Spatie\Permission\Models\Role;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::SuperAdmin]);
    }

    public function dashboard()
    {
        return view('super-admin.pages.dashboard');
    }

    /*-------------Users-------------*/
    public function users()
    {
        $users = User::where('user_type','!=',UserTypesEnum::SuperAdmin)->get();
        $roles = Role::whereIn('name',[UserTypesEnum::User,UserTypesEnum::Admin])->get();
        return view('super-admin.pages.users', compact('users','roles'));
    }

    public function userPost(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required | unique:users,email',
                'type' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $users = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make('system_default'),
                'user_type' => $input['type']
            ]);

            $users->assignRole($input['type']);

            if ($users) {
                return redirect()->back()->with('success', 'User registered successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editUser($id)
    {
        $this->authorize('edit user');
        $user = User::find($id);
        return response()->json($user);
    }

    public function editUserPost(Request $request, $id){
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required | unique:users,email,'.$id,
                'type' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::find($id);
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->user_type = $input['type'];
            $user->save();

            $user->syncRoles($input['type']);

            if($user){
                return redirect()->back()->with('success', 'User updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        }
        catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteUser(Request $request)
    {
//        $this->authorize('delete user');
        $user = User::where('id', $request->id)->first();
        $user->delete();
        $user->syncRoles([]);
        return redirect()->back()->with('success', 'User deleted successfully');
    }




    public function company()
    {
        $companies = Company::all();
        $admins = User::where('user_type', UserTypesEnum::Admin)->get();
        return view('super-admin.pages.company', compact('companies','admins'));
    }


    public function companyPost(Request $request)
    {
        $this->authorize('create company');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:companies,id_software',
                'tax_id' => 'required | unique:companies,tax_id',
                'company_name' => 'required',
                'threshold_amount' => 'required',
                'legal_address' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $company = Company::create([
                'id_software' => $input['id_software'],
                'tax_id' => $input['tax_id'],
                'name' => $input['company_name'],
                'threshold_amount' => $input['threshold_amount'],
                'legal_address' => $input['legal_address'],
                'user_id' => $input['user_id'],
            ]);

            if ($company) {
                return redirect()->back()->with('success', 'Company created successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editCompany($id)
    {
        $company = Company::find($id);
        return response()->json($company);
    }

    public function editCompanyPost(Request $request, $id)
    {
        $this->authorize('edit company');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:companies,id_software,' . $id,
                'tax_id' => 'required | unique:companies,tax_id,' . $id,
                'company_name' => 'required',
                'threshold_amount' => 'required',
                'legal_address' => 'required',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $company = Company::find($id);
            $company->id_software = $input['id_software'];
            $company->tax_id = $input['tax_id'];
            $company->name = $input['company_name'];
            $company->threshold_amount = $input['threshold_amount'];
            $company->legal_address = $input['legal_address'];
            $company->user_id = $input['user_id'];
            $company->save();

            if ($company) {
                return redirect()->back()->with('success', 'Company updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteCompany(Request $request)
    {
        $this->authorize('delete company');
        try {
            Company::where('id',$request->id)->delete();
            return redirect()->back()->with('success','Company deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function typeOfExpense()
    {
        $typeOfExpenses = TypeOfExpanse::all();
        return view('super-admin.pages.type-of-expense', compact('typeOfExpenses'));
    }

    public function typeOfExpensePost(Request $request)
    {
//        $this->authorize('create type of expense');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:type_of_expanses,id_software',
                'name' => 'required',
                'accounting_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $typeOfExpense = TypeOfExpanse::create([
                'id_software' => $input['id_software'],
                'name' => $input['name'],
                'accounting_id' => $input['accounting_id'],
            ]);

            if ($typeOfExpense) {
                return redirect()->back()->with('success', 'Type of expense created successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editTypeOfExpense($id)
    {
        $typeOfExpense = TypeOfExpanse::find($id);
        return response()->json($typeOfExpense);
    }

    public function editTypeOfExpensePost(Request $request, $id)
    {
//        $this->authorize('edit type of expense');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:type_of_expanses,id_software,' . $id,
                'name' => 'required',
                'accounting_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $typeOfExpense = TypeOfExpanse::find($id);
            $typeOfExpense->id_software = $input['id_software'];
            $typeOfExpense->name = $input['name'];
            $typeOfExpense->accounting_id = $input['accounting_id'];
            $typeOfExpense->save();

            if ($typeOfExpense) {
                return redirect()->back()->with('success', 'Type of expense updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteTypeOfExpense(Request $request)
    {
        try {
            TypeOfExpanse::where('id',$request->id)->delete();
            return redirect()->back()->with('success','Type of expense deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function departments()
    {
        $departments = Department::all();
//        $users = User::whereIn('user_type',[UserTypesEnum::User,UserTypesEnum::Admin])->get();
        $users = User::where('user_type',UserTypesEnum::User)->get();
        return view('super-admin.pages.department', compact('departments','users'));
    }

    public function departmentsPost(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:departments,id_software',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $department = Department::create([
                'id_software' => $input['id_software'],
                'name' => $input['name'],
            ]);

            if ($department) {
                return redirect()->back()->with('success', 'Department created successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editDepartment($id)
    {
        $department = Department::find($id);
        return response()->json($department);
    }

    public function editDepartmentPost(Request $request, $id)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:departments,id_software,' . $id,
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $department = Department::find($id);
            $department->id_software = $input['id_software'];
            $department->name = $input['name'];
            $department->save();

            if ($department) {
                return redirect()->back()->with('success', 'Department updated successfully');
            }

            return redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteDepartment(Request $request)
    {
        try {
            Department::where('id',$request->id)->delete();
            return redirect()->back()->with('success','Department deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
