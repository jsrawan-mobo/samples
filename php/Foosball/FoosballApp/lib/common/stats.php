<?php     
    function cmpfloat ($a, $b)
    {
        if ($a == $b)
        {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }


class stats
{

 protected $valueArray = array();
    
    public function __construct($valueArray = NULL)
    {
        if ( is_null($valueArray) )
        {
            throw new Exception('Need value array');
        }
        $this->valueArray = $valueArray;
    }




    public function calculateStdAndAvgForSet ()
    {
        //stdeviation
        $stddev = 0;
        $average = 0;
        $calcLength = count($this->valueArray);
        for ($i = 0 ; $i < $calcLength; $i++ )
        {
            $average = $average + $this->valueArray[$i];
        }
        $average = $average / $calcLength;
    
        for ($i = 0 ; $i  < $calcLength;  $i++ )
        {
            $stddev = $stddev + pow( $this->valueArray[$i] - $average, 2);
        }

        if ( $calcLength > 1)
        {
            $stddev = sqrt( $stddev/($calcLength -1) );
        }
    
    
        //sort
        $sortedArray = $this->valueArray;
        usort($sortedArray, "cmpfloat");
        $min = $sortedArray[0];
        $max = $sortedArray[$calcLength - 1];
        $results = array('stddev' => $stddev, 'average' => $average, 'min'=> $min, 'max'=>$max );
        return $results;
    }


}
?>