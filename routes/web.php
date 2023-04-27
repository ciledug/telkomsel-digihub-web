<?php

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

Route::get('/', function() { return view('auth.login'); });

Auth::routes();

Route::middleware('guest')->group(function() {
    Route::get('register', 'Auth\RegisterController@index');
    Route::post('register', 'Auth\RegisterController@register')->name('register');
});

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('transaction')->group(function() {
        Route::get('/', 'TransactionHistoryController@index')->name('transactions');
        Route::get('/{param}', 'TransactionHistoryController@show')->name('transactions.show');
    });

    Route::prefix('telco')->group(function() {
        Route::get('/v01', 'TelcoController@index')->name('telco_v01');
        Route::post('/v01', 'TelcoController@send')->name('telco_v01.send');

        Route::get('/v02', 'TelcoController@index_02')->name('telco_v02');
        Route::post('/v02', 'TelcoController@send_02')->name('telco_v02.send');
    });

    Route::put('profile/newpassword', 'ProfileController@updatePassword')->name('profile.newpassword');
    Route::resource('profile', 'ProfileController');
    
    Route::resource('apicalls', 'ApiCallsController');
});