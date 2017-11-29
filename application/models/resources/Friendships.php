<?php

class Application_Resource_Friendships extends Zend_Db_Table_Abstract
{
    protected $_name    = 'friendships';
    protected $_primary  = 'friendship_id';
    protected $_rowClass = 'Application_Resource_Friendships_Item';

	public function init()
    {
    }
       
    public function getFriendshipById($Id)
    {
        return $this->fetchRow($this->select()->where('friendship_id = ?', $Id));
    }	
    
    
    public function areTheyFriends($usr1,$usr2)
    {
        $query=$this->fetchRow($this->select()->where("(username = '$usr1' AND friend_username ='$usr2') OR (username = '$usr2' AND friend_username ='$usr1')"));
		
					 
		if($query == null)
			return 0;
			
		else 
			return 1;			
		
    }
    
    
    public function addFriends($adder,$receiver)
    {
        $values = array(
        
            "username" => $adder,
            "friend_username"=> $receiver
            
        );
        
        $this->insert($values);
    
    }
    
    public function getFriends($username)
    {
        $friends = $this->fetchAll($this->select()->where("username = ? OR friend_username = ?",$username,$username));
        return $friends;
    }
    
    
    public function removeFriend($me,$usrToRemove)
    {
        
        $where = $this->getAdapter()->quoteInto("(username = '$me' AND friend_username ='$usrToRemove') 
                                                    
                                                    OR 
        
                                                 (username = '$usrToRemove' AND friend_username ='$me')",$me);
        
        $this->delete($where);

    }
    
    public function removeFriendshipsOfUser($username)
    {
        
        $where = $this->getAdapter()->quoteInto('username = ? OR friend_username = ? ',$username);
        
        $this->delete($where);

    }
    
    
    
    
    
    
    
    
    
    
    
    
}

