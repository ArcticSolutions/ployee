<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        
        if (!$auth->hasIdentity()) {
            $this->_redirect('/auth/login');
            return;
        }
    }

    public function indexAction()
    {
        // action body
    }


}

