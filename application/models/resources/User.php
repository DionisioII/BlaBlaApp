<?php

class Application_Resource_User extends Zend_Db_Table_Abstract
{
    protected $_name    = 'user';
    protected $_primary  = 'username';
    protected $_rowClass = 'Application_Resource_User_Item';

	public function init()
    {
    }
	
	public function changeLogInfo($values,$usrName)
	{
		
		$where = $this->getAdapter()->quoteInto('username = ?', $usrName);
		$this->update($values,$where);
	}
       
    public function getUserByName($usrName)
    {
        return $this->fetchRow($this->select()->where('username = ?', $usrName));
    }	
	
	public function saveUser($info)
	{
		$this->insert($info);
	}   
    
    public function getAllUsers()
    {
        return $this->fetchAll($this->select());
    }
    
    public function modificautente($values,$username)
    {
        
        $where = $this->getAdapter()->quoteInto('username = ?', $username);
        
		if($this->update($values,$where))
            return true;
        else
            return false;
    }
    
    
	
	public function findUsername($value)
	{
		
		$query=$this->fetchRow($this->select()->where('username = ?', $value));
		
					 
		if($query != null)
			return FALSE;
			
		else {
			return TRUE;
			
		}
	}
	
	
	public function getUsrData($usrName)
	{
		return $this->fetchRow($this->select()->where('username = ?', $usrName));
	}
	
	public function toggleVisibility($usr,$booleanValue)
	{
		if ($booleanValue == 'true')
			$booleanValue =1;
		else
			$booleanValue =0;
		$info = array(
			'hidden'=>$booleanValue
		);
		$where = $this->getAdapter()->quoteInto('username = ?', $usr);
		$this->update( $info,$where);
	}
	
	
	public function getUsersBySearch($search)
	{
		$select;
		$search=trim($search);
		$array =explode(' ',$search,2);
		
		$num =count($array);
		if ($num ==1){
			$select=$this->select()
					 ->from('user')
					 ->where('(name LIKE ? OR surname LIKE ? )','%'.$search.'%');
					 
		}else{
			$select=$this->select()
					 ->from('user')
					 ->where('name LIKE ? OR surname LIKE ? ','%'.$array[0].'%')
					 ->where(' name LIKE ? OR surname LIKE ? ','%'.$array[1].'%');
			
		}
		
		
					
		
		return $this->fetchAll($select);
	}	
    
    
    public function getUsersByReSearch($name,$surname)
	{
		$select;
		$name = trim($name);
        $surname = trim($surname);
        $name = str_replace('*','%',$name);        
        $surname = str_replace('*','%',$surname);
        if($name=="" && $surname== "")
            return null;
        if($name=="")
            $name ='%';
        if($surname=="")
            $surname='%';	

		
		
			$select=$this->select()
					 ->from('user')
					 ->where("name LIKE '$name' && surname LIKE '$surname' ");
		
		
					
		
		return $this->fetchAll($select);
	}	
    
    public function modifyUser($usrname,$column,$value)
    {
        
        $where = $this->getAdapter()->quoteInto('username = ?', $usrname);
        $values = array($column => $value);
		if($this->update($values,$where))
            return true;
        else
            return false;
        
    }
    public function deleteUser($username)
    {
          $where = $this->getAdapter()->quoteInto("username = ?",$username);
        
            if($this->delete($where))
                return true;
        else
            return false;
    }

    
    
    
	
}

