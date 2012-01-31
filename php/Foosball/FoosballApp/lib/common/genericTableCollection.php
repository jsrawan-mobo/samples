<?php

class genericTableCollection extends daocollection implements daocollectioninterface
{
    protected $__tableName = null;
    protected $__whereClause = null;    
    
    public function __construct(dao $dummy)
    {
    }

    public function __setTableName($tableName)
    {
        $this->__tableName = $tableName;
        
    }
    
    public function __setWhereClause($whereClause)
    {
        $this->__whereClause = $whereClause;
        
    }
    
    public function getwithdata()
    {
        $connection = db::factory('mysql');
        
        $sql = "select * from " .  $this->__tableName;
        
        if ($this->__whereClause != null)
        {
            $sql = $sql . " where " . $this->__whereClause;
        }
        $results = $connection->getArray($sql);
        
        

        customErrorHandler(E_USER_NOTICE, "GenericTable  " . $this->__tableName . "Count:" . count($results) . " query: " . $sql, __FILE__, __LINE__);

        customObjectErrorHandler(E_USER_NOTICE, $results, __FILE__, __LINE__);

        
        $this->populate($results, $this->__tableName);
    }
    
    public function populate($array, $dataObj)
    {
        customErrorHandler(E_USER_NOTICE, "genericTableCollection::populate" , __FILE__, __LINE__);		

    	parent::populate($array, $dataObj);
    
    }
}
?>