<?php

class Application_Form_Utente_ProfiForm extends App_Form_Abstract
{
     
    
	public function init()
    
    {
    	              
        $this->setMethod('post');
        $this->setName('profiForm');
        $this->setAction('');  
		$this->setAttrib('enctype', 'multipart/form-data'); 
       
    	
		
		 $this->addElement('file', 'picImage', array(
        	'label' => 'Aggiorna la tua profipic:',
        	//'destination' => $this->setPath(),
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 25102400),
        			array('Extension', false, array('jpg','png'))),
            'decorators' => $this->fileDecorators,
        			));

    	
        $this->addElement('text', 'nome', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome:',
            'decorators' => $this->elementDecorators,
            
            ));
        
        $this->addElement('text', 'cognome', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Cognome:',
            'decorators' => $this->elementDecorators,
            
            ));
		
		$this->addElement('text', 'birthdate', array(
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
			
		$this->addElement('password', 'pass', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25)),
                array('identical', false, array('token' => 'conf_pass'))
            ),
            'required'   => false,
            'label'      => 'Nuova password:',
            'decorators' => $this->elementDecorators,
            
            ));
			
		$this->addElement('password', 'conf_pass', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
               array('identical', false, array('token' => 'pass'))
            ),
            'required'   => false,
            'label'      => 'conferma password:',
            'decorators' => $this->elementDecorators,
            
            ));


        $this->addElement('submit', 'cambia', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'conferma',
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