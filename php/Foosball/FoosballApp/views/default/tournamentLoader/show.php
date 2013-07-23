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
 * @var gamescoreCollection $gameScoreColl
 */
//$gameScoreColl = $view['gamescoreColl'];

customErrorHandler(E_USER_NOTICE, "Rendering View:"  . $header  . " in Acquisition " , __FILE__, __LINE__);


echo "<div id ='body_hdr'>";

echo "<div id ='body_hdr_left'>";
echo '<h1>' . $header . '</h1>';
//echo '<p>' . "Count : "    . $gameScoreColl->countItems() . '</p>';
echo "</div>";
echo "</div>"; //body_hdr

echo "<div id ='body_data_user'>";
echo '<table>';
echo '<tr>';
    echo view::show('tournamentLoader/header');
echo '</tr>';


echo view::show('tournamentLoader/import', array() ) ;


echo '</table>';
echo "</div>"

?>
