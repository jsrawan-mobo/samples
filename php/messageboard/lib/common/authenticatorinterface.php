<?php
/**
 * Defines the authentication interface.
 *
 */
interface authenticatorinterface
{
    public function authenticate(users $user, $password);

    public function create($username, $password);


}

?>