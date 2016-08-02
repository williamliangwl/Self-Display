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
Route::get('/product/check', 'ProductController@check');
Route::post('/product/all', 'ProductController@getAll');
Route::post('/product/create', 'ProductController@create');
Route::post('/product/delete', 'ProductController@delete');
Route::post('/product/update', 'ProductController@update');

Route::get('/transaction/in', 'InTransactionController@getAll');
Route::post('/transaction/in/create', 'InTransactionController@create');

Route::get('/transaction/out', 'OutTransactionController@getAll');
Route::get('/transaction/out/previous', 'OutTransactionController@getPrevious');
Route::post('/transaction/out/create', 'OutTransactionController@create');
Route::get('/transaction/out/buyer', function(){
    return view('transaction.out.branch.find');
});
Route::post('/transaction/out/buyer/', 'OutTransactionController@getBuyerTransaction');

Route::get('/transaction/out/report/{transactionId}', 'OutTransactionController@showReport');
Route::get('/transaction/out/report/{transactionId}/download', 'OutTransactionController@downloadReport');

Route::get('/report/daily', 'ReportController@dailyReport');
Route::get('/report/weekly', 'ReportController@weeklyReport');

Route::get('/expense', 'ExpenseController@index');
Route::post('/expense/create', 'ExpenseController@create');
Route::post('/expense/delete', 'ExpenseController@delete');
Route::post('/expense/update', 'ExpenseController@update');

Route::get('/cash-expense', 'CashExpenseController@index');
Route::post('/cash-expense/create', 'CashExpenseController@create');
Route::post('/cash-expense/delete', 'CashExpenseController@delete');
Route::post('/cash-expense/update', 'CashExpenseController@update');

Route::post('/buyer/get', 'BuyerController@get');
Route::post('/buyer/create', 'BuyerController@create');