<?php

class Zend_View_Helper_AreWeFriends extends Zend_View_Helper_Abstract
{   
    protected $_userModel;
	
    public function areWeFriends ($usr1,$usr2,$request=0)
    {
    	$this->_userModel=new Application_Model_User();
		$bool=$this->_userModel->areTheyFriends($usr1,$usr2);
        if ($bool == -1 && $request == 0)
            $bool = 0;
		
		return $bool;
	}

	
}
