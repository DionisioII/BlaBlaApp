<?php

class Application_Resource_Notifications extends Zend_Db_Table_Abstract
{
    protected $_name    = 'notifications';
    protected $_primary  = 'id_notification';
    protected $_rowClass = 'Application_Resource_Notifications_Item';

	public function init()
    {
    }
       
    public function getNotificationById($Id)
    {
        return $this->fetchRow($this->select()->where('id_notification = ?', $Id));
		
    }	
    
    
    public function notification($usrReceiver,$usrGenerator,$type ,$id_blog, $id_post )
    {
        $values = array(
            
            "type" => $type,
            "id_blog" => $id_blog,
            "id_post" => $id_post,
            "username" => $usrReceiver,
            "usr_generator" => $usrGenerator,
                    
        );
        
        return $this->insert($values);
        
    }
    
    public function getNotifications($username)
    {
        return $this->fetchAll($this->select()->where('username = ?', $username)->order('timestamp DESC'));
    }
    
    public function alterNotification($idNotification,$bool)
    {
        if($bool){
            $data = array('type' => 'friendship_confermed');

            $where = array(
                'id_notification = ?' => $idNotification
                
            );

            $this->update($data, $where);
        }else{
            $data = array('type' => 'friendship_refused');

            $where = array(
                'id_notification = ?' => $idNotification
                
            );

            $this->update($data, $where);
        }
    }
    
    
    public function updateNotification($username)
    {
        $data = array('seen' => 1);

            $where = array(
                'username= ?' => $username
                
            );

            $this->update($data, $where);
    }
    
    public function checkNotification($username)
    {
        
        $rows= $this->fetchAll($this->select()->where('username = ?', $username)->where('seen = 0'));
                              
        return  count($rows);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}

