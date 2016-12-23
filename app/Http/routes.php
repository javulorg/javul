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
Route::get('/account', 'AccountController@index');
Route::get('/account/logout', 'AccountController@logout');
Route::post('/account/upload_profile', 'AccountController@upload_profile');
Route::post('/account/remove_profile_pic', 'AccountController@remove_profile_pic');
Route::any('/userprofiles/{user_id}','UserController@user_profile');
Route::any('/userprofiles/{user_id}/{slug}','UserController@user_profile');
Route::get('/my_tasks','UserController@my_tasks');
Route::get('/my_contributions','UserController@my_contribution');
Route::post('/account/withdraw','AccountController@withdraw');
Route::post('/account/paypal_email_check','AccountController@paypal_email_check');
Route::post('/account/update-creditcard','AccountController@update_creditcard');
Route::any('/notification/success','NotificationController@success_payment');
Route::post('/account/update_personal_info','AccountController@update_personal_info');
Route::any('/notification/error','NotificationController@error_payment');
Route::any('/notification/ipn_payment','NotificationController@ipn_payment');
Route::any('/notification/ipn_donation','NotificationController@ipn_donation');
Route::get('/activities','HomeController@global_activities');
Route::get('/get_unit_site_activity_paginate','HomeController@get_unit_site_activity_paginate');
Route::get('/get_site_activity_paginate','HomeController@get_site_activity_paginate');
Route::get('/add_to_watchlist','HomeController@add_to_watchlist');
Route::get('/remove_from_watchlist','HomeController@remove_from_watchlist');
Route::get('/my_watchlist','HomeController@my_watchlist');
Route::any('/site_admin','HomeController@site_admin');
Route::any('/skills/get_skill_paginate','HomeController@get_skill_paginate');
Route::any('/category/get_category_paginate','HomeController@get_category_paginate');
Route::any('/area_of_interest/get_area_of_interest_paginate','HomeController@get_area_of_interest_paginate');

Route::any('job_skills/get_skills','HomeController@get_skills');
Route::any('job_skills/get_next_level_skills','HomeController@get_next_level_skills');
Route::get('job_skills/approve_skill','HomeController@approveSkill');
Route::get('job_skills/discard_skill_changes','HomeController@discard_skill_change');
Route::get('job_skills/browse_skills','HomeController@browse_skills');
Route::any('/job_skills/add','HomeController@skill_add');
Route::any('/job_skills/delete','HomeController@skill_delete');
Route::any('/job_skills/edit','HomeController@skill_edit');

Route::any('unit_category/get_categories','HomeController@get_categories');
Route::any('unit_categories/get_next_level_categories','HomeController@get_next_level_categories');
Route::any('unit_category/add','HomeController@category_add');
Route::any('unit_category/edit','HomeController@category_edit');
Route::any('unit_category/delete','HomeController@category_delete');
Route::get('unit_category/approve_category','HomeController@approve_category');
Route::get('unit_category/discard_category_changes','HomeController@discard_category_changes');
Route::get('unit_category/browse_categories','HomeController@browse_categories');


Route::any('area_of_interest/get_area_of_interest','HomeController@get_area_of_interest');
Route::any('area_of_interest/get_next_level_area_of_interest','HomeController@get_next_level_area_of_interest');
Route::any('area_of_interest/add','HomeController@area_of_interest_add');
Route::any('area_of_interest/edit','HomeController@area_of_interest_edit');
Route::any('area_of_interest/delete','HomeController@area_of_interest_delete');
Route::get('area_of_interest/approve_area_of_interest','HomeController@approve_area_of_interest');
Route::get('area_of_interest/discard_area_of_interest_changes','HomeController@discard_area_of_interest_changes');
Route::get('area_of_interest/browse_area_of_interest','HomeController@browse_area_of_interest');

Route::any('/category/add','HomeController@category_add');

Route::any('/area_of_interest/add','HomeController@area_of_interest_add');
//Route::any('/job_skills/{skill_id}/edit','HomeController@skill_edit');
Route::any('/category/{category_id}/edit','HomeController@category_edit');
Route::any('/area_of_interest/{area_id}/edit','HomeController@area_of_interest_edit');
//Route::get('/job_skills/{skill_id}','HomeController@skill_view');
Route::get('/category/{category_id}','HomeController@category_view');
Route::any('/area_of_interest/{area_id}','HomeController@area_of_interest_view');

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
Route::any('units/add', 'UnitsController@create');
Route::get('unit/set_featured_unit','UnitsController@set_featured_unit');
Route::any('units/{unitid}/edit', 'UnitsController@edit');
Route::post('units/get_state', 'UnitsController@get_state');
Route::post('units/get_city', 'UnitsController@get_city');
Route::post('units/get_featured_unit','UnitsController@get_featured_unit');
Route::get('units/delete_unit', 'UnitsController@delete_unit');
Route::get('units/available_bid/{unit_id}','UnitsController@available_bids');
Route::any('units/{unitid}/{slug}', 'UnitsController@view');
Route::get('units/get_units_paginate', 'UnitsController@get_units_paginate');


