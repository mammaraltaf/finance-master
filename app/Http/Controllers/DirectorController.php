<?php

namespace App\Http\Controllers;

use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectorController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Director]);
    }

    public function dashboard()
    {
        // $this->authorize('director');
        $requests = RequestFlow::whereIn('status',[StatusEnum::FinanceOk,StatusEnum::ManagerConfirmed])->get();
        return view('director.pages.dashboard', compact('requests'));
    }

    public function approveRequest(Request $request)
    {
        try{
            $requestFlow = RequestFlow::with('company')->find($request->id);
            if ($requestFlow->amount > $requestFlow->company->threshold_amount) {
                $requestFlow->status = StatusEnum::ConfirmedPartially;
            }
            else {
                $requestFlow->status = StatusEnum::DirectorConfirmed;
            }
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
            $requestFlow->status = StatusEnum::DirectorRejected;
            $requestFlow->comment = $request->comment;
            $requestFlow->save();
            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
