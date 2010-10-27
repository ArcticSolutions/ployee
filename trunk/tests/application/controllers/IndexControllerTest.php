<?php

require_once 'PHPUnit/Framework/TestCase.php';

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        parent::setUp();
    }
    
    public function testIndexAction()
    {
        $this->dispatch('/');
        $this->assertController('index');
        $this->assertAction('index');
    }
    
    public function tearDown()
    {
        /* Tear Down Routine */
    }
}