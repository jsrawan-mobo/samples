<?php
    $errors = "";    
    if (lib::exists('error'))
    {
        $errors = lib::getitem('error', lib::NO_PERSISTENT_STORAGE);
    }

    if (is_array($errors))
    {
        print '<ul class="error"><li>' . implode('</li><li>', $errors) . '</li></ul>';
    }
    
?>