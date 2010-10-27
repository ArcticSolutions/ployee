<?php

require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

class AuthControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        parent::setUp();
    }
    
    public function testNotLoggedIn()
    {
        $this->dispatch('/auth');
        $this->assertController('auth');
        $this->assertAction('index');
    }

    public function tearDown()
    {
        /* Tear Down Routine */
    }
}