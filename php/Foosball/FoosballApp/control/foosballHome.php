<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/30/12
 * Time: 10:18 PM
 * To change this template use File | Settings | File Templates.
 */

class foosballHome {


//Here is some temp changes

    public function defaultaction()
    {
        $this->showAll();
//Okay i figured this out.
    }

    /**
     * @return void
     */
    public function showAll()
    {
        $dummy = 'hello';
        $this->showAllScores($dummy);
    }

    /**
     * @param $dateSelected
     * @return void
     */
    public function showAllScores($dateSelected)
    {

        $gamescoreColl = new gamescoreCollection();
        $gamescoreColl->findAllByUserId(1);


        $header = 'Show All Scores';
        $decription = "Sorted By Date:" . $dateSelected ;
        echo view::show('foosballHome/show', array('gamescoreColl'=>$gamescoreColl, 'header'=>$header,  'description'=> $decription ) );
    }




}
