<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        
        $this->addElement('text', 'username', array(
                'label' => 'Brukernavn:',
                'required' => true,
                'filters' => array('StringTrim')
            )
        );
        
        $this->addElement('password', 'password', array(
           'label' => 'Passord:',
           'required' => true
        ));
        
        $this->addElement('submit', 'submit', array(
           'ignore' => true,
           'label' => 'Log på'
        ));
    }
}