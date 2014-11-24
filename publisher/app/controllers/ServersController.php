<?php

class ServersController extends BaseController {

    /*
        服务器列表
    */

    public function editServer()
    {
        $id = intval(Input::get('id'));
        $server = null;
        if($id)
        {
            $server = Server::find($id);
        }
        $project_id = intval(Input::get("project_id"));
        //权限
        if(!Auth::user()->pj_is_mine($project_id))
        {
            $project_id = 0;
        }
        $error = '';
        if (Request::isMethod('post'))
        {
            $title = trim(Input::get('title'));
            $ip = trim(Input::get('ip'));
            $rsync_name = trim(Input::get('rsync_name'));
            $comment = trim(Input::get('comment'));
            if(!$title || !$ip || !$rsync_name || !$project_id)
            {
                $error = "填写信息不完整";
            }
            if(!$error)
            {
                if(!$server)
                {
                    $server = new Server;
                    $server->last_pub_time = '0000-00-00 00:00:00';
                }
                $server->title = $title;
                $server->project_id = $project_id;
                $server->ip = $ip;
                $server->rsync_name = $rsync_name;
                $server->current_version = '';
                $server->comment = $comment;
                $server->save();
                return Redirect::action('ProjectsController@publish',array('id'=>$project_id));
            }
        }
        //当前用户拥有的所有项目
        $projects = Project::whereIn('id',Auth::user()->pj_ids())->get();
        $prj_list = array();
        foreach ($projects as $value) {
            $prj_list[$value->id] = $value->title;
        }
        return View::make('servers/edit',array('server'=>$server,'error' => $error,'project_id' => $project_id,'projects'=>$prj_list));
    }

}
