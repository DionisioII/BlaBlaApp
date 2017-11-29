<?php

class AdminController extends Zend_Controller_Action
{
    
    protected $_userModel = null;
    protected $_adminModel = null;
    protected $_insertForm = null;
    protected $_publicModel = null;
    protected $_profiForm = null;
    protected $_modifyForm = null;
    
    
    public function init()
    {
        $this->_helper->layout->setLayout('stafflayout');
		$this->_authService = new Application_Service_Auth();
        $this->_adminModel = new Application_Model_Admin(); 
        $this->_userModel = new Application_Model_User();
        $this->_publicModel = new Application_Model_Public();
        $this->view ->insertForm= $this-> getInsertForm();
        $this->view ->profiForm= $this-> getProfiForm();
        $this->view ->modifyForm= $this-> getModifyForm();
        
    }

    public function indexAction()
    {
        $this->_helper->redirector('index','staff');
    }
    
    public function getProfiForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
		$this->_profiForm = new Application_Form_Utente_ProfiForm();
            
        
		 
		 $this->_profiForm->setAction($urlHelper->url(array(
				'controller' => 'user',
				'action' => 'updateloginfo'),
				'default'
		));
        
        
		
		//$data = DateTime::createFromFormat('Y-m-d',$this->_authService->getIdentity()->age)->format('d/m/Y');
        $data = date('d/m/Y', strtotime($this->_authService->getIdentity()->age));
		$this->_profiForm->nome->setValue($this->_authService->getIdentity()->name);
		$this->_profiForm->cognome->setValue($this->_authService->getIdentity()->surname);
		$this->_profiForm->birthdate->setValue($data);
        $this->_profiForm->description->setValue($this->_authService->getIdentity()->description);
		
    		
		return $this->_profiForm;
    }
    
    public function getInsertForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
		$this->_insertForm = new Application_Form_Admin_InsertUserForm();
		 
		 $this->_insertForm->setAction($urlHelper->url(array(
				'controller' => 'admin',
				'action' => 'insertuser'),
				'default'
		));
    		
		return $this->_insertForm;
    }
    
    public function getModifyForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
		$this->_modifyForm = new Application_Form_Admin_ModifyUserForm();
		 
		 $this->_modifyForm->setAction($urlHelper->url(array(
				'controller' => 'admin',
				'action' => 'savemodifications'),
				'default'
		));
    		
		return $this->_modifyForm;
    }
	
	
    
    public function gestioneAction()
    {
        $allUsers = $this->_adminModel->getAllUsers(); 
        $num_blogs = $this->_adminModel->getNumberOfBlogs();
    
        $this->view->assign(array(
        
        'Users' => $allUsers ,
        'Num_Blogs' => $num_blogs
        
        ));
    }

    
    public function informazioniAction()
    {

    }
    
    //ajax method
    public function modifyuserAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();

        $usrname = $_POST['username'];
		$column =$_POST['column'];
        $value = $_POST['value'];
        
        if($column == 'age')
            //$value =DateTime::createFromFormat('d/m/Y',$value)->format('Y-m-d H:i:s');
            
        $value = implode("-", array_reverse(explode("/", $value)));
        
        
        if(strlen($value) >= 3)
            if($this->_adminModel->modifyUser($usrname,$column,$value))
            {
                echo 1;
            }
        else
            echo 'inserire valore maggiore di 3 caratteri';
        
    }
    
    public function deleteuserAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();

        $usrname = $_POST['username'];
        
        if($this->_adminModel->deleteUser($usrname))
        {
            echo 1;
        }
    }
    
    public function detailsuserAction()
    {
        if(!is_null($_POST))
        {
            $username = $this->getParam('username');
            $friends = $this->_userModel->getFriends($username);
            $friendRequests = $this->_adminModel->getfriendRequests($username);
            
            $this->view->assign(array(
                
                'User' => $username,
                'Friends' => $friends,
                'FriendRequests' => $friendRequests
        
        ));
            
            
        }
        else
            $this->_helper->redirector('index','staff');
    }
    
    public function inserisciutenteAction()
    {
        
    }
    
    public function insertuserAction()
    {
        $this->_helper->viewRenderer->setNoRender();
		
		if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
		$form=$this->_insertForm;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('inserisciutente');
        }
        $Values = $form->getValues();
        
        if($this->checkUsername($Values['username'])){
            unset($Values['conf_pass']);
            $this->_publicModel->saveUser($Values);
             $form->setDescription('utente aggiunto con successo');
            $form->reset();
            return $this->render('inserisciutente');
        }else{
            $form->setDescription('Attenzione: nome utente già presente in database');
            return $this->render('inserisciutente');
        }
        
				
		
		
    }
    
    public function modificautenteAction()
    {
        $username = $this->getParam('username',null);
        if (!is_null($username)){
            $username = $this->_adminModel->getUserByName($username);
            
            $this->_modifyForm->name->setValue($username->name);
            $this->_modifyForm->surname->setValue($username->surname);
            $this->_modifyForm->description->setValue($username->description);
            $this->_modifyForm->data->setValue(date('d/m/Y', strtotime($username->age)));
            $this->_modifyForm->role->setValue($username->role);
            
            //$this->view->modifyForm = $form;
            
            
            
            
        }else
        {
            $this->_helper->redirector('index','staff');
        }
    }
    
    public function savemodificationsAction()
    {
        $this->_helper->viewRenderer->setNoRender();
		
		if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index','admin');
        }
		$form=$this->_modifyForm;
        if (!$form->isValid($_POST)) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificautente');
        }
        $Values = $form->getValues();
        $usr = $this->getParam('username',null);
        
        if(!is_null($usr)){
            unset($Values['conf_pass']);
            if($Values['password'] == '')
                unset($Values['password']);
            
            //$Values['age'] = date('Y-m-d', strtotime($Values['data']));
            $Values['age'] = implode("-", array_reverse(explode("/", $Values['data'])));
            //$date = implode("-", array_reverse(explode("/", $values['data'])));
            unset($Values['data']);
            
            
            $this->_adminModel->modificaUtente($Values,$usr);
            $form->setDescription('utente modificato con successo');
            
            $username = $this->_adminModel->getUserByName($usr);
            
            $this->_modifyForm->name->setValue($username->name);
            $this->_modifyForm->surname->setValue($username->surname);
            $this->_modifyForm->description->setValue($username->description);
            $this->_modifyForm->data->setValue(date('d/m/Y', strtotime($username->age)));
            $this->_modifyForm->role->setValue($username->role);
            
            
            return $this->render('modificautente');
        }else{
            
            $form->setDescription('Attenzione: errore');
            return $this->render('modificautente');
        }
    }
    
    
    public function checkUsername($usrname){
		
		if($this->_publicModel->findUsername($usrname))
			return TRUE;
		else
			return FALSE;
		
	}
    
}

