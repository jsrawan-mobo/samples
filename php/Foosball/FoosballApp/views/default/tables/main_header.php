<?php 
    

$dataRow = $view['dataRow'];
    
foreach ( $dataRow as $col=>$val )
{
    echo '<th>'  . $col .  '</th>';
}

?>
 