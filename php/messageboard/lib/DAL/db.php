<?php
abstract class db
{
	/*Abstract class to encapsulate generic databse functionality (so if we change drivers or engines)*/
	
	/*Simple interface for singleton type objects*/


    /**
     * This is factory design pattern with singleton getInstance() function.
     * These compound patterns are popular in java
     * It also represents a facade
     *
     * @static
     * @param $type - The name of the sql adapter i.e. MySql
     * @param bool $isAdmin - get an admin connection (for logins).
     * @return mixed
     */
	public static function factory($type, $isAdmin = false)
	{
		return call_user_func_array(array($type, 'getInstance'), array($isAdmin) );
	}

    /**
     * These give access to the sql DAL layer
     * @abstract
     * @param $query
     * @return void
     */
	abstract public function execute($query);
	abstract public function getArray($query);
	abstract public function insertGetID($query);
	abstract public function clean($string);
	abstract public function close();


}
?>