<?php

namespace App\Http\Controllers;

use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Finance]);
    }

    public function dashboard()
    {
        // $this->authorize('finance');
        return view('finance.pages.dashboard');
    }

    public function getNewRequests()
    {
        $requests = RequestFlow::whereStatus(StatusEnum::New)->get();
        return view('finance.pages.new_requests', compact('requests'));
    }

    public function getRequestDetail($id){
        $request = RequestFlow::find($id);
        return response()->json($request);
    }

    public function approveRequest(Request $request)
    {
        try{
            $requestFlow = RequestFlow::find($request->id);
            $requestFlow->status = StatusEnum::FinanceOk;
            $requestFlow->comment = $request->comment ?? null ;
            $requestFlow->save();
            return redirect()->back();
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
            $requestFlow->comment = $request->comment ?? null ;
            $requestFlow->save();
            return redirect()->back();
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
