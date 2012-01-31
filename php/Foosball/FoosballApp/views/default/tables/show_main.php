<?php




$header = $view['header'];
$description = $view['description'];

customErrorHandler(E_USER_NOTICE, "Rendering View:"  . $header  . " in tables show_main" , __FILE__, __LINE__); 



echo "<div id ='body_hdr'>";

echo "<div id ='body_hdr_left'>";
echo '<h1>' . $header . '</h1>';
echo '<p>' . $description . '</p>';



echo "<div id ='body_hdr_center'>";
echo "</div>";


echo "<div id ='body_data'>";
echo '<table>';
$tableRows = $view['$tableRows'];
echo '<tr>';
    echo view::show('tables/main_header', array('dataRow'=>$tableRows[0] )  );
echo '</tr>';

foreach ($tableRows as $row)
{
    echo view::show('tables/main_row', array('dataRow'=>$row) ) ;
}
echo '</table>';
echo "</div>";


echo "</div>";


?>

