<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/30/12
 * Time: 10:23 PM
 * To change this template use File | Settings | File Templates.
 */

/** @var $view */
$header = $view['header'];
$description = $view['description'];

/**
 * @var gamescoreCollection[] $gameScoreColl
 */
$statisticArray = $view['statisticsArray'];

customErrorHandler(E_USER_NOTICE, "Rendering View:"  . $header  . " in Acquisition " , __FILE__, __LINE__);


echo "<div id ='body_hdr'>";

echo "<div id ='body_hdr_left'>";
echo '<h1>' . $header . '</h1>';
echo '<p>' . "Count : "    . count($statisticArray) . '</p>';
echo "</div>";
echo "</div>"; //body_hdr

echo "<div id ='body_data_user'>";
echo '<table>';
echo '<tr>';
    echo view::show('statistic/header'); //array('dataRow'=>$tableRows[0] )  );
echo '</tr>';



if ($statisticArray)
{

    $pos = 0;
    foreach ( $statisticArray as $userName=>$dataRow )
    {
        $pos++;
        echo view::show('statistic/row', array('dataRow'=>$dataRow, 'userName'=>$userName, 'pos' => $pos ) ) ;
    }

    /*
    foreach ( $gameScoreColl as $gameScore )
    {
        echo view::show('foosballHome/row', array('dataRow'=>$gameScore ) ) ;
        $gameScoreColl->next();
    }
    */
}


echo '</table>';
echo "</div>"

?>