<?php

class Tools_Model_Mapper_AbstractTest extends PHPUnit_Framework_TestCase
{
    protected function _getDbTable()
    {
        $stub = $this->getMockForAbstractClass('Zend_Db_Table_Abstract');
        
        return $stub;
    }
    
    protected function _getNonDbTable()
    {
        $stub = $this->getMockForAbstractClass('Zend_Db_Row_Abstract');
        
        return $stub;
    }
    
    public function testCanCreateMapper()
    {
        $stub = $this->getMockForAbstractClass('Tools_Model_Mapper_Abstract');
        $this->assertType('Tools_Model_Mapper_Abstract', $stub);
    }
    
    public function testSetOptions()
    {
        $options = array('defaultdbtable' => 'Zend_Db_Table_Abstract');
        $stub = $this->getMockForAbstractClass('Tools_Model_Mapper_Abstract', array($options));
        
        $this->assertEquals('Zend_Db_Table_Abstract', $stub->getDefaultdbtable());
    }
    
    public function testSettersAndGetters()
    {
        $stub = $this->getMockForAbstractClass('Tools_Model_Mapper_Abstract');
        
        $this->assertNull($stub->defaultdbtable);
        $stub->defaultdbtable = 'Zend_Db_Table_Abstract';
        $this->assertEquals('Zend_Db_Table_Abstract', $stub->defaultdbtable);
        
        $this->assertNull($stub->defaultmodel);
        $stub->defaultmodel = 'Tools_Model_Abstract';
        $this->assertEquals('Tools_Model_Abstract', $stub->defaultmodel);
        
        $stub->modelcols = array('id', 'name');
        $this->assertEquals(array('id', 'name'), $stub->modelcols);
    }
    
    public function testSetAndGetDbTable()
    {
        $dbTable = $this->_getDbTable();
        $stub = $this->getMockForAbstractClass('Tools_Model_Mapper_Abstract');
        
        try {
            $stub->getDbTable();
        } catch(Exception $e) {
            
        }
        
        $stub->setDbTable($dbTable);
        $this->assertType('Zend_Db_Table_Abstract', $stub->getDbTable());
    }
}