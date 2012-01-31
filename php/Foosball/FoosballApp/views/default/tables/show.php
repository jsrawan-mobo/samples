<?php

$header = $view['header'];
$description = $view['description'];

customErrorHandler(E_USER_NOTICE, "Rendering View:"  . $header  . " in tables " , __FILE__, __LINE__); 


echo "<div id ='body_hdr'>";

echo "<div id ='body_hdr_left'>";
echo '<h1>' . $header . '</h1>';
echo '<p>' . $description . '</p>';



echo "<div id ='body_hdr_center'>";
echo "</div>";


echo "<div id ='body_data'>";
echo '<table>';
$rowColl = $view['rowColl'];
echo '<tr>';
    echo view::show('tables/header', array('daoRow'=> $rowColl->current())  );
echo '</tr>';

foreach ($rowColl as $daoRow)
{
    echo view::show('tables/row', array('daoRow'=>$daoRow));
}
echo '</table>';
echo "</div>";


echo "</div>";


?>

