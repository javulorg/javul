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
Route::get('/account/logout', 'AccountController@logout');

Route::auth();


// get all request except login,register, forgot password, reset password and logout method
/*Route::any('{all}', function($all){

    $all = explode("/",$all);
    $method_name = $all[0];
    unset($all[0]);
    $param = array_values($all);

    return App::call('\App\Http\Controllers\UnitsController@' . $method_name, $param);

})->where('all', '(.*)');*/


// unit controller route
Route::post('units/get_state', 'UnitsController@get_state');
Route::post('units/get_city', 'UnitsController@get_city');
Route::any('units/create', 'UnitsController@create');
Route::any('units/edit/{unitid}', 'UnitsController@edit');
Route::get('units/delete_unit', 'UnitsController@delete_unit');
Route::any('units/{unitid}', 'UnitsController@view');


// objective controller route
Route::any('objectives/create/{unitid}', 'ObjectivesController@create');
Route::any('objectives/edit/{objectiveid}', 'ObjectivesController@edit');
Route::post('objectives/importance', 'ObjectivesController@add_importance');
Route::get('objectives/delete_objective', 'ObjectivesController@delete_objective');
Route::any('objectives/{objectiveid}', 'ObjectivesController@view');

// tasks controller route
Route::post('tasks/get_objective', 'TasksController@get_objective');
Route::any('tasks/create', 'TasksController@create');
Route::any('tasks/edit/{taskid}', 'TasksController@edit');
Route::any('tasks/remove_task_document', 'TasksController@remove_task_documents');
Route::get('tasks/delete_task', 'TasksController@delete_task');
Route::any('tasks/{taskid}', 'TasksController@view');


Route::resource('/issues','IssuesController');
Route::resource('/objectives','ObjectivesController');
Route::resource('/tasks','TasksController');
Route::resource('/units','UnitsController');
Route::resource('/user','UserController');




