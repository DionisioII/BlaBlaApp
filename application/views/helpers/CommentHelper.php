<?php

class Zend_View_Helper_CommentHelper extends Zend_View_Helper_Abstract
{   
    protected $_userModel;
	
    public function CommentHelper ($id_post)
    {
    	$this->_userModel=new Application_Model_User();
		$comments=$this->_userModel->getCommentsFromIdPost($id_post);
		//$blogs_array = array();
		return $comments;
	}

	
}
