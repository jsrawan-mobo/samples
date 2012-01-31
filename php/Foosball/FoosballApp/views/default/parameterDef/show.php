<?php

$header = $view['header'];
$description = $view['description'];
$careerAlgParameter = $view['careerAlgParameter'];
$paramDescriptions = $view['paramDescriptions'];
$algorithmName = $view['algorithmName'];


customErrorHandler(E_USER_NOTICE, "Rendering View:"  . $header  . " in parameterDef " , __FILE__, __LINE__);


echo "<div id ='body_hdr'>";

echo "<div id ='body_hdr_left'>";
echo '<h1>' . $header . '</h1>';
echo '<p>' . $description . '</p>';
echo '<p> Algorithm: <b> ' . $careerAlgParameter->algorithm .  "</b> Value: <b>" . $algorithmName . '</b></p>';
echo "</div>";


echo "<div id ='body_hdr_center'>";
echo "</div>";

echo "<div id ='body_data_user'>";

echo "<form action='/parameterDef/updateParameters/"  .  $careerAlgParameter->careeracquisition_def_id   .  "' method='post'> ";
echo "<input type='hidden' name='algorithm' value='" . $careerAlgParameter->algorithm   . "'/>";
echo "<div>";

echo "<table>";
echo "<tr>";
echo '<th>'  . 'Name'  .  '</th>';    
echo '<th>'  . 'Value'  .  '</th>';
echo '<th>'  . 'Description'  .  '</th>';
echo "</tr>";

echo "<tbody>";

for ($i=0 ; $i < 10 ; $i++)
{
    $name = "param" . "$i";
    $description = "description" . "$i";
    echo "<tr>";
    echo "<td>" . $name . "</td>";
    echo "<td width='Auto'>";
    echo "<input type='text' name='" . $name . "' id='" . $name . "' value=\""  . $careerAlgParameter->$name  .  "\" class ='wide_input'>";
    echo "</td>";

    echo "<td>" . $paramDescriptions->$description . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "<input id='update' name='update'  type='submit' value='update' class = 'submit_button'>";
echo "<input id='close' name='close'  type='button' value='close' class = 'submit_button'  onClick='javascript: self.close();'>";

echo "</form>";

echo "</div>";


?>