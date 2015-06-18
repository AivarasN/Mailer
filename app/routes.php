<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'FrontendController@index');
Route::get('/admin', 'BackendController@index');
Route::get('/admin/new_email', 'BackendController@newEmail');
Route::get('/admin/mail_queue', 'BackendController@mailQueue');
Route::get('/admin/clean_inbox', 'BackendController@cleanInbox');

Route::post('/registerAddress', 'FrontendController@registerAddress');
Route::post('/admin/sendEmail', 'BackendController@sendEmail');
