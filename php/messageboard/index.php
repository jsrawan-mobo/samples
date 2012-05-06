<?php


    /**
     * This file gets called on every page request
     * It seets up things like autoloading, smart, database etc.
     *
     *
     *
     */
    require 'lib/DAL/db.inc.php';
	require 'lib/DAL/db.inc.admin.php';
	require 'lib/common/autoloader.php';
    require 'lib/common/exceptions.php';
	require 'lib/common/customErrorHandler.php';


    /*
     * This is required to template the <
     * the index is the case sensitive name of the view folder
     * The value to show
     *
     * */
    $VIEW_LOCATION_LOOKUP = array(    '0' => "Default",
                                                'messages' => "Message Board",
                                                'login' => "Login",
                                                );


	error_reporting(E_ALL);
	set_error_handler("customErrorHandler");
	session_start();
	
	
	$pageRequested = "";
	if (isset($_GET['u']))
	{ $pageRequested = $_GET['u']; }
	
	customErrorHandler(E_USER_NOTICE, "Page Requested:"  . $pageRequested, __FILE__, __LINE__); 

	lib::setitem('controller', new controller($pageRequested));
	$view = new view();
    view::setViewPageName($VIEW_LOCATION_LOOKUP);

	
	lib::getitem('controller')->render();

    $headerContent = view::renderHead();

    $content = $view->finish();


	echo view::show('shell', array('body'=>$content, 'headerContent'=>$headerContent, 'pagename'=> view::getViewPageName($pageRequested) ) );

?>