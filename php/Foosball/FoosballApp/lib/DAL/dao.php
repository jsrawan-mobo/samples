<?php
class dao
{
    protected $values = array();
    
    public function __construct($qualifier = NULL)
    {
        if (!is_null($qualifier)) {
            
            $conditional = array();
            
            if (is_numeric($qualifier)) {
                $conditional = array('id'=>$qualifier);
            }
            else if (is_array($qualifier)) {
                $conditional = $qualifier;
            }
            else {
                throw new Exception('Invalid type of qualifier given');
            }

            $this->populate($conditional);
        }
    }
    
    public function __set($name, $value)
    {
        $this->values[$name] = $value;
    }
    
    public function __get($name)
    {
        if (isset($this->values[$name])) {
            return $this->values[$name];
        }
        else {
            return null;
        }
    }
    
    
    public function getGenericArray()
    {
	return $this->values;
    }
    
    protected function isAdmin()
    {
    	return false;
    }


	public function numRecords($conditional)
	{
		$valuearray = $this->getPopulate($conditional);
		
		return count($valuearray);
	}

	protected function addWhereClause($conditional)
	{
		$connection = db::factory('mysql');
		$qualifier = '';
		foreach ($conditional as $column=>$value)
		{
			if (!empty($qualifier))
			{ 
				$qualifier .= ' and ';
			}
			$qualifier .= "`{$column}`='" . $connection->clean($value) . "' ";
		}
		return  (" where " . $qualifier);
	}

	protected function addUpdateParams($parameters)
	{
		$connection = db::factory('mysql');
		$updates = array();
	    foreach ($parameters as $key=>$value) 
	    {
			$key = "`{$key}`=";

			if (strcasecmp($value, "NULL") == 0)
			{
				$updates[] = $key . "NULL";
			}
			else
			{
				$updates[] = $key . "'" . $connection->clean($value) . "'";
			}
		}
	
	    $paramStr = " set " . implode(',', $updates);
		return $paramStr;
	}

	protected function addInsertParams($parameters)
	{
		$connection = db::factory('mysql');

			$paramStr = "(`";
	        $paramStr .= implode('`, `', array_keys($parameters));
	        $paramStr .= "`) values (";
	        
	        $clean = array();
	        foreach ($parameters as $value) 
	        {
				if (strcasecmp($value, "NULL") == 0)
				{
					$clean[] = "NULL";
				}
				else
				{ 
					$clean[] = "'" . $connection->clean($value)  . "'";
				}
	        }
	        $paramStr .= implode(', ', $clean);
	        $paramStr .= ")";
	 
		return $paramStr;
	}

	protected function getPopulate($conditional)
	{
        ob_start();
       	var_dump($conditional);
        $conditionalString = ob_get_clean();

		customErrorHandler(E_USER_NOTICE, "dao::populate for table" . $this->table . " qualifier " . $conditionalString , __FILE__, __LINE__);

		$connection = db::factory('mysql',  $this->isAdmin());
		
		$sql = "select * from {$this->table}";

		$sql .= $this->addWhereClause($conditional);

		$valuearray = $connection->getArray($sql);

		return $valuearray;

	}


	protected function populate($conditional)
	{
		$valuearray = $this->getPopulate($conditional);
		
		if ( count($valuearray) <> 1 )
		{
		    ob_start(); var_dump($conditional); $tempStr = ob_get_clean();		     
		    customErrorHandler(E_NOTICE, "Did not get 1 row for table:" . $this->table . " instead got:" . count($valuearray) . "with Conditional:" . $tempStr   ,__FILE__,__LINE__); 
		}
		
		if (!isset($valuearray[0])) {
			$valuearray[0] = array();
		}
		
		foreach ($valuearray[0] as $name=>$value)
		{
			$this->$name = $value;
			$this->__set($name, $value); //This will allow iteration.
		}
	}
	
	//This is for tables that have an incrementing AI id
	public function save() 
	{
	    $result = false;
	    if (!$this->id) 
	    {
	        $result = $this->create();
	    }
	    else 
	    {
	        $result = $this->update();
	    }
	    return $result;
	}

	//This is for tables that have no AI primary key
	public function saveWithNoId() 
	{
	    $result = false;
		$result = $this->create(false);

	    return $result;
	}
	
	protected function create($insertID = true)
	{
	    
	        customErrorHandler(E_USER_NOTICE,   "create", __FILE__, __LINE__);	        
		    
	        $connection = db::factory('mysql');
	        
	        $sql = "insert into {$this->table}";

			$sql .= $this->addInsertParams( $this->values );
	        
			if ($insertID)
			{
				$this->id = $connection->insertGetID($sql);
			}
			else
			{
				$result = $connection->execute($sql);
			}
		
		return true;	        
	}


	public function updateWithNoId($conditional) 
	{
		$connection = db::factory('mysql');
	    
	    $sql = "update {$this->table}";
	    
		$sql .= $this->addUpdateParams($this->values);
		
		$sql .= $this->addWhereClause($conditional);
		    
	    $result = $connection->execute($sql);
	    
	    if (!$result)
	    {
		    customErrorHandler(E_ERROR, "queryFailed" . $sql , __FILE__, __LINE__);
		    return false;
	    
	    }
	    return true;

	}
	
		
	protected function update()
	{
	    $connection = db::factory('mysql');
	    
	    $sql = "update {$this->table}";
	    
		$sql .= $this->addUpdateParams($this->values);

		$sql .= $this->addWhereClause( array('id' => $this->id) );

	    $result = $connection->execute($sql);
	    
	    if (!$result)
	    {
		    customErrorHandler(E_ERROR, "queryFailed" . $sql , __FILE__, __LINE__);
		    return false;
	    
	    }
	    return true;
	
	}
}
?>