<?php

namespace App\Http\Controllers;

use App\Classes\Enums\ActionEnum;
use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Models\RequestFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\LogAction;
use App\Traits\LogActionTrait;
class DirectorController extends Controller
{
    use LogActionTrait;

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
public function filter($id){
if($id=='1'){
   return $this->dashboard();
}elseif($id=='2'){
    $requests = RequestFlow::whereIn('status',[StatusEnum::DirectorConfirmed])->get();
    return view('director.pages.dashboard', compact('requests'));
}else{
    $requests = RequestFlow::whereIn('status',[StatusEnum::DirectorRejected])->get();
    return view('director.pages.dashboard', compact('requests'));
}
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
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::DIRECTOR_ACCEPT);
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
            $this->logActionCreate(Auth::id(), $requestFlow->id, ActionEnum::DIRECTOR_REJECT);
            return redirect()->back()->with('success', 'Request Rejected Successfully');
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