// objective controller route
Route::any('objectives/add','ObjectivesController@create');
Route::any('objectives/{unitid}/add', 'ObjectivesController@create');
Route::any('objectives/{objectiveid}/edit', 'ObjectivesController@edit');
Route::post('objectives/importance', 'ObjectivesController@add_importance');
Route::get('objectives/delete_objective', 'ObjectivesController@delete_objective');
Route::get('objectives/{unitid}/lists', 'ObjectivesController@lists');
Route::any('objectives/{objectiveid}/{slug}', 'ObjectivesController@view');
Route::get('objectives/get_objectives_paginate', 'ObjectivesController@get_objectives_paginate');

// tasks controller route
Route::any('tasks/add', 'TasksController@create');
Route::any('tasks/{unitid}/{objectiveid}/add', 'TasksController@create');
Route::post('tasks/get_objective', 'TasksController@get_objective');
Route::post('tasks/get_tasks', 'TasksController@get_tasks');
Route::get('tasks/get_biding_details','TasksController@get_biding_details');
Route::get('tasks/check_assigned_task', 'TasksController@check_assigned_task');
Route::get('tasks/accept_offer', 'TasksController@accept_offer');
Route::get('tasks/reject_offer', 'TasksController@reject_offer');
Route::any('tasks/remove_task_document', 'TasksController@remove_task_documents');
Route::any('tasks/submit_for_approval', 'TasksController@submit_for_approval');
Route::get('tasks/delete_task', 'TasksController@delete_task');
Route::get('tasks/assign', 'TasksController@assign_task');
Route::any('tasks/cancel_task/{task_id}','TasksController@cancel_task');
Route::any('tasks/complete_task/{task_id}','TasksController@complete_task');
Route::any('tasks/re_assign/{task_id}','TasksController@re_assign');
Route::post('tasks/mark_task_complete/{task_id}','TasksController@mark_as_complete');
Route::any('tasks/{taskid}/edit', 'TasksController@edit');
Route::any('tasks/bid_now/{task_id}','TasksController@bid_now');
Route::get('tasks/{unitid}/lists', 'TasksController@lists');
Route::any('tasks/{taskid}/{slug}', 'TasksController@view');
Route::get('tasks/get_tasks_paginate', 'TasksController@get_tasks_paginate');


Route::get('funds/donate/unit/{unit_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/donate/objective/{objective_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/donate/task/{task_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/donate/user/{user_id}','FundsController@donate_to_unit_objective_task');
Route::get('funds/get-card-name','FundsController@get_card_name');
Route::post('funds/donate-amount','FundsController@donate_amount');
Route::get('funds/success','FundsController@success');
Route::get('funds/cancel','FundsController@cancel');

Route::get('issues/remove_issue_document','IssuesController@remove_document');
Route::get('/issues/get_issues_paginate','IssuesController@get_issues_paginate');
Route::any('/issues/add','IssuesController@add');
Route::post('issues/importance','IssuesController@add_importance');
Route::post('issues/sort_issue','IssuesController@sort_issues');
Route::any('issues/{unit_id}/add','IssuesController@create');
Route::any('issues/{unit_id}/lists','IssuesController@lists');
Route::any('issues/{issue_id}/view','IssuesController@view');
Route::any('issues/{issue_id}/edit','IssuesController@edit');
Route::any('issues/{unit_id}/{objective_id}/add','IssuesController@create');
Route::any('issues/{unit_id}/{objective_id}/{task_id}/add','IssuesController@create');


Route::post('alerts/set_alert','AlertsController@set_alert');

Route::resource('/issues','IssuesController');
Route::resource('/objectives','ObjectivesController');
Route::resource('/tasks','TasksController');
Route::resource('/units','UnitsController');
Route::resource('/user','UserController');
Route::resource('/funds','FundsController');
Route::resource('/alerts','AlertsController');




