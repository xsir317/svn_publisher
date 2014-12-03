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
		if(file_exists($this->filelock) && function_exists('posix_kill') && posix_kill(intval(file_get_contents($this->filelock)),0))
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
				//TaskHelper
				Task::run($_id);
			}
			sleep(1);
		}
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
