<?php

abstract class Tools_Model_Abstract implements Tools_Model_Interface
{
    protected $_id;
    
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid model property');
        }
        $this->$method($value);
    }
    
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid model property');
        }
        return $this->$method();
    }
    
    public function setOptions(array $options)
    {
        if (is_array($options)) {
            $methods = get_class_methods($this);
            foreach ($options as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (in_array($method, $methods)) {
                    $this->$method($value);
                }
            }
        }
        return $this;
    }
    
    public function setId($id)
    {
        $this->_id = (integer) $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function toArray()
    {
        $array = array();
        $array['id'] = $this->getId();
        return $array;
    }
}