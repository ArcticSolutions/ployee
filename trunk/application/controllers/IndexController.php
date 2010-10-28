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
    }

    public function indexAction()
    {
        $this->view->employeeName = $this->_employee->name;
        $this->view->images = $this->_employee->getImages();
    }

    public function confirmAction()
    {
        // action body
    }

    public function confirmedAction()
    {
        // action body
    }
}





