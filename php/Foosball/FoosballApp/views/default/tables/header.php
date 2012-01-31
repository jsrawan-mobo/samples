<?php 
    

$daoRow = $view['daoRow'];
$values = $daoRow->getGenericArray();
    
foreach ( $values as $col=>$val )
{
    echo '<th>'  . $col .  '</th>';
}

?>
 