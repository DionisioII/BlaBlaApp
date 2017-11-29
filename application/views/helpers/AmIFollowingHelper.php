<?php

class Zend_View_Helper_AmIFollowingHelper extends Zend_View_Helper_Abstract
{   
    protected $_userModel;
	
    public function AmIFollowingHelper ($username,$id_blog)
    {
    	$this->_userModel=new Application_Model_User();
		$bool=$this->_userModel->amIFollowingThisBlog($username,$id_blog);
		//$blogs_array = array();
		return $bool;
	}

	
}
