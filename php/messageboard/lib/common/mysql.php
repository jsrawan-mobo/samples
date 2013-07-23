<?php
class mysql extends db
{
	protected static $instanceAdmin = null;
	protected static $instanceUser = null;
	protected $link;
	protected $isAdmin;

	public static function getInstance($isAdmin = false)
	{
		//Need to distinguish between admin connectino and a normal connection
		
		if ( $isAdmin == true )
		{
			if (is_null(self::$instanceAdmin))
			{
				self::$instanceAdmin = new self($isAdmin);
			}
			return self::$instanceAdmin;				
		}
		else
		{
			if (is_null(self::$instanceUser))
			{
				self::$instanceUser = new self($isAdmin);
			}
			return self::$instanceUser;	
		}
		
		
	}
	
	protected function __construct($isAdmin)
	{
		$this->isAdmin = $isAdmin;
		if ($this->isAdmin == true)
		{
			$user = MYSQL_USER_ADMIN;
			$pass = MYSQL_PASSWORD_ADMIN;
			$host = MYSQL_HOST_ADMIN;
			$db = MYSQL_DB_ADMIN;
		}
		else
		{
			$user = MYSQL_USER;
			$pass = MYSQL_PASSWORD;
			$host = MYSQL_HOST;
			$db = MYSQL_DB;
		}
		
		$this->link = mysqli_init();
		$this->link->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 1');
		$this->link->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);


		//$this->link->real_connect($host, $user, $pass, $db, true, 131074); //tbd:linux65536);
		if (!  $this->link->real_connect($host, $user, $pass, $db, 3306) )
		{
		    customErrorHandler(E_ERROR, "could not connect : Error No: " . mysqli_connect_errno()  . " With Error: " . mysqli_connect_error(). $this->isAdmin . "--" . $host . "--" . $user . "--" . $pass . "--" . $db, __FILE__, __LINE__);
		}
	}
	
	
	//This function esacpes a string and returns the string that was escaped.
	public function clean($string)
	{
	    return $this->link->real_escape_string($string);
	}
	
	public function getArray($query)
	{
		if (! $this->link )
		{
		    customErrorHandler(E_ERROR, "link is invalid", __FILE__, __LINE__);
		
		}
        customErrorHandler(E_USER_NOTICE, "q:". $query, __FILE__, __LINE__);
	    $result = $this->link->query($query);

	    if (!$result)
	    {
				customErrorHandler(E_ERROR, "queryFailed: " . $query . " Error No: " . mysqli_errno($this->link)  . " With Error: " . mysqli_error($this->link) , __FILE__, __LINE__);
	    }

		$return = array();
 

		while ($result != null)
		{
			while ($row = $result->fetch_assoc())
			{
				$return[] = $row;
			}
			$result->free();
			$result = null;
			if ( $this->link->more_results() )
			{
				$results = 	$this->link->next_result();
			}
		} 				
		return $return;
	}
	
	
	//temp, this returns more than one value, we need to derive a collections from this (probably depricated by DAO connection)
	public function getPostableArray($query)
	{
		if (! $this->link )
		{
		    customErrorHandler(E_ERROR, "link is invalid", __FILE__, __LINE__);
		
		}
        customErrorHandler(E_USER_NOTICE, "q:". $query, __FILE__, __LINE__);
		$result = $this->link->query($query);
		
		if (!$result)
	    {
				customErrorHandler(E_ERROR, "queryFailed: " . $query . " Error No: " . mysqli_errno($this->link)  . " With Error: " . mysqli_error($this->link) , __FILE__, __LINE__);
	    }
		$return = array();
		
		while ($result != null)
		{
			while ($row = $result->fetch_assoc())
			{
				$return[] = array('row'=>$row);
			}
			$result->free();
			$result = null;
			if ( $this->link->more_results() )
			{
				$results = 	$this->link->next_result();
			}
		} 					
		return $return;
	}	
	
//this only writes.
	public function execute($query)
	{
		if (! $this->link )
		{
		    customErrorHandler(E_ERROR, "link is invalid", __FILE__, __LINE__);
		
		}		
		$result = $this->link->query($query);
		
		if (!$result)
	    {
			customErrorHandler(E_ERROR, "queryFailed: " . $query . " Error No: " . mysqli_errno($this->link)  . " With Error: " . mysqli_error($this->link) , __FILE__, __LINE__);
	    }	
		return true;
	}
	
	//this executes the query and returns the id (unique id)
	public function insertGetID($query)
	{
	    $this->execute($query);
	    
	    $num = $this->link->insert_id;
	    if ($num <= 0)
	    {
			customErrorHandler(E_ERROR, "queryFailed" . $query , __FILE__, __LINE__);
	    }

	    return $num; 
	}
	
	public function close()
	{
		//The @ suppress output!
		@$this->link->mysqli_close();
	}
}
?>