<?php
class outputFormatter 
{
    
        public static function checkOutputParam()
	{
            /* soak in the passed variable or set our own */
            customErrorHandler(E_USER_NOTICE, "Got Here 1 ", __FILE__, __LINE__);
            if( isset($_GET['output']) || isset($_POST['input']) )
            {

            	if ( isset($_GET['output']) )
            	{
			$format = strtolower($_GET['output']) == 'json' ? 'json' : 'xml'; //xml is the default            	
		}
		else
		{
			$format = strtolower($_POST['input']) == 'json' ? 'json' : 'xml'; //xml is the default            	
		}
            
            }
            else
            {
            	$format = "xml";
            }
            
               customErrorHandler(E_USER_NOTICE, $format, __FILE__, __LINE__);

            return $format;
        }
        

    //*----------------------------------------------------------------------
    //description:  Returns an code to the server with no data
    // this is if an error occured but not necessarily an assertion.
    //
    // Inputs:
    //
    // Returns:
    //*----------------------------------------------------------------------
    public static function displayResult($code, $msg, $format)
	{
		
        if($format == 'json')
        {
            $rows = array();
            header('Content-type: application/json');
            $data = array( 'rows' => $rows );
            addUserResponseMessage($data, $code, $msg );
        }
        else
        {
            header('Content-type: text/xml');
            echo '<rows>';
        }
    }

    //*----------------------------------------------------------------------
    //description:  Returns a proper http request with data.  For use by PHP webservices.
    //
    // Inputs:
    //
    // Returns:
    //*----------------------------------------------------------------------
	public static function display($rows, $format)
	{
        /* output in necessary format */
            
		$status_header = 'HTTP/1.1 ' . "200" . ' ' . "OK";  
		//set the status  
     	header($status_header);
		
		
            if($format == 'json') {
                    header('Content-type: application/json');
                    
                    $data = array( 'rows' => $rows);
                    addUserResponseMessage( $data , 0, "Success");
            }
            else {
                   header('Content-type: text/xml');
                    echo '<rows>';
                    foreach($rows as $index => $row) {
                            if(is_array($row)) {
                                    foreach($row as $key => $value) {
                                            echo '<',$key,'>';
                                            if(is_array($value)) {
                                                    foreach($value as $tag => $val) {
                                                            echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
                                                    }
                                            }
                                            echo '</',$key,'>';
                                    }
                            }
                    }
                    echo '</rows>';
            }
	
	}
	
	public static function parse($rowString, $format)
	{
	            /* output in necessary format */
	        if($format == 'json') 
	        {	
				$rows = json_decode(utf8_decode($rowString));
				return $rows;
	        }
	        else 
	        {
				$p = xml_parser_create();
				xml_parse_into_struct($p,$rowString,$rows,$index);
				xml_parser_free($p);
				return $rows;
	         }
	
	}	
}
?>