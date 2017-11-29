<?php

class PublicController extends Zend_Controller_Action
{
	protected $_authService;
	protected $_form;
	protected $_registrationForm;
	protected $_publicModel;

    public function init()
    {
        $this->_authService = new Application_Service_Auth();
        $this->view->loginForm = $this->getLoginForm();
		$this->view->registrationForm = $this->getRegistrationForm();
		$this->_publicModel = new Application_Model_Public();
		
    }

    public function indexAction()
    {
        // action body
	}

    public function aboutusAction()
    {
        // action body
        
    }

    public function whereAction()
    {
        // action body
    }

    public function contactusAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
    }
	
	
    public function authenticateAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        $form = $this->_form;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('login');
        }
        if (false === $this->_authService->authenticate($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
        return $this->_helper->redirector('index', $this->_authService->getIdentity()->role);
	}

	// Validazione AJAX
	public function validateloginAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $loginform = new Application_Form_Public_Auth_Login();
        $response = $loginform->processAjax($_POST); 
        if ($response !== null) {
        	$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }else{
			$registrationform = new Application_Form_Public_Auth_Registration();
			$response = $registrationform->processAjax($_POST); 
			if ($response !== null) {
        	$this->getResponse()->setHeader('Content-type','application/json')->setBody($response); 
        	
        	}
		}
		
    }
	
	public function getLoginForm()
    {
    		$urlHelper = $this->_helper->getHelper('url');
		$this->_form = new Application_Form_Public_Auth_Login();
    		$this->_form->setAction($urlHelper->url(array(
				'controller' => 'public',
				'action' => 'authenticate'),
				'default'
		));
		return $this->_form;
    }   
	
	public function getRegistrationForm()
    {
    		$urlHelper = $this->_helper->getHelper('url');
		$this->_registrationForm = new Application_Form_Public_Auth_Registration();
    		/*$this->_registrationForm->setAction($urlHelper->url(array(
				'controller' => 'public',
				'action' => 'registration'),
				'default'
		));*/
        
		return $this->_registrationForm;
    }   
	
	
	public function registrationAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        $form = $this->_registrationForm;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('login');
        }
        if (false === $this->_authService->authenticate($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
        return $this->_helper->redirector('index', $this->_authService->getIdentity()->role);
	}
	
	
	//Ajax registration
	public function registraAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $registrationform = new Application_Form_Public_Auth_Registration();
        $_POST['picImage'] = $_FILES['picImage'];
        $response = $registrationform->processAjax($_POST);
        
		
        if ($response == 'true') {
			
			$data = $_POST;
			
			//$date = DateTime::createFromFormat('d/m/Y',$data['birthdate'])->format('Y-m-d H:i:s');
            
            $date = implode("-", array_reverse(explode("/", $_POST['birthdate'])));
            
			
			if($data['passwd']==$data['conf_password'])
			{
				if(strtotime($date)<time()){
					
					if($this->checkUsername($data['usrname'])){
                        
                        $photo_name = null;
                        if($_FILES['picImage'] != null)
                        $photo_name = $this->validatePhoto($photo_name,$data['usrname']);
					
						$info = array('username'=> $data['usrname'],
							  'password' => $data['passwd'],
							  'role' => 'user',
							  'name'=> $data['name'],
							  'surname' => $data['surname'],
							  'age' => $date,
							  'description'=> $data['description'],
							  'profipic' => $photo_name
							 );
						$this->_publicModel->saveUser($info);
						echo'registered';
                        
                        
					}else{
						echo 'username già preso';
					}
			
				}else{

						echo 'non puoi nascere nel futuro';

				}
			}
				else{
				
					echo 'password non uguali';
			}
			
        }else{
			
			$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);
        	
        	}
		}
	
	public function checkUsername($usrname){
		
		if($this->_publicModel->findUsername($usrname))
			return TRUE;
		else
			return FALSE;
		
	}
    
    public function validatePhoto($photo_name,$username)
    {
        
		
		if($_FILES['picImage'] != null ){
                            
                            
                                $photo_name = $_FILES['picImage']['name'];
                                $path = APPLICATION_PATH . '/../public/images/profiphotos/'.$username;

                                if (!is_dir($path)) {

                                    mkdir($path, 0777, true);
                                }
                                move_uploaded_file($_FILES["picImage"]["tmp_name"], $path.'/'.$photo_name);
                                chmod($path, 0777);
                                chmod($path.'/'.$photo_name, 0777);
            return $photo_name;
                                
                               
        }
        return null;
        
    }
	



}









