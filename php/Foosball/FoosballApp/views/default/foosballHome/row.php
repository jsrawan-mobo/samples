<?php

/** @var $view */
$dataRow = $view['dataRow']->getGenericArray();

echo '<tr>';

echo '<td>'  . $dataRow['id']  .  '</td>';
echo '<td>'  . $dataRow['timestamp']  .  '</td>';
echo '<td>'  . $dataRow['score_1']  .  '</td>';
echo '<td>'  . $dataRow['score_2']  .  '</td>';
echo '<td>'  . $dataRow['fk_User_id_1']  .  '</td>';
echo '<td>'  . $dataRow['fk_User_id_2']  .  '</td>';

echo '</tr>';