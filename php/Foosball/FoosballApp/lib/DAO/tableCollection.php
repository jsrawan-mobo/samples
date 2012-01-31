<?php
class tableCollection extends daocollection implements daocollectioninterface
{
    protected $columnName = array();
    
    public function __construct(dao $item)
    {
        //this item is only for if we have where clause.
    }
    
    public function getwithdata()
    {
        $columnName = array();
        
        $databaseName = MYSQL_DB;
        $this->columnName[0] = "Tables_in_$databaseName";
        $this->columnName[1] = "Table_Type";
        


        $connection = db::factory('mysql');
        
        $sql = "SHOW FULL TABLES";
        $results = $connection->getArray($sql);
        
        $this->populate($results, 'table');
    }
    
    public function getLinkedTableRow()
    {
         $linkedArray[] = array();         
         
         $count = 0;          
         
         foreach ($this as $daoRow)
         {   
            $row = $daoRow->getGenericArray();
            foreach ($row as $col=>$value )
            {
                $linkedArray[$count][$col] = $value;
            }
            $tableCol = $this->columnName[0];      
            $tableName = $row[$tableCol];
            $linkedArray[$count]['link'] = "/tables/show/$tableName";
            $count++;
         }
         return $linkedArray;
    }
    
    //make this a read only object, as tables does not exist.
    public function saveall()
    {
        customErrorHandler(E_ERROR, "It is not possible to saveAll() on a tables collection"   ,__FILE__,__LINE__); 
    }
    
    
}
?>