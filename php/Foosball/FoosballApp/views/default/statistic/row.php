<?php

/** @var $view */
$dataRow = $view['dataRow'];
$userName = $view['userName'];
$pos = $view['pos'];

$diff = $dataRow['pointsfor'] - $dataRow['pointsagainst'];

echo '<tr>';

echo '<td>'  . $pos  .  '</td>';
echo '<td>'  . $userName  .  '</td>';
echo '<td>'  . $dataRow['rank']  .  '</td>';
echo '<td>'  . $dataRow['wins']  .  '</td>';
echo '<td>'  . $dataRow['losses']  .  '</td>';
echo '<td>'  . $dataRow['winning']  .  '</td>';
echo '<td>'  . $dataRow['pointsfor']  .  '</td>';
echo '<td>'  . $dataRow['pointsagainst']  .  '</td>';
echo '<td>'  . $diff .  '</td>';

echo '</tr>';