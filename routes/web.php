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

// Route::get('/', function () {
//     return view('pages.register_form.register');
// });

Route::get('/', 'AuthController@index')->name('auth.login');

if(Route::middleware(['guest'])->group(function () {
    Route::get('/auth', 'AuthController@index')->name('auth.login');
    Route::post('/auth', 'AuthController@doLogin')->name('auth.doLogin');
}));

if(Route::middleware(['auth'])->group(function () {
    // Route::get('/backend/pendaftar', 'RegisterUserController@index')->name('pendaftar.index');
    // Route::post('/backend/pendaftar/ajax', 'RegisterUserController@dataTable')->name('pendaftar.DataTable');
    // Route::resource('/backend/pendaftar', 'RegisterUserController');
    Route::get('/pegadaian/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::resource('pegadaian', 'PegadaianController');
    Route::post('/backend/pegadaian/datatable', 'PegadaianController@datatables')->name('pegadaian.datatables');
    Route::get('/pegadaian/tebus/{pegadaian}', 'PegadaianController@tebus')->name('pegadaian.tebus');
    Route::get('/pegadaian/form_perpanjang/{pegadaian}', 'PegadaianController@form_perpanjang')->name('pegadaian.form_perpanjang');
    Route::put('/pegadaian/perpanjang/{pegadaian}', 'PegadaianController@perpanjang')->name('pegadaian.perpanjang');
    Route::get('/pegadaian/lelang/{pegadaian}', 'PegadaianController@lelang')->name('pegadaian.lelang');
    Route::get('/pegadaian/getPdf/{pegadaian}', 'PegadaianController@getReport')->name('pegadaian.getReport');
    Route::get('/pegadaian/downloadReport/{pegadaian}', 'PegadaianController@downloadReport')->name('pegadaian.downloadReport');
    Route::get('/pegadaian/print/{pegadaian}', 'PegadaianController@print')->name('pegadaian.print');
    // Route::get('/backend/pendaftar/create', 'RegisterUserController@create')->name('pendaftar.create');
    // Route::post('/backend/pendaftar/store', 'RegisterUserController@store')->name('pendaftar.store');
    // Route::get('/backend/pendaftar/edit/{register}', 'RegisterUserController@edit')->name('pendaftar.edit');
    // Route::put('/backend/pendaftar/update/{register}', 'RegisterUserController@update')->name('pendaftar.update');
    // Route::delete('/backend/pendaftar/destroy/{register}', 'RegisterUserController@destroy')->name('pendaftar.destroy');
    Route::get('/auth/logout', 'AuthController@logout')->name('auth.logout');
}));
