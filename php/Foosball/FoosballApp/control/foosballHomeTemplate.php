<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/31/12
 * Time: 12:04 AM
 * To change this template use File | Settings | File Templates.
 */


/**
 * fsfg
 */
class foosballHomeTemplate extends foosballHome {


    public function showAllScores($dateSelected)
    {

        $gamescoreColl = new gamescoreCollection();
        $gamescoreColl->findAllByUserId(1);


        $header = 'Show All Scores for template';
        $decription = "Sorted By Date:" . $dateSelected ;
        //echo view::show('foosballHomeTemplate/show', array('gamescoreColl'=>$gamescoreColl, 'header'=>$header,  'description'=> $decription ) );

        $smarty = view::getSmarty();
        //$smarty->assign('name', 'george smith');
        //$smarty->assign('address', '45th & Harris');

        // display it
        //$smarty->display('show.tpl');

        //$smarty-> foosballColl

        echo view::showSmarty('foosballHomeTemplate/show', $smarty);

    }

}
