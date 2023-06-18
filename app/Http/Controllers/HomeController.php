<?php

namespace App\Http\Controllers;

use App\Models\LogAction;
use App\Models\RequestFlow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
