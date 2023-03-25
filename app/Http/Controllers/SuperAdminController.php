<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{

    public function dashboard()
    {
//        $this->authorize('super-admin');
        return view('super-admin.pages.dashboard');
    }

    public function company()
    {
        $companies = Company::all();
        return view('super-admin.pages.company', compact('companies'));
    }


    public function companyPost(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:companies,id_software',
                'tax_id' => 'required | unique:companies,tax_id',
                'company_name' => 'required',
                'threshold_amount' => 'required',
                'legal_address' => 'required',
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
                'user_id' => auth()->user()->id ?? 1,
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
        try {
            $input = $request->all();
            $validator = Validator::make($input, [
                'id_software' => 'required | unique:companies,id_software,' . $id,
                'tax_id' => 'required | unique:companies,tax_id,' . $id,
                'company_name' => 'required',
                'threshold_amount' => 'required',
                'legal_address' => 'required',
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
            $company->user_id = auth()->user()->id ?? 1;
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
        try {
            Company::where('id',$request->id)->delete();
            return redirect()->back()->with('success','Company deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
