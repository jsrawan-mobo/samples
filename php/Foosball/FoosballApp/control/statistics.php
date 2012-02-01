<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/30/12
 * Time: 10:18 PM
 * To change this template use File | Settings | File Templates.
 */
 
class statistics {


    public function defaultaction()
    {
        $this->showAll();
    }

    public function showAll()
    {
        $this->showTheKingStatistics();
    }


    public function showTheKingStatistics()
    {

        $gamescoreColl = new gamescoreCollection();
        $gamescoreColl->findAll();
        $statisticArray = $this->computeStatistics($gamescoreColl);

        $header = 'King Stats';
        $decription = "Sorted By Name:";
        echo view::show('statistic/show', array('statisticsArray'=>$statisticArray, 'header'=>$header,  'description'=> $decription ) );
    }


    /**
     *
     * @var gamescoreCollection $gamescoreColl
     * returns
     * Names, wins, losses, points for, points A, diff
     *
     */
    private function computeStatistics($gamescoreColl)
    {
       $allUsersHash = array();
       $allUsersHash = $this->getInitialRankingsHash($gamescoreColl);
       $this->getActualRank($allUsersHash);
       return $allUsersHash;


    }

    /**
     * Adds a 'rank' to the array based on the algorithm
     *
     * @return void
     */
    private function getActualRank(&$allUsersHash)
    {

        /**
         * First calculate opponents strengths and add to hash mpa
         */

        foreach ($allUsersHash as $userName => $stats)
        {
            $userName;
            $opponentsArray =  $stats['opponents'];

            $cnt = 0;
            $sum = 0;
            foreach ($opponentsArray as $key=>$opponents)
            {
                $cnt++;
                $sum += $allUsersHash[ $opponents ]['winning'];
            }
            $allUsersHash[$userName]['strength'] = $sum / $cnt;
            $allUsersHash[$userName]['rank'] = $sum / $cnt;
        }

        /***
        * Rank comes from winning * stength
        *
        */

    }

    private function getInitialRankingsHash($gamescoreColl)
    {
    $allUsersHash = array();

    while ( $gamescoreColl->valid() )
    {
        /**
         * @var dao
         */
        $daoObject = $gamescoreColl->current();
        $genArray = $daoObject->getGenericArray();

        $login1 = $genArray['login_1' ];
        $login2 = $genArray['login_2' ];
        $score1 = $genArray['score_1' ];
        $score2 = $genArray['score_2' ];

        if ( ! isset($allUsersHash[$login1] ))
             $allUsersHash[$login1] = array();

        if ( ! isset($allUsersHash[$login1] [ 'init' ] ) )
        {
            $allUsersHash[ $login1 ][ 'init' ] = true;
            $allUsersHash[ $login1 ][ 'wins' ] = 0;
            $allUsersHash[ $login1 ][ 'losses'] = 0;
            $allUsersHash[ $login1 ][ 'pointsfor'] =  0;
            $allUsersHash[ $login1 ][ 'pointsagainst']  = 0 ;
            $allUsersHash[ $login1 ][ 'winning'] = 0;
            $allUsersHash[ $login1 ][ 'opponents'] = array();
        }


        if ( ! isset($allUsersHash[$login2] ) )
             $allUsersHash[$login2] = array();

        if ( ! isset($allUsersHash[$login2 ][ 'init' ] ) )
        {
            $allUsersHash[ $login2 ][ 'init' ] = true ;
            $allUsersHash[ $login2 ][ 'wins'] = 0  ;
            $allUsersHash[ $login2 ][ 'losses'] = 0;
            $allUsersHash[ $login2 ][ 'pointsfor'] = 0;
            $allUsersHash[ $login2 ][ 'pointsagainst'] = 0;
            $allUsersHash[ $login2 ][ 'winning'] = 0;
            $allUsersHash[ $login2 ][ 'opponents'] = array();
        }

        $allUsersHash[ $login1 ][ 'wins' ] +=  $score1 > $score2 ? 1.00 : 0.00;
        $allUsersHash[ $login1 ][ 'losses']  += $score1 > $score2 ? 0.00 : 1.00;
        $wins = $allUsersHash[$login1 ][ 'wins' ] ;
        $losses = $allUsersHash[$login1 ][ 'losses'];
        $allUsersHash[ $login1 ][ 'winning']  = $wins / ( $wins  + $losses );
        $allUsersHash[ $login1 ][ 'pointsfor']  += $score1;
        $allUsersHash[ $login1 ][ 'pointsagainst'] +=  $score2;
        array_push( $allUsersHash[$login1 ][ 'opponents'],  $login2 );

        $allUsersHash[ $login2 ][ 'wins']   +=  $score2 > $score1 ? 1.00: 0.00;
        $allUsersHash[ $login2 ][ 'losses'] +=  $score2 > $score1 ? 0.00: 1.00;
        $wins = $allUsersHash[ $login2 ][ 'wins' ] ;
        $losses = $allUsersHash[ $login2 ][ 'losses'];
        $allUsersHash[ $login2 ][ 'winning']  = $wins / ( $wins + $losses );
        $allUsersHash[ $login2 ][ 'pointsfor'] +=  $score2;
        $allUsersHash[ $login2 ][ 'pointsagainst'] += $score1;
        array_push( $allUsersHash[ $login2 ][ 'opponents'],  $login1 );


        $gamescoreColl->next();
    }
    return $allUsersHash;

}

}
