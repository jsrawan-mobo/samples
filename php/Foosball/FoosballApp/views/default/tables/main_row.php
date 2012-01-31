<?php

$dataRow = $view['dataRow'];
echo '</tr>';
foreach ( $dataRow as $col=>$val )
{
    $valueToPrint = $val;
    if ( strpos($col,"BASE") > 0  ||  strpos($col,"link") === 0 ||  strpos($col,"url") === 0)
    {
        $valueToPrint = "<a href='" . $val .    "'>Show</a>";
    }
    echo '<td>'  . $valueToPrint .  '</td>';
    
}
echo '</tr>';

?>