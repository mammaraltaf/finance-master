<?php

use App\Models\Company;
use Illuminate\Support\Facades\Route;
use App\Classes\Enums\UserTypesEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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


Route::group(['middleware'=>'auth'],function (){
    /*Super Admin Routes*/
    Route::group([
        'middleware' => ['role:'.UserTypesEnum::SuperAdmin],
        'prefix' => UserTypesEnum::SuperAdmin,
        'as' => UserTypesEnum::SuperAdmin.'.',
    ], function () {
        Route::get('/dashboard', [App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/company', [App\Http\Controllers\SuperAdminController::class, 'company'])->name('company');
        Route::get('/edit-company/{id}', [App\Http\Controllers\SuperAdminController::class, 'editCompany'])->name('edit-company');
        Route::post('/edit-company/{id}', [App\Http\Controllers\SuperAdminController::class, 'editCompanyPost'])->name('edit-company-post');
        Route::post('/delete-company', [App\Http\Controllers\SuperAdminController::class, 'deleteCompany'])->name('delete-company');
    });
});



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/company', function () {
    $companies = Company::all();
    return view('super-admin.pages.company', compact('companies'));
});

Route::post('/company', [App\Http\Controllers\SuperAdminController::class, 'company'])->name('super-admin.company');
Route::post('/company', [App\Http\Controllers\SuperAdminController::class, 'companyPost'])->name('super-admin.companyPost');

Route::get('/logout', function () {
    Session::flush();
    Auth::logout();
    return redirect('/');
})->name('logout');

Auth::routes(
    [
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]
);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
