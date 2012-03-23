<?php
class lib
{
	//This class sets session variables and retrieves them for presistance
	const SETTING_AN_ARRAY = TRUE;
	
	const NO_PERSISTENT_STORAGE = FALSE;

    /**
     * @static
     * @param $name
     * @param bool $persist - if true, we keep the session variable
     * @return null
     */
	public static function getitem($name, $persist = TRUE)
	{
		$return = NULL;
		
		if (isset($_SESSION[$name]))
		{
			$return = $_SESSION[$name];
			
			if (!$persist)
		    { //debate usefullness, to avoid multithreading issue I guess?
				unset($_SESSION[$name]);
			}
		}
		else
		{
			customErrorHandler(E_ERROR, "No session variable: " . $name, __FILE__, __LINE__);
		}
		
		return $return;
	}
	
	public static function setitem($name, $value, $array = false)
	{
		if ($array)
		{
			if (!isset($_SESSION[$name]))
		    {
				$_SESSION[$name] = array();
				$_SESSION[$name][] = $value;
			}
			else
			{
				$_SESSION[$name][] = $value;
			}
		}
		else
		{
			$_SESSION[$name] = $value;	
		}
	}

    public static function clearAllItems()
    {
		foreach ( $_SESSION as $name=>$value )
		{
				unset($_SESSION[$name]);
		}
	}
	
	public static function clearItem($name)
	{

				unset($_SESSION[$name]);
	}	

    public static function exists($name)
	{
		return isset( $_SESSION[$name] );
	}
	
	public static function seterror($error)
	{
		self::setitem('error', $error, self::SETTING_AN_ARRAY);
	}
	
	public static function sendto($url = '')
	{
		if (empty($url))
		{
			$url = '/';
			//or header("HTTP/1.0 404 Not Found");
		}
		//Location: is an HTTP redirect (302)
		die(header('Location: ' . $url));
	}
	
    public static function makehashedpassword(user $user, $password)
    {
        return sha1($user->username . $password);
    }
}
?>