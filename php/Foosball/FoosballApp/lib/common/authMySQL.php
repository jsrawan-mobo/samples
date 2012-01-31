<?php


/**
 * Uses the mysql table to figure out the password.
 *
 *
 */
class authMySQL implements authenticatorinterface
{
    public function authenticate(user $user, $password)
    {    

	    $connection = db::factory('mysql', true);
        
	    $sql = "select PASSWORD('$password') encryptedPass;";
        $results = $connection->getArray($sql);

        if ($user->Password == $results[0]['encryptedPass']) 
        {
            return true;
        }
        else 
        {
            customErrorHandler(E_USER_ERROR, "The passwords did not match"  . $user->Password . "--" . $results[0]['encryptedPass']       ,__FILE__,__LINE__); 
            return false;
        }
    }
}
?>