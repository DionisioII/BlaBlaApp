<?php

class Application_Form_Utente_Blog extends App_Form_Abstract
{
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('blogForm');
        $this->setAction('');
    	
        $this->addElement('text', 'title', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Titolo del blog:',
            'decorators' => $this->elementDecorators,
            ));
		
		$this->addElement('textarea', 'tema', array(
            
            'required'   => true,
            'label'      => 'Una breve presentazione del blog in cui ne specifichi il tema:',
			'COLS'		=> '25',
			'ROWS'      => '12',
            'decorators' => $this->elementDecorators,
            
            ));
		

        $this->addElement('submit', 'submitButton', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Crea Blog',
            'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
