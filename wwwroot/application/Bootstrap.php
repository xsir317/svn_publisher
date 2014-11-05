<?php
class Bootstrap extends Yaf_Bootstrap_Abstract{
	public function _initLocalLibrary() 
	{
		Yaf_Loader::getInstance()->registerLocalNamespace(array("Db"));
	}
}