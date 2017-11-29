<?php

class Application_Model_Staff extends App_Model_Abstract
{ 

	public function __construct()
    {
    }

    
    
    public function getUserByName($info)
    {
    	return $this->getResource('User')->getUserByName($info);
    }
    
    public function getAllUsers()
    {
        return $this->getResource('User')->getAllUsers();
    }
    
    public function modifyUser($usrname,$column,$value)
    {
        return $this->getResource('User')->modifyUser($usrname,$column,$value);
    }
    
    public function deleteUser($username)
    {
         $blogs = $this->getBlogsFromUsername($username);
         foreach($blogs as $blog)
             $this->deleteBlog($blog->blog_id);
        $this->getResource('Friendships')->removeFriendshipsOfUser($username);
         
         return $this->getResource('User')->deleteUser($username);
    }
    
    public function deleteBlogsOfUser($user)
    {
        
    }
    
    public function deleteBlog($blogToDelete)
    {
        $this->getResource("Posts")->deletePostsOfBlog($blogToDelete);
        return $this->getResource("Blogs")->deleteBlog($blogToDelete);
    }
    
    public function getBlogsFromUsername($username)
	{		
		return $this->getResource('Blogs')->getBlogsFromUsername($username);
	}
    
    public function getfriendRequests($username)
    {
        return $this->getResource('FriendRequests')->getfriendRequests($username);
    }

}