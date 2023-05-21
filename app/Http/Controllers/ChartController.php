<?php

namespace App\Http\Controllers;

use App\Classes\Enums\StatusEnum;
use App\Models\RequestFlow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class ChartController extends Controller
{
    public function dashboard()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $firstDayOfCurrentMonth = Carbon::create($currentYear, $currentMonth, 1, 0, 0, 0);
        $lastDayOfCurrentMonth = Carbon::create($currentYear, $currentMonth, 1, 0, 0, 0)->endOfMonth();
        $firstDayOfCurrentYear = Carbon::create($currentYear, 1, 1, 0, 0, 0);
        $lastDayOfCurrentYear = Carbon::create($currentYear, 12, 31, 0, 0, 0);

        $chartColors =[
            '#ff6384',
            '#36a2eb',
            '#ffce56',
            '#3366CC', // blue
            '#DC3912', // red
            '#FF9900', // orange
            '#109618', // green
            '#990099', // purple
            '#0099C6', // light blue
            '#DD4477', // pink
            '#66AA00', // dark green
            '#B82E2E', // dark red
            '#316395'  // dark blue
        ];

        $requests = RequestFlow::with('company','supplier','typeOfExpense','department')
            ->whereStatus(StatusEnum::Paid)
            ->whereBetween('created_at', [$firstDayOfCurrentMonth, $lastDayOfCurrentMonth])
            ->get();

        $requestsByDepartment = $requests->groupBy('department.name');
        $departmentNames = array_keys($requestsByDepartment->toArray());
        $departmentTotals = array_values($requestsByDepartment->map->sum('amount_in_gel')->toArray());

        $departmentChart = [
            'labels' => $departmentNames,
            'datasets' => [
                [
                    'data' => $departmentTotals,
                    'backgroundColor' => $chartColors,
                    'hoverBackgroundColor' => ['#ff6384', '#36a2eb', '#ffce56']
                ]
            ]
        ];

        /*Chart 2 - Type Of Expanse Chart*/
        $requestsByTypeOfExpanse = $requests->groupBy('typeOfExpense.name');
        $typeOfExpanseNames = array_keys($requestsByTypeOfExpanse->toArray());
        $typeOfExpanseTotals = array_values($requestsByTypeOfExpanse->map->sum('amount_in_gel')->toArray());

        $typeOfExpanseChart = [
            'labels' => $typeOfExpanseNames,
            'datasets' => [
                [
                    'data' => $typeOfExpanseTotals,
                    'backgroundColor' => $chartColors,
                    'hoverBackgroundColor' => ['#ff6384', '#36a2eb', '#ffce56', '#ff6384', '#36a2eb', '#ffce56']
                ]
            ]
        ];

        /*Chart 3 - Yearly Based Expanses*/

        $getAllYearRequests = RequestFlow::with('company','supplier','typeOfExpense','department')
            ->whereStatus(StatusEnum::Paid)
            ->whereBetween('created_at', [$firstDayOfCurrentYear, $lastDayOfCurrentYear])
            ->get();

        $requestsByMonth = $getAllYearRequests->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('F'); // grouping by months
        })->sortBy(function ($requests, $month) {
            return Carbon::parse($month)->month; // sorting by month (numerical order)
        });

        $requestsByMonth = $requestsByMonth->map->sum('amount_in_gel')->toArray();

        $monthNames = array_keys($requestsByMonth);
        $monthTotals = array_values($requestsByMonth);

        $yearChart = [
            'labels' => $monthNames,
            'datasets' => [
                [
                    'data' => $monthTotals,
                    'backgroundColor' => $chartColors,
                    'hoverBackgroundColor' => ['#ff6384', '#36a2eb', '#ffce56', '#ff6384', '#36a2eb', '#ffce56']
                ]
            ]
        ];
        $user_id=Auth::user()->id;
        $user_type=Auth::user()->user_type;
        $companies_slug = User::where('id', Auth::user()->id)->first()->companies;
        if($user_type=="finance"){
        return view('finance.pages.dashboard', compact('companies_slug','user_id','user_type','requests','departmentChart','typeOfExpanseChart','yearChart'));
        }elseif($user_type=="manager"){
            return view('manager.pages.dashboard', compact('companies_slug','user_id','user_type','requests','departmentChart','typeOfExpanseChart','yearChart'));
        }elseif($user_type=="director"){
            return view('director.pages.dashboard', compact('companies_slug','user_id','user_type','requests','departmentChart','typeOfExpanseChart','yearChart'));
        }elseif($user_type=="accounting"){
            return view('accounting.pages.dashboard', compact('companies_slug','user_id','user_type','requests','departmentChart','typeOfExpanseChart','yearChart'));
        }else{
            dd("sorry");
        }
    }
}
