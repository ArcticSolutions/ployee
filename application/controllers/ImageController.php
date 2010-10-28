<?php

class ImageController extends Zend_Controller_Action
{
    protected $_employeeMapper = null;
    protected $_employee = null;
    protected $_imageMapper = null;
    protected $_image = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        
        if (!$auth->hasIdentity()) {
            $this->_redirect('/login');
            return;
        }
        
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->_employeeMapper = new Application_Model_EmployeeMapper();
        $this->_employee = $this->_employeeMapper->find($auth->getIdentity()->id);
        
        $this->_imageMapper = new Application_Model_ImageMapper();
        $this->_image = $this->_imageMapper->find($this->getRequest()->getParam('id'));
        
        $acl = Zend_Registry::get('acl');
        
        if (!$acl->isAllowed($this->_employee, $this->_image)) {
            die('You are not allowed to view this image!');
        }
    }

    public function indexAction()
    {
        $size = $this->getRequest()->getParam('size');
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($size == 'default') {
            header('Content-type: '.finfo_file($finfo, APPLICATION_PATH . '/../data/images/' . $this->_employee->id . '/' . $this->_image->filename));
            readfile(APPLICATION_PATH . '/../data/images/' . $this->_employee->id . '/' . $this->_image->filename);
        } elseif($size == 'thumb') {
            header('Content-type: '.finfo_file($finfo, APPLICATION_PATH . '/../data/images/' . $this->_employee->id . '/' . $this->_image->filename_thumb));
            readfile(APPLICATION_PATH . '/../data/images/' . $this->_employee->id . '/' . $this->_image->filename_thumb);
        }
    }
}

