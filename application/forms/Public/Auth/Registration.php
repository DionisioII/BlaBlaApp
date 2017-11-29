<?php
 
class Application_Form_Public_Auth_Registration extends App_Form_Abstract
{
		
	public function init()
    {
    	              
        $this->setMethod('post');
        $this->setName('registration');
        $this->setAttrib('enctype', 'multipart/form-data'); 
        $this->setAction('');  
		
		
		
    	
    	$this->addElement('text', 'usrname', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Username',
            'decorators' => $this->elementDecorators,
            
            )); 
			
			$this->addElement('text', 'name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Nome',
            'decorators' => $this->elementDecorators,
            
            )); 
			
			$this->addElement('text', 'surname', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Cognome',
            'decorators' => $this->elementDecorators,
            
            )); 
		
		
		$this->addElement('text', 'birthdate', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Data di nascita',
            'enabled' => false,
           
            'decorators' => $this->elementDecorators,
            
            )); 
		
		$this->addElement('textarea', 'description', array(
            
            'required'   => true,
            'label'      => 'parlaci un pò di te',
			'COLS'		=> '25',
			'ROWS'      => '6',
            'decorators' => $this->elementDecorators,
            
            ));
        
        $this->addElement('file', 'picImage', array(
        	'label' => 'immagine profilo',
        	
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 25102400),
        			array('Extension', false, array('jpg', 'png'))),
            'required'=> false,
            'decorators' => $this->fileDecorators,
        			));


		
		$this->addElement('password','passwd',array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'Password',
            'decorators' => $this->elementDecorators,
            ));
				
				
		$this->addElement('password','conf_password',array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('identical', false, array('token' => 'passwd'))
            ),
            'required'   => true,
            'ignore'   => true,
            'label'      => 'Conferma Password',
            'decorators' => $this->elementDecorators,
            ));
			
		
  
        
					
		
        $this->addElement('submit', 'subButton', array(
            'required' => false,
            'ignore'   => true,
			
            'label'    => 'inscriviti',
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