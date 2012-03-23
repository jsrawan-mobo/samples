<?php






/**
 * This class is responsible for display the view
 * It also handles things like <head> and <body> insertion.
 * Support for different user agents is good to go as well. (default, mobile).
 *
 */
class view
{
    public static $LAST_SHOW_VIEW = 'view_LAST_SHOW_VIEW';

    /**
     * @var USER AGENT viewtype
     */
    public static $viewtype;

    /**
     * This a naming convention for all view rather than use html
     * @var
     */
    public static $VIEW_LOCATION_LOOKUP;


    /**
     * this is the location to the head.php element that can be use
     * to include a special header, i.e. loading javascript on demans
     * @var
     */
    public static $_htmlHeadView;

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

    /**
     * This gets any echoed data in the buffer.
     * Generally the way the design is it should be empty.
     * @return string
     *
     */
    public function finish()
    {
        $content = ob_get_clean();
        return $content;        
    }

    public static function renderHead()
    {

        $content = '';
	    if (is_readable(self::$_htmlHeadView))
        {
            ob_start();
            include self::$_htmlHeadView;
            $content = ob_get_clean();
         }
		return $content;
	}

    
	public static function show($location, $params = array())
	{
	    if (empty(self::$viewtype)) {
	        self::setviewtype();
	    }
	    
        $views[] = $_SERVER['DOCUMENT_ROOT'] . '/views/' . self::$viewtype . '/' . $location . '.php';

        $parts = explode('/', $location);
		if (count($parts) == 2) {
			self::$_htmlHeadView = $_SERVER['DOCUMENT_ROOT'] . '/views/' . self::$viewtype . "/" .$parts[0] .'/head.php';
		}



		$content = '';

        //Note: Ithink we don't need a loop here any more
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