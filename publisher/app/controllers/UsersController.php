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

	//添加、修改用户
	public function edit()
    {
    	if(!Auth::user()->is_superadmin)
		{
			App::abort(403, 'Unauthorized action.');
		}
        $id = intval(Input::get('id'));
        $user = null;
        if($id)
        {
            $user = User::find($id);
        }
        $error = '';
        if (Request::isMethod('post'))
        {
            $username = trim(Input::get('username'));
            $password = trim(Input::get('password'));
            $is_superadmin = intval(Input::get('is_superadmin'));
            $project_ids = Input::get('project');
            if($user)
            {
                if($password)
                {
                	$user->password = Hash::make($password);
                }
            }
            else
            {
            	if(!$username || !$password)
            	{
            		$error = '信息不完整！';
            	}
            	if(User::where("username",$username)->get())
            	{
            		$error = '用户名不能和已有用户重复';
            	}
            }
            if(!$error)
            {
                if(!$user)
                {
                    $user = new User;
                    $user->username = $username;
                    $user->password = Hash::make($password);
                }
                $user->is_superadmin = $is_superadmin;
                $user->save();
                //如果不是超级管理员，处理传过来的项目id数组
                if(!$user->is_superadmin)
                {

                }
                return Redirect::to('/users/index');
            }
        }
        return View::make('users/edit',array('user'=>$user,'error' => $error,'projects'=>Project::all()));
    }

	//改密码
	public function changepwd()
	{

	}
}