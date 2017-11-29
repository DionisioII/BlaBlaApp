<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract
{
    protected $_name    = 'faq';
    protected $_primary  = 'id_faq';
    protected $_rowClass = 'Application_Resource_Faq_Item';

	public function init()
    {
    }
       
    public function getFaqById($Id)
    {
        return $this->fetchRow($this->select()->where('id_faq = ?', $Id));
    }	
}

