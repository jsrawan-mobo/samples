<?php

// Return Code : 0 is success,2 and 10 : failure -->


	require '../lib/common/db.inc.php';
	require '../lib/common/db.inc.admin.php';
	require '../lib/common/autoloader.php';
	require '../lib/common/customErrorHandler.php';
	require '../lib/common/globalConfigurations.php';


	//unpack to the POST
	if(!isset($_POST['rows'])) 
	{	
		customErrorHandler(E_USER_NOTICE, "Require rows parameter in GenericWrite service: ", __FILE__, __LINE__);	
		customObjectErrorHandler(E_ERROR, $_POST, __FILE__, __LINE__);
				
	}


	session_start();
	
	customErrorHandler(E_USER_NOTICE, "Web Service Called", __FILE__, __LINE__);

	$format = outputFormatter::checkOutputParam();
	$myRows = ($_POST['rows']);
	$myRows = htmlspecialchars_decode($_POST['rows']);

	$postedRows = outputFormatter::parse($myRows, $format);

	if ( count($postedRows) < 1)
	{
		$error_msg_num = json_last_error();
		customErrorHandler(E_USER_NOTICE, $error_msg_num . " no rows from following json: ", __FILE__, __LINE__);	
		customObjectErrorHandler(E_ERROR, $myRows, __FILE__, __LINE__);
	}
	
	
	//outputFormatter::display($postedRows, $format);

	$dataArray;
	$rowCount = 0;
	$databaseName = "";

	foreach ($postedRows as $rowData)
	{
 
		foreach ($rowData as $properties=>$propValues)
		{
		
			customErrorHandler(E_USER_NOTICE, "Properties:" . $properties , __FILE__, __LINE__);		

			if ( $properties == "databaseName")
			{
				$databaseName = $propValues;
			}
			else
			{
				foreach ( $propValues as $col=>$value)
				{
					//customErrorHandler(E_USER_NOTICE, "hello: ". $rowCount , __FILE__, __LINE__);	
					//customObjectErrorHandler(E_USER_NOTICE, $col , __FILE__, __LINE__);
					//customErrorHandler(E_USER_NOTICE, "hello: ". $rowCount , __FILE__, __LINE__);				
					//customObjectErrorHandler(E_USER_NOTICE, $value , __FILE__, __LINE__);
					//array_push($dataArray[$rowCount], array($col=>$value) );
					$dataArray[$databaseName][$rowCount][$col] = $value;
				}
			}
		}
		$rowCount++;	
	}
	
	//outputFormatter::display($dataArray, 'json');

	
	foreach ($dataArray as $database=>$rowArray)
	{
		$daoObj = new careeracquisition();
		
		$gtc = new genericTableCollection($daoObj);
	
		$gtc->__setTableName($databaseName);
		
		$gtc->populate($rowArray , $databaseName);
		
		
		//debug
		//$storageOutput = $gtc->getStorage();
		//customObjectErrorHandler(E_USER_NOTICE, $storageOutput , __FILE__, __LINE__);		

		//
		$gtc->saveall();
		customErrorHandler(E_USER_NOTICE, "Finished Writing" , __FILE__, __LINE__);		
	}
    outputFormatter::displayResult(0, "Success", 'json');
	
	/*Testing service - play catch
	
	ob_start();
	outputFormatter::display($rows,$output);
    	$msg = ob_get_clean();
    	
    	$newRows2 = outputFormatter::parse($msg,$output);
    	
	outputFormatter::display($rows,$output);
    	
    	
        customErrorHandler(E_USER_NOTICE, "Rows From Post", __FILE__, __LINE__);
        customObjectErrorHandler(E_USER_NOTICE, $newRows2, __FILE__, __LINE__);
    	

	$connection->close();
	*/

?>
