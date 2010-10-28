<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        
        if (!$auth->hasIdentity() and $this->getRequest()->getActionName() != 'login') {
            $this->_redirect('/login');
            return;
        }
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_redirect('/');
            return;
        }
        
        $db = $this->_getParam('db');
        
        $loginForm = new Application_Form_Login();
        if ($this->getRequest()->isPost()) {
            if ($loginForm->isValid($this->getRequest()->getPost())) {
                $authAdapter = new Zend_Auth_Adapter_DbTable(
                    $db,
                    'employees',
                    'username',
                    'password'
                );
                
                $authAdapter->setIdentity($loginForm->getValue('username'));
                $authAdapter->setCredential($loginForm->getValue('password'));
                
                $authResult = $auth->authenticate($authAdapter);
                
                if ($authResult->isValid()) {
                    $authStorage = $auth->getStorage();
                    $authStorage->write($authAdapter->getResultRowObject(null));
                    
                    $this->_helper->FlashMessenger('Logget på!');
                    $this->_redirect('/');
                    return;
                }
            }
        }
        $this->view->loginForm = $loginForm;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
            $this->_redirect('/login');
            return;
        }
    }


}





