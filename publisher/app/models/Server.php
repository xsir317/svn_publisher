<?php

class Server extends Eloquent {

	protected $table = 'servers';
	public $timestamps = false;

	public function project()
	{
		return $this->belongsTo('Project','project_id');
	}

		// 测试服务器通迅
	// public static function pingServers($ip)
	// {
	// 	$result = array();
	// 	$fp = @fsockopen($ip, 873, $errno, $errstr, 5);
	// 	if (!$fp)
	// 	{
	// 		$result['result'] = false;
	// 		$result['msg'] = "failure: $errstr ($errno)";
	// 	}
	// 	else
	// 	{
	// 		fwrite($fp, "\n");
	// 		$ret = fread($fp, 8192);
	// 		if(preg_match('/RSYNCD:\s*\d+/',$ret))
	// 		{
	// 			$result['result'] = true;
	// 			$result['msg'] = "success: ".$ret;
	// 		}
	// 		elseif (preg_match ("/@ERROR:/i", $ret))
	// 		{
	// 			$result['result'] = false;
	// 			$result['msg'] = "error: ".$ret;
	// 		}
	// 		fclose($fp);
	// 	}
	// 	return $result;
	// }
}