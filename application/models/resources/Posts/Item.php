<?php

class Application_Resource_Posts_Item extends Zend_Db_Table_Row_Abstract
{   
	public function init()
    {
    }
    
    public function getBlog()
    {
        return $this->blog_id;
    }
    
}