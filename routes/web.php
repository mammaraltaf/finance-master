<?php

use App\Models\Company;
use Illuminate\Support\Facades\Route;
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
});

Route::get('/company', function () {
    $companies = Company::all();
    return view('super-admin.pages.company', compact('companies'));
});

Route::post('/company', [App\Http\Controllers\SuperAdminController::class, 'company'])->name('super-admin.company');
Route::post('/company', [App\Http\Controllers\SuperAdminController::class, 'companyPost'])->name('super-admin.companyPost');

Auth::routes(
    [
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//user routes
Route::get('/users',[App\Http\Controllers\SuperAdminController::class,'all_users']);
Route::post('/users', [App\Http\Controllers\SuperAdminController::class, 'adduser'])->name('super-admin.adduser');
// Route::post('/users', [App\Http\Controllers\SuperAdminController::class, 'deleteuser'])->name('super-admin.deleteuser');


