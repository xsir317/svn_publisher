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
        return ;
    }

    /**
    *
    * 调用svn或git的log，获取版本号和更新文字日志
    */
    public function get_log($src_path,$type='svn',$limit=10,$offset=0)
    {

    }
}
