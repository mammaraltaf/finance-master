<?php

use Illuminate\Support\Facades\Route;
use App\Classes\Enums\UserTypesEnum;
use App\Http\Controllers\SuperAdminController;

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

Route::group(['middleware' => ['userType:' . UserTypesEnum::SuperAdmin , 'auth'],'prefix' => UserTypesEnum::SuperAdmin, 'as' => UserTypesEnum::SuperAdmin.'.'], function () {
    Route::get('/dashboard',[SuperAdminController::class,'dashboard'])->name('dashboard');
});
