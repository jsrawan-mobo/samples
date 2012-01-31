
<?php
if (auth::isloggedin()) {
    $links = array('/'=>'Home', 
                   '/tables/showAll'=>view::getViewPageName('tables'),
                   '/views/default/documents'=>'Documents',
                   '/foosballHome/showAll'=>view::getViewPageName('foosballHome'),
                   '/foosballHomeTemplate/showAll'=>view::getViewPageName('foosballHomeTemplate'),
                   '/statistics/showAll' => view::getViewPageName('statistics'),
                   '/tournamentLoader/showAll' => view::getViewPageName('tournamentLoader'));


    $links['/logout'] = 'Log Out';
    
    echo '<ul>';
    foreach ($links as $link=> $title) {
        echo '<li><a href="' . $link . '">' . $title . '</a></li>';
    }


    $player = lib::getitem('player');

    echo '<li>' .  $player->login . '</li>';
    echo '<li>' .  $player->privelege . '</li>';
    echo '</ul>';
}
?>