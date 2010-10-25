<?php

abstract class Tools_Model_Mapper_Abstract implements Tools_Model_Mapper_Interface
{
    protected $_defaultDbTable;
    protected $_defaultModel;
    protected $_modelCols;
    protected $_dbTable;
    
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid mapper property');
        }
        $this->$method($value);
    }
    
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            throw new Exception('Invalid mapper property');
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
    
    public function setDefaultmodel($model)
    {
        $this->_defaultModel = (string) $model;
        return $this;
    }
    
    public function getDefaultmodel()
    {
        return $this->_defaultModel;
    }
    
    public function setDefaultdbtable($dbtable)
    {
        $this->_defaultDbTable = (string) $dbtable;
        return $this;
    }
    
    public function getDefaultdbtable()
    {
        return $this->_defaultDbTable;
    }
    
    public function setModelcols(array $cols)
    {
        $this->_modelCols = (array) $cols;
        return $this;
    }
    
    public function getModelcols()
    {
        if (null == $this->_modelCols) {
            $info = $this->getDbTable()->info();
            $this->_modelCols = $info['cols'];
        }
        return $this->_modelCols;
    }
    
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if(!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    
    public function getDbTable()
    {
        if (null == $this->_dbTable) {
            if (null == $this->_defaultDbTable) {
                throw new Exception('No default DbTable set for ' . get_class($this));
            }
            $this->setDbTable($this->_defaultDbTable);
        }
        return $this->_dbTable;
    }
    
    public function save(Tools_Model_Abstract $model)
    {
        $data = array();
        
        foreach ($this->getModelcols() as $col) {
            $data[$col] = $model->$col;
        }
        
        if (null === ($id = $model->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    public function find($id, Tools_Model_Abstract $model = null)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        return $this->mapModel($row, $model);
    }
    
    public function fetchAll()
    {
        if (null == $this->_defaultModel) {
            throw new Exception('No default model set for ' . get_class($this));
        }
        $resultSet  = $this->getDbTable()->fetchAll();
        $entries    = array();
        foreach ($resultSet as $row) {
            $entries[] = $this->mapModel($row);
        }
        return $entries;
    }
    
    protected function mapModel(Zend_Db_Table_Row $row, Tools_Model_Abstract $model = null)
    {
        if (null == $this->_defaultModel) {
            throw new Exception('No default model set for ' . get_class($this));
        }
        if (null == $model) {
            $model = new $this->_defaultModel();
        }
        foreach ($this->getModelcols() as $col) {
            $model->$col = $row->$col;
        }
        return $model;
    }
}