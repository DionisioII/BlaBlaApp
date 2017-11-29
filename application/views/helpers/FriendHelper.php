<?php

class Zend_View_Helper_FriendHelper extends Zend_View_Helper_Abstract
{   
    protected $_userModel;
	
    public function FriendHelper ($username)
    {
    	$this->_userModel=new Application_Model_User();
		$info=$this->_userModel->getUsrData($username);
		
		return $info;
    
    }

	
}
