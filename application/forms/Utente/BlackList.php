<?php

class Application_Form_Utente_BlackList extends App_Form_Abstract
{
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('blackListForm');
        $this->setAction('');
		
		 $this->addElement('select', 'blog_select', array(
            'label' => 'Blog:',
            'required' => true,
        	
            'decorators' => $this->elementDecorators,
        ));
		
		$this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));

       
    }
}
