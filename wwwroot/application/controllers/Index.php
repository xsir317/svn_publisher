<?php
class IndexController extends Yaf_Controller_Abstract {
   public function indexAction() {//默认Action
       $this->_view->assign("content", "Hello World");
   }
}