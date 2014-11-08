<?php

class ServersController extends BaseController {

    /*
        服务器列表
    */

    public function allServers()
    {
        $all_servers = Servers::all();
        return View::make('servers/index',array('servers' => $all_servers));
    }

}
