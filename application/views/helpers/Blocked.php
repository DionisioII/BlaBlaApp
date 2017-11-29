<?php

class Zend_View_Helper_Blocked extends Zend_View_Helper_Abstract
{   
    protected $_userModel;
    
    protected $_authService;
	
    public function Blocked ($username,$blogId)
    {
        if (null === $this->_authService) {
            $this->_authService = new Application_Service_Auth();
        }
        
        if($this->_authService->getIdentity()->role != 'user')
            
            return false;
        
    	$this->_userModel=new Application_Model_User();
		$bool=$this->_userModel->isUserBlocked($username,$blogId);
		
        
		return $bool;
	}

	
}