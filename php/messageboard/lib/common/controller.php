<?php
class controller
{
    protected $parts;
    public $params;
    
	public function __construct($urlString)
	{
		if (substr($urlString, -1, 1) == '/') {
			$urlString = substr($urlString, 0, strlen($urlString) - 1);
		}
		
		$parts = explode('/', $urlString);
		if (empty($parts[0])) {
			$parts[0] = 'index';
		}
		if (empty($parts[1])) {
			$parts[1] = 'defaultaction';
		}
		
		$this->parts = $parts;
		array_shift($parts);
		array_shift($parts); 
		$this->params = $parts;
	}
	
	public function render()
	{
		if (!class_exists($this->parts[0])) 
		{
			throw new SectionDoesntExistException("{$this->parts[0]} is not a valid module.");
		}
		
		if (!method_exists($this->parts[0], $this->parts[1])) 
		{
			throw new ActionDoesntExistException("{$this->parts[1]} of module {$this->parts[0]} is not a valid action.");
		}
		
		customErrorHandler(E_USER_NOTICE, "Control passed to!:"  . $this->parts[0] ."--". $this->parts[1] , __FILE__, __LINE__);
		
		$called = call_user_func(array(new $this->parts[0], $this->parts[1]));
		
		if ($called === FALSE) 
		{
			throw new ActionFailedException("{$this->parts[1]} of section {$this->parts[0]} failed to execute properly.");
		}
	}
}
?>