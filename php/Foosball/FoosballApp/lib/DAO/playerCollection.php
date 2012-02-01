<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/31/12
 * Time: 11:15 AM
 * To change this template use File | Settings | File Templates.
 */
 


class playerCollection extends daocollection implements daocollectioninterface
{

    public function __construct()
    {

    }


    public function getwithdata()
       {
           $connection = db::factory('mysql');

           $sql = "select * from player";

           $results = $connection->getArray($sql);

           $this->populate($results, 'user');
       }

       /**
        * This is a lookup cache
        * @return array
        */
       public function getAllPayerNameCache()
       {
           $playerCache = array();

           foreach ($this as $daoRow)
           {
               $row = $daoRow->getGenericArray();
               $playerCache[$row['login']] = $row['id'] ;
           }
           return $playerCache;
       }


}