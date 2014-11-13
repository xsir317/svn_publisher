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

//项目
Route::get('projects/index', array('before' => 'auth', 'uses' => 'ProjectsController@allProjects'));
Route::any('projects/add'  , array('before' => 'auth', 'uses' => 'ProjectsController@editProject'));
Route::any('projects/edit' , array('before' => 'auth', 'uses' => 'ProjectsController@editProject'));
Route::get('projects/publish',array('before' => 'auth', 'uses' => 'ProjectsController@publish'));

//登入登出
Route::any('login','HomeController@login');
Route::get('logout',function(){
	Auth::logout();
	return Redirect::guest('login');
});

//各种测试
Route::get('passwd/test',function(){
    return  Hash::make('admin');
});
