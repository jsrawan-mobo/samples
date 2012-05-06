<?php
class authstandard implements authenticatorinterface
{
    public function authenticate(users $user, $password)
    {    
    	
    	//return true;
    	$hashedPassword = lib::makehashedpassword($user, $password);
        if ($user->password == $hashedPassword )
        {
            return true;
        }
        else 
        {
            customErrorHandler(E_USER_ERROR, "The passwords did not match"  . $user->password . "--" . $hashedPassword       ,__FILE__,__LINE__);
            return false;
        }
    }


    public function create($username, $password)
    {
          $user = new users();
          $user->username = $username;
          $hashedPassword = lib::makehashedpassword($user, $password);

          $user->password = $hashedPassword;

          $user->saveWithNoId();
    }

}
?>