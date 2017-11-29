<?php

class Application_Resource_BlackList extends Zend_Db_Table_Abstract
{
    protected $_name    = 'blacklist';
    protected $_primary  = 'blog_id';
    protected $_rowClass = 'Application_Resource_BlackList_Item';

	public function init()
    {
    }
       
    
    public function isThisUserBlocked($id_blog,$username)
    {
        $row = $this->fetchAll($this->select()
                               ->where("blog_id = '$id_blog' 
        && username = '$username'"));
        
        
        return count($row);
        
    }
    
    public function getDeniedBlogs($username)
    {
        $select = $this->select()->where("username = '$username'");
        
        $rows = $this->fetchAll($select);
        
        $blog_ids = array();
        
        foreach($rows as $row){
            array_push($blog_ids,$row->blog_id);
        }
        
        return $blog_ids;
        
        
    }
    
    public function addElement($values)
	{
		return $this->insert($values);		
	}
    
    public function emptyBlacklist($blogId)
    {
        $where = $this->getAdapter()->quoteInto('blog_id = ?',$blogId);
        $this->delete($where);

    
    }
    
    public function insertInBlacklist($blogId,$username)
    {
        $array= array('blog_id'=>$blogId,
                       'username' => $username
                     );
        return $this->insert($array);	
    }
    
    
    
    
    
}