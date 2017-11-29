<?php

class Application_Form_Utente_ResearchForm extends App_Form_Abstract
{
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('researchForm');
        
    	
        $this->addElement('text', 'nameResearchInput', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome:',
            'decorators' => $this->elementDecorators,
            ));
        
        $this->addElement('text', 'surnameResearchInput', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Cognome',
            'decorators' => $this->elementDecorators,
            ));
		
		

        $this->addElement('submit', 'submitCerca', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Cerca',
            'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'span')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
