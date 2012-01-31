<?php

$daoRow = $view['daoRow'];
$values = $daoRow->getGenericArray();

echo '</tr>';
foreach ( $values as $col=>$val )
{
    
    $valueToPrint = $val;
    if ( strpos($col,"BASE") > 0  ||  strpos($col,"url") === 0)
    {
        $valueToPrint = "<a href='" . $val .    "'>"  . $val . "</a>";
    }
    echo '<td>'  . $valueToPrint .  '</td>';
    
    
}
echo '</tr>';

?>