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
        if (Request::isMethod('post'))
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
            $project->title
            //manager
            //vcs_type
            //src_addr
            //ignore_files
            //comments
        }
        else
        {
            return View::make('projects/edit',array('project'=>$project));
        }
    }

}
