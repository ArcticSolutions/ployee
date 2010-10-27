<?php

class Tools_Model_AbstractTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateModel()
    {
        $stub = $this->getMockForAbstractClass('Tools_Model_Abstract');
        $this->assertType('Tools_Model_Abstract', $stub);
    }
    
    public function testSettersAndGetters()
    {
        $stub = $this->getMockForAbstractClass('Tools_Model_Abstract');
        
        $this->assertNull($stub->id);
        $stub->id = 1;
        $this->assertEquals(1, $stub->getId());
        
        try {
            $stub->nonvariable = 1;
        } catch(Exception $e) {
            $this->assertEquals('Invalid model property', $e->getMessage());
        }
        
        try {
            $dummy = $stub->nonvariable;
        } catch(Exception $e) {
            $this->assertEquals('Invalid model property', $e->getMessage());
        }
    }
    
    public function testSetOptions()
    {
        $options = array('id' => 123);
        $stub = $this->getMockForAbstractClass('Tools_Model_Abstract', array($options));
        
        $this->assertEquals(123, $stub->getId());
    }
}