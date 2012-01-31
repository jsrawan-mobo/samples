<?php






class view
{
    public static $LAST_SHOW_VIEW = 'view_LAST_SHOW_VIEW';

    public static $viewtype;

    public static $VIEW_LOCATION_LOOKUP;


 


    public function __construct()
    {
        ob_start();
    }

    public static function setViewPageName($viewLocationLookup)
    {
       self::$VIEW_LOCATION_LOOKUP = $viewLocationLookup;
    }


	public static function getViewPageName($location)
	{
		$pageName = strtok($location, "/");
		$viewName = self::$VIEW_LOCATION_LOOKUP[$pageName];
		return $viewName;
	}
    
    public function finish()
    {
        $content = ob_get_clean();
        return $content;        
    }
    
	public static function show($location, $params = array())
	{
	    if (empty(self::$viewtype)) {
	        self::setviewtype();
	    }
	    
	    if (self::$viewtype != 'default') 
	    {
	        $views[] = $_SERVER['DOCUMENT_ROOT'] . '/views/' . self::$viewtype . '/' . $location . '.php';
	    }
	    $views[] = $_SERVER['DOCUMENT_ROOT'] . '/views/default/' . $location . '.php';
		
		$content = '';
		
		foreach ($views as $viewlocation) 
		{
	    		if (is_readable($viewlocation)) 
	    		{
	    		    $view = $params;

	    			ob_start();
	    			include $viewlocation;
	    			$content = ob_get_clean();
	    			break;
	    		}
		}
		
		return $content;
	}
	
	protected static function setviewtype()
	{
	    switch (TRUE) {
	        case stripos($_SERVER['HTTP_USER_AGENT'], 'Windows CE') !== FALSE:
	            self::$viewtype = 'mobile';
	            break;
	        default:
	            self::$viewtype = 'default';
	    }
	}
}
?>