<?php

class Project extends Eloquent {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';
    public $timestamps = false;

    //自定义一些enum字段的含义
    public static $vcs_types = array('svn' => 'SVN','git' => 'GIT');

}
