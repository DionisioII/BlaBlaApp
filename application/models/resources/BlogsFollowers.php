<?php

class Application_Resource_BlogsFollowers extends Zend_Db_Table_Abstract
{
    protected $_name    = 'blogs_followers';
    protected $_primary  = 'blog_id';
    protected $_rowClass = 'Application_Resource_BlogsFollowers_Item';

	public function init()
    {
    }
       
    public function getFollowersById($Id)
    {
        return $this->fetchRow($this->select()->where('blog_id = ?', $Id));
    }	
    
    public function amIFollowingThisBlog($username,$id_blog)
    {
        $row = $this->fetchAll($this->select()->where("blog_id = '$id_blog' && username = '$username'"));
        
        if (count($row)!=0)
            return true;
        else
            return false;
    }
    
    public function addFollower($values)
	{
		return $this->insert($values);		
	}
    
     public function unfollowBlogs($me,$blogToUnfollow_id)
    {
        $where = $this->getAdapter()->quoteInto("username = '$me' AND blog_id = '$blogToUnfollow_id'",$me);
        $this->delete($where);

        
    }
    
    public function getFollowedBlogs($username)
    {
        $select = $this->select()->where("username = '$username'");
        
        $rows = $this->fetchAll($select);
        
        $blog_ids = array();
        
        foreach($rows as $row){
            array_push($blog_ids,$row->blog_id);
        }
        
        return $blog_ids;
        
        
    }
    
    
    
}