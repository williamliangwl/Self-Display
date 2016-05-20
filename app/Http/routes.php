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

Route::get('/', 'ProductController@getAll');
Route::get('/transaction', 'TransactionController@getAll');
Route::post('/product/create', 'ProductController@create');
Route::post('/transaction/create', 'TransactionController@create');
