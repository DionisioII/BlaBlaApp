<?php

class Application_Form_Admin_InsertUserForm extends App_Form_Abstract
{
		
	public function init()
    {
    	              
        $this->setMethod('post');
        $this->setName('insertUserForm');
        $this->setAction('');  
		$this->setAttrib('enctype', 'multipart/form-data'); 

    	
        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'username:',
            'decorators' => $this->elementDecorators,
            
            ));
        $this->addElement('text', 'name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome:',
            'decorators' => $this->elementDecorators,
            
            ));
        
        $this->addElement('text', 'surname', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Cognome:',
            'decorators' => $this->elementDecorators,
            
            ));
        
        $this->addElement('select','role',array(
		'value'=>'user',
		'multiOptions'=>array(
						'staff'=>'staff','admin'=>'admin'),
		'label'=>'Ruolo',
		'decorators'=> $this->elementDecorators,
		));          
		
			
		$this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'password:',
            'decorators' => $this->elementDecorators,
            
            ));
			
		$this->addElement('password', 'conf_pass', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
               array('identical', false, array('token' => 'password'))
            ),
            'required'   => true,
            'label'      => 'conferma password:',
            'decorators' => $this->elementDecorators,
            
            ));


        $this->addElement('submit', 'insertButton', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'aggiungi utente',
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
?>