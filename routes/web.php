<?php

use Illuminate\Support\Facades\Auth;
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






Auth::routes();


Route::get('/', 'CoronaController@index')->name('home');
Route::get('/getData', 'CoronaController@getData')->name('getData');
Route::get('/provincechart', 'CoronaController@provinceChart');
Route::get('/provinceLowestChart', 'CoronaController@provinceLowestChart');

Route::post('/storeContact', 'CoronaController@storeContact')->name('store-contact');
Route::post('/deleteContact/{id}', 'CoronaController@delete')->name('delete-contact');
//Auth::routes();

Route::middleware(['cors'])->group(function () {
    Route::get('coronas-list', 'CoronaController@coronaList'); 
});

// Route::get('/home', 'HomeController@index')->name('home');
