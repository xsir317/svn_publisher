<?php

class Server extends Eloquent {

	protected $table = 'servers';

	public $timestamps = false;

	public function project()
	{
		return $this->belongsTo('Project','project_id');
	}
}