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

Route::post(	'user', 'UserController@create'	);
Route::put(		'user', 'UserController@update' );
Route::get(		'user/{id}', 'UserController@read'	);


Route::post(	'event', 		  'NgoEventController@create'	);
Route::get(		'event/all/{id}', 'NgoEventController@readAll'		);
Route::get(		'event/{id}', 	  'NgoEventController@read'		);
Route::put(		'event', 		  'NgoEventController@update'	);
Route::delete(	'event/{id}', 	  'NgoEventController@delete'	);

Route::post(	'need', 		  'NeedController@create'	);
Route::get(		'need/all/{id}',  'NeedController@readAll'		);
Route::get(		'need/{id}', 	  'NeedController@read'		);
Route::put(		'need', 		  'NeedController@update'	);
Route::delete(	'need/{id}', 	  'NeedController@delete'	);



