
<?php
	require '../lib/common/db.inc.php';
	require '../lib/common/db.inc.admin.php';
	require '../lib/common/autoloader.php';
	require '../lib/common/customErrorHandler.php';
	
	session_start();
	customErrorHandler(E_USER_NOTICE, "Web Service Called", __FILE__, __LINE__);

	$output = outputFormatter::checkOutputParam();

	$connection = db::factory('mysql');
	$query = "SELECT * from company_def";
	$rows = $connection->getPostableArray($query);
	//outputFormatter::display($rows,$output);
	
	//Testing service - play catch
	
	ob_start();
	outputFormatter::display($rows,$output);
		$msg = ob_get_clean();
		
		$newRows2 = outputFormatter::parse($msg,$output);
    	
	outputFormatter::display($rows,$output);
    	
    	
        customErrorHandler(E_USER_NOTICE, "Rows From Post", __FILE__, __LINE__);
        customObjectErrorHandler(E_USER_NOTICE, $newRows2, __FILE__, __LINE__);
    	

	$connection->close();

?>