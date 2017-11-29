<?php

class Zend_View_Helper_UserHelper extends Zend_View_Helper_Abstract
{   
    protected $_userModel;
	
    public function userHelper ($username)
    {
    	$this->_userModel=new Application_Model_User();
		$blogs=$this->_userModel->getBlogsFromUsername($username);
		
		return $blogs;
	}

	
}
