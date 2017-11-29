<?php

class Application_Resource_DeletedFriendships extends Zend_Db_Table_Abstract
{
    protected $_name    = 'DeletedFriendships';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_DeletedFriendships_Item';

	public function init()
    {
    }
       
    public function getDeletedFriendshipByid($id)
    {
        return $this->fetchRow($this->select()->where('id = ?', $id));
    }	
}

