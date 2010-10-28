<?php

class Application_Model_ImageMapper extends Tools_Model_Mapper_Abstract
{
    protected $_defaultDbTable = 'Application_Model_DbTable_Images';
    protected $_defaultModel = 'Application_Model_Image';
    
    public function getAllImagesForEmployee($id)
    {
        if (null == $this->_defaultModel) {
            throw new Exception('No default model set for ' . get_class($this));
        }
        $select     = $this->getDbTable()->select()->where('employee_id = ?', $id);
        $resultSet  = $this->getDbTable()->fetchAll($select);
        $entries    = array();
        foreach ($resultSet as $row) {
            $entries[] = $this->_mapModel($row);
        }
        return $entries;
    }
}

