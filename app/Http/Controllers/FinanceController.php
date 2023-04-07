<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use App\Traits\LogActionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinanceController extends Controller
{
    use LogActionTrait;
    public function __construct()
    {
        $this->middleware(['auth', 'role:'.UserTypesEnum::Finance]);
    }

    public function dashboard()
    {
        // $this->authorize('finance');
        $requests = RequestFlow::whereStatus(StatusEnum::SubmittedForReview)->get();
        return view('finance.pages.dashboard', compact('requests'));
    }

//    public function getNewRequests()
//    {
//        $requests = RequestFlow::whereStatus(StatusEnum::SubmittedForReview)->get();
//        return view('finance.pages.new_requests', compact('requests'));
//    }

    public function getRequestDetail($id){
        try{
            $request = RequestFlow::find($id);
            return response()->json($request);
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function approveRequest(Request $request)
    {
        try{
            $requestFlow = RequestFlow::find($request->id);
            $requestFlow->status = StatusEnum::FinanceOk;
            $requestFlow->comment = $request->comment ?? null ;
            $requestFlow->save();
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::FINANCE_ACCEPT);
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
            $requestFlow->status = StatusEnum::FinanceRejected;
            $requestFlow->comment = $request->comment;
            $requestFlow->save();
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::FINANCE_REJECT);
            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
