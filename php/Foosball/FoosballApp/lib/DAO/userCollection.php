<?php
class userCollection extends daocollection implements daocollectioninterface
{
    
    public function __construct()
    {
        
    }
    
    public function getwithdata()
    {
        $connection = db::factory('mysql', true);
        
        $sql = "select * from user where user.host <> 'localhost'";
        
        $results = $connection->getArray($sql);
        
        $this->populate($results, 'user');
    }

    public function getAllUserNames()
    {
        $usersArray = array();
        
        foreach ($this as $daoRow)
        {
            $row = $daoRow->getGenericArray();
            array_push($usersArray, $row['User'] );
        }
        return $usersArray;
    }

    public function getallUserNameCache()
    {
         $userArray = $this->getAllUserNames();

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
            $count++;
         }
         return $linkedArray;
    }

}
?>