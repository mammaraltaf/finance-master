<?php

use App\Models\Company;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Route;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpectatorController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/delete-exported-file',[AccountingController::class, 'deleteExportedFile'])->name('deleteExportedFile');

Route::get('/mail', function () {
    $request_data = \App\Models\RequestFlow::whereId(1)->first();
    \App\Jobs\AcceptOrRejectRequest::dispatch($request_data);
});

Route::get('/store-button-value/{buttonValue}', function ($buttonValue) {
    Session::forget('url-slug');
    Session::put('url-slug', $buttonValue);
    return response()->json(['status' => 'success']);
});


Route::group(['middleware' => 'auth'], function () {
    /*This endpoint is created for showing pop up modal for request details*/
    Route::get('/request-detail/{id}', [HomeController::class, 'requestDetail'])->name('request-detail');
    /*This endpoint is created for showing pop up modal for logs*/
    Route::get('/log-detail/{id}', [HomeController::class, 'logDetail'])->name('log-detail');
    /*Get Departments based on Company IDS selected*/
    Route::post('/get-departments', [HomeController::class, 'getDepartments'])->name('get-departments');

    Route::get('/{company?}/logging', [HomeController::class, 'logging'])->name('logging');
    Route::post('/logFilters', [HomeController::class, 'logFilters'])->name('logFilters');
    /*Super Admin Routes*/
    Route::group([
        'middleware' => ['role:' . UserTypesEnum::SuperAdmin],
        'prefix' => UserTypesEnum::SuperAdmin,
        'as' => UserTypesEnum::SuperAdmin . '.',
    ], function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [SuperAdminController::class, 'profile'])->name('profile');
        Route::post('/changepassword', [SuperAdminController::class, 'changepassword'])->name('changepassword');
        /*Manage Users*/
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
        Route::post('/add-user', [SuperAdminController::class, 'userPost'])->name('add-user-post');
        Route::get('/edit-user/{id}', [SuperAdminController::class, 'editUser'])->name('edit-user');
        Route::post('/edit-user/{id}', [SuperAdminController::class, 'editUserPost'])->name('edit-user-post');
        Route::post('/delete-user', [SuperAdminController::class, 'deleteUser'])->name('delete-user');
        Route::post('/block-user', [SuperAdminController::class, 'blockUser'])->name('block-user');
        Route::post('/unblock-user', [SuperAdminController::class, 'unblockUser'])->name('unblock-user');

        /*Manage Company*/
        Route::get('/company', [SuperAdminController::class, 'company'])->name('company');
        Route::post('/company', [SuperAdminController::class, 'companyPost'])->name('companyPost');
        Route::get('/edit-company/{id}', [SuperAdminController::class, 'editCompany'])->name('edit-company');
        Route::post('/edit-company/{id}', [SuperAdminController::class, 'editCompanyPost'])->name('edit-company-post');
        Route::post('/delete-company', [SuperAdminController::class, 'deleteCompany'])->name('delete-company');

        /*Manage Type Of Expanse*/
        Route::get('/type-of-expense', [SuperAdminController::class, 'typeOfExpense'])->name('type-of-expense');
        Route::post('/type-of-expense', [SuperAdminController::class, 'typeOfExpensePost'])->name('type-of-expense-post');
        Route::get('/edit-type-of-expense/{id}', [SuperAdminController::class, 'editTypeOfExpense'])->name('edit-type-of-expense');
        Route::post('/edit-type-of-expense/{id}', [SuperAdminController::class, 'editTypeOfExpensePost'])->name('edit-type-of-expense-post');
        Route::post('/delete-type-of-expense', [SuperAdminController::class, 'deleteTypeOfExpense'])->name('delete-type-of-expense');

        /*Manage Department*/
        Route::get('/department', [SuperAdminController::class, 'departments'])->name('department');
        Route::post('/department', [SuperAdminController::class, 'departmentsPost'])->name('department-post');
        Route::get('/edit-department/{id}', [SuperAdminController::class, 'editDepartment'])->name('edit-department');
        Route::post('/edit-department/{id}', [SuperAdminController::class, 'editDepartmentPost'])->name('edit-department-post');
        Route::post('/delete-department', [SuperAdminController::class, 'deleteDepartment'])->name('delete-department');

        /*Manage Supplier*/
        Route::get('/supplier', [SuperAdminController::class, 'supplier'])->name('supplier');
        Route::get('/edit-supplier/{id}', [SuperAdminController::class, 'editsupplier'])->name('edit-supplier');
        Route::post('/edit-supplier/{id}', [SuperAdminController::class, 'updatesupplier'])->name('edit-supplier-post');
        Route::post('/delete-supplier', [SuperAdminController::class, 'deletesupplier'])->name('delete-supplier');
    });


    /*Admin Routes*/
    Route::group([
        'middleware' => ['role:' . UserTypesEnum::Admin],
        'prefix' => UserTypesEnum::Admin,
        'as' => UserTypesEnum::Admin . '.',
    ], function () {

        Route::post('/payments', [AdminController::class, 'payments'])->name('payments');
        Route::post('/edit-company/{id}', [AdminController::class, 'editCompanyPost'])->name('edit-company-post');
        Route::post('/add-user', [AdminController::class, 'userPost'])->name('add-user-post');
        Route::post('/edit-user/{id}', [AdminController::class, 'editUserPost'])->name('edit-user-post');
        Route::post('/delete-user', [AdminController::class, 'deleteUser'])->name('delete-user');
        Route::post('/block-user', [AdminController::class, 'blockUser'])->name('block-user');
        Route::post('/unblock-user', [AdminController::class, 'unblockUser'])->name('unblock-user');
        Route::post('/changepassword', [AdminController::class, 'changepassword'])->name('changepassword');
        Route::post('/type-of-expense', [AdminController::class, 'typeOfExpensePost'])->name('type-of-expense-post');
        Route::post('/edit-type-of-expense/{id}', [AdminController::class, 'editTypeOfExpensePost'])->name('edit-type-of-expense-post');
        Route::post('/delete-type-of-expense', [AdminController::class, 'deleteTypeOfExpense'])->name('delete-type-of-expense');
        Route::post('/department', [AdminController::class, 'departmentsPost'])->name('department-post');
        Route::post('/edit-department/{id}', [AdminController::class, 'editDepartmentPost'])->name('edit-department-post');
        Route::post('/delete-department', [AdminController::class, 'deleteDepartment'])->name('delete-department');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::get('/viewrequests', [AdminController::class, 'viewrequests'])->name('viewrequests');
        Route::get('/company', [AdminController::class, 'company'])->name('company');
        Route::get('/edit-company/{id}', [AdminController::class, 'editCompany'])->name('edit-company');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('edit-user');
        Route::get('/type-of-expense', [AdminController::class, 'typeOfExpense'])->name('type-of-expense');
        Route::get('/edit-type-of-expense/{id}', [AdminController::class, 'editTypeOfExpense'])->name('edit-type-of-expense');
        Route::get('/department', [AdminController::class, 'departments'])->name('department');
        Route::get('/edit-department/{id}', [AdminController::class, 'editDepartment'])->name('edit-department');

    });

    /*User Routes*/
    Route::group([
        'middleware' => ['role:' . UserTypesEnum::User],
        'prefix' => UserTypesEnum::User,
        'as' => UserTypesEnum::User . '.',
    ], function () {

        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/addsupplier', [UserController::class, 'addsupplier'])->name('addsupplier');
        Route::post('/delete-supplier', [UserController::class, 'deletesupplier'])->name('delete-supplier');
        Route::post('/addrequest', [UserController::class, 'addrequest'])->name('addrequest');
        Route::post('/delete-request', [UserController::class, 'deleterequest'])->name('delete-request');
        Route::post('/edit-request/{id}', [UserController::class, 'updaterequest'])->name('edit-request-post');
        Route::post('/changepassword', [UserController::class, 'changepassword'])->name('changepassword');
        Route::get('/select-company', [HomeController::class, 'selectCompany'])->name('select-company');
        Route::get('{company?}/dashboard', [UserController::class, 'dashboard'])->name('company.dashboard');
        Route::get('{company?}/supplier', [UserController::class, 'supplier'])->name('supplier');
        Route::get('{company?}/request', [UserController::class, 'request'])->name('request');
        Route::get('/edit-request/{id}', [UserController::class, 'editrequest'])->name('edit-request');
        Route::get('/filter/{id}', [UserController::class, 'filter'])->name('filter');
        Route::get('rejected-requests', [UserController::class, 'rejected_requests'])->name('rejected-requests');

    });


    /*Finance Routes*/
    Route::group([
        'middleware' => ['role:' . UserTypesEnum::Finance],
        'prefix' => UserTypesEnum::Finance,
        'as' => UserTypesEnum::Finance . '.',
    ], function () {

        Route::get('/profile', [FinanceController::class, 'profile'])->name('profile');

        Route::post('/approve-request', [FinanceController::class, 'approveRequest'])->name('approve-request');
        Route::post('/reject-request', [FinanceController::class, 'rejectRequest'])->name('reject-request');
        Route::post('/payments', [FinanceController::class, 'payments'])->name('payments');
        Route::post('/logfilters', [FinanceController::class, 'logfilters'])->name('logfilters');
        Route::post('/changepassword', [FinanceController::class, 'changepassword'])->name('changepassword');
        Route::get('/select-company', [HomeController::class, 'selectCompany'])->name('select-company');
        Route::get('{company?}/dashboard', [ChartController::class, 'dashboard'])->name('company.dashboard');
        Route::get('/request', [FinanceController::class, 'requestFinance'])->name('request');
        Route::get('/get-new-requests', [FinanceController::class, 'getNewRequests'])->name('get-new-requests');
        Route::get('/get-request-detail/{id}', [FinanceController::class, 'getRequestDetail'])->name('get-request-detail');
        Route::get('/logs', [FinanceController::class, 'logs'])->name('logs');
        Route::get('/filter/{id}', [FinanceController::class, 'filtering'])->name('filtering');
    });


    /*Manager Routes*/
    Route::group([
        'middleware' => ['role:' . UserTypesEnum::Manager],
        'prefix' => UserTypesEnum::Manager,
        'as' => UserTypesEnum::Manager . '.',
    ], function () {

        Route::get('/profile', [ManagerController::class, 'profile'])->name('profile');
        Route::post('/approve-request', [ManagerController::class, 'approveRequest'])->name('approve-request');
        Route::post('/reject-request', [ManagerController::class, 'rejectRequest'])->name('reject-request');
        Route::post('payments', [ManagerController::class, 'payments'])->name('payments');
        Route::post('/logfilters', [ManagerController::class, 'logfilters'])->name('logfilters');
        Route::post('/changepassword', [ManagerController::class, 'changepassword'])->name('changepassword');
        Route::get('/select-company', [HomeController::class, 'selectCompany'])->name('select-company');
        Route::get('{company?}/dashboard', [ChartController::class, 'dashboard'])->name('company.dashboard');
        Route::get('{company?}/viewrequests', [ManagerController::class, 'viewrequests'])->name('viewrequests');
        Route::get('{company?}/logs', [ManagerController::class, 'logs'])->name('logs');
//        Route::get('{company?}/dashboard', [ManagerController::class, 'dashboard'])->name('company.dashboard');
        Route::get('/filter/{id}', [ManagerController::class, 'filtering'])->name('filtering');
    });


    /*Director Routes*/
    Route::group([
        'middleware' => ['role:' . UserTypesEnum::Director],
        'prefix' => UserTypesEnum::Director,
        'as' => UserTypesEnum::Director . '.',
    ], function () {

        Route::get('/profile', [DirectorController::class, 'profile'])->name('profile');
        Route::post('/logfilters', [DirectorController::class, 'logfilters'])->name('logfilters');
        Route::post('/reject', [DirectorController::class, 'rejectRequest'])->name('reject');
        Route::post('/accept', [DirectorController::class, 'approveRequest'])->name('accept');
        Route::post('/approve-request', [DirectorController::class, 'approveRequest'])->name('approve-request');
        Route::post('/reject-request', [DirectorController::class, 'rejectRequest'])->name('reject-request');
        Route::post('/payments', [DirectorController::class, 'payments'])->name('payments');
        Route::post('/changepassword', [DirectorController::class, 'changepassword'])->name('changepassword');
        Route::get('/select-company', [HomeController::class, 'selectCompany'])->name('select-company');
        Route::get('{company?}/dashboard', [ChartController::class, 'dashboard'])->name('company.dashboard');
        Route::get('{company?}/logs', [DirectorController::class, 'logs'])->name('logs');
        Route::get('{company?}/viewrequests', [DirectorController::class, 'viewrequests'])->name('viewrequests');
        Route::get('/filter/{id}', [DirectorController::class, 'filtering'])->name('filtering');
    });


    /*Accounting Routes*/
    Route::group([
        'middleware' => ['role:' . UserTypesEnum::Accounting],
        'prefix' => UserTypesEnum::Accounting,
        'as' => UserTypesEnum::Accounting . '.',
    ], function () {
        Route::get('/profile', [AccountingController::class, 'profile'])->name('profile');
        Route::post('/payment/{id}', [AccountingController::class, 'pay'])->name('payment-post');
        Route::post('/payments', [AccountingController::class, 'payments'])->name('payments');
        Route::post('/bulk-pay-or-reject', [AccountingController::class, 'bulkPayOrReject'])->name('bulk-pay-or-reject');
        Route::post('/changepassword', [AccountingController::class, 'changepassword'])->name('changepassword');
        Route::post('/logfilters', [AccountingController::class, 'logfilters'])->name('logfilters');
        Route::post('/edit-supplier/{id}', [AccountingController::class, 'updatesupplier'])->name('edit-supplier-post');
        Route::get('/select-company', [HomeController::class, 'selectCompany'])->name('select-company');
        Route::get('{company?}/dashboard', [ChartController::class, 'dashboard'])->name('company.dashboard');
        Route::get('{company?}/supplier', [AccountingController::class, 'supplier'])->name('supplier');
        Route::get('{company?}/logs', [AccountingController::class, 'logs'])->name('logs');
        Route::get('{company?}/viewrequests', [AccountingController::class, 'viewrequests'])->name('viewrequests');
        Route::get('/payment/{id}', [AccountingController::class, 'payment'])->name('payment');
        Route::get('/edit-supplier/{id}', [AccountingController::class, 'editsupplier'])->name('edit-supplier');
        Route::get('/alldata', [AccountingController::class, 'alldata'])->name('alldata');
        Route::get('/print/{id}', [AccountingController::class, 'print'])->name('print');
    });
});

