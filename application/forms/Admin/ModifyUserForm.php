<?php

class Application_Form_Admin_ModifyUserForm extends App_Form_Abstract
{
		
	public function init()
    {
    	              
        $this->setMethod('post');
        $this->setName('modifyUserForm');
        $this->setAction('');  
		$this->setAttrib('enctype', 'multipart/form-data'); 

    	
       
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
        
        $this->addElement('text', 'data', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Data di nascita:',
            'readonly' => 'readonly',
            'decorators' => $this->elementDecorators,
            
            )); 
        $this->addElement('textarea', 'description', array(
            
            'required'   => false,
            'label'      => 'presentazione:',
			'COLS'		=> '25',
			'ROWS'      => '12',
            'decorators' => $this->elementDecorators,
            
            ));
			
        
        $this->addElement('select','role',array(
		'value'=>'user',
		'multiOptions'=>array(
						'user'=>'user','staff'=>'staff','admin'=>'admin'),
		'label'=>'Ruolo',
		'decorators'=> $this->elementDecorators,
		));          
		
			
		$this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25)),
                array('identical', false, array('token' => 'conf_pass'))
            ),
            'required'   => false,
            'label'      => 'password:',
            'decorators' => $this->elementDecorators,
            
            ));
			
		$this->addElement('password', 'conf_pass', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
               array('identical', false, array('token' => 'password'))
            ),
            'required'   => false,
            'label'      => 'conferma password:',
            'decorators' => $this->elementDecorators,
            
            ));


        $this->addElement('submit', 'insertButton', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'modifica',
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