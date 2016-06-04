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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::auth();

Route::post('units/get_state', 'UnitsController@get_state');
Route::post('units/get_city', 'UnitsController@get_city');
Route::any('units/create', 'UnitsController@create');
Route::any('units/edit/{unitid}', 'UnitsController@edit');
Route::any('units/{unitid}', 'UnitsController@view');

Route::resource('/issues','IssuesController');
Route::resource('/objectives','ObjectivesController');
Route::resource('/tasks','TasksController');
Route::resource('/units','UnitsController');
Route::resource('/user','UserController');




