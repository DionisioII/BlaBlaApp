<?php

class UserController extends Zend_Controller_Action
{

    protected $_blogForm = null;
	protected $_postForm = null;
	protected $_profiForm = null;
    protected $_researchForm = null;
    protected $_blacklistForm = null;

    protected $_userModel = null;
	

    public function init()
    {
        $this->_helper->layout->setLayout('userlayout');
		$this->_authService = new Application_Service_Auth();
		 $this->view->blogForm = $this->getBlogForm();
		$this->view->postForm = $this->getPostForm();
		$this->_userModel = new Application_Model_User();
		$this->view ->profiForm= $this-> getProfiForm();
        $this->view ->researchForm = $this->getResearchForm();
        $this->view->blacklistForm = $this->getBlackListForm();
    }

    public function indexAction()
    {
        $username = $this->_authService->getIdentity()->username;
        
        $paged = $this->_getParam('page', 1);
        
        $homefeed = $this->_userModel->getHomeFeed($username,$paged);
        $this->view->assign(array(
					'Posts'=> $homefeed
					));
            
        
       
    }

    public function getBlogForm()
    {
    		$urlHelper = $this->_helper->getHelper('url');
		$this->_blogForm = new Application_Form_Utente_Blog();
    		
		return $this->_blogForm;
    }
    
    public function getBlackListForm()
    {
        $this->_blacklistForm = new Application_Form_Utente_BlackList();
        $blogs = $this->_userModel->getBlogsFromUsername($this->_authService->getIdentity()->username);
        $selectValues = array();
        foreach($blogs as $blog){
            $selectValues[$blog->blog_id] = $blog->blog_name;
        }
        
        $this->_blacklistForm->getElement('blog_select')->setMultiOptions($selectValues);
        return $this->_blacklistForm;
    }
	
	 public function getPostForm()
    {
    		$urlHelper = $this->_helper->getHelper('url');
		$this->_postForm = new Application_Form_Utente_PostForm();
		 
		 $this->_postForm->setAction($urlHelper->url(array(
				'controller' => 'user',
				'action' => 'createpost'),
				'default'
		));
    		
		return $this->_postForm;
    }
	
	public function getProfiForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
		$this->_profiForm = new Application_Form_Utente_ProfiForm();
            
        
		 
		 /*$this->_profiForm->setAction($urlHelper->url(array(
				'controller' => 'user',
				'action' => 'updateloginfo'),
				'default'
		));
        */
        
		
		//$data = DateTime::createFromFormat('Y-m-d',$this->_authService->getIdentity()->age)->format('d/m/Y');
        
        
        $data = date('m/d/Y',strtotime($this->_authService->getIdentity()->age));
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
	
	public function updateloginfoAction()
	{
		$request=$this->getRequest();
    	$this->_helper->viewRenderer->setNoRender();
		if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
		$password=null;
		if($_POST['pass']!= '' && $_POST['conf_pass']!= '' && $_POST['pass']== $_POST['conf_pass'] )
			$password =$_POST['pass'];
        
		
		//$data = DateTime::createFromFormat('d/m/Y',$_POST['birthdate'])->format('Y-m-d');
        $data = date('Y-m-d', strtotime($_POST['birthdate']));
		
        $photo_name=null;
		
		if(count($_FILES) > 0 ){
            
                            $photo_name = $_FILES['picImage']['name'];
                            $path = APPLICATION_PATH . '/../public/images/profiphotos/'.$this->_authService->getIdentity()->username;

                            if (!is_dir($path)) {

                                mkdir($path, 0777, true);
                            }
                            move_uploaded_file($_FILES["picImage"]["tmp_name"], $path.'/'.$photo_name);
                            chmod($path, 0777);
                            chmod($path.'/'.$photo_name, 0777);
        }
        
        
        $values = array(
			'name' => $_POST['nome'],
			'surname' => $_POST['cognome'],
			'age' => $data,
			'password' => $password,
			'profipic'=>$photo_name,
            'description' =>$_POST['description']
		);
		if($values['password'] == null)
			unset ($values['password']);
        if($values['profipic'] == null)
			unset ($values['profipic']);
        
        
		$this->_userModel->changeLogInfo($values,$this->_authService->getIdentity()->username);
        
        $user = Zend_Auth::getInstance()->getIdentity();
        $user->name = $values['name'];
        $user->surname = $values['surname'];
        $user->age = $data;
        $user->description = $values['description'];
        
        if(isset($values['password']))
            $user->password = $values['password'];
        if(isset($values['profipic']))
            $user->profipic = $values['profipic'];
        
		$this->_helper->redirector('index');   		    
		
	}
    
