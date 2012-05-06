

<form action="/messages/newMessage" method="post">
    <div class="row"><label for="username">Users:</label><input type="text" disabled name="username" id="username" value="<?php if(lib::exists('username')) {echo lib::getitem('username');}?>" /></div>
    <div class="row"><label for="Message">Message:</label><input type="text" name="message" id="message" /></div>
    <div class="row"><label for="NewMessages1"> </label><input id="NewMessages1" type="submit" value="create" class="submitbutton" /></div>

</form>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 2/1/12
 * Time: 8:44 PM
 * To change this template use File | Settings | File Templates.
 */
 

/**
 * @var boardCollection $boardColl
 */






$boardColl = $view['boardColl'];

echo '<table>';
while ( $boardColl->valid() )
{

    $dataCurrent = $boardColl->current();
    $dataRow = $dataCurrent->getGenericArray();
    echo '<tr>';

    echo '<td>'  . $dataRow['username']  .  '</td>';
    echo '<td>'  . $dataRow['entered_on']  .  '</td>';
    echo '<td>'  . $dataRow['message']  .  '</td>';
    echo '</tr>';

    $boardColl->next();
}
echo '</table>';
echo "</div>";