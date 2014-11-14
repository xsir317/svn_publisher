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
    public function run($task)
    {
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
        //get the project record
        //get the project source path
        //run the checkout command
        //write the output to db, and status
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
    * 获得指定id的project的目录路径
    */
    private function _get_work_path($project_id)
    {
        $path = app_path().'/storage/project_base_'.$project_id;
        if(!file_exists($path))
        {
            mkdir($path);
        }
        return $path;
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
        switch ($type) {
            case 'svn':
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
                $cmdresult = `$cmd`;
                $loadxml = simplexml_load_string(trim($cmdresult), 'SimpleXMLElement', LIBXML_NOCDATA);
                $out = array();
                foreach($loadxml->children() as $elem)
                {
                    $out[(string)$elem->attributes()->revision] = $elem->author.":".$elem->msg;
                }
                if($last && isset($out[$last])) unset($out[$last]);
                return $out;
            case 'git':

                break;
            default:
                return null;
        }
    }
}
