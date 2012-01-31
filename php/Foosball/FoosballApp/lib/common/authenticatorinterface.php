<?php
/**
 * Defines the authentication interface.
 *
 */
interface authenticatorinterface
{
    public function authenticate(user $user, $password);
}

?>