    //ajaxUpdateUserInfo
    
    public function ajaxupdateuserinfoAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $profiform = new Application_Form_Utente_ProfiForm();
        $_POST['picImage'] = $_FILES['picImage'];
        
    
        $response = $profiform->processAjax($_POST);
        
		
        if ($response == 'true') {
			
			
			
			//$date = DateTime::createFromFormat('d/m/Y',$data['birthdate'])->format('Y-m-d H:i:s');
                
                $date = implode("-", array_reverse(explode("/", $_POST['birthdate'])));
				if(strtotime($date) < time()){
					
					$photo_name = null;
                    if($_FILES['picImage'] != null)
                    $photo_name = $this->validatePhoto($photo_name,$this->_authService->getIdentity()->username);
                        
                    $values = array(
                                'name' => $_POST['nome'],
                                'surname' => $_POST['cognome'],
                                'age' => $date,
                                'password' => $_POST['pass'],
                                'profipic'=>$photo_name,
                                'description' =>$_POST['description']
                            );
                        if($values['password'] == null || $values['password']=='')
                                unset ($values['password']);
                        if($values['profipic'] == null)
                                unset ($values['profipic']);
                    
						$this->_userModel->changeLogInfo($values,$this->_authService->getIdentity()->username);
                    
                        $user = Zend_Auth::getInstance()->getIdentity();
                        $user->name = $values['name'];
                        $user->surname = $values['surname'];
                        $user->age = $date;
                        $user->description = $values['description'];

                        if(isset($values['password']))
                            $user->password = $values['password'];
                        if(isset($values['profipic']))
                            $user->profipic = $values['profipic'];
                    
						echo'OK';
                        
                        
					
			
				}else{

						echo 'non puoi nascere nel futuro';

				}
			
				
			
			
        }else{
			
			$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);
        	
        	}
        
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
	

    public function createblogAction()
    {
		$this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();
		
        $Blogform = new Application_Form_Utente_Blog();
		
        $response = $Blogform->processAjax($_POST);
		
		
		
        if ($response == 'true') {
			
			$data = $_POST;
			
			$values = array(
				'blog_name' => $data['title'],
				'username' => $this->_authService->getIdentity()->username,
				'tema' => $data['tema']
			);
			
			$this->_userModel->createBlog($values);
			
			echo 'OK';
			
        }else{
			
			
			echo 'error';
        	
        	}
    }
	
	
	 public function createpostAction()
    {
		 $this->_helper->viewRenderer->setNoRender();
		
		if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
		$blogId=$this->getParam('blog_id');
		$usr = $this->getParam('usr',null);
		
		
		$form=$this->_postForm;
        if (!$form->isValid($_POST)) {
			
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            $params = array('blog_id' => $blogId,'usr' => $usr);
		 	$this->_helper->redirector('view-single-blog', 'user','', $params);
		
        }
         $me = $this->_authService->getIdentity()->username;
		 
		 $photo_name=null;
		
		 if(count($_FILES) > 0 ){
			$photo_name = $_FILES['postImage']['name'];
			move_uploaded_file($_FILES["postImage"]["tmp_name"], APPLICATION_PATH . '/../public/images/postphotos/'.$photo_name);
            chmod(APPLICATION_PATH . '/../public/images/postphotos/'.$photo_name, 0666);
			
			
		}
		
		$values=array(
			'blog_id'=>$blogId,
			'username'=>$me,
			'timestamp'=> time(),
			'photo_name' => $photo_name,
			'title'=>$_POST['postTitle'],
			'post_text'=> $_POST['postarea']
			
		);
		
        
		$this->_userModel->createPost($values);
        $usersToNotificate = $this->_userModel->getFollowersById($blogId);
         // se c'è almeno uno che segue il blog mandagli la notifica
         if ($usersToNotificate != null){
             foreach($usersToNotificate as $destUser )
             {
                 $this->_userModel->notification($destUser,$me,$type ='new_post',$id_blog = $blogId);
                 
             }
         }
         
        
		$params = array('blog_id' => $blogId,'usr' => $usr); 
		$this->_helper->redirector('view-single-blog', 'user','', $params);
		
    }
    
    //Ajax createPost action
    
    public function ajaxcreatepostAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();
		
        $Postform = new Application_Form_Utente_PostForm();
        
        $_POST['postImage'] = $_FILES['postImage'];
		
        $response = $Postform->processAjax($_POST);
        
        $photo_name = null;
        
        
        if ($response == 'true') {
            
            $blogId=$this->getParam('blog_id');
            $me = $this->_authService->getIdentity()->username;
            
			
			$photo_name = $this->validatePhotoPost($me);
			
			$values=array(
			'blog_id'=>$blogId,
			'username'=>$me,
			'timestamp'=> time(),
			'photo_name' => $photo_name,
			'title'=>$_POST['postTitle'],
			'post_text'=> $_POST['postarea']
			
		);
		
			
			$this->_userModel->createPost($values);
			
			echo 'OK';
			
        }else{
			
			
			$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);
        	
        	}
        
        
		
    }
    
    
    public function validatePhotoPost($username)
    {
        
		
		if(is_uploaded_file($_FILES['postImage']['tmp_name']) ){
                            
                $photo_name = $_FILES['postImage']['name'];
                move_uploaded_file($_FILES["postImage"]["tmp_name"], APPLICATION_PATH . '/../public/images/postphotos/'.$photo_name);
                chmod(APPLICATION_PATH . '/../public/images/postphotos/'.$photo_name, 0666);

                            
                
            return $photo_name;
                                
                               
        }
        return null;
        
    }
	
	

    public function viewSingleBlogAction()
    {
		$blog_id=$this->getParam('blog_id');
		//il parametro usrToVisualize serve solo nel caso il profilo visualizzato non sia il proprio
		$usrToVisualize = $this->_getParam('usr',null);
        
        $ok = true;
		
		if($usrToVisualize !== null){
		      $data = $this->_userModel->getUsrData($usrToVisualize);
              if($data->hidden && $this->areWeFriends($usrToVisualize) != 1
               && $this->_authService->getIdentity()->role == 'user'  )
                  $ok = false;
        }
        
		else
			$data =null;
        
        if($this->_userModel->isUserBlocked($this->_authService->getIdentity()->username,$blog_id) 
           
           &&
                $this->_authService->getIdentity()->role =='user' )
                
                                    $ok = false;
		
		if($ok){
		$blog = $this->_userModel->getBlogById($blog_id);
		
		$paged = $this->_getParam('page', 1);
		if (!is_null($blog) && $ok) {
				$posts=$this->_userModel->getPostsByBlogId($blog_id, $paged);
        
        

			$this->view->assign(array(
					'Blog'=> $blog,
					'Posts'=>$posts,
					'usrData'=>$data
			));
        }else
            $this->view->assign(array(
					'Blog'=> null,
					'Posts'=>null,
					'usrData'=>null));
            


		}
	}
    
    public function homeFeedAction()
    {
        
        
        
    }
	
	
	
	//Ajax comment
	public function commentAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
    		$this->_helper->viewRenderer->setNoRender();

        $comment = $_POST['comment'];
		$id_post =$_POST['id_post'];
        $me = $this->_authService->getIdentity()->username;
		
		$values= array(
			'id_post'=>$id_post,
			'username'=>$me,
			'comment'=>$comment
		);
		
		$this->_userModel->addComment($values);
        //mandiamo una notifica all'autore del post
        $author = $this->_userModel->getAuthorOfPost($id_post);
        if($me != $author){
            $blog = $this->_userModel->getBlogFromPost($id_post);
            $this->_userModel->notification($author,$me,$type ='new comment',$id_blog = $blog,$id_post = $id_post);
            }
        
		
         echo 'OK';
			
		}
	
	//Ajax toggle visibility del profilo
	public function togglevisibilityAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
		
		
		$visibility = $_POST['visibility'];
		$this->_userModel->toggleVisibility($this->_authService->getIdentity()->username,$visibility);
        $user = Zend_Auth::getInstance()->getIdentity();
        $user->hidden = $visibility;
		
			
		
	}
    //Ajax friend request
    public function friendrequestAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
        
        $futureFriend = $_POST['usr'];
        $me = $this->_authService->getIdentity()->username;
        
        if($me != $futureFriend)
            
            {
                $this->_userModel->friendRequest($me,$futureFriend);
                $this->_userModel->notification($futureFriend,$me);
                echo 1;
            }
        else
            echo 0;
            
    }
	
	//endpoint pervisualizzare profilo altrui
	public function profileAction()
	{
		if (isset($_POST)){
			$usrToVisualize = $this->_getParam('usr');
            if (is_array($usrToVisualize))
                $usrToVisualize = end($usrToVisualize);
            if($this->_authService->getIdentity()->username == $usrToVisualize )
                return $this->_helper->redirector('index','user');
                
			$data = $this->_userModel->getUsrData($usrToVisualize);
            
            $ok = true;
            
            if($data->hidden && $this->areWeFriends($usrToVisualize) != 1 
              && $this->_authService->getIdentity()->role == 'user'  )
                $ok = false;
                
            
			$this->view->assign(array(
				'usrData' => $data,
                'OK' => $ok
				
			));
		}
	}
	
	public function searchAction()
	{
		$this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
        
        $results = null;
        
        if(isset($_POST['value'])){
            $search = $_POST['value'];
            if($search != ''){
                $results = $this->_userModel->getUsersBySearch($search=$search);
            }
        
        }
        
        elseif(isset($_POST['name']) || isset($_POST['surname']))
        {   
        
            $results = $this->_userModel->getUsersBySearch($search = null,$name=$_POST['name'],$surname = $_POST['surname']);
        }


            $json = array();
            foreach ($results as $row){
                 array_push($json, array(
                     $row['name'], 
                     $row['surname'],
                     $this->_authService->getIdentity()->role == 'user' ? $row['hidden'] : 0,
                     $this->areWeFriends($row['username']),
                     $this->getProfiImage($row['username'],$row['profipic']),
                     $row['username'],
                     //DateTime::createFromFormat('Y-m-d',$row['age'])->format('d/m/Y')
                     $data = date('d/m/Y', strtotime($row['age']))
                     

                    ));
            }



                header('Content-Type: application/json');
                echo json_encode($json);
        }
    
    public function getProfiImage($username,$profipic)
    {
        if(!is_null($profipic)){
                
                $path = $this->view->baseUrl('images/profiphotos/'. $username.'/'.$profipic);
                
                return $path;
                
            }else{
                $path = $this->view->baseUrl('images/profiphotos/userpic.gif');
                
                return $path;
            }
    
    }
    
    public function researchAction()
    {
        
    }
	
	public function areWeFriends($username){
		return $this->_userModel->areTheyFriends($this->_authService->getIdentity()->username,$username);
	}
	
    //Ajax blog follow 
    
    public function followblogAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
        
        $blog = $_POST['BlogId'];
        $me = $this->_authService->getIdentity()->username;
        
        if(!($this->_userModel->amIFollowingThisBlog($me,$blog)))
        {
            $values = array(
                
                "blog_id" => $blog,
                "username" => $me
            
            
            );
            $this->_userModel->addFollower($values);
            $author = $this->_userModel->getAuthorOfBlog($blog);
            $this->_userModel->notification($author,$me,$type ='new_follower',$id_blog = $blog);
            echo 1;
        }
    }
    
    //Ajax Blog Unfollow
    public function unfollowblogAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
        
        $blog = $_POST['BlogId'];
        $me = $this->_authService->getIdentity()->username;
        
        if($this->_userModel->amIFollowingThisBlog($me,$blog))
        {
            $values = array(
                
                "blog_id" => $blog,
                "username" => $me
            
            
            );
            $this->_userModel->unfollowBlog($values['username'],$values['blog_id']);
            
            echo 1;
        }
    }
    
    
    public function notificationsAction()
    {
        $me = $this->_authService->getIdentity()->username;
		
        $notifications = $this->_userModel->getNotifications($me);

			$this->view->assign(array(
					'Notifications'=> $notifications
			))	;


		
    }
    
    public function singlepostAction()
    {
        $blog_id = $this->getParam('blogId');
        $post_id = $this->getParam('postId');
        
        if($this->_userModel->isUserBlocked($this->_authService->getIdentity()->username,$blog_id) && $this->_authService->getIdentity()->role == 'user')
            return $this->_helper->redirector('index','user');	
        
        $post = $this->_userModel->getPostById($post_id);
        $blog = $this->_userModel->getBlogById($blog_id);
        $this->view->assign(array(
					'Post'=> $post,
                    'Blog'=> $blog
			))	;
    }
    
    //ajax method
    public function acceptfriendshipAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        if(!(is_null($_POST['adder']))  && !(is_null($_POST['receiver'])) && !(is_null($_POST['idNotification']))   ){
            $adder = $_POST['adder'];
            $receiver =$_POST['receiver'];
            $idNotification = $_POST['idNotification'];

            if($this->_userModel->updateFriendRequest(1,$adder,$receiver))//settiamo a uno la friend request
            {
                $this->_userModel->addFriends($adder,$receiver); //aggiungiamo l'amicizia
                $this->_userModel->alterNotification($idNotification,1);//cambiamo la notifica in amicizia confermata
                $this->_userModel->notification($adder,$receiver,$type ='friendship_accepted'); 

                echo "OK";
            }else
                echo "error";
        }      
                
    }
    
    //ajax method
    public function denyfriendshipAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        if(!(is_null($_POST['adder']))  && !(is_null($_POST['receiver'])) && !(is_null($_POST['idNotification']))   ){
            $adder = $_POST['adder'];
            $receiver =$_POST['receiver'];
            $idNotification = $_POST['idNotification'];

            if($this->_userModel->updateFriendRequest(0,$adder,$receiver))//settiamo a -1 la friend request
            {
                
                $this->_userModel->alterNotification($idNotification,0);//cambiamo la notifica in amicizia rifiutata
                
                $this->_userModel->notification($adder,$receiver,$type ='request_refused'); 
                
                echo "OK";
            }else
                echo "error";
        }      
                
    }
    
    //AjaxMethod
    public function deletefriendshipAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if(!(is_null($_POST)) && !(is_null($_POST['usrName'])))
        {
            $me = $this->_authService->getIdentity()->username;
            $friendToDelete = $_POST['usrName'];
            $this->_userModel->unfollowBlogsOf($me,$friendToDelete);
            $this->_userModel->removeFriend($me,$friendToDelete);
            $this->_userModel->notification($friendToDelete,$me,$type ='friendship_deleted');
            echo 1;
        }else
            echo 0;
    }
    
    
    
    //Ajax method
    public function deletepostAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        if(!(is_null($_POST)) && !(is_null($_POST['idPost'])))
        {
            $me = $this->_authService->getIdentity()->username;
            $postToDelete = $_POST['idPost'];
            
            if ($this->_authService->getIdentity()->role == 'staff') // se è un membro dello staff manda una notifica
            {
                $authorOfPost = $this->_userModel->getAuthorOfPost($postToDelete);
                $this->_userModel->notification($authorOfPost,$me,$type ='post_deleted');
            }
            
            $this->_userModel->deletePost($postToDelete);
            echo 1;
        }//end if
        else
            echo 0;
    }
    
    public function deleteblogAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $usr;
        
        
        if(!(is_null($_POST)) && !(is_null($_POST['idBlog'])))
        {
            
            $blogToDelete = $_POST['idBlog'];
            $me = $this->_authService->getIdentity()->username;
            
            if ($this->_authService->getIdentity()->role == 'staff') // se è un mebro dello staff manda una notifica
            {
                $authorOfBlog = $this->_userModel->getAuthorOfBlog($blogToDelete);
                $usr = $authorOfBlog;
                $this->_userModel->notification($authorOfBlog,$me,$type ='blog_deleted');
            }
            $this->_userModel->deleteBlog($blogToDelete);
            
        }
        
        if($this->_authService->getIdentity()->role == 'staff')
            echo $this->_helper->url('profile','user',null,array('usr'=> $usr));
            
        
        else
           
            echo $this->_helper->url('index','user');
        
        
    }
    
    
    
    
    public function friendsAction()
    {
        $friends = $this->_userModel->getFriends($this->_authService->getIdentity()->username);
        
        $this->view->assign(array(
            
            'Friends' => $friends
            
        ));

    }
    

    public function whereAction()
    {
        // action body
    }

    public function contactusAction()
    {
        // action body
    }
    
    public function logoutAction()
	{
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
	}
    
    public function updatenotificationAction(){
        
          $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $this->_userModel->updateNotification($this->_authService->getIdentity()->username);
        echo 1;
    }
    
    public function checknotificationAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        echo $this->_userModel->checkNotification($this->_authService->getIdentity()->username);
        
    }
    
    public function blacklistAction()
    {
        $me = $this->_authService->getIdentity()->username;
        $blog_id = $this->_getParam('blog_id', key($this->_blacklistForm->getElement('blog_select')->getMultiOptions()));
        if (is_array($blog_id))
                $blog_id = end($blog_id);
        
        
        
        $friendships = $this->_userModel->getFriends($me);
        $friends= array();
        foreach($friendships as $friendship){
            array_push($friends,$friendship->username == $me ? $friendship->friend_username : $friendship->username );
        }
        $this->view->assign(array(
            'Friends'=> $friends,
            'blogId'=>$blog_id
        ));
    }
    
    public function updateblacklistAction()
    {
        $this->_helper->getHelper('layout')->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        if(isset($_POST) && isset($_POST['ListOfUsernames']) && isset($_POST['blogId']) )
        {
            $usernames = $_POST['ListOfUsernames'];
            $blogId = $_POST['blogId'];
            
            
            $this->_userModel->emptyBlacklist($blogId);
            
            if($usernames != 'empty')
            {
                foreach($usernames as $username)
                    $this->_userModel->insertInBlacklist($blogId,$username);
            }          
                
                
            echo 1;
        }//end if
        else
            echo 0;
    }


}



