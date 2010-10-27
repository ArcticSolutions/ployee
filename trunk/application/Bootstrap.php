<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initSessionStorage()
    {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('auth'));
    }
}