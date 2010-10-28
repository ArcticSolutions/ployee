<?php

class Application_Model_Image
    extends Tools_Model_Abstract
    implements Zend_Acl_Resource_Interface
{
    protected $_id;
    protected $_filename;
    protected $_filename_thumb;
    protected $_originalname;
    protected $_employee_id;
    
    protected $_aclResourceId = 'image';
    
    public function setFilename($filename)
    {
        $this->_filename = $filename;
    }
    
    public function getFilename()
    {
        return $this->_filename;
    }
    
    public function setFilename_thumb($filename_thumb)
    {
        $this->_filename_thumb = $filename_thumb;
    }

    public function getFilename_thumb()
    {
        return $this->_filename_thumb;
    }
    
    public function setOriginalname($originalname)
    {
        $this->_originalname = $originalname;
    }

    public function getOriginalname()
    {
        return $this->_originalname;
    }
    
    public function setEmployee_id($employee_id)
    {
        $this->_employee_id = $employee_id;
    }

    public function getEmployee_id()
    {
        return $this->_employee_id;
    }
    
    public function getResourceId()
    {
        return $this->_aclResourceId;
    }
}

