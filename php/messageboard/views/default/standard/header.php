
<?php
if (auth::isloggedin()) {
    $links = array('/'=>'Home',
                   '/messages/showAll'=>view::getViewPageName('messages') );


    $links['/logout'] = 'Log Out';
    
    echo '<ul>';
    foreach ($links as $link=> $title) {
        echo '<li><a href="' . $link . '">' . $title . '</a></li>';
    }
}
?>