/*Accounting Routes*/
Route::group([
    'middleware' => ['role:' . UserTypesEnum::Spectator],
    'prefix' => UserTypesEnum::Spectator,
    'as' => UserTypesEnum::Spectator . '.',
], function () {
    Route::get('/select-company', [SpectatorController::class, 'selectCompany'])->name('select-company');
    Route::get('{company?}/dashboard', [ChartController::class, 'dashboard'])->name('company.dashboard');
    Route::get('{company?}/viewrequests', [SpectatorController::class, 'viewrequests'])->name('viewrequests');
    Route::post('/changepassword', [SpectatorController::class, 'changepassword'])->name('changepassword');
    Route::get('{company?}/logs', [SpectatorController::class, 'logs'])->name('logs');
    Route::get('/dashboard', [SpectatorController::class, 'dashboard'])->name('dashboard');
    Route::post('/logfilters', [SpectatorController::class, 'logfilters'])->name('logfilters');
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(
    [
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]
);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//user routes
Route::get('/users', [App\Http\Controllers\SuperAdminController::class, 'all_users']);
Route::post('/users', [App\Http\Controllers\SuperAdminController::class, 'adduser'])->name('super-admin.adduser');
// Route::post('/users', [App\Http\Controllers\SuperAdminController::class, 'deleteuser'])->name('super-admin.deleteuser');

Route::redirect('/', '/login');


