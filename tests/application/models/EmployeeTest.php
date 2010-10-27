<?php

class EmployeeTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateModel()
    {
        $model = new Application_Model_Employee();
        $this->assertType('Application_Model_Employee', $model);
    }
    
    public function testCanSetAndGetFields()
    {
        $model = new Application_Model_Employee();
        
        $this->assertNull($model->getName());
        $model->setName('Tester, Testerson');
        $this->assertSame('Tester, Testerson', $model->getName());
        
        $this->assertNull($model->getUsername());
        $model->setUsername('tester');
        $this->assertSame('tester', $model->getUsername());
        
        $this->assertNull($model->getEmail());
        $model->setEmail('tester@ployee.com');
        $this->assertSame('tester@ployee.com', $model->getEmail());
        
        $this->assertNull($model->getPassword());
        $model->setPassword('1234');
        $this->assertSame('1234', $model->getPassword());
        
        $this->assertFalse($model->getExtra());
        $model->setExtra(true);
        $this->assertTrue($model->getExtra());
        
        $this->assertNull($model->getSelected_id());
        $model->setSelected_id(1);
        $this->assertNotNull($model->getSelected_id());
    }
}