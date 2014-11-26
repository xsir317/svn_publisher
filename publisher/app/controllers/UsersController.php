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
            $project_ids = Input::get('project',array());
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
            	if(User::where("username",$username)->count())
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
                    $owned_pj = $user->pj_ids();
                    foreach ($project_ids as $value) {
                        if(!in_array($value, $owned_pj))
                        {
                            $_tmp = new UserProjectRelation;
                            $_tmp->uid = $user->id;
                            $_tmp->prj_id = $value;
                            $_tmp->save();
                        }
                        else
                        {
                            unset($owned_pj[array_search($value, $owned_pj)]);
                        }
                    }
                    if(!empty($owned_pj))
                    {
                        UserProjectRelation::where('uid',$user->id)->whereIn('prj_id',$owned_pj)->delete();
                    }
                }
                return Redirect::to('/users/index');
            }
        }
        return View::make('users/edit',array('user'=>$user,'error' => $error,'projects'=>Project::all()));
    }

	//改密码
	public function changepwd()
	{
        $error = '';
        if (Request::isMethod('post'))
        {
            $oldpwd = trim(Input::get('oldpwd'));
            $newpwd = trim(Input::get('newpwd'));
            $repwd = trim(Input::get('repwd'));
            $project_ids = Input::get('project',array());
            if(!$oldpwd || !$newpwd)
            {
                $error = '信息填写不完整';
            }
            else if(!Auth::validate(array('username' => Auth::user()->username,'password'=> $oldpwd)))
            {
                $error = '旧密码不正确';
            }
            else if($newpwd != $repwd)
            {
                $error = '2次输入的新密码不一致！';
            }
            if(!$error)
            {
                Auth::user()->password = Hash::make($newpwd);
                Auth::user()->save();
                return Redirect::action('ProjectsController@allProjects');
            }
        }
        return View::make('users/pwd',array('error' => $error));
	}
}