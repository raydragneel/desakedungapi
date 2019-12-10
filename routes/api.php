<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [ 'as' => 'login', 'uses' => 'UserController@login']);


Route::group(['middleware' => ['auth:api']], function () {
	// User
	Route::put('/user/{nik}','UserController@setUser');
	Route::get('/user/{nik}','UserController@getUser');

	// Aduan
	Route::get('/aduan/jenis','AduanController@jenisAduan');
	Route::get('/aduan','AduanController@getAduan');
	Route::post('/aduan','AduanController@createAduan');

	// Pelayanan
	Route::get('/pelayanan/jenis','PelayananController@JenisPelayanan');
	Route::post('/pelayanan','PelayananController@createPelayanan');
});
