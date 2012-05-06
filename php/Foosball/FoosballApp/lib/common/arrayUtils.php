<?php


/**
 * Various array utils
 * asdfasf
 *
 */
class arrayUtils {

    protected $theArray = array ();

    public function __construct($theArray) {
        $this->theArray = $theArray;
    }

    /**
     * Recursive function to get a key in a multi-index array.
     *
     * @param $array
     * @param $needle_key
     * @return array
     */
    public function extractValuesByKey($array, $needle_key) {
        $out = array ();
        foreach($array as $key=> $value) {
            if(!is_array($value)) {
                if($key == $needle_key) {
                    $out[] = $value;
                }
            } else {
                $tempOut = $this->extractValuesByKey($value, $needle_key);
                if(count($tempOut) > 0) {
                    $out = array_merge($out, $tempOut);
                }
            }
        }
        return $out;
    }

    public function getAllByKey($key) {
        $resultArray = $this->extractValuesByKey($this->theArray, $key);
        return $resultArray;
    }
}

?>