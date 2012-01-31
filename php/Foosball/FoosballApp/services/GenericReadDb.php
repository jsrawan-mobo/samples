<?php

		// Return Code : 0 is success, 1 is no rows, and 10 : failure -->


	require '../lib/common/db.inc.php';
	require '../lib/common/db.inc.admin.php';
	require '../lib/common/autoloader.php';
	require '../lib/common/customErrorHandler.php';

	error_reporting(E_ALL);
	set_error_handler("customErrorHandler");
	session_start();

	
	/* require the user as the parameter */
	//i.e.  query=
	if(!isset($_GET['query'])) 
	{	
		customErrorHandler(E_USER_NOTICE, "Require rows parameter in GenericRead service: ", __FILE__, __LINE__);	
		customObjectErrorHandler(E_ERROR, $_GET, __FILE__, __LINE__);
	}
	
	
	$output = outputFormatter::checkOutputParam();

	$connection = db::factory('mysql');
	$query = stripslashes( $_GET['query'] );
	

	$rows = $connection->getPostableArray($query);
	
	if ( count($rows) < 1)
	{
		$message = "getPostableArray returned no rows from following query: " . $query;
		customErrorHandler(E_USER_NOTICE, $message, __FILE__, __LINE__);
		outputFormatter::displayResult(1, $message, 'json');
		return;
	}
	outputFormatter::display($rows,$output);
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