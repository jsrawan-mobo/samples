<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/30/12
 * Time: 10:28 PM
 * To change this template use File | Settings | File Templates.
 */
 
class boardCollection extends daocollection implements daocollectioninterface {


    /**
     * @var db $_connection
     */
    private $_connection;

    public function __construct()
    {
        $this->_connection = db::factory('mysql');
    }

    /**
     * Find all b
     * @param $userId
     * @return void
     */
    public function findAll()
    {

        $query = "select * from board";
        $query .= " order by entered_on desc";

        $results =  $this->_connection->getArray($query);

        $this->populate($results, 'board');

    }


    public function findAllByUser($userName)
    {
        $query =  sprintf("select * from board where board.username = '%s'", $this->_connection->clean($userName) );
        $query .= " order by entered_on desc";

        $results =  $this->_connection->getArray($query);

        $this->populate($results, 'board');

    }

}