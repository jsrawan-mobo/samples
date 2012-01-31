<?php
	require 'lib/DAL/db.inc.php';
	require 'lib/DAL/db.inc.admin.php';
	require 'lib/common/autoloader.php';
    require 'lib/common/exceptions.php';
	require 'lib/common/customErrorHandler.php';
	require 'lib/common/globalConfigurations.php';


    /*
     * the index is the case sensitive name of the view folder
     * The value to show
     *
     * */
    $VIEW_LOCATION_LOOKUP = array(    '0' => "Default",
                                                'parameterDef' => "Parameters",
                                                'login' => "Login",
                                                'tables' => "Tables",
                                                'foosballHome' => 'My Foosball World',
                                                'statistics' => 'King of Turf',
                                                'tournamentLoader' => 'Tournament Loader',
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
	$content = $view->finish();
	echo view::show('shell', array('body'=>$content, 'pagename'=> view::getViewPageName($pageRequested) ) );

	
	/*
	$output = outputFormatter::checkOutputParam();
	$connection = db::factory('mysql');
	$query = "SELECT * from company_def";
	$posts = $connection->getArray($query);
	outputFormatter::display($posts,$output);
	
	*/

?>