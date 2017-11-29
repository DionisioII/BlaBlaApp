<?php

class Zend_View_Helper_NotificationHelper extends Zend_View_Helper_Abstract
{   
    protected $_userModel;
	
    public function NotificationHelper ($notification)
    {
        
    	$this->_userModel=new Application_Model_User();
        
        $blogName = $notification->id_blog == null ? null : $this->getBlog($notification->id_blog);
        $postName = $notification->id_post == null ? null: $this->getPost($notification->id_post);
        $generator =$this->_userModel->getUsrData($notification->usr_generator);
        
		
		
        
        $values = array(
            "blogName"=>$blogName,
            "postName" =>$postName,
            "generatorName" => $generator['name'],
            "generatorSurname" => $generator['surname'],
            "timestamp" => $notification->timestamp
        );
		return $values;
	}
    
    public function getPost($idPost)
    {
        $result = $this->_userModel->getPostById($idPost);
        if(!is_null($result))
        return $result->title;
    }
    
    public function getBlog($idBlog)
    {
        $result = $this->_userModel->getBlogById($idBlog);
        if(!is_null($result))
        return $result->blog_name;
    }

	
}
