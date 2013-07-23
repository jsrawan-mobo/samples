<?php


//10 is reserved for assertion
//other codes are acceptable, 0 should be success and
// 1-9 can be used as desired.
function addUserResponseMessage($data, $code, $msg)
{
	$data['userCode'] = $code;
	$data['userMsg'] = $msg;
	echo json_encode($data);
}



function customErrorHandler($type, $msg, $file, $line)
{
	date_default_timezone_set('America/Los_Angeles');
	$today = date("Y-m-d");
	$filename = "./logs/$today.txt";
	$fd = fopen($filename, "ab");
	$str = "[" . date("h:i:s", time()) . "]" . $msg;
	fwrite($fd, $str . " " .$file . "(" . $line .")"  . PHP_EOL);
	fclose($fd);
	
	
	if($type < E_USER_ERROR)
	{
		header('Content-type: application/json');
		$dummy = array( 'data' => null);
		addUserResponseMessage($dummy, 10, "ASSERTED with msg: " . $msg );
		die;
	}
	else
	{
		//TBD: these are for info. error_log("$msg (error type $type)", 0);	
	}
}


function customObjectErrorHandler($type, $obj, $file, $line)
{
	ob_start();
	var_dump($obj);
    	$msg = ob_get_clean();	
	customErrorHandler($type, $msg, $file, $line);
}



?>