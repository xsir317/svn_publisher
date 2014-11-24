<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function pj_ids()
	{
		if(!Session::has("pj_ids"))
		{
			$ids = array();
			if($this->is_superadmin)
			{
				$ids = Project::lists("id");
			}
			else
			{
				$ids = UserProjectRelation::where('uid',$this->id)->lists("prj_id");
			}
			Session::put("pj_ids",$ids);
		}
		return Session::get("pj_ids");
	}

	public function pj_is_mine($id)
	{
		return in_array($id, $this->pj_ids());
	}
}
