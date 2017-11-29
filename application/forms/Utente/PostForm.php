<?php

class Application_Form_Utente_PostForm extends App_Form_Abstract
{
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('postForm');
        $this->setAction('');
		$this->setAttrib('enctype', 'multipart/form-data'); 
		
		$this->addElement('textarea', 'postarea', array(
            
            'required'   => true,
            
			'COLS'		=> '40',
			'ROWS'      => '9',
            'decorators' => $this->elementDecorators
            
            ));
		
		$this->addElement('text', 'blog_id_input', array(
           
            'required'   => false,
			'hidden'=> true,
            
            ));
        
    	
        $this->addElement('text', 'postTitle', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', true, array(3, 25))
            ),
            'required'   => true,
            'label'      => 'titolo:',
            'decorators' => $this->elementDecorators,
            ));
		
		 
			 $this->addElement('file', 'postImage', array(
        	'label' => 'Foto Allegata:',
        	//'destination' => APPLICATION_PATH . '/../public/images/postphotos',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 11102400),
        			array('Extension', false, array('jpg','png'))),
                 'required' => false,
            'decorators' => $this->fileDecorators,
        			));
               
		

        $this->addElement('submit', 'submitPostButton', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'SalvaPost',
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
