<?php

use App\Models\Company;
use Illuminate\Support\Facades\Route;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('auth.login');
})->name('mainpage');

Route::group(['middleware'=>'auth'],function (){
    /*Super Admin Routes*/
    Route::group([
        'middleware' => ['role:'.UserTypesEnum::SuperAdmin],
        'prefix' => UserTypesEnum::SuperAdmin,
        'as' => UserTypesEnum::SuperAdmin.'.',
    ], function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

        /*Manage Users*/
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
        Route::post('/add-user', [SuperAdminController::class, 'userPost'])->name('add-user-post');
        Route::get('/edit-user/{id}', [SuperAdminController::class, 'editUser'])->name('edit-user');
        Route::post('/edit-user/{id}', [SuperAdminController::class, 'editUserPost'])->name('edit-user-post');
        Route::post('/delete-user', [SuperAdminController::class, 'deleteUser'])->name('delete-user');

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
    });

    /*User Routes*/  
    Route::group([
        'middleware' => ['role:'.UserTypesEnum::User],
        'prefix' => UserTypesEnum::User,
        'as' => UserTypesEnum::User.'.',
    ], function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/supplier', [UserController::class, 'supplier'])->name('supplier');
        Route::post('/addsupplier', [UserController::class, 'addsupplier'])->name('addsupplier');
        Route::get('/edit-supplier/{id}', [UserController::class, 'editsupplier'])->name('edit-supplier');
        Route::post('/edit-supplier/{id}', [UserController::class, 'updatesupplier'])->name('edit-supplier-post');
        Route::get('/request', [UserController::class, 'request'])->name('request');
        Route::post('/addrequest', [UserController::class, 'addrequest'])->name('addrequest');

    });

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
Route::get('/users',[App\Http\Controllers\SuperAdminController::class,'all_users']);
Route::post('/users', [App\Http\Controllers\SuperAdminController::class, 'adduser'])->name('super-admin.adduser');
// Route::post('/users', [App\Http\Controllers\SuperAdminController::class, 'deleteuser'])->name('super-admin.deleteuser');



//Route::get('/logout', function () {
//    Session::flush();
//    Auth::logout();
//    return redirect('/');
//})->name('logout');
