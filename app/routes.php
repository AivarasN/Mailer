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

Route::get('/', array(
                    'as' => 'frontendIndex',
                    'uses' => 'FrontendController@index'
));

Route::post('/registerAddress', array(
                    'as' => 'frontendRegisterAddress',
                    'uses' => 'FrontendController@registerAddress'
));


Route::group(array('prefix' => 'admin'), function()
{

    Route::get('/', array(
                        'as' => 'backendIndex',
                        'uses' => 'BackendController@index'
    ));

    Route::get('/new_email', array(
                        'as' => 'backendNewEmail',
                        'uses' => 'BackendController@newEmail'
    ));

    Route::get('/mail_queue', array(
                        'as' => 'backendMailQueue',
                        'uses' => 'BackendController@mailQueue'
    ));

    Route::get('/clean_inbox', array(
                        'as' => 'backendCleanInbox',
                        'uses' => 'BackendController@cleanInbox'
    ));

    Route::post('/admin/sendEmail', array(
                        'as' => 'backendSendEmail',
                        'uses' => 'BackendController@sendEmail'
    ));

});

