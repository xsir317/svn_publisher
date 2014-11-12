<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function login()
	{
		$msg = '';
		if (Request::isMethod('post'))
		{
		    if (Auth::attempt(array('username' => Request::get('username'), 'password' => Request::get('password')), intval(Request::get('remember_me'))))
			{
				return Redirect::to('/');
			}
			else
			{
				$msg = '登入失败，用户名/密码错误';
			}
		}
		return View::make('login',array('msg'=>$msg));
	}
}
