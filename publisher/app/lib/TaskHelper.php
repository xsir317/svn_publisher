<?php
/**
* 这是整个任务系统的核心，是Web操作命令行、文件的所有逻辑
* 注册为facade
*/
namespace TaskCore;
class TaskHelper 
{
	private static $_error = '';

	public function getError()
	{
		return self::$_error;
	}

	private function err($msg)
	{
		self::$_error = $msg;
		return false;
	}


	public function create($action,$uid,$taskdata,$pre_task=0)
	{
		if(!isset(\Tasks::$types[$action]))
		{
			return $this->err('任务类型错误');
		}
		if(in_array($action,array('checkout', 'update', 'delete',)))
		{
			if(!isset($taskdata['project_id']))
			{
				return $this->err('需要project_id');
			}
		}
		if(in_array($action,array('rsync')))
		{
			if(!isset($taskdata['server_id']))
			{
				return $this->err('需要server_id');
			}
		}
		$record = new \Tasks;
		$record->type = $action;
		$record->command = json_encode($taskdata);
		$record->pre_task = $pre_task;
		$record->status = 'created';
		$record->create_time = date('Y-m-d H:i:s');
		$record->execute_time = '0000-00-00 00:00:00';
		$record->output = '';
		$record->uid = $uid;
		$record->save();
		return $record->id;
	}

	/**
	 * 
	 * 针对一个任务，调用适当方法进行处理，处理后回写执行结果
	 * 任务种类 'checkout', 'update', 'delete', 'rsync'
	 * 
	*/
    public function run($task_id)
    {
        $task = \Tasks::find($task_id);
    	if($task->status != 'created')
        {
            return $this->err('供执行的任务必须是初始状态');
        }
    	//TODO 检查前置任务pre_task 的状态
        if($task->pre_id)
        {
            $pre_task = \Tasks::find($task->pre_id);
            if(!$pre_task || $pre_task->status != 'success')
            {
                return $this->err('前置任务尚未完成，跳过此任务');
            }
        }
        $task->status = 'execute';
        $task->execute_time = date('Y-m-d H:i:s');
        $task->save();
        $func = '_run'.ucfirst($task->type);
        return $this->$func($task);
    }

    /**
     * 针对一个项目Project，获取最新版本库，放到指定目录，并将版本号回写到Project记录中。
     * 
    */
    private function _runCheckout($task)
    {
        if($task->project_id)
        {
            $pj_dir = Project::getTempDir($task->project_id);//项目代码存放目录
            if(!file_exists($pj_dir))
            {
                if(!mkdir($pj_dir,0750))
                {
                    return array('result'=>false,'output'=>"mkdir $pj_dir failed!");
                }
            }
            $project = Project::find($project_id);
            switch ($project->vcs_type) {
                case 'svn':
                    if(function_exists('svn_checkout'))
                    {
                        $result = svn_checkout($project->svn_addr,$pj_dir);
                        return array('result'=>$result,'output'=> implode("\n", $output));
                    }
                    else
                    {
                        $command = "svn checkout {$project->svn_addr} {$pj_dir} ";
                        $command .= " --no-auth-cache --username={$project->username} --password={$project->password}";
                        exec($command,$output,$return_var);
                        return array('result'=>($return_var == 0),'output'=> implode("\n", $output));
                    }
                    break;
                case 'git':
                    break;
                default:
                    # code...
                    break;
            }
        }
        //返回
    }

    /**
     * 针对一个项目，将其发布代码目录更新到指定版本，并将版本号回写到Project记录中。
     * 
    */
    private function _runUpdate($task)
    {

    }


    /**
     * 针对一个项目，将其发布代码目录清空，并将Project记录中的版本号置空。
     * 
    */
    private function _runDelete($task)
    {

    }

    /**
     * 
     * 针对一个服务器，调用Rsync将项目发布到线上，然后回写Server的版本和更新结果
     * 
    */
    private function _runRsync($task)
    {

    }

    /**
    *
    * 调用svn或git的log，获取版本号和更新文字日志
    * @param $src_path 地址
    * @param $type='svn' svn或者git
    * @param $auth=null  帐号密码
    * @param $limit=10 数量
    * @param $last=''  从某版本开始查询
    */
    public function get_log($src_path,$type='svn',$auth=null,$limit=10,$last='')
    {
        //如果last没指定，则取最新limit个
        //如果指定了，则取limit+1个，去掉last
        $out = array();
        switch ($type) {
            case 'svn':
                if(function_exists('svn_log'))
                {
                    if($auth)
                    {
                        svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, $auth['username']);
                        svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, $auth['password']);
                    }
                    if($last)
                    {
                        $_return = svn_log($src_path,$last,1,($limit+1),SVN_STOP_ON_COPY);
                    }
                    else
                    {
                        $_return = svn_log($src_path,null,null,$limit,SVN_STOP_ON_COPY);
                    }
                    foreach ($_return as $_log) {
                        $out[$_log['rev']] = "{$_log['author']}:{$_log['msg']}";
                    }
                }
                else
                {
                    $cmd = "svn log {$src_path} --xml --non-interactive --stop-on-copy";
                    if(!empty($auth))
                    {
                        $cmd .= " --username {$auth['username']} --password {$auth['password']}";
                    }
                    if($last)
                    {
                        $cmd .= " -r {$last}:1 --limit ".($limit +1);
                    }
                    else
                    {
                        $cmd .= " --limit {$limit}";
                    }
                    $cmdresult = exec($cmd);
                    /*//$cmdresult = '<?xml version="1.0" encoding="UTF-8"?><log><logentry revision="530"><author>测试用户</author><msg>测试文字</msg></logentry><logentry revision="529"><author>测试用户</author><msg>测试文字</msg></logentry></log>';*/
                    $loadxml = simplexml_load_string(trim($cmdresult), 'SimpleXMLElement', LIBXML_NOCDATA);
                    foreach($loadxml->children() as $elem)
                    {
                        $out[(string)$elem->attributes()->revision] = $elem->author.":".$elem->msg;
                    }
                }
                if($last && isset($out[$last])) unset($out[$last]);
                return $out;
            case 'git':

                break;
            default:
                return null;
        }
    }

    private function get_current_version($src_path,$type='svn')
    {
        
    }
}
