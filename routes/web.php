<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::middleware('two_factor_auth')->group(function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
});

Route::get('/two-fa', 'TwoFactorController@show2faForm');
Route::post('/two-fa', 'TwoFactorController@verifyToken');
Route::get('/payment','PaymentController@payment')->middleware('auth');
Route::post('/subscribe','PaymentController@subscribe')->middleware('auth');
// Route::get('/getCurrentPlan','PaymentController@getCurrentPlan');
Route::get('/dashboard/energy_service_1','HomeController@energy_service_1')->middleware('subscription-plan');
Route::get('/dashboard/energy_service_2','HomeController@energy_service_2')->middleware('subscription-plan');
Route::get('/dashboard/energy_service_3','HomeController@energy_service_3')->middleware('subscription-plan');
