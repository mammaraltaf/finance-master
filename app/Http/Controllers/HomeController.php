<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LogAction;
use App\Models\RequestFlow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function selectCompany()
    {
        $companies = User::where('id', Auth::user()->id)->first()->companies;
        return view('user.pages.companylist', compact('companies'));
    }

    public function requestDetail($id){
        $requestFlow = RequestFlow::whereId($id)->first();
        return response()->json($requestFlow);
    }

    public function logDetail($id){
        $logs = LogAction::whereId($id)->first();
        return response()->json($logs);
    }

    public function getDepartments(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'ids' => 'required|array|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()]);
            }

            $departments = Department::whereIn('company_id', $request->ids)->get();
            return response()->json($departments);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
