<?php

class Application_Model_Public extends App_Model_Abstract
{ 

	public function __construct()
    {
    }

    
    
    public function getUserByName($info)
    {
    	return $this->getResource('User')->getUserByName($info);
    }
	
	public function saveUser($info)
    {
    	return $this->getResource('User')->saveUser($info);
    }

	public function findUsername($value)
    {
    	return $this->getResource('User')->findUsername($value);
    }
	
	public function createBlog($values)
    {
    	return $this->getResource('Blogs')->createBlog($values);
		
    }
	
	public function createPost($values)
	{		
		return $this->getResource('Posts')->createPost($values);
	}
}