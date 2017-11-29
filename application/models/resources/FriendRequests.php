<?php

class Application_Resource_FriendRequests extends Zend_Db_Table_Abstract
{
    protected $_name    = 'friend_requests';
    protected $_primary  = 'id_request';
    protected $_rowClass = 'Application_Resource_FriendRequests_Item';

	public function init()
    {
    }
       
    public function getFriendRequestById($Id)
    {
        return $this->fetchRow($this->select()->where('id_request = ?', $Id));
    }	
    
    public function friendRequest($requester,$requested)
    {
        $values = array(
            "requester" => $requester,
            "receiver" => $requested,
        );
        
        return $this->insert($values);
    }
    
    public function isThereARequestBetween($usr1,$usr2)
    {
        $query=$this->fetchRow($this->select()->where("(requester = '$usr1' AND receiver ='$usr2'AND accepted = 0) OR (requester = '$usr2' AND receiver ='$usr1' AND accepted =0)"));
        
        
		
					 
		if($query == null)
			return 0;
			
		else 
			return 1;			
		
    }
    
    public function updateFriendRequest($bool,$adder,$receiver)
    {
        
        if ($bool){
            $data = array('accepted' => 1);

            $where = array(
                'requester = ?' => $adder,
                'receiver = ?' => $receiver,
                'accepted = ?' => 0
            );

            return $this->update($data, $where);
            
            
        }else{
            $data = array('accepted' => -1); // se rifiutata il valore viene messo a -1

            $where = array(
                'requester = ?' => $adder,
                'receiver = ?' => $receiver,
                'accepted = ?' => 0
                );

            $this->update($data, $where);
            return 1;
            
        }  
                   
    }
    
    public function getfriendRequests($username)
    {
        return $this->fetchAll($this->select()->where('receiver = ?', $username));
    }
    
}

