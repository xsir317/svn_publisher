<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function check_own($prj_id)
	{
		if(!Auth::user()->pj_is_mine($prj_id))
		{
			//if(Request::ajax())
			//{
			//	return Response::json(array("result"=>false,'msg' => '403 Unauthorized action'));
			//}
			//TODO 美化一下403返回页
			App::abort(403, 'Unauthorized action.');
		}
	}
}
