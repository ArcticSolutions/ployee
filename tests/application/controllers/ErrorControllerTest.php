<?php

require_once 'PHPUnit/Framework/TestCase.php';

class ErrorControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        parent::setUp();
    }
    
    public function testErrorAction()
    {
        $this->dispatch('/error/error');
        $this->assertController('error');
        $this->assertAction('error');
    }
    
    public function test404Eror()
    {
        $this->dispatch('/thiswillnotbefound');
        $this->assertController('error');
        $this->assertAction('error');
    }
    
    public function tearDown()
    {
        /* Tear Down Routine */
    }
}