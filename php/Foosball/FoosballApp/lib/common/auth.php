<?php
class auth
{
	public static function isloggedin()
	{
	    return lib::exists('user');
	}
	
	/*
	public static function isadmin()
	{
	    return self::isloggedin() && (1 == lib::getitem('user')->admin);
	}
	*/
	
	
	public static function authenticate(user $user, $password)
	{
	    $authenticator = self::factory('MySQL');
	    return $authenticator->authenticate($user, $password);
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