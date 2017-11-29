<?php

class Application_Resource_Blogs extends Zend_Db_Table_Abstract
{
    protected $_name    = 'blogs';
    protected $_primary  = 'blog_id';
    protected $_rowClass = 'Application_Resource_Blogs_Item';

	public function init()
    {
    }
       
    public function getBlogById($blogID)
    {
        return $this->fetchRow($this->select()->where('blog_id = ?', $blogID));
    }
	
	public function createBlog($values){
		$this->insert($values);
	}
    
    public function getNumberOfBlogs()
    {
        $result = $this->fetchAll();
        if(!is_null($result))
            return count($result);
        else
            return 0;
    }
    
    
    
	
	public function getBlogsFromUsername($username)
	{
		return $this->fetchAll($this->select()->where('username = ?', $username));
	}
    
    public function getMyBlogsIds($username)
    {
        $select = $this->select()->where("username = '$username'");
        
        $rows = $this->fetchAll($select);
        
        $blog_ids = array();
        
        foreach($rows as $row){
            array_push($blog_ids,$row->blog_id);
        }
        
        return $blog_ids;
        
        
    }
    
    public function getAuthorOfBlog($idBlog)
    {
        return $this->fetchRow($this->select()->where('blog_id = ?', $idBlog))->username;
    }
	
    public function deleteBlog($blogToDelete)
    {
        $where = $this->getAdapter()->quoteInto("blog_id = ?",$blogToDelete);
        
        $this->delete($where);
    }
    
    public function deleteBlogsOfUser($username)
    {
        $where = $this->getAdapter()->quoteInto("username = ?",$username);
        $this->delete($where);
    }
    
        
	
}

