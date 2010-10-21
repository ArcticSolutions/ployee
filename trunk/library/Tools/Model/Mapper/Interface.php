<?php

interface Tools_Model_Mapper_Interface
{
    public function __construct(array $options = null);
    
    public function __set($name, $value);
    public function __get($name);
    
    public function setOptions(array $options);
    
    public function setDefaultmodel(string $model);
    public function getDefaultmodel();
    
    public function setDefaultdbtable(string $dbtable);
    public function getDefaultdbtable();
    
    public function setModelcols(array $cols);
    public function getModelcols();
    
    public function setDbTable($dbTable);
    public function getDbTable();
    
    public function save(Tools_Model_Abstract $model);
    public function find($id, Tools_Model_Abstract $model);
    public function fetchAll();
}