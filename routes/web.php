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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register/{invitation}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register/{invitation}', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');

/*
 * User Routes
 */
Route::get('/users', 'UserController@index')->name('user.index');
Route::get('/user/{user}/edit', 'UserController@edit')->name('user.edit');
Route::patch('/user/{user}', 'UserController@update')->name('user.update');

/*
 * Invitation Routes
 */
Route::get('/user/invite', 'InvitationController@create')->name('invitation.create');
Route::post('/user/invite', 'InvitationController@store')->name('invitation.store');

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
Route::get('/tags', 'TagController@index')->name('tag.index');
Route::get('/tag/create', 'TagController@create')->name('tag.create');
Route::post('/tag', 'TagController@store')->name('tag.store');
Route::get('/tag/{tag}/edit', 'TagController@edit')->name('tag.edit');
Route::patch('/tag/{tag}', 'TagController@update')->name('tag.update');
Route::delete('/tag/{tag}', 'TagController@destroy')->name('tag.destroy');

/*
 * Guide Routes
 */
Route::get('/guides', 'GuideController@index')->name('guide.index');
Route::get('/guide/create', 'GuideController@create')->name('guide.create');
Route::post('/guide', 'GuideController@store')->name('guide.store');