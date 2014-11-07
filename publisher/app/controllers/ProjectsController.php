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

}
