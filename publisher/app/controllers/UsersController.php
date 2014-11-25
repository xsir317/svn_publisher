<?php

class UsersController extends BaseController {
	//用户列表
	public function all()
	{
		if(!Auth::user()->is_superadmin)
		{
			App::abort(403, 'Unauthorized action.');
		}
		return View::make("users/list",array("users"=>User::all()));
	}

	//添加用户
	public function edit()
	{

	}

	//改密码
	public function changepwd()
	{

	}
}