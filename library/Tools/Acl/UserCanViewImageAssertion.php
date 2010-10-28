<?php

class Tools_Acl_UserCanViewImageAssertion
    implements Zend_Acl_Assert_Interface
{
    public function assert(Zend_Acl $acl,
                           Zend_Acl_Role_Interface $user = null,
                           Zend_Acl_Resource_Interface $image = null,
                           $privilege = null)
    {
        if (!$user instanceof Application_Model_Employee)
        {
            throw new Exception(__CLASS__.'::'.__METHOD__.' expects the role to be an instance of Application_Model_Employee');
        }
        
        if (!$image instanceof Application_Model_Image)
        {
            throw new Exception(__CLASS__.'::'.__METHOD__.' expects the resource to be an instance of Application_Model_Image');
        }
        
        if ($user->getRoleId() == 'admin')
        {
            return true;
        }
        
        if ($user->id != null && $user->id == $image->employee_id)
        {
            return true;
        }
        
        return false;
    }
}