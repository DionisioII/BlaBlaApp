<?php

class Application_Model_User extends App_Model_Abstract
{ 

	public function __construct()
    {
    }

    public function changeLogInfo($values,$username)
	{
		return $this->getResource('User')->changeLogInfo($values,$username);
	}
    
    
	
	public function createBlog($values)
    {
    	return $this->getResource('Blogs')->createBlog($values);
		
    }
	
	public function createPost($values)
	{		
		return $this->getResource('Posts')->createPost($values);
	}
	
	public function getBlogsFromUsername($username)
	{		
		return $this->getResource('Blogs')->getBlogsFromUsername($username);
	}
	
	public function getBlogById($blog_id)
	{	
		return $this->getResource('Blogs')->getBlogById($blog_id);
	}
    
    public function getBlogFromPost($id_post)
    {
        return $this->getResource('Posts')->getBlogFromPost($id_post);
    }
	
	public function getPostsByBlogId($blog_id, $paged=null)
	{
		return $this->getResource('Posts')->getPostsByBlogId($blog_id, $paged);
	}
	
	public function getCommentsFromIdPost($blog_id)
	{
		return $this->getResource('Comments')->getCommentsByBlogId($blog_id);
	}
	
	public function addComment($values)
	{
		return $this->getResource('Comments')->addComment($values);		
	}
    
    public function addFollower($values)
	{
		return $this->getResource('BlogsFollowers')->addFollower($values);		
	}
	
	public function getUsrData($usrName)
	{
		return $this->getResource('User')->getUsrData($usrName);
	}
    
    public function getAuthorOfPost($idPost)
    {
        return $this->getResource('Posts')->getAuthorOfPost($idPost);
    }
    
    public function findUsername($value)
    {
    	return $this->getResource('User')->findUsername($value);
    }
    
    public function getAuthorOfBlog($idBlog)
    {
        return $this->getResource('Blogs')->getAuthorOfBlog($idBlog);
    }
	
	public function toggleVisibility($usr,$booleanValue)
	{
		return $this->getResource('User')->toggleVisibility($usr,$booleanValue);
	}
	
	public function getUsersBySearch($search = null, $name = null, $surname=null)
	{  
        
        if(!is_null($search))
		return $this->getResource('User')->getUsersBySearch($search);
        else
            return $this->getResource('User')->getUsersByReSearch($name,$surname);
	}
    
    
    public function getFollowersById($blog_id)
    {
        return $this->getResource('BlogsFollowers')->getFollowersById($blog_id);
    }
    
    public function friendRequest($requester,$requested)
    {
        return $this->getResource('FriendRequests')->friendRequest($requester,$requested);
    }
    
    
    public function notification($usrReceiver,$usrGenerator,$type = 'friendship_request',$id_blog = null, $id_post = null)
    {
        return $this->getResource('Notifications')->notification($usrReceiver,$usrGenerator,$type ,$id_blog , $id_post );
        
    }
    
    public function areTheyFriends($usr1,$usr2){
        if( $this->getResource('Friendships')->areTheyFriends($usr1,$usr2) || $usr1 == $usr2)
            return 1;
        elseif ($this->getResource('FriendRequests')->isThereARequestBetween($usr1,$usr2))
            return -1;
        else
            return 0;
    }
    
    public function amIFollowingThisBlog($username,$id_blog)
    {
        return $this->getResource('BlogsFollowers')->amIFollowingThisBlog($username,$id_blog);
    }
    
    public function getNotifications($username)
    {
        return $this->getResource('Notifications')->getNotifications($username);
    }
    
    public function getPostById($idPost)
    {
        return $this->getResource('Posts')->getPostById($idPost);
    }
	
    public function updateFriendRequest($bool,$adder,$receiver)
    {
                   
        return $this->getResource('FriendRequests')->updateFriendRequest($bool,$adder,$receiver);          
            
    }
    
    public function addFriends($adder,$receiver)
    {
        return $this->getResource('Friendships')->addFriends($adder,$receiver);
    }
    
    public function alterNotification($idNotification,$bool)
    {
        $this->getResource('Notifications')->alterNotification($idNotification,$bool);
    }
    
    public function getFriends($username)
    {
        return $this->getResource('Friendships')->getFriends($username);
    }
    
    public function unfollowBlogsOf($me,$usrToDelete)
    {
        $blogsToUnfollow = $this->getBlogsFromUsername($usrToDelete);
        foreach($blogsToUnfollow as $blog)
        {
            $this->getResource('BlogsFollowers')->unfollowBlogs($me,$blog->blog_id);
        }
       
    }
    
    public function unfollowBlog($me,$id_blog)
    {
        $this->getResource('BlogsFollowers')->unfollowBlogs($me,$id_blog);
    }
    
    public function removeFriend($me,$usrToRemove)
    {
        return $this->getResource("Friendships")->removeFriend($me,$usrToRemove);
    }
    
    public function deletePost($postToDelete)
    {
        return $this->getResource("Posts")->deletePost($postToDelete);
    }
    
    public function deleteBlog($blogToDelete)
    {
        $this->getResource("Posts")->deletePostsOfBlog($blogToDelete);
        return $this->getResource("Blogs")->deleteBlog($blogToDelete);
    }
    
    public function getHomeFeed($username,$paged = null)
    {
        $friendships = $this->getFriends($username);
        $friends = array();
        
        foreach($friendships as $friendship)
        {
            array_push($friends, $username == $friendship->friend_username ? $friendship->username : $friendship->friend_username  );
        }
        array_push($friends,$username);
        
        $BlockedBlogs = $this->getResource('BlackList')->getDeniedBlogs($username);
        $FollowedBlogs = $this->getResource('BlogsFollowers')->getFollowedBlogs($username);
        $myBlogIDS = $this->getResource('Blogs')->getMyBlogsIds($username);
        
        $FollowedBlogs = array_merge($FollowedBlogs,$myBlogIDS);
       
        return $this->getResource('Posts')->getPostsForHomeFeed($friends,$BlockedBlogs,$FollowedBlogs,$paged);
        
        
        
    }
    
    public function isUserBlocked($username,$blogId)
    {
        return $this->getResource('BlackList')->isThisUserBlocked($blogId,$username);
    }
    
    
    public function emptyBlacklist($blogId)
    {
        return $this->getResource('BlackList')->emptyBlacklist($blogId);
    
    }
    
    public function insertInBlacklist($blogId,$username)
    {
        return $this->getResource('BlackList')->insertInBlacklist($blogId,$username);
    }
    
    //settiamo lenotifiche come già viste
    public function updateNotification($username)
    {
        return $this->getResource('Notifications')->updateNotification($username);
    }
    
        
    public function checkNotification($username)
    {
        return $this->getResource('Notifications')->checkNotification($username);
    }
    
    
    
    
    
    
    
    
}