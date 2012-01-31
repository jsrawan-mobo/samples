<?php
class authstandard implements authenticatorinterface
{
    public function authenticate(user $user, $password)
    {    
    	
    	//return true;
    	$databasePassword = lib::makehashedpassword($user, $password);
        if ($user->password == $databasePassword ) 
        {
            return true;
        }
        else 
        {
            customErrorHandler(E_USER_ERROR, "The passwords did not match"  . $user->password . "--" . $databasePassword       ,__FILE__,__LINE__); 
            return false;
        }
    }
}
?>