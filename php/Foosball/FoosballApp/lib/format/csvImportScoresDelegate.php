<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/31/12
 * Time: 8:57 AM
 * To change this template use File | Settings | File Templates.
 */
 
class csvImportScoresDelegate {

    protected $contents;

    public function setcontents($contents)
    {
        $this->contents = $contents;
    }

    /**
     *
     * converts to csv and retuns an array that 'can' be inserted into db.
     * @return array
     *
     */
    public function getArray()
    {
        $lines = explode("\n", $this->contents);
        $keys = explode(',', array_shift($lines)); //assume first row is keys

        $array = array();

        foreach ($lines as $line) {
            if (!empty($line)) {
                $keyed = array_combine($keys, explode(',', $line));
                $array[] = $keyed;
            }
        }
        return $array;
    }

}
