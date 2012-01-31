<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/30/12
 * Time: 10:28 PM
 * To change this template use File | Settings | File Templates.
 */
 
class gamescoreCollection extends daocollection implements daocollectioninterface {


    /**
     * @var db $_connection
     */
    private $_connection;

    public function __construct()
    {
        $this->_connection = db::factory('mysql');
    }

    public function setDateFilter()
    {

    }

    public function findAll($userId)
    {

        $query = sprintf("SELECT * FROM gamescore WHERE fk_User_id_1='%d'",
            $this->_connection->clean($userId)
            );

        $results =  $this->_connection->getArray($query);

        $this->populate($results, 'gamescore');

    }

}