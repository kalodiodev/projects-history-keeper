<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
 * Project Routes
 */
Route::get('/projects', 'ProjectController@index')->name('project.index');
Route::get('/project/create', 'ProjectController@create')->name('project.create');
Route::post('/project', 'ProjectController@store')->name('project.store');
Route::get('/project/{project}', 'ProjectController@show')->name('project.show');
Route::get('/project/{project}/edit', 'ProjectController@edit')->name('project.edit');
Route::patch('/project/{project}', 'ProjectController@update')->name('project.update');
Route::delete('/project/{project}', 'ProjectController@destroy')->name('project.destroy');

/*
 * Project Task Routes
 */
Route::get('/project/{project}/task/create', 'TaskController@create')->name('project.task.create');
Route::post('/project/{project}/task', 'TaskController@store')->name('project.task.store');
Route::get('/task/{task}/edit', 'TaskController@edit')->name('project.task.edit');
Route::patch('/task/{task}', 'TaskController@update')->name('project.task.update');
Route::delete('/task/{task}', 'TaskController@destroy')->name('project.task.destroy');

/*
 * Tag Routes
 */
Route::get('/tag/create', 'TagController@create')->name('tag.create');