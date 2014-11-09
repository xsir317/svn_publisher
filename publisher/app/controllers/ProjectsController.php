<?php

class ProjectsController extends BaseController {

	/*
		项目列表
	*/

	public function allProjects()
	{
		$all_projects = Project::all();
		return View::make('projects/index',array('projects' => $all_projects));
	}

    public function editProject()
    {
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
                if($project)
                {
                    if($project->src_addr != $src_addr)
                    {
                        //生成task 清理当前source目录
                        //生成task 重新checkout，注意前置任务
                    }
                }
                else
                {
                    $project = new Project;
                    //生成task checkout
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
                return Redirect::action('ProjectsController@allProjects');
            }
        }
        return View::make('projects/edit',array('project'=>$project,'error' => $error));
    }

}
