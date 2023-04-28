<?php

namespace App\Http\Controllers;
use App\Classes\Enums\StatusEnum;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\RequestFlow;
use App\Models\DepartmentUser;
use App\Models\TypeOfExpanse;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Admin]);
    }

    public function dashboard()
    {
        return view('admin.pages.dashboard');
    }
    public function viewrequests()
    {

        $user = Auth::user();
        $company = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->where('company_id', $company)->orderBy('request_flows.created_at', 'desc')->get();
       return view('admin.pages.requests', compact('requests'));
    }
    public function payments(Request $request)
    {
        $user = Auth::user();
        $company = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
        $input = $request->all();
        $start = Carbon::parse($input['start-date'])->toDateTimeString();
        $end = Carbon::parse($input['end-date'])->toDateTimeString();
        $requests = RequestFlow::with('company', 'supplier', 'typeOfExpense')->where('company_id', $company)
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('request_flows.created_at', 'desc')
            ->get();
        return view('admin.pages.requests', compact('requests'));
    }
    public function company()
    {
        $user = Auth::user();
        $company_id = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
        $companys = Company::where('id',$company_id)->get();
        $admin = User::where('id', $user->id)->get();
        return view('admin.pages.company', compact('companys','admin'));
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
public function users()
    {
        try{
            $user = Auth::user(); 
            $company_id = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
            $user_ids = CompanyUser::where([
                ['company_id', $company_id],
                ['user_id','!=', $user->id]
                ])
                ->get('user_id');
                $users = User::whereIn('id', $user_ids)->withTrashed()->orderBy('created_at', 'desc')->get();
                
                $roles = Role::whereNotIn('name',[UserTypesEnum::SuperAdmin,UserTypesEnum::Admin])->get();
            return view('admin.pages.users', compact('users','roles'));
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
            $user = Auth::user(); 
          
            $companyIds = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
           
            $users->companies()->attach($companyIds);
           

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
        $user = User::where('id',$id)->first();
        return response()->json($user);

    }
   
    public function editUserPost(Request $request, $id){
                try{
                    $input = $request->all();
                    $validator = Validator::make($input, [
                        'name' => 'required',
                        'email' => 'required | unique:users,email,'.$id,
                        'type' => 'required',
                        'password' => 'required'
                    ]);
        
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $user = Auth::user(); 
          
                    $user = User::find($id);
                    $user->name = $input['name'];
                    $user->email = $input['email'];
                    $user->user_type = $input['type'];
                    $user->password = Hash::make($input['password']);
                    $user->original_password = $input['password'];
                    $user->save();
        
                    $companyIds = CompanyUser::where('user_id', $user->id)->pluck('company_id')->first();
                    $user->companies()->sync($companyIds);
        
                    if($user){
                        return redirect()->back()->with('success', 'User updated successfully');
                    }
        
                    return redirect()->back()->with('error', 'Something went wrong');
                }
                catch (Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
            }
            public function blockUser(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->status = StatusEnum::Blocked;
        $user->save();
        $user->delete();
        return redirect()->back()->with('success', 'User status updated successfully');
    }
    public function unblockUser(Request $request)
    {
        $user = User::where('id', $request->id)->withTrashed()->first();
        $user->status = StatusEnum::Active;
        $user->deleted_at = null;
        $user->save();
        return redirect()->back()->with('success', 'User status updated successfully');
    }
    public function deleteUser(Request $request)
    {
//        $this->authorize('delete user');
        $user = User::where('id', $request->id)->first();
        $user->delete();
        $user->syncRoles([]);
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
