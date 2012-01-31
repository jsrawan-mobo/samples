<?php






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

    /**
     * We can render a smarty view or php view.
     * @var
     */
    public static $_smarty;



    public function __construct()
    {
        ob_start();
    }

    /**
     * @static
     * @param smarty.class $smarty
     * @return void
     */
    public static function setSmarty($smarty)
    {
       self::$_smarty = $smarty;
    }


    /**
     * @static
     * @return smarty.class
     */
    public static function getSmarty()
    {
       return self::$_smarty;
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


    public static function showSmarty($location, $smarty)
	{
	    if (empty(self::$viewtype)) {
	        self::setviewtype();
	    }

        $views[] = $_SERVER['DOCUMENT_ROOT'] . '/views/' . self::$viewtype . '/' . $location . '.php';

        $parts = explode('/', $location);
		if (count($parts) == 2) {
			self::$_htmlHeadView = $_SERVER['DOCUMENT_ROOT'] . '/views/' . self::$viewtype . "/" .$parts[0] .'/head.php';
		}
        $smarty->display('show.tpl');
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