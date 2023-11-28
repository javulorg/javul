<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('issues/index', [\App\Http\Controllers\API\IssueController::class, 'index']);
Route::get('issues-unit/index', [\App\Http\Controllers\API\IssueController::class, 'unitView']);
Route::get('units/index', [\App\Http\Controllers\API\UnitController::class, 'index']);
Route::get('objectives/index', [\App\Http\Controllers\API\ObjectiveController::class, 'index']);
Route::get('objectives-unit/index', [\App\Http\Controllers\API\ObjectiveController::class, 'unitView']);
Route::get('tasks/index', [\App\Http\Controllers\API\TaskController::class, 'index']);
Route::get('tasks-unit/index', [\App\Http\Controllers\API\TaskController::class, 'unitView']);
Route::get('ideas/index', [\App\Http\Controllers\API\IdeaController::class, 'index']);
Route::get('ideas-unit/index', [\App\Http\Controllers\API\IdeaController::class, 'unitView']);


Route::get('watchlist-units/index', [\App\Http\Controllers\API\WatchListController::class, 'units']);
Route::get('watchlist-objectives/index', [\App\Http\Controllers\API\WatchListController::class, 'objectives']);
Route::get('watchlist-tasks/index', [\App\Http\Controllers\API\WatchListController::class, 'tasks']);
Route::get('watchlist-issues/index', [\App\Http\Controllers\API\WatchListController::class, 'issues']);


