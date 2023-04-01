<?php

namespace App\Http\Controllers;

use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Manager]);
    }


    public function dashboard()
    {
        $requests = RequestFlow::whereStatus(StatusEnum::FinanceOk)->get();
        return view('manager.pages.dashboard', compact('requests'));
    }

    public function approveRequest(Request $request)
    {
        try{
            $requestFlow = RequestFlow::find($request->id);
            $requestFlow->status = StatusEnum::Confirmed;
            $requestFlow->comment = $request->comment ?? null ;
            $requestFlow->save();
            return redirect()->back()->with('success', 'Request Approved Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function rejectRequest(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'comment' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $requestFlow = RequestFlow::find($request->id);
            $requestFlow->status = StatusEnum::Rejected;
            $requestFlow->comment = $request->comment;
            $requestFlow->save();
            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
