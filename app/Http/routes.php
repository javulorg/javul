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

/*Route::get('objectives', 'ObjectivesController@index');
Route::get('issues', 'IssuesController@index');
Route::get('tasks', 'TasksController@index');
Route::get('units', 'UnitsController@index');
Route::get('user', 'UserController@index');*/

Route::resource('issues','IssuesController');
Route::resource('objectives','ObjectivesController');
Route::resource('tasks','TasksController');
Route::resource('units','UnitsController');
Route::resource('user','UserController');

/*Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'issues'=>'IssuesController',
    'objectives'=>'ObjectivesController',
    'tasks'=>'TasksController',
    'units'=>'UnitsController',
    'user'=>'UserController'
]);*/
Route::auth();


