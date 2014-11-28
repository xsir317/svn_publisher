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

    public function servers()
    {
    	return $this->hasMany('Server','project_id','id');
    }

    //project临时目录
    public function getTempDir($_id)
    {
        return app_path().'/storage/pjfolder_'.intval($_id);
    }

    public function getUsernameAttribute()
    {
        if(!$this->auth_info) return '';
        $_tmp = json_decode($this->auth_info,true);
        return $_tmp['username'];
    }

    public function setUsernameAttribute($val)
    {
        $val = trim($val);
        $_tmp = $this->auth_info ? json_decode($this->auth_info,true) : array('username' =>'','password'=>'');
        $_tmp['username'] = $val;
        $this->auth_info = json_encode($_tmp);
        if($_tmp['username'] == '' && $_tmp['password'] == '')
            $this->auth_info = '';
    }

    public function getPasswordAttribute()
    {
        if(!$this->auth_info) return '';
        $_tmp = json_decode($this->auth_info,true);
        return $_tmp['password'];
    }

    public function setPasswordAttribute($val)
    {
        $val = trim($val);
        $_tmp = $this->auth_info ? json_decode($this->auth_info,true) : array('username' =>'','password'=>'');
        $_tmp['password'] = $val;
        $this->auth_info = json_encode($_tmp);
        if($_tmp['username'] == '' && $_tmp['password'] == '')
            $this->auth_info = '';
    }
}
