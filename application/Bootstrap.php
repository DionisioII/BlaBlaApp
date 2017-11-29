<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected $_logger;
	protected $_view;	
		
	protected function _init()
    {
        $this->bootstrap('frontController');
    }

    protected function _initLocale()
    {
        $locale = new Zend_Locale('it_IT');
    }
    
    public function _initTranslate() {
        
        $translator = new Zend_Translate(
            'array',
            APPLICATION_PATH.'/resources/languages',  // you need to copy the resources folder
                                    // (from your Zend Framework installation)
                                    // in the application folder 

            'it', // 'it' for italian, 'fr' for french, etc. 
                  // Just look at the directories

            // Zend_Translate, NOT Zend_Locale
            array(
                'scan' => Zend_Translate::LOCALE_DIRECTORY
            )
        );

        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }
    
    
   /* protected function _initLogging()
    {
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);
        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);
    	$this->_logger->info('Bootstrap ' . __METHOD__);
    }*/

    protected function _initViewSettings()
    {
        $this->bootstrap('view');
        $this->_view = $this->getResource('view');
        $this->_view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        $this->_view->headMeta()->appendHttpEquiv('Content-Language', 'it-IT');
        $this->_view->headLink()->appendStylesheet('css/style.css');
        $this->_view->headTitle('BlablaApp');
		
    }
    
    protected function _initDefaultModuleAutoloader()
    {
    	$loader = Zend_Loader_Autoloader::getInstance();
		$loader->registerNamespace('App_');
        $this->getResourceLoader()
             ->addResourceType('modelResource','models/resources','Resource');  
    }

    protected function _initFrontControllerPlugin()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$front->registerPlugin(new App_Controller_Plugin_Acl());
    }
    
	protected function _initDbParms()
    {
    	
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
    			'host'     => 'hostname',
    			'username' => 'nameuser',
    			'password' => 'password',
    			'dbname'   => 'blablaapp'
				));  
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
	}

}

