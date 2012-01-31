<?php

// Return Code : 0 is success, 1 is no rows, and 10 : failure -->
// ex. http://www.myserver.dev:8080/services/companyMomentum.php?output=json

	require '../lib/common/db.inc.php';
	require '../lib/common/db.inc.admin.php';
	require '../lib/common/autoloader.php';
	require '../lib/common/customErrorHandler.php';

	error_reporting(E_ALL);
	set_error_handler("customErrorHandler");
	session_start();

	
	/* require the user as the parameter */
	//i.e.  query=
	/*if(!isset($_GET['query'])) 
	{	
		customErrorHandler(E_USER_NOTICE, "Require rows parameter in " . __CLASS__ ." service: ", __FILE__, __LINE__);	
		customObjectErrorHandler(E_ERROR, $_GET, __FILE__, __LINE__);
	}
	*/
	
	
	$output = outputFormatter::checkOutputParam();

	$connection = db::factory('mysql');
	
	/*
	$query = stripslashes( $_GET['query'] );
	$rows = $connection->getPostableArray($query);
	*/
	
	//1. Get parameters and action (get, post, put, delete)
	
		$sortableKey = 'week1_delta';
		if ( isset($_GET['sortableKey']) )
		{
				$sortableKey = stripslashes( $_GET['sortableKey'] );
		}
		
		$sortOrder = 'desc';
		if ( isset($_GET['sortOrder' ]) )
		{
				$sortOrder = stripslashes( $_GET['sortOrder'] );
		}
		
		
		$referenceDate = strtotime("now");
		if ( isset($_GET['referenceDate' ]) )
		{
				$referenceDate =  strtotime($_GET['referenceDate'] );				
		}
		
		$duration = 2;
		if ( isset($_GET['duration' ]) )
		{
				$duration = stripslashes( $_GET['duration'] );
		}
		
		$minMAJobsSelected = 15;
		if ( isset($_GET['minMAJobsSelected' ]) )
		{
		  $minMAJobsSelected = stripslashes( $_GET['minMAJobsSelected'] );
		}        
	
	//2. Make call to the Business Object
	
	
    $company_def = new company_def(array('ticker_id'=> 'AAPL') ); //dummy
    $companyAcqColl = new companyMomentumBO($company_def);
    $companyAcqColl->setCompanyFilter('%');
    $companyAcqColl->getwithdata();
    $tableRows = $companyAcqColl->getMomentumData($sortableKey, $sortOrder, $referenceDate, $duration, $minMAJobsSelected);

	
	//3. Return results
	
	if ( count($tableRows) < 1)
	{
		$message = "getMomentumData failed";
		customErrorHandler(E_USER_NOTICE, $message, __FILE__, __LINE__);
		outputFormatter::displayResult(1, $message, 'json');
		return;
	}
	outputFormatter::display($tableRows,$output);
	$connection->close();
	return;
	
	/*Testing service - play catch
	
	ob_start();
	outputFormatter::display($rows,$output);
    	$msg = ob_get_clean();
    	
    	$newRows2 = outputFormatter::parse($msg,$output);
    	
	outputFormatter::display($rows,$output);
    	
    	
        customErrorHandler(E_USER_NOTICE, "Rows From Post", __FILE__, __LINE__);
        customObjectErrorHandler(E_USER_NOTICE, $newRows2, __FILE__, __LINE__);
    	

	*/

?>