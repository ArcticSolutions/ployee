<?php

class IndexController extends Zend_Controller_Action
{

    protected $_employeeMapper = null;
    protected $_employee = null;

    public function init()
    {
        $auth = Zend_Auth::getInstance();
     
        if (!$auth->hasIdentity()) {
            $this->_redirect('/login');
            return;
        }
        
        $this->_employeeMapper = new Application_Model_EmployeeMapper();
        $this->_employee = $this->_employeeMapper->find($auth->getIdentity()->id);
        
        if ($this->_employee->selected_id != null and $this->getRequest()->getActionName() != 'selected') {
            $this->_redirect('/selected');
            return;
        }
    }

    public function indexAction()
    {
        $this->view->employeeName = $this->_employee->name;
        $this->view->images = $this->_employee->getImages();
    }

    public function confirmAction()
    {
        $this->_checkImageAccess();
    }

    public function confirmedAction()
    {
        $this->_checkImageAccess();
        
        $this->_employee->selected_id = $this->view->imageId;
        $this->_employeeMapper->save($this->_employee);
    }
    
    public function selectedAction()
    {
        $this->view->imageId = $this->_employee->selected_id;
    }
    
    protected function _checkImageAccess()
    {
        $this->view->imageId = $this->getRequest()->getParam('id');
        
        $acl = Zend_Registry::get('acl');
        
        $imageMapper = new Application_Model_ImageMapper();
        $image = $imageMapper->find($this->view->imageId);
        
        if (!$acl->isAllowed($this->_employee, $image)) {
            $this->_redirect('/');
        }
    }
}