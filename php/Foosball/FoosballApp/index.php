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
	require 'lib/common/globalConfigurations.php';

    require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/smarty/Smarty.class.php');


// create object
    $smarty = new Smarty;
    $smarty->template_dir = $_SERVER["DOCUMENT_ROOT"]. '/views/default/foosballHomeTemplate';
    $smarty->compile_dir = $_SERVER["DOCUMENT_ROOT"] . '/cache/smarty/templates_c';
    $smarty->cache_dir = $_SERVER["DOCUMENT_ROOT"] . '/cache/smarty/cache';
    $smarty->config_dir = $_SERVER["DOCUMENT_ROOT"] . '/cache/smarty/configs';


    /***
     * @TODO This is 3.11.7 Smarty.  Didn't work due to templating problems
     *
     *
     */
    /*require_once('lib/smarty/Smarty.class.php');
    $smarty = new Smarty();
    $smarty->setTemplateDir('views/default/foosballHomeTemplate');
    $smarty->setCompileDir('cache/smarty/templates_c');
    $smarty->setCacheDir('cache/smarty/cache');
    $smarty->setConfigDir('cache/smarty/configs');
    $smarty->testInstall();
    */

    /*
     * This is required to template the <
     * the index is the case sensitive name of the view folder
     * The value to show
     *
     * */
    $VIEW_LOCATION_LOOKUP = array(    '0' => "Default",
                                                'parameterDef' => "Parameters",
                                                'login' => "Login",
                                                'tables' => "Tables",
                                                'foosballHome' => 'My Foosball World',
                                                'foosballHomeTemplate' => 'My Foosball World Temlate',
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
    $view::setSmarty($smarty);
    view::setViewPageName($VIEW_LOCATION_LOOKUP);

	
	
	lib::getitem('controller')->render();

    $headerContent = view::renderHead();

    $content = $view->finish();


	echo view::show('shell', array('body'=>$content, 'headerContent'=>$headerContent, 'pagename'=> view::getViewPageName($pageRequested) ) );

	
	/*
	$output = outputFormatter::checkOutputParam();
	$connection = db::factory('mysql');
	$query = "SELECT * from company_def";
	$posts = $connection->getArray($query);
	outputFormatter::display($posts,$output);
	
	*/

?>