<?php

interface Tools_Model_Interface
{
    public function __construct(array $options = null);
    
    public function __set($name, $value);
    public function __get($name);
    
    public function setOptions(array $options);
    
    public function setId($id);
    public function getId();
    
    public function toArray();
}