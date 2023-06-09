<?php

namespace App\Http\Controllers;

use App\Classes\Enums\StatusEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\Supplier;
use App\Models\TypeOfExpanse;
use App\Models\CompanyUser;
use App\Models\CompanyDepartment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::SuperAdmin]);
    }

    public function dashboard()
    {
        $users = User::where('user_type','!=',UserTypesEnum::User)->count();
        $companies = Company::count();
        $departments = Department::count();
        $suppliers = Supplier::count();
        $typeOfExpanse = TypeOfExpanse::count();
        $user_id=Auth::user()->id;
        return view('super-admin.pages.dashboard', compact('user_id','users','companies','departments','suppliers','typeOfExpanse'));
    }

    public function profile(){
        $user_id=Auth::user()->id;
        $user = User::find($user_id);
        return view('super-admin.pages.profile', compact('user'));
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

    /*-------------Users-------------*/
    public function users()
    {
        try{
            $users = User::where('user_type','!=',UserTypesEnum::SuperAdmin)->withTrashed()->orderBy('created_at', 'desc')->get();
//            $roles = Role::whereIn('name',[UserTypesEnum::User,UserTypesEnum::Admin])->get();
            $roles = Role::where('name','!=',UserTypesEnum::SuperAdmin)->get();
            $companies = Company::all();
            $departments = Department::all();

//            $companies = Company::doesntHave('users')->get();
//            $departments = Department::doesntHave('users')->get();

            return view('super-admin.pages.users', compact('users','roles','companies','departments'));
        }
        catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userPost(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required | unique:users,email',
                'type' => 'required',
                'company' => 'required | array',
                'department' => 'required | array',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $users = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'original_password' => $input['password'],
                'user_type' => $input['type'],
            ]);

            $companyIds = $request->input('company',[]);
            $departmentIds = $request->input('department',[]);
            $users->companies()->attach($companyIds);
            $users->departments()->attach($departmentIds);

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
//        $this->authorize('edit user');
//        $user = User::find($id);
        $user = User::with(['companies','departments'])->where('id',$id)->first();
        return response()->json($user);
    }

    public function editUserPost(Request $request, $id){
//        dd($request->all(),$id);
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required | unique:users,email,'.$id,
                'type' => 'required',
                'company' => 'required',
                'department' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::find($id);
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->user_type = $input['type'];
            $user->password = Hash::make($input['password']);
            $user->original_password = $input['password'];
            $user->save();

            $companyIds = $request->input('company',[]);
            $departmentIds = $request->input('department',[]);
            $user->companies()->sync($companyIds);
            $user->departments()->sync($departmentIds);

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
     try{
         $user = User::where('id', $request->id)->first();
         $user->forceDelete();
         $user->syncRoles([]);
         return redirect()->back()->with('success', 'User deleted successfully');
     }
        catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function blockUser(Request $request)
    {
        try{
            $user = User::where('id', $request->id)->first();
            $user->status = StatusEnum::Blocked;
            $user->save();
            $user->delete();
            return redirect()->back()->with('success', 'User status updated successfully');
        }
        catch (Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function unblockUser(Request $request)
    {
        try{
            $user = User::where('id', $request->id)->withTrashed()->first();
            $user->status = StatusEnum::Active;
            $user->deleted_at = null;
            $user->save();
            return redirect()->back()->with('success', 'User status updated successfully');
        }
        catch (Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function company()
    {
        $companies = Company::all();
//        $admins  = User::where('user_type',UserTypesEnum::Admin)->doesntHave('companies')->get();
        return view('super-admin.pages.company', compact('companies'));
    }


    public function companyPost(Request $request)
    {
//        $this->authorize('create company');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'logo' => 'required',
//                'id_software' => 'required | unique:companies,id_software',
                'tax_id' => 'required | unique:companies,tax_id',
                'company_name' => 'required',
                'threshold_amount' => 'required',
                'legal_address' => 'required',
//                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasfile('logo')) {
                $file = $request->file('logo');
                $name = time() . rand(1, 50) . '.' . $file->extension();
                $file->move(public_path('image'), $name);
                $logo = $name;
            }

            $company = Company::create([
                'logo' => $logo,
                'id_software' => $input['id_software'] ?? Str::random(10),
                'tax_id' => $input['tax_id'],
                'name' => $input['company_name'],
                'slug' => Str::slug($input['company_name']),
                'threshold_amount' => $input['threshold_amount'],
                'bog_account_number' => $input['bog'],
                'tbc_account_number' => $input['tbc'],
                'legal_address' => $input['legal_address'],
            ]);

//            $company->users()->attach($input['user_id']);

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
        $company = Company::with(['users'=>function($query){
            $query->where('user_type', UserTypesEnum::Admin);
        }])
            ->where('id', $id)
            ->first();

        return response()->json($company);
    }

    public function editCompanyPost(Request $request, $id)
    {
//        $this->authorize('edit company');
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'tax_id' => 'required | unique:companies,tax_id,' . $id,
                // 'logo' => 'required',
                'company_name' => 'required',
                'threshold_amount' => 'required',
                'legal_address' => 'required',
//                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if ($request->hasfile('logo')) {
                $file=$request->file('logo');

                    $name = time() . rand(1, 50) . '.' . $file->extension();
                    $file->move(public_path('image'), $name);
                    $logo = $name;
            }

            $company = Company::find($id);
            $company->tax_id = $input['tax_id'];
            $company->name = $input['company_name'];
            $company->slug = Str::slug($input['company_name']);
            $company->threshold_amount = $input['threshold_amount'];
            $company->legal_address = $input['legal_address'];
            $company->bog_account_number = $input['bog'];
            $company->tbc_account_number = $input['tbc'];
            if(isset($logo)){
                $company->logo = $logo;
            }
            // $company->user_id = $input['user_id'];
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
        // $this->authorize('delete company');
        try {
           $data= Company::where('id',$request->id)->delete();
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
                'name' => 'required',
                'accounting_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $typeOfExpense = TypeOfExpanse::create([
                'id_software' => $input['id_software'] ?? Str::random(10),
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
                'name' => 'required',
                'accounting_id' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $typeOfExpense = TypeOfExpanse::find($id);
            $typeOfExpense->id_software = $input['id_software'] ?? Str::random(10);
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
        $companies = Company::all();
//        $users = User::whereIn('user_type',[UserTypesEnum::User,UserTypesEnum::Admin])->get();
        $users = User::where('user_type',UserTypesEnum::User)->get();
        return view('super-admin.pages.department', compact('departments','users','companies'));
    }

    public function departmentsPost(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'unique:departments,id_software',
                'company_id' => 'required | numeric | exists:companies,id',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $department = Department::create([
                'id_software' => $input['id_software'] ?? Str::random(10),
                'name' => $input['name'],
                'company_id' => $input['company_id'],
                'user_id' => auth()->user()->id,
            ]);


//            $company_id = $request->input('company_id');
//            $department_id = $department->id;
//            $companyDepartment = new CompanyDepartment([
//                'company_id' => $company_id,
//                'department_id' => $department_id,
//            ]);
//            $companyDepartment->save();


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
                'id_software' => 'unique:departments,id_software,' . $id,
                'company_id' => 'required | numeric | exists:companies,id',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $department = Department::find($id);
            $department->id_software = $input['id_software'] ?? Str::random(10);
            $department->name = $input['name'];
            $department->company_id = $input['company_id'];
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

    public function supplier()
    {
        $suppliers = Supplier::all();
        return view('user.pages.supplier', compact('suppliers'));
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
                'id_software' => 'unique:suppliers,id_software,'. $id,
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
            $supplier->id_software = $input['id_software'] ?? Str::random(10);
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

    public function deletesupplier(Request $request){
        try {
      supplier::where('id',$request->id)->delete();
            return redirect()->back()->with('success','Supplier deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
