<?php

class Application_Resource_Posts extends Zend_Db_Table_Abstract
{
    protected $_name    = 'posts';
    protected $_primary  = 'id_post';
    protected $_rowClass = 'Application_Resource_Posts_Item';

	public function init()
    {
    }
       
    public function getPostById($Id)
    {
        return $this->fetchRow($this->select()->where('id_post = ?', $Id));
    }	
	
	public function createPost($values){
		return $this->insert($values);
	}
	
	public function getPostsByFriends($arrayFriends)
	{
		
	}
	
	public function getPostsByusername($username)
	{
		
	}
    
     public function getBlogFromPost($id_post)
    {
        return $this->fetchRow($this->select()->where('id_post = ?', $id_post))->blog_id;
    }
    
    public function deletePost($postToDelete)
    {
        $where = $this->getAdapter()->quoteInto("id_post = ?",$postToDelete);
        
        $this->delete($where);
    }
    
    public function deletePostsOfBlog($blogToDelete)
    {
        $where = $this->getAdapter()->quoteInto("blog_id = ?",$blogToDelete);
        
        $this->delete($where);
    }
	
    
    public function getAuthorOfPost($idPost)
    {
        return $this->fetchRow($this->select()->where('id_post = ?', $idPost))->username;
    }
	
	public function getPostsByBlogId($BlogId, $paged=null)
    {
        $select = $this->select()
        				->from('posts')
        				->where('blog_id IN(?)', $BlogId)
                        ->order('timestamp DESC');
        
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(2)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }
    
    public function getPostsForHomeFeed($arrayOfUserNames,$BlockedBlogs,$FollowedBlogs,$paged=null)
    {
        
        
        
        $select = $this->select()
        				->from('posts')
        				->where('username IN(?)', $arrayOfUserNames)
                        ->order('timestamp DESC');
                        //->where('blog_id not IN(?)',$BlockedBlogs)
                        //->where('blog_id IN(?)',$FollowedBlogs);
       
        if($BlockedBlogs != null && count($BlockedBlogs) > 0)
            $select = $select->where('blog_id not IN(?)',$BlockedBlogs);
        
        if($FollowedBlogs!= null && count($FollowedBlogs)>0 )
            $select = $select->where('blog_id IN (?)',$FollowedBlogs);
        else
            $select = $select->where('blog_id IN (?)',-1);
        
        
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(2)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
        
    }
}

