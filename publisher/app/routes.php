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

Route::get('/', function()
{
	return View::make('hello');
});
Route::get('home/welcome', 'HomeController@showWelcome');

Route::get('projects/index', 'ProjectsController@allProjects');
Route::any('projects/add', 'ProjectsController@editProject');
Route::any('projects/edit', 'ProjectsController@editProject');

Route::any('site/login','HomeController@login');

