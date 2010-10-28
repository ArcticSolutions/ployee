<?php

class Application_Model_Employee
    extends Tools_Model_Abstract
    implements Zend_Acl_Role_Interface
{
    protected $_id;
    protected $_name;
    protected $_username;
    protected $_email;
    protected $_password;
    protected $_extra = false;
    protected $_selected_id;
    
    protected $_images = null;
    
    protected $_aclRoleId = 'employee';
    
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->_name;
    }
    
    public function setUsername($username)
    {
        $this->_username = (string) $username;
        return $this;
    }
    
    public function getUsername()
    {
        return $this->_username;
    }
    
    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }
    
    public function getPassword()
    {
        return $this->_password;
    }
    
    public function setExtra($extra)
    {
        $this->_extra = (boolean) $extra;
        return $this;
    }
    
    public function getExtra()
    {
        return $this->_extra;
    }
    
    public function setSelected_id($id)
    {
        $this->_selected_id = (integer) $id;
        return $this;
    }
    
    public function getSelected_id()
    {
        return $this->_selected_id;
    }
    
    public function getImages()
    {
        if ($this->_images == null) {
            $imageMapper = new Application_Model_ImageMapper();
            $this->_images = $imageMapper->getAllImagesForEmployee($this->getId());
        }
        return $this->_images;
    }
    
    public function getRoleId()
    {
        if ($this->_aclRoleId == null) {
            return 'guest';
        }
        
        return $this->_aclRoleId;
    }
}
