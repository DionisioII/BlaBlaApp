<?php

class StaffController extends Zend_Controller_Action
{
    protected $_staffModel = null;
    protected $_profiForm = null;
    protected $_userModel = null;
    protected $_publicModel = null;
    protected $_researchForm = null;
     

    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout->setLayout('stafflayout');
        $this->_staffModel = new Application_Model_Staff();
        $this->_authService = new Application_Service_Auth();
        $this->_userModel = new Application_Model_User();
        $this->_publicModel = new Application_Model_Public();
        $this->view ->researchForm = $this->getResearchForm();
        $this->view ->profiForm= $this-> getProfiForm();
    }
    
        public function getProfiForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
		$this->_profiForm = new Application_Form_Utente_ProfiForm();
            
        
        
		
		//$data = DateTime::createFromFormat('Y-m-d',$this->_authService->getIdentity()->age)->format('d/m/Y');
        $data = date('m/d/Y', strtotime($this->_authService->getIdentity()->age));
		$this->_profiForm->nome->setValue($this->_authService->getIdentity()->name);
		$this->_profiForm->cognome->setValue($this->_authService->getIdentity()->surname);
		$this->_profiForm->birthdate->setValue($data);
        $this->_profiForm->description->setValue($this->_authService->getIdentity()->description);
		
    		
		return $this->_profiForm;
    }
    
     public function getResearchForm()
    {
    		$urlHelper = $this->_helper->getHelper('url');
		  $this->_researchForm = new Application_Form_Utente_ResearchForm();
		 
		 /*$this->_researchForm->setAction($urlHelper->url(array(
				'controller' => 'user',
				'action' => 'updateloginfo'),
				'default'
		));
		*/
		
		
    		
		return $this->_researchForm;
    }
    
    public function indexAction()
    {   
        if($this->_authService->getIdentity()->role == 'admin')
            $this->_helper->redirector('gestione','admin');
        
        $this->_helper->redirector('gestione','staff');
    }
    
    
    public function gestioneAction()
    {
        if($this->_authService->getIdentity()->role == 'admin')
            $this->_helper->redirector('gestione','admin');
        
        
        $allUsers = $this->_staffModel->getAllUsers(); 
    
        $this->view->assign(array(
        
        'Users' => $allUsers        
        
        ));
    }
    
     public function userblogsAction()
    {
        if(!is_null($_POST))
        {
            $username = $this->getParam('username');
            $blogs = $this->_userModel->getBlogsFromUsername($username);
            
            
            $this->view->assign(array(
                
                'Blogs' => $blogs,
                'Username' => $username               
        
        ));
            
            
        }
        else
            $this->_helper->redirector('gestione','staff');
    }
    
    public function blogviewAction()
    {
         if(!is_null($_POST))
        {
            $blog = $this->_userModel->getBlogById($this->getParam('id_blog'));
            $posts = $this->_userModel->getPostsByBlogId($this->getParam('id_blog'));
            
            
            
            $this->view->assign(array(
                
                'Blog' => $blog,
                'Posts' => $posts               
        
        ));
            
            
        }
        else
            $this->_helper->redirector('gestione','staff');
    }
    
    
    public function singlepostAction()
    {
       $blog_id = $this->getParam('id_blog');
        $post_id = $this->getParam('id_post');
        
        if($this->_userModel->isUserBlocked($this->_authService->getIdentity()->username,$blog_id) && $this->_authService->getIdentity()->role == 'user')
            return $this->_helper->redirector('index','user');	
        
        $post = $this->_userModel->getPostById($post_id);
        $blog = $this->_userModel->getBlogById($blog_id);
        $this->view->assign(array(
					'Post'=> $post,
                    'Blog'=> $blog
			))	;
        
    }
    
    public function researchAction()
    {
        
    }
    
    public function whereAction()
    {
        // action body
    }

    public function contactusAction()
    {
        // action body
    }
    


}

