<?php
class tables
{

    
    public function showAll()
    {
        $dummy = new dao();
        $tableColl = new tableCollection($dummy);
        $tableColl->getwithdata();
        
        customErrorHandler(E_USER_NOTICE, "TableCollection Count:" . $tableColl->countItems(), __FILE__, __LINE__);
        //customObjectErrorHandler(E_USER_NOTICE, $tableColl, __FILE__, __LINE__);

        $tableRows = $tableColl->getLinkedTableRow();

        $header = "All Database tables in: " . MYSQL_DB;
        $decription = 'Number of Records: ' . count($tableRows);
        
        
        echo view::show('tables/show_main', array('$tableRows'=>$tableRows, 'header'=>$header,  'description'=>$decription ));
        
    }
    
    public function show()
    {

        $controller = lib::getitem('controller');
        $tableName =  $controller->params[0];
        if ( empty($tableName) ) {
            lib::sendto();
        }
        else
        {

        
            $dummy = new $tableName;
            $rowColl = new genericTableCollection($dummy);
            $rowColl->__setTableName($tableName);
            $rowColl->getwithdata();

            $header = "Records in: " . $tableName;
            $decription = 'Number of Records: ' . $rowColl->countItems();

            echo view::show('tables/show', array('rowColl'=>$rowColl, 'header'=>$header,  'description'=>$decription ));
        }
    }
    
    
    public function defaultaction()
    {
        $this->showAll();
    }
}
?>