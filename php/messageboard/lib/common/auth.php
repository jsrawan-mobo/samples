<?php
class auth
{
	public static function isloggedin()
	{
	    return lib::exists('user');
	}
	
	public static function authenticate(users $user, $password)
	{
	    $authenticator = self::factory('standard');
	    return $authenticator->authenticate($user, $password);
	}


	public static function create($username, $password)
	{
	    $authenticator = self::factory('standard');
	    return $authenticator->create($username, $password);
	}

	
	protected static function factory($type)
	{
	    $class = "auth{$type}";
	    if (class_exists($class)) {
	        return new $class;
	    }
	    else {
            throw new InternalException($type . ' is not a defined auth module.');	        
	    }
	}
}
?>