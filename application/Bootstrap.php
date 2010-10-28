<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initSessionStorage()
    {
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('auth'));
    }
    
    public function _initAcl()
    {
        $registry = Zend_Registry::getInstance();
        
        $acl = new Zend_Acl();
        
        $acl->addRole('guest');
        $acl->addRole('employee', 'guest');
        
        $acl->addResource('image');
        
        $acl->deny('guest', 'image');
        $acl->allow('employee', 'image', null, new Tools_Acl_UserCanViewImageAssertion());
        
        $registry->set('acl', $acl);
        
        return $acl;
    }
}