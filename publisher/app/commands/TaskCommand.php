<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
//runs like php artisan tasks:run 123

class TaskCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'tasks:run';
	private $filelock = '';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This is a daemon process handles tasks in nebula.tasks table.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->filelock = app_path().'/storage/taskrun.pid';
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//启动之前先检查进程是否还活着,如果还活着咱就退
		if(file_exists($this->filelock) && posix_kill(intval(file_get_contents($this->filelock)),0))
		{
			die("pid exists,exit");
		}
		file_put_contents($this->filelock, getmypid());
		Tasks::where("status" , "execute")->update(array("status"=>"created"));
		while (true) {
			//获取任务，执行任务
			$tasks = Tasks::where('status' , 'created')->lists('id');
			foreach ($tasks as $_id)
			{
				$this->_run($_id);
			}
			sleep(1);
		}
	}

	private function _run($id)
	{
		$task = Tasks::find($id);
		//如果task不存在或者状态不对
		if(!$task || $task->status != 'created')
		{
			return;
		}
		//如果task有前置任务，而且前置任务没完成
		if($task->pre_task && $task->pre()->status != 'success')
		{
			return;
		}
		$task->status = 'execute';
		$task->save();
		$_func = sprintf('_run_%s',$task->type);
		$result = $this->$_func($task);
		$task->execute_time = date('Y-m-d H:i:s');
		$task->status = $result['result'] ? 'success':'failed';
		$task->output = $result['output'];
		$task->save();
	}

	private function _run_checkout($task)
	{
		//如果目录非空，失败
		//checkout到指定目录
		//返回
	}

	private function _run_update($task)
	{
		//根据命令，运行update指令
		//返回
	}

	private function _run_delete($task)
	{
		//清空指定目录
	}

	private function _run_rsync($task)
	{
		//运行rsync
	}


	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
