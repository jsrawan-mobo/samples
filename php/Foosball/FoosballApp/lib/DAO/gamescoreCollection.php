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

    /**
     * Find all b
     * @param $userId
     * @return void
     */
    public function findAllByUserId($userId)
    {

        $query = sprintf("  select gs.id, timestamp, pl1.login as login_1, pl2.login as login_2, score_1, score_2 FROM gamescore gs
                            inner join player pl1 on pl1.id = gs.fk_User_id_1
                            inner join player pl2 on pl2.id = gs.fk_User_id_2
                            WHERE fk_User_id_1= '%d' " . " or fk_User_id_2= '%d' "
                            . 'order by gs.id desc',
            $this->_connection->clean($userId),
            $this->_connection->clean($userId)
            );

        $results =  $this->_connection->getArray($query);

        $this->populate($results, 'gamescore');

    }



    /**
     * Find all b
     * @param $userId
     * @return void
     */
    public function findAll()
    {

        $query = sprintf("  select gs.id, timestamp, pl1.login as login_1, pl2.login as login_2, score_1, score_2 FROM gamescore gs
                            inner join player pl1 on pl1.id = gs.fk_User_id_1
                            inner join player pl2 on pl2.id = gs.fk_User_id_2
                            order by gs.id desc"
            );

        $results =  $this->_connection->getArray($query);

        $this->populate($results, 'gamescore');

    }

}