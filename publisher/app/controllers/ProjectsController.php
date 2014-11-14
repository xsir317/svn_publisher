<?php

class ProjectsController extends BaseController {

	/*
		项目列表
	*/
	public function allProjects()
	{
        //TODO 根据用户权限筛选
		$all_projects = Project::all();
		return View::make('projects/index',array('projects' => $all_projects));
	}

    public function editProject()
    {
        //TODO 根据用户权限判断
        $id = Input::get('id');
        $project = null;
        if($id)
        {
            $project = Project::find($id);
        }
        $src_addr = trim(Input::get('src_addr'));
        $error = '';
        if (Request::isMethod('post'))
        {
            if(!trim(Input::get('title')))
            {
                $error = '请填写标题';
            }
            if(!trim(Input::get('manager')))
            {
                $error = '请填写项目管理员';
            }
            if(!trim(Input::get('src_addr')))
            {
                $error = '请填写源码地址';
            }
            if(!$error)
            {
                $project_created = false;
                if($project)
                {
                    if($project->src_addr != $src_addr)
                    {
                        //生成task 清理当前source目录
                        $clean_task = Task::create('delete',Auth::id(),array('project_id'=>$project->id));
                        //生成task 重新checkout，注意前置任务
                        Task::create('checkout',Auth::id(),array('project_id'=>$project->id),$clean_task);
                    }
                }
                else
                {
                    $project = new Project;
                    $project_created = true;
                }
                $project->title = trim(Input::get('title'));
                $project->manager = trim(Input::get('manager'));
                $project->vcs_type = trim(Input::get('vcs_type'));
                $project->src_addr = $src_addr;
                $project->ignore_files = trim(Input::get('ignore_files'));
                $project->comments = trim(Input::get('comments'));
                if(!in_array($project->vcs_type, Project::$vcs_types))
                {
                    $project->vcs_type = array_pop(Project::$vcs_types);
                }
                $project->save();
                if($project_created)
                {
                    //生成task checkout
                    Task::create('checkout',Auth::id(),array('project_id'=>$project->id));
                }
                return Redirect::action('ProjectsController@allProjects');
            }
        }
        return View::make('projects/edit',array('project'=>$project,'error' => $error));
    }


    public function publish()
    {
        //TODO 根据用户权限判断
        $id = intval(Input::get('id'));
        $project = Project::with('servers')->find($id);
        if(!$id || !$project)
        {
            return Response::view('errors.missing', array(), 404);
        }
        return View::make('projects/publish',array('project'=>$project));
    }

    public function getSrclog()
    {
        //TODO 根据用户权限判断
        $id = intval(Input::get('id'));
        $project = Project::with('servers')->find($id);
        if(!$id || !$project)
        {
            return Response::view('errors.missing', array(), 404);
        }
        $limit = intval(Input::get('limit'));
        $limit = $limit ? $limit : 10;
        $last = trim(Input::get('last'));
        $last = $last ? $last : '';
        $auth_info = empty($project->auth_info) ? null : json_decode($project->auth_info,true);
        $logs = Task::get_log($project->src_addr,$project->vcs_type,$auth_info,$limit,$last);
        $last_version = empty($logs) ? $last : last(array_keys($logs));
        return Response::json(array('logs' => $logs, 'last' => $last_version ));
    }
}
