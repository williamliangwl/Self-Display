<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/user/login', function(){
    return view('user.login');
});
Route::get('/user/register', function(){
    return view('user.register');
});
Route::get('/', 'UserController@index');
Route::get('/user', 'UserController@getAll');
Route::post('/user/login', 'UserController@login');
Route::post('/user/create', 'UserController@create');
Route::get('/user/logout', 'UserController@logout');
Route::post('/user/delete', 'UserController@delete');
Route::post('/user/update', 'UserController@update');

Route::get('/product', 'ProductController@index');
Route::post('/product/all', 'ProductController@getAll');
Route::post('/product/create', 'ProductController@create');
Route::post('/product/delete', 'ProductController@delete');
Route::post('/product/update', 'ProductController@update');

Route::get('/transaction/in', 'InTransactionController@getAll');
Route::post('/transaction/in/create', 'InTransactionController@create');

Route::get('/transaction/out', 'OutTransactionController@getAll');
Route::get('/transaction/out/previous', 'OutTransactionController@getPrevious');
Route::post('/transaction/out/create', 'OutTransactionController@create');

Route::get('/transaction/out/report/{transactionId}', 'OutTransactionController@showReport');
Route::get('/transaction/out/report/{transactionId}/download', 'OutTransactionController@downloadReport');
Route::get('/report', 'ReportController@index');
