<?php

class Application_Resource_Comments extends Zend_Db_Table_Abstract
{
    protected $_name    = 'comments';
    protected $_primary  = 'id_comment';
    protected $_rowClass = 'Application_Resource_Comments_Item';

	public function init()
    {
    }
       
    public function getCommentById($Id)
    {
        return $this->fetchRow($this->select()->where('id_comment = ?', $Id));
    }	
	
	public function addComment($values){
		return $this->insert($values);
	}
	
	
	
	public function getCommentsByBlogId($idPost, $total= null)
    {
        $select = $this->select()
        				->from('comments')
        				->where('id_post IN(?)', $idPost);
        
		if (null !== $total) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(2)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    } 
